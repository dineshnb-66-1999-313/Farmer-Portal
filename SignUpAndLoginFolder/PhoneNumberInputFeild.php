<?php
    require_once "../ComponentFolder/header.php";
    session_start();
    $errors2=0;
if(isset($_POST['SendOTP']))
{
    if(isset($_SESSION['email']))
    {
        $_SESSION['PhoneNumber'] = $_POST['pnumber']; 

        $p_uniq_farmer = $pdo->prepare("SELECT COUNT(phone_number) AS PUniquefarmer FROM sign_up_farmer_information WHERE phone_number=:phone_number");
        $p_uniq_farmer->execute(array(':phone_number' => $_SESSION['PhoneNumber']));
        $row3 = $p_uniq_farmer->fetch(PDO::FETCH_ASSOC); 

        $p_uniq_user = $pdo->prepare("SELECT COUNT(phone_number) AS PUniqueUser FROM sign_up_user_information WHERE phone_number=:phone_number");
        $p_uniq_user->execute(array(':phone_number' => $_SESSION['PhoneNumber']));
        $row31 = $p_uniq_user->fetch(PDO::FETCH_ASSOC); 

        if(preg_match("/^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/",$_SESSION['PhoneNumber']))
        {
            if($row31['PUniqueUser']<1)
            {
                if($row3['PUniquefarmer']<1)
                {
                    // Authorisation details.
                    $username = "dineshnb2038@gmail.com";
                    $hash = "50cc943928fde8415b1de658390b767ff1fadb8f3f9236aa1e5097a5f9f7da82";

                    // Config variables. Consult http://api.textlocal.in/docs for more info.
                    $test = "0";

                    // Data for text message. This is the text message data.
                    $sender = "API Test"; // This is who the message appears to be from.
                    $numbers = $_SESSION['PhoneNumber']; // A single number or a comma-seperated list of numbers
                    $otp = mt_rand(100000, 999999);
                    setcookie("otp", $otp);
                    $message = "Hai". $_SESSION['firstname']."The OTP is".$otp;
                    // 612 chars or less
                    // A single number or a comma-seperated list of numbers
                    $message = urlencode($message);
                    $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
                    $ch = curl_init('http://api.textlocal.in/send/?');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch); // This is the result from the API
                    $_SESSION['otpSendedMessage'] = "<h6><i class='fa fa-check fa-lg mr-3'></i>OTP Sended Successfully</h6>";
                    $_SESSION['otp'] = $otp;
                    header("Location: OtpVarification.php");
                    curl_close($ch);    
                }
                else{
                    $message1 ='<label>Phone Number already registored</label>';
                }
            }
            else{
                $message1 ='<label>You Already Registred As a Purchaser</label>'; 
            }
        }
        else{
            $message1 ='<label>Please Enter the Valid Phone Number </label>';
        }
    }
    else{
        $message1 ='<label>Session Not Started Please Continue From the First Step</label>';
    }
} 
if(isset($_POST['backtobasicdetails'])){
    header("Location: BasicDetailSignUp.php");
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
        padding: 1rem 2rem;
    }
    .maincontainer{
        margin-top: 7rem;
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
<div class="container maincontainer" style="width:100%;">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-2" id="main_div_center" style="border-radius:0.4rem;border: 2px solid #000;" >
        <?php
            if(isset($message1)){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message1.'</span></div>';
            }
        ?>
        <form method="post" class="paddingcontainer">
            <h3><b>Phone Number</b></h3><br>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone fa-lg"></i></span>
                <input type="tel" placeholder="Enter Phone Number" value="<?php echo isset($_SESSION['PhoneNumber']) ? $_SESSION['PhoneNumber'] : ''?>" name="pnumber" autocomplete="off" class="form-control form-control-lg ml-0" required="required" onkeyup="validationpnumber()" id="pnumberinfo"><br>
            </div>
            <div class="row">
                <div class="col-6 col-md-6">
                    <a href="BasicDetailSignUp.php" class="btn btn-warning responsive-content btn-block mt-4 pl-4 pr-4"><i class="fa fa-arrow-left mr-3"></i>Back</a>
                </div>
                <div class="col-6 col-md-6">
                    <button name="SendOTP" class="btn btn-primary responsive-content btn-block mt-4 pl-4 pr-4">Send OTP</button>
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
    function validationpnumber()
    {
        var createnumber=document.getElementById('pnumberinfo').value;
        var numberpattren=/^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
            if(numberpattren.test(createnumber)){
                document.getElementById('pnumberinfo').style.border='3px dashed green';
            }
            else{
                document.getElementById('pnumberinfo').style.border='3px dashed red';
            }
    }
    </script>

</body>
</html>