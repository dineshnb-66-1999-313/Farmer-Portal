<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";
    $errorMessage=0;

    if(isset($_SESSION['passwordresetemail']) && isset($_SESSION['usertypepasswordreset']))
    {
        if(isset($_POST['rememberpassword']))
        {
            $_SESSION['createpassrremamber'] = $_POST['createpassremember'];
            $_SESSION['confirmpasswordremember'] = $_POST['confirmpassremember'];

            if($_SESSION['createpassrremamber'] == $_SESSION['confirmpasswordremember'])
            {
                if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/",$_SESSION['createpassrremamber']))
                {
                    if($_SESSION['usertypepasswordreset'] == 'FARMER')
                    {
                        $_SESSION['createpassrremamber'] = password_hash($_SESSION['createpassrremamber'], PASSWORD_BCRYPT);
                        $sqlforpasswordupdate = $pdo->prepare("UPDATE sign_up_farmer_information SET cre_password = :cre_password WHERE E_mail_id = :E_mail_id");
                        $sqlforpasswordupdate->execute(array(':cre_password' =>$_SESSION['createpassrremamber'], ':E_mail_id' =>$_SESSION['passwordresetemail']));
                        unset($_SESSION['createpassrremamber']);
                        unset($_SESSION['confirmpasswordremember']);
                        unset($_SESSION['passwordresetemail']);
                        unset($_SESSION['usertypepasswordreset']);
                        unset($_SESSION['reset_email']);
                        unset($_SESSION['reset_dob']);
                        $_SESSION['passwordretriavl'] ='<label><i class="fas fa-check fa-lg mr-2"></i>Password Changed Successfully</label>';
                        header('location: LoginPageFarmerPortal.php');
                    }
                    else
                    {
                        $_SESSION['createpassrremamber'] = password_hash($_SESSION['createpassrremamber'], PASSWORD_BCRYPT);
                        $sqlforpasswordupdate = $pdo->prepare("UPDATE sign_up_user_information SET cre_password = :cre_password WHERE E_mail_id = :E_mail_id");
                        $sqlforpasswordupdate->execute(array(':cre_password' =>$_SESSION['createpassrremamber'], ':E_mail_id' =>$_SESSION['passwordresetemail']));
                        unset($_SESSION['createpassrremamber']);
                        unset($_SESSION['confirmpasswordremember']);
                        unset($_SESSION['passwordresetemail']);
                        unset($_SESSION['usertypepasswordreset']);
                        unset($_SESSION['reset_email']);
                        unset($_SESSION['reset_dob']);
                        $_SESSION['passwordretriavl'] ='<label><i class="fas fa-check fa-lg mr-2"></i>Password Changed Successfully</label>';
                        header('location: LoginPageFarmerPortal.php');
                    }
                }
                else{
                    $errorMessage=1;
                    $message ='<label>Please Follow the restriction in Password Feild</label>';
                }
            }
            else{
                $errorMessage=2;
                $message ='<label>Password Does Not Match</label>';
            }
        }  
    }
    else
    {
        header('location: Forgotpassword.php');
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
            <h2 class="text-success text-center">Password Reset</h2>
                <form method="post" class="paddingcontainer">

                <label class="form-label"><b>Create Password</b></label>
                <i type="button" class="fas fa-info-circle fa-lg text-success" data-bs-html="true" title="Restriction in password feild" data-bs-content="<h6>1. At least a lowercase letter</h6><h6>2. At least a uppercase letter</h6> <h6>3. At least a Numeric digit</h6> <h6>4. Minimum length is 8</h6> <h6>5. Maximum length is 15</h6>" data-toggle="popover" data-placement="top"></i> 
                
                <div class="input-group mb-3">
                    <input type="password" name="createpassremember" maxlength="15" value="<?php echo isset($_SESSION['createpassrremamber']) ? $_SESSION['createpassrremamber'] : ''?>" onkeyup="validationpassword()" id="createpasswordinput" placeholder="Create Password" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 1){echo 'style="border:3px dashed red"';} ?>>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-eye fa-lg" id="togglepassword1"></i></span>
                    </div>
                </div>

                <label class="form-label"><b>Confirm Password</b></label>
                <div class="input-group mb-3">
                    <input type="password" name="confirmpassremember" value="<?php echo isset($_SESSION['confirmpasswordremember']) ? $_SESSION['confirmpasswordremember'] : ''?>" placeholder="Conform password" id="createconfirmpasswordinput" onkeyup="passwordmatching()" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 2){echo 'style="border:3px dashed red"';} ?>>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-eye fa-lg" id="togglepassword2"></i></span>
                    </div>
                </div>
                    
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mr-5">
                            <button type="submit" id="OnFarmerSubmit" class="btn btn-outline-Success btn-block btn-lg mt-4" name="rememberpassword">Remember Password</button>
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
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
    function passwordmatching()
    {
        var create_password=document.getElementById('createpasswordinput').value;
        var confirm_password=document.getElementById('createconfirmpasswordinput').value;
        if(create_password === confirm_password){
            document.getElementById('createconfirmpasswordinput').style.border='3px dashed green';
        }
        else{
            document.getElementById('createconfirmpasswordinput').style.border='3px dashed red';
        }
    }
    function validationpassword()
    {
        var createpass=document.getElementById('createpasswordinput').value;
        var passpattren=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
            if(passpattren.test(createpass)){
                document.getElementById('createpasswordinput').style.border='3px dashed green';
            }
            else{
                document.getElementById('createpasswordinput').style.border='3px dashed red';
            }
    }
</script>

<script>
    const togglePasswordcreatePass = document.querySelector('#togglepassword1');
    const password1 = document.querySelector('#createpasswordinput');
        togglePasswordcreatePass.addEventListener('click', function (e) {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    const togglePasswordconfirmPass = document.querySelector('#togglepassword2');
    const password2 = document.querySelector('#createconfirmpasswordinput');
    togglePasswordconfirmPass.addEventListener('click', function (e) {
        const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
        password2.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>



