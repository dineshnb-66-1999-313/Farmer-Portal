<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";
    $errorMessage=0;

    if(isset($_POST['resetpassword']))
    {
        $_SESSION['reset_email'] = $_POST['emailresetinput'];
        $_SESSION['reset_dob'] = $_POST['dateofbirth'];

        $forgot_password_query_count = $pdo->prepare("SELECT COUNT(E_mail_id) AS Email_idcount_farmer FROM sign_up_farmer_information WHERE E_mail_id=:E_mail_id");
        $forgot_password_query_count->execute(array(':E_mail_id' => $_SESSION['reset_email']));
        $fetching_the_row_count = $forgot_password_query_count->fetch(PDO::FETCH_ASSOC);

        if($fetching_the_row_count['Email_idcount_farmer'] > 0)
        {
            $selectallreset = $pdo->prepare("SELECT * FROM sign_up_farmer_information WHERE E_mail_id=:E_mail_id");
            $selectallreset->execute(array(':E_mail_id' => $_SESSION['reset_email']));
            $fetchallreset = $selectallreset->fetch(PDO::FETCH_ASSOC);

            if($_SESSION['reset_dob'] == $fetchallreset['date_of_birth'])
            {
                $_SESSION['passwordresetemail'] = $_SESSION['reset_email'];
                $_SESSION['usertypepasswordreset'] = $fetchallreset['User_Type'];
                session_unset($_SESSION['reset_dob']);
                header('Location: PasswordRetrivalFarmeruser.php');
            }
            else
            {
                $errorMessage = 2;
                $message ='<label>Date of birth not matching</label>';
            }
        }
        else
        {
            $forgot_password_query_count = $pdo->prepare("SELECT COUNT(E_mail_id) AS Email_idcount_purchaser FROM sign_up_user_information WHERE E_mail_id=:E_mail_id");
            $forgot_password_query_count->execute(array(':E_mail_id' => $_SESSION['reset_email']));
            $fetching_the_row_count = $forgot_password_query_count->fetch(PDO::FETCH_ASSOC);

            if($fetching_the_row_count['Email_idcount_purchaser'] > 0)
            {
                $selectallreset = $pdo->prepare("SELECT * FROM sign_up_user_information WHERE E_mail_id=:E_mail_id");
                $selectallreset->execute(array(':E_mail_id' => $_SESSION['reset_email']));
                $fetchallreset = $selectallreset->fetch(PDO::FETCH_ASSOC);

                if($_SESSION['reset_dob'] == $fetchallreset['date_of_birth'])
                {
                    $_SESSION['passwordresetemail'] = $fetchallreset['E_mail_id'];
                    $_SESSION['usertypepasswordreset'] = $fetchallreset['User_Type'];
                    header('Location: PasswordRetrivalFarmeruser.php');
                }
                else
                {
                    $errorMessage = 2;
                    $message ='<label>Date of birth not matching</label>';
                }
            }
            else{
                $errorMessage = 1;
                $message ='<label>E-mail does not Exist</label>';
            }
        }
    }

?>

<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
    }
    .form-control-md{
        max-width: -webkit-fill-available;
    }
    #main_div_center{
        margin-inline: auto;
    }
    .paddingcontainer{
        padding: 1rem 1.2rem;
    }
    .maincontainer{
        margin-top: 4rem;
    }
</style>

<?php
    nav_bar_sign_up();
?>

<div class="container-fluid maincontainer" style="width:100%;">
    <div class="row">
        <div class="col-12 col-sm-9 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-4" id="main_div_center" style="border-radius:0.4rem;border: 2px solid #000;">
        <?php
            if(isset($message)){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
            }
        ?>
        <?php
            if(isset($_SESSION['withoutsession'])){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$_SESSION['withoutsession'].'</span></div>';
            }
        ?>
            <h2 class="text-success text-center">Forgot Password</h2>
                <form method="post" class="paddingcontainer">

                    <label class="form-label"><b>Enter Email</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope fa-lg" <?php if($errorMessage == 1){echo 'style="color: red;"';}?>></i></span>
                        <input type="text" name="emailresetinput" value="<?php echo isset($_SESSION['reset_email']) ? $_SESSION['reset_email'] : ''?>" placeholder="Enter Email" autocomplete="off" class="form-control form-control-lg ml-0" required="required"  <?php if($errorMessage == 1){echo 'style="border:3px dashed red"';} ?>>
                    </div>
                    
                    <label class="form-label"><b>Date of Birth</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-birthday-cake fa-lg" <?php if($errorMessage == 2){echo 'style="color: red;"';}?>></i></span>
                        <input type="date" name="dateofbirth" id="datepicker" value="<?php echo isset($_SESSION['reset_dob']) ? $_SESSION['reset_dob'] : ''?>" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 2){echo 'style="border:3px dashed red;"';} ?>> 
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mr-5">
                            <button type="submit" id="OnFarmerSubmit" class="btn btn-outline-Success btn-block btn-lg mt-4" name="resetpassword">Reset Password</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>   
<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>



