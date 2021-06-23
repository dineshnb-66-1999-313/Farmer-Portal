<?php
    require_once "../ComponentFolder/header.php";
    session_start();
    $errors2=0;
if(isset($_POST['MoveToDocumentVarification']))
{
    if(isset($_SESSION['email']))
    {
        $otpmessage = $_POST['otpInput'];
        if($otpmessage == $_COOKIE['otp'])
        {
            $_SESSION['P_N_status'] = 'SUCCESS';
            header('Location: DocumentVarification.php');
        }
        else{
            $message = '<label>Please Enter the Correct OTP</label>';
        }
    }
    else{
        $message ='<label>Session Not Started Please Continue From the First Step</label>';
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
    .maincontainer{
        margin-top: 7rem;
    }
    .paddingcontainer{
        padding: 1rem 2rem;
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
<?php
    nav_bar_sign_up();
?>
<div class="container-fluid maincontainer" style="width:100%;">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-1" id="main_div_center" style="border-radius: 0.4rem;rem;border: 2px solid #000;" >
        <?php
            if(isset($message)){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
            }
            if(isset($_SESSION['otpSendedMessage'])){
                echo '<div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$_SESSION['otpSendedMessage'].'</span></div>';
            }
        ?>
        <?php 
        echo '<form method="post" class="paddingcontainer">
                <h3><b>Enter OTP</b></h3><br>
                <div class="input-group mb-3">
                    <input type="password" name="cpass" value="'.$_SESSION['otp'].'" disabled maxlength="15" id="createpasswordinput" placeholder="Create Password" autocomplete="off" class="form-control form-control-lg ml-0" required="required">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-eye fa-lg" id="togglepassword1"></i></span>
                    </div>
                </div>
                <input type="text" placeholder="Enter OTP" name="otpInput" autocomplete="off" class="form-control form-control-lg ml-0" required="required" maxlength="10"><br>
                
                <div class="row">
                    <div class="col-6 col-md-5">
                        <a href="PhoneNumberInputFeild.php" class="responsive-content btn btn-warning btn-block mt-4 pl-4 pr-4"><i class="fa fa-arrow-left mr-3"></i>Back</a>
                    </div>
                    <div class="col-6 col-md-5">
                        <button name="MoveToDocumentVarification" class="responsive-content btn btn-primary btn-block mt-4 pl-4 pr-4">Varify OTP</button>
                    </div>
                </div>
            </form>
            '
        ?>
        </div>
    </div>
</div>   
<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>

<script>
    const togglePasswordcreatePass = document.querySelector('#togglepassword1');
    const password1 = document.querySelector('#createpasswordinput');
        togglePasswordcreatePass.addEventListener('click', function (e) {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>