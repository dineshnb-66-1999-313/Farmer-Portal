<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    $errorMessage = 0;

    if(isset($_POST['LoginFarmerSubmit']))
    {
        $_SESSION['emailEmailPhoneNumberInput'] = $_POST['emailEmailPhoneNumberInput'];
        $_SESSION['LoginCreatePasswordInput'] = $_POST['LoginCreatePassword'];
        unset($_SESSION['passwordretriavl']);

        $SearchForEmailIdFarmertable = $pdo->prepare("SELECT E_mail_id, phone_number, cre_password, first_name, last_name, User_Type,document_status FROM sign_up_farmer_information WHERE E_mail_id = :E_mail_id OR phone_number = :phone_number");
        $SearchForEmailIdFarmertable->execute(array(':E_mail_id' => $_SESSION['emailEmailPhoneNumberInput'],
                                                    ':phone_number' => $_SESSION['emailEmailPhoneNumberInput']));
        $FarmerUser = $SearchForEmailIdFarmertable->fetch(PDO::FETCH_ASSOC);

        if($FarmerUser == true)
        {
            $VarifyFarmerPassword = password_verify($_SESSION['LoginCreatePasswordInput'], $FarmerUser['cre_password']);
            if($VarifyFarmerPassword)
            {
                if($FarmerUser['document_status'] === 'ACTIVE')
                {
                    $_SESSION['SecureLoginSession'] = $FarmerUser['E_mail_id'];
                    $_SESSION['LoginFarmerFirstName'] = $FarmerUser['first_name'];
                    $_SESSION['LoginFarmerLastName'] = $FarmerUser['last_name'];
                    $_SESSION['LoginFarmerUserType'] = $FarmerUser['User_Type'];
                    $_SESSION['emailEmailPhoneNumberInput'] = '';
                    $_SESSION['LoginCreatePasswordInput'] = '';
                    header("Location: ../FarmerHomePageFolder/HomePageFarmerPortal.php");
                }
                else{
                    $message ='<labe>Document Varification Is in Process</label>';
                }
            }
            else{
                $errorMessage = 2;
                $message ='<labe>Incorrect Password</label>';
            }
        }
        else{
            $errorMessage = 1;
            $message ='<labe>Incorrect Email/Phone Number</label>';
        }
    }

    if(isset($_POST['LoginUserSubmit'])){
        $_SESSION['emailEmailPhoneNumberInput'] = $_POST['emailEmailPhoneNumberInput'];
        $_SESSION['LoginCreatePasswordInput'] = $_POST['LoginCreatePassword'];
        unset($_SESSION['passwordretriavl']);
        
        $SearchForEmailIdinUsertable = $pdo->prepare("SELECT E_mail_id, phone_number, cre_password, full_name, User_Type FROM sign_up_user_information WHERE E_mail_id = :E_mail_id OR phone_number = :phone_number");
        $SearchForEmailIdinUsertable->execute(array(':E_mail_id' => $_SESSION['emailEmailPhoneNumberInput'],
                                                    ':phone_number' => $_SESSION['emailEmailPhoneNumberInput']));
        $UserTabledatafetching = $SearchForEmailIdinUsertable->fetch(PDO::FETCH_ASSOC);

        if($UserTabledatafetching == true)
        {
            $VarifyFarmerPassword = password_verify($_SESSION['LoginCreatePasswordInput'], $UserTabledatafetching['cre_password']);

            if($VarifyFarmerPassword)
            {
                $_SESSION['SecureLoginSession'] = $UserTabledatafetching['E_mail_id'];
                $_SESSION['LoginUserFullName'] = $UserTabledatafetching['full_name'];
                $_SESSION['LoginFarmerUserType'] = $UserTabledatafetching['User_Type'];
                $_SESSION['emailEmailPhoneNumberInput'] = '';
                $_SESSION['LoginCreatePasswordInput'] = '';
                header("Location: ../FarmerHomePageFolder/HomePageFarmerPortal.php");
            }  
            else{
                $errorMessage = 2;
                $message ='<labe>Incorrect Password</label>';
            }
        }
        else{
            $errorMessage = 1;
            $message ='<labe>Incorrect Email Or Phone Number</label>';
        }
    }
?>
<?php
    nav_bar_sign_up();
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
    @media (max-width: 576px) {
      .responsive-content {
        font-size: 4vw;
      }
    }
    @media (min-width: 768px) {
      .responsive-content {
        font-size: 1.5vw;
      }
    }
</style>
<div class="container-fluid maincontainer" style="width:100%;">
    <div class="row">
        <div class="col-12 col-sm-9 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-4" id="main_div_center" style="border-radius:0.4rem;border: 2px solid #000;">
        <?php
            if(isset($message)){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
            }
        ?>
        <?php
            if(isset($_SESSION['passwordretriavl'])){
                echo '<div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><h5>'.$_SESSION['passwordretriavl'].'</h5></div>';
            }
        ?>
            <h2 class="text-success text-center">Farmer/ User Login</h2>
                <form method="post" class="paddingcontainer">
                    <div class="row">
                        <label class="form-label"><b>Email Or Phone Number</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope fa-lg" <?php if($errorMessage == 1){echo 'style="color: red"';}?>></i></span>
                            <input type="text" name="emailEmailPhoneNumberInput" value="<?php echo isset($_SESSION['emailEmailPhoneNumberInput']) ? $_SESSION['emailEmailPhoneNumberInput'] : ''?>" placeholder="Enter Email Or Phone Number" autocomplete="off" class="form-control form-control-lg ml-0" required="required"  <?php if($errorMessage == 1){echo 'style="border:3px dashed red"';} ?>>
                        </div>
                        
                        <label class="form-label"><b>Enter Password</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-lock fa-2x" <?php if($errorMessage == 2){echo 'style="color: red"';}?>></i></span>
                            <input type="password" name="LoginCreatePassword" id="myinput1" value="<?php echo isset($_SESSION['LoginCreatePasswordInput']) ? $_SESSION['LoginCreatePasswordInput'] : ''?>" placeholder="Enter Password" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 2){echo 'style="border:3px dashed red"';} ?>>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-eye fa-lg" id="togglepassword1"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="Forgotpassword.php" class="float-right">forgot password ?</a>
                    </div><br>
                    <div class="row justify-content-center">
                        <div class="col-6 col-sm-5 col-md-4 col-lg-5">
                            <button type="submit" id="OnFarmerSubmit" class="responsive-content btn-block btn btn-outline-Success mt-4" name="LoginFarmerSubmit">Login As Farmer</button>
                        </div>
                        <div class="col-6 col-sm-5 col-md-4 col-lg-4">
                            <button type="submit" class="responsive-content btn btn-outline-primary btn-block mt-4" name="LoginUserSubmit">Login as User</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>   
<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>
<script>
    const togglePassword1 = document.querySelector('#togglepassword1');
    const password1 = document.querySelector('#myinput1');
        togglePassword1.addEventListener('click', function (e) {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        });
</script>