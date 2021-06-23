<?php
    require_once "../ComponentFolder/header.php";
    session_start();
    $errorMessage = 0;
    $profileimageboy='https://previews.123rf.com/images/salamatik/salamatik1801/salamatik180100019/92979836-profile-anonymous-face-icon-gray-silhouette-person-male-default-avatar-photo-placeholder-isolated-on.jpg';
    $profileimagegirl='https://media.istockphoto.com/vectors/person-gray-photo-placeholder-woman-vector-id1074273082';
if(isset($_POST['SignUpUserFormSubmit']))
{
    $_SESSION['FullName']=$_POST['FullName'];
    $_SESSION['UserEmail']=$_POST['UserEmail'];
    $_SESSION['DateOfBirth'] = $_POST['DateOfBirth'];
    $_SESSION['UserGender'] = $_POST['UserGender'];
    $_SESSION['UserMobile'] = $_POST['UserMobile'];          
    $_SESSION['CreatePassword']=$_POST['CreatePassword'];
    $_SESSION['ConfirmPassword'] = $_POST['ConfirmPassword'];
        
    if($_SESSION['CreatePassword'] == $_SESSION['ConfirmPassword'])
    {
        if(preg_match("/^[a-zA-Z]{3,}/",$_SESSION['FullName']))
        {
            $p_uniq_user = $pdo->prepare("SELECT COUNT(phone_number) AS PUniqueUser FROM sign_up_user_information WHERE phone_number=:phone_number");
            $p_uniq_user->execute(array(':phone_number' => $_SESSION['UserMobile']));
            $row2 = $p_uniq_user->fetch(PDO::FETCH_ASSOC); 

            $p_uniq_farmer = $pdo->prepare("SELECT COUNT(phone_number) AS PUniqueFormer FROM sign_up_farmer_information WHERE phone_number=:phone_number");
            $p_uniq_farmer->execute(array(':phone_number' => $_SESSION['UserMobile']));
            $row21 = $p_uniq_farmer->fetch(PDO::FETCH_ASSOC); 

            if(preg_match("/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/",$_SESSION['UserMobile']))
            {
                if($row21['PUniqueFormer']<1)
                {
                    if($row2['PUniqueUser']<1)
                    {
                        if(preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/",$_SESSION['UserEmail']))
                        {
                            $emailiduniqueinusertable = $pdo->prepare("SELECT COUNT(E_mail_id) AS emailiduniqueinuser FROM sign_up_user_information WHERE E_mail_id=:E_mail_id");
                            $emailiduniqueinusertable->execute(array(':E_mail_id' => $_SESSION['UserEmail']));
                            $row3 = $emailiduniqueinusertable->fetch(PDO::FETCH_ASSOC);

                            $emailiduniqueinfarmertable = $pdo->prepare("SELECT COUNT(E_mail_id) AS emailiduniqueinfarmer FROM sign_up_farmer_information WHERE E_mail_id=:E_mail_id");
                            $emailiduniqueinfarmertable->execute(array(':E_mail_id' => $_SESSION['UserEmail']));
                            $row31 = $emailiduniqueinfarmertable->fetch(PDO::FETCH_ASSOC);

                            if($row31['emailiduniqueinfarmer'] < 1)
                            {
                                if($row3['emailiduniqueinuser'] < 1)
                                {
                                    if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/",$_SESSION['CreatePassword']))
                                    {
                                        $_SESSION['CreatePassEncrypted'] = password_hash($_SESSION['CreatePassword'], PASSWORD_BCRYPT);

                                        $InsertFarmerDataUser=$pdo->prepare("INSERT INTO sign_up_user_information(full_name, E_mail_id, User_Type, date_of_birth, user_gender, phone_number, cre_password, date_time_of_sign_up) 
                                                    VALUES (:full_name, :E_mail_id, :User_Type, :date_of_birth, :user_gender, :phone_number, :cre_password, now())");
                                        $InsertFarmerDataUser->execute(array(
                                            ':full_name' => $_SESSION['FullName'],
                                            ':E_mail_id' => $_SESSION['UserEmail'],
                                            ':User_Type' => 'PURCHASER',
                                            ':date_of_birth' => $_SESSION['DateOfBirth'],
                                            ':user_gender' => $_SESSION['UserGender'],
                                            ':phone_number' => $_SESSION['UserMobile'],
                                            ':cre_password' => $_SESSION['CreatePassEncrypted']
                                        ));

                                        if($_SESSION['UserGender'] == 'Male')
                                        {    
                                            $profilequery1=$pdo->prepare("INSERT INTO user_profile_information (E_mail_id, Profile_Status, Default_profile, Actual_profile_image, date_of_profile_update_info) 
                                                                    VALUES (:E_mail_id, :Profile_Status , :Default_profile, :Actual_profile_image,now())");
                                            $profilequery1->execute(array(':E_mail_id' => $_SESSION['UserEmail'],
                                                                          ':Profile_Status' => "NO" ,
                                                                          ':Default_profile' => $profileimageboy,
                                                                          ':Actual_profile_image' => $profileimageboy));

                                            echo '<script>swal("Registration Successfull"," ","success").then(function(){window.location = "LoginPageFarmerPortal.php";});</script>';
                                        }
                                        if($_SESSION['UserGender'] == 'Female')
                                        {
                                            $profilequery2=$pdo->prepare("INSERT INTO user_profile_information (E_mail_id, Profile_Status, Default_profile, Actual_profile_image, date_of_profile_update_info)
                                                                         VALUES (:E_mail_id, :Profile_Status , :Default_profile, :Actual_profile_image,now())");
                                            $profilequery2->execute(array(':E_mail_id' => $_SESSION['UserEmail'],
                                                                          ':Profile_Status' => "NO" ,
                                                                          ':Default_profile' => $profileimagegirl,
                                                                          ':Actual_profile_image' => $profileimagegirl));
                                            $message ='<label>Registration successful</label>';
                                            header('Location: LoginPageFarmerPortal.php');
                                        }   
                                        session_reset();
                                        session_destroy();
                                    }
                                    else{
                                        $errorMessage = 9;
                                        $message ='<label>Please follow the restriction in password-field </label>';
                                    }
                                }
                                else{
                                    $errorMessage = 8;
                                    $message ='<label>E-mail Alredy Exist</label>';
                                }
                            }
                            else{
                                $message ='<label>You Already Sign Up As a Farmer</label>';
                            }
                        }
                        else{
                            $errorMessage = 7;
                            $message ='<label>Invalid Email format</label>';
                        }
                    }
                    else{
                        $errorMessage = 6;
                        $message ='<label>Phone Number Already Registered</label>';
                    }
                }
                else{
                    $errorMessage = 6;
                    $message ='<label>You Already Sign Up As a Farmer </label>';
                }
            }
            else{
                $errorMessage = 5;
                $message ='<label>Please Enter The valid Phone Number</label>';
            }
        }
        else{
            $errorMessage = 2;
            $message ='<labe>Full Name should be more than three charactors</label>';
        }
    }
    else{
        $errorMessage = 1;
        $message ='<label>password does not match</label>';
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
    .fas{
        line-height: 2;
        font-size: 1.5rem;
    }
</style>
<?php
    nav_bar_sign_up();
?>
<div class="container maincontainer" style="width:100%;">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-8 col-lg-6 mt-3 justify-content-center align-items-center bg-white p-4" id="main_div_center" style="border-radius:0.5rem;border: 2px solid #000;">
        <?php
            if(isset($message)){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
            }
        ?>
            <h2 class="text-success text-center">Sign Up User</h2>
                <form method="post" class="paddingcontainer">
                <label class="form-label"><b>Full Name</b></label>
                    <input type="text" name="FullName" id="fullname" onkeyup="fullnamevalidation()" value="<?php echo isset($_SESSION['FullName']) ? $_SESSION['FullName'] : ''?>" placeholder="Enter Full Name" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 2){echo 'style="border:3px dashed red"';} ?>>
                
                <label class="form-label"><b>Email</b></label>
                    <input type="text" name="UserEmail" value="<?php echo isset($_SESSION['UserEmail']) ? $_SESSION['UserEmail'] : ''?>" placeholder="Enter Email" id="emailinput" onkeyup="emailvalidation()" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 7 || $errorMessage == 8){echo 'style="border:3px dashed red"';} ?>>    

                <label class="form-label"><b>Date of Birth</b></label>
                    <input type="date" name="DateOfBirth" id="datepicker" value="<?php echo isset($_SESSION['DateOfBirth']) ? $_SESSION['DateOfBirth'] : ''?>" class="form-control form-control-lg ml-0" required="required"> 
                    
                <label class="form-label"><b>Phone Number</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone fa-lg"></i></span>
                        <input type="tel" placeholder="Enter Phone Number" value="<?php echo isset($_SESSION['UserMobile']) ? $_SESSION['UserMobile'] : ''?>" name="UserMobile" autocomplete="off" class="form-control form-control-lg ml-0" required="required" onkeyup="validationpnumber()" id="pnumberinfo" <?php if($errorMessage == 5 || $errorMessage == 6){echo 'style="border:3px dashed red"';} ?>><br>
                    </div>
                <label class="form-label"><b>Gender</b></label>
                    <select name="UserGender" class="custom-select form-control-lg" required="required">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                <label class="form-label"><b>Create Password</b></label>
                
                <i type="button" class="fas fa-info-circle fa-2x text-success" data-bs-html="true" title="Restriction in password feild" data-bs-content="<h6>1. At least a lowercase letter</h6><h6>2. At least a uppercase letter</h6> <h6>3. At least a Numeric digit</h6> <h6>4. Minimum length is 8</h6> <h6>5. Maximum length is 15</h6>" data-toggle="popover" data-placement="bottom"></i>  
                
                <div class="input-group mb-3">
                    <input type="password" name="CreatePassword" maxlength="15" value="<?php echo isset($_SESSION['CreatePassword']) ? $_SESSION['CreatePassword'] : ''?>" onkeyup="validationpassword()" id="myinput1" placeholder="Create Password" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 9){echo 'style="border:3px dashed red"';} ?>>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-eye fa-lg" id="togglepassword1"></i></span>
                    </div>
                </div>

                <label class="form-label"><b>Conform Password</b></label>
                <div class="input-group mb-3">
                    <input type="password" name="ConfirmPassword" value="<?php echo isset($_SESSION['ConfirmPassword']) ? $_SESSION['ConfirmPassword'] : ''?>" placeholder="Conform password" id="myinput2" onkeyup="passwordmatching()" autocomplete="off" class="form-control form-control-lg ml-0" required="required" <?php if($errorMessage == 1){echo 'style="border:3px dashed red"';} ?>>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-eye fa-lg" id="togglepassword2"></i></span>
                    </div>
                </div> 
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" name="SignUpUserFormSubmit">Submit</button><br><br>
            </form>
        </div>
    </div>
</div>   
<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>
    <script>  
        $(function () {
            $('[data-toggle="popover"]').popover()
        });

        var date = new Date();
        var cYear = date.getUTCFullYear();
        var cMounth = date.getMonth() + 1;
        var cDate = date.getDate();

        if(cMounth < 9){
            cMounth = "0" + cMounth;
        }
        if(cDate < 10){
            cDate = "0" + cDate;
        }
        var maxdate = cYear + "-" + cMounth + "-" + cDate;

        document.getElementById("datepicker").setAttribute("max", maxdate);

    function passwordmatching(){
        var creat_password=document.getElementById('myinput1').value;
        var conform_password=document.getElementById('myinput2').value;
        if(creat_password === conform_password){
            document.getElementById('myinput2').style.border='3px dashed green';
        }
        else{
            document.getElementById('myinput2').style.border='3px dashed red';
        }
    }
    function fullnamevalidation() 
    { 
        var fullnameInput=document.getElementById('fullname').value;
        var firstnamevalidation=/^[a-zA-Z]{3,}/;
            if(firstnamevalidation.test(fullnameInput)){
                document.getElementById('fullname').style.border='3px dashed green';
            }
            else{
                document.getElementById('fullname').style.border='3px dashed red';
            }
    }
    function usernamevalidation()
    {
            var username=document.getElementById('usernamecheck').value;
            var usernamepattren=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;
                if(usernamepattren.test(username)){
                    document.getElementById('usernamecheck').style.border='3px dashed green';
                }
                else{
                    document.getElementById('usernamecheck').style.border='3px dashed red';
                }
    }
    function validationpassword()
    {
        var createpass=document.getElementById('myinput1').value;
        var passpattren=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
            if(passpattren.test(createpass)){
                document.getElementById('myinput1').style.border='3px dashed green';
            }
            else{
                document.getElementById('myinput1').style.border='3px dashed red';
            }
    }
    function emailvalidation()
    {
        var emailinput=document.getElementById('emailinput').value;
        var emailpattren=/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
            if(emailpattren.test(emailinput)){
                document.getElementById('emailinput').style.border='3px dashed green';
            }
            else{
                document.getElementById('emailinput').style.border='3px dashed red';
            }
    }
    function validationpnumber()
    {
        var createnumber=document.getElementById('pnumberinfo').value;
        var numberpattren=/^[0-9].{9,9}$/;
            if(numberpattren.test(createnumber)){
                document.getElementById('pnumberinfo').style.border='3px dashed green';
            }
            else{
                document.getElementById('pnumberinfo').style.border='3px dashed red';
            }
    }
    const togglePassword1 = document.querySelector('#togglepassword1');
    const password1 = document.querySelector('#myinput1');
        togglePassword1.addEventListener('click', function (e) {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        });

    const togglePassword2 = document.querySelector('#togglepassword2');
    const password2 = document.querySelector('#myinput2');
        togglePassword2.addEventListener('click', function (e) {
        const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
        password2.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        });

    </script>

</body>
</html>