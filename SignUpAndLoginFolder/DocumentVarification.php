<?php
    require_once "../ComponentFolder/header.php";
    session_start();
    $errors2=0;
$random1 = substr(number_format(time() * rand(),0,'',''),0,8);
if(isset($_POST['SubmitAllDocumentFromOneTwoFour']))
{
    if(isset($_SESSION['email']) || isset($_SESSION['P_N_status']))
    {
        $_SESSION['file1name'] = $_FILES['file1']['name'];
        $file1tempname = $_FILES['file1']['tmp_name'];
        $_SESSION['file2name'] = $_FILES['file2']['name'];
        $file2tempname = $_FILES['file2']['tmp_name'];
        $_SESSION['file3name'] = $_FILES['file3']['name'];
        $file3tempname = $_FILES['file3']['tmp_name'];
        
        $file1size = $_FILES['file1']['size'];
        $file2size = $_FILES['file2']['size'];
        $file3size = $_FILES['file3']['size'];

        $file1ext=explode('.',$_SESSION['file1name']);
        $fil1eactualext = strtolower(end($file1ext));
        $file1allowed=array('jpg','jpeg','png');

        $file2ext=explode('.',$_SESSION['file2name']);
        $fil2eactualext = strtolower(end($file2ext));
        $file2allowed=array('pdf');

        $file3ext=explode('.',$_SESSION['file3name']);
        $fil3eactualext = strtolower(end($file3ext));
        $file3allowed=array('pdf');

        if(in_array($fil1eactualext,$file1allowed))
        {
            if($file1size<(1*1024*1024))
            {
                if(in_array($fil2eactualext,$file2allowed))
                {
                    if($file2size<(1*1024*1024))
                    {
                        if(in_array($fil3eactualext,$file3allowed))
                        {
                            if($file3size<(1*1024*1024))
                            {
                                $email_given = $_SESSION['email'];
                                $email_split = explode('@',$email_given,2);
                                mkdir('../UploadedFarmerDocuments/'.$email_split[0]);
                                mkdir('../UploadedFarmerDocuments/'.$email_split[0].'/UploadedCrop');
                                $location = '../UploadedFarmerDocuments/'.$email_split[0];
                                $file1namenew="profile_".$email_split[0]."_".$random1.".".$fil1eactualext;
                                $file1destination= $location."/".$file1namenew;
                                move_uploaded_file($file1tempname,$file1destination);

                                $email_given = $_SESSION['email'];
                                $file2namenew="LandDocument_".$email_split[0]."_".$random1.".".$fil2eactualext;
                                $file2destination= $location."/".$file2namenew;
                                move_uploaded_file($file2tempname,$file2destination);

                                $email_given = $_SESSION['email'];
                                $file3namenew="AadharDocument_".$email_split[0]."_".$random1.".".$fil3eactualext;
                                $file3destination= $location."/".$file3namenew;
                                move_uploaded_file($file3tempname,$file3destination);

                                $InsertFarmerData=$pdo->prepare("INSERT INTO sign_up_farmer_information(first_name,last_name, E_mail_id, User_Type, date_of_birth,phone_number,P_N_status,profile_picture,land_document,aadhar_document,document_status,cre_password,date_time_of_sign_up) 
                                        VALUES (:first_name, :last_name, :E_mail_id, :User_Type, :date_of_birth, :phone_number, :P_N_status, :profile_picture, :land_document, :aadhar_document, :document_status, :cre_password, now())");
                                $InsertFarmerData->execute(array(
                                    ':first_name' => $_SESSION['firstname'],
                                    ':last_name' => $_SESSION['lastname'],
                                    ':E_mail_id' => $_SESSION['email'],
                                    ':User_Type' => 'FARMER',
                                    ':date_of_birth' => $_SESSION['dateofbirth'],
                                    ':phone_number' => $_SESSION['PhoneNumber'],
                                    ':P_N_status'=> $_SESSION['P_N_status'],
                                    ':profile_picture' => $file1destination,
                                    ':land_document' => $file2destination,
                                    ':aadhar_document' => $file3destination,
                                    ':document_status' => "NOTACTIVE",
                                    ':cre_password' => $_SESSION['createpassencrypted']
                                ));
                                session_reset();
                                session_destroy();
                                echo '<script>swal("All the Data stored Successfully","We will contact you in the 2 Business Hours","success").then(function(){window.location = "../FarmerHomePageFolder/HomePageDefaultFarmerUser.php";});</script>';
                            }
                            else{
                                $message ='<label><b>Aadhar Document file is too big</b></label>';
                            }
                        }
                        else{
                            $message ='<label><b>You cannot upload files of this kind in Aadhar Document</b></label>';
                        }
                    }
                    else{
                        $message ='<label><b>Land Document file is too big</b></label>';
                    }
                }
                else{
                    $message ='<label><b>You cannot upload files of this kind in Land Document</b></label>';
                }
            }
            else{
                $message ='<label><b>Profile image is too big</b></label>';
            }
        }
        else{
            $message ='<label><b>You cannot upload files of this kind in profile Image</b></label>';
        }
    }
    else{
        $message ='<label>Session Not Started Please Continue From the First Step</label>';
    }
}
if(isset($_POST['backtobasicdetails'])){
    header("Location: OtpVarification.php");
}

?>
<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
    }
    .form-control{
        max-width: -webkit-fill-available;
        margin: 0rem;
        padding: 0.4rem;
    }
    #main_div_center{
        margin-inline: auto;
    }
    .paddingcontainer{
        padding: 1.5rem 2rem;
    }
    .maincontainer{
        margin-top: 3.5rem;
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
    <div class="row" style="margin-top:3rem;">
        <div class="col-12 col-sm-12 col-md-8 col-lg-5 mt-5 justify-content-center align-items-center bg-white p-1" id="main_div_center" style="border-radius:0.4rem;border: 2px solid #000;" >
        <?php
            if(isset($message)){
                echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
            }
        ?>
        <?php
            if(isset($Successmessage)){
                echo '<div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$Successmessage.'</span></div>';
            }
        ?>
            <h3 class="text-center text-success">Document Varification</h3>
            <form method="post" enctype="multipart/form-data" class="paddingcontainer">
                <h4><b>Select Profile Picture</b></h4><br>
                <div class="mb-3 input-group">
                    <input class="form-control form-control-lg" type="file" name="file1"  id="formFile">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="far fa-id-badge fa-lg"></i></span>
                    </div>
                </div>
                <h4><b>Select Land Document</b></h4>
                <div class="mb-3 pt-3 input-group">
                    <input class="form-control form-control-lg" type="file" name="file2" id="formFile">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-file-pdf fa-lg"></i></span>
                    </div>
                </div>
                <h4><b>Select Aadhar Document</b></h4>
                <div class="mb-3 pt-3 input-group">
                    <input class="form-control form-control-lg" type="file" name="file3" id="formFile">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-file-pdf fa-lg"></i></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 col-md-5">
                        <a href="OtpVarification.php" class="responsive-content btn btn-warning btn-block btn-md mt-4 pl-3 pr-3"><i class="fa fa-arrow-left mr-3"></i>Back</a>
                    </div>
                    <div class="col-6 col-md-6">
                        <button name="SubmitAllDocumentFromOneTwoFour" class="responsive-content btn-block btn btn-primary btn-md mt-4 pl-5 pr-5">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>

</body>
</html>