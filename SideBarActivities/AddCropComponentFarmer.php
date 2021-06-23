<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";
    $errorMessage = 0;
    $NotApproved = 'NOTAPPROVED';
    $Approved = 'APPROVED';
    $Rejected = 'REJECTED';
    error_reporting(0);
    
    $random1 = substr(number_format(time() * rand(),0,'',''),0,8);
    $random2 = substr(number_format(time() * rand(),0,'',''),0,5);

    if(isset($_POST['AddToCropSubmitButton']))
    {
        $_SESSION['CropCategoryName'] = $_POST['CropCategoryName'];
        $_SESSION['CropCategory'] = $_POST['CropCategory'];
        $_SESSION['CropQuantity'] = $_POST['Quantity'];
        $_SESSION['CropPrice'] = $_POST['CropPrice'];
        $_SESSION['crop_description'] = $_POST['crop_description'];
        
        $CropImage = $_FILES['CropImage']['name'];
        $CropImagetmplocation = $_FILES['CropImage']['tmp_name'];
        $CropImageSize = $_FILES['CropImage']['size'];
        
        $CropImageext=explode('.', $CropImage);
        $CropImageactualext = strtolower(end($CropImageext));
        $CropImageallowed=array('jpg','jpeg','png');

        if(preg_match("/^[1-9]{1,}/",$_SESSION['CropQuantity']))
        {
            if(!preg_match("/^((\-(\d*)))$/", $_SESSION['CropQuantity']))
            {
                if(preg_match("/^[1-9]{1,}/",$_SESSION['CropPrice']))
                {
                    if(!preg_match("/^((\-(\d*)))$/", $_SESSION['CropPrice']))
                    {
                        if(in_array($CropImageactualext,$CropImageallowed))
                        {
                            if($CropImageSize<(1*1024*1024))
                            {   
                                $email_given = $_SESSION['SecureLoginSession'];
                                $email_split = explode('@',$email_given,2);
                                $Croplocation = '../UploadedFarmerDocuments/'.$email_split[0].'/UploadedCrop';
                                $Cropnamenew = "CropImage_".$_SESSION['CropCategoryName']."_".$random1.".".$CropImageactualext;
                                $CropImagedestination= $Croplocation."/".$Cropnamenew;
                                move_uploaded_file($CropImagetmplocation, $CropImagedestination);

                                $Insertaddcropitem=$pdo->prepare("INSERT INTO add_crop_image_table(Crop_id, E_mail_id, crop_name, crop_status, crop_category, crop_quantity, crop_price, crop_description, crop_image) 
                                                VALUES (:Crop_id, :E_mail_id, :crop_name, :crop_status, :crop_category, :crop_quantity, :crop_price, :crop_description, :crop_image)");
                                $Insertaddcropitem->execute(array(
                                        ':Crop_id' => $random2,
                                        ':E_mail_id' => $_SESSION['SecureLoginSession'],
                                        ':crop_name' => $_SESSION['CropCategoryName'],
                                        ':crop_status' => $NotApproved,
                                        ':crop_category' => $_SESSION['CropCategory'],
                                        ':crop_quantity' => $_SESSION['CropQuantity'],
                                        ':crop_price' => $_SESSION['CropPrice'],
                                        ':crop_description' => $_SESSION['crop_description'],
                                        ':crop_image' => $CropImagedestination
                                    ));

                                $_SESSION['CropName'] = '';
                                $_SESSION['CropCategory'] = '';
                                $_SESSION['CropQuantity'] = '';
                                $_SESSION['CropPrice'] = '';
                                echo '<script>swal("Farmer Crop Data Added Successfully","We will varify your Crop with in 30 minutes","success").then(function(){window.location = "AddCropComponentFarmer.php";})</script>';
                            }
                            else{
                                $errorMessage = 4;
                                $message ='<labe>Crop Image size is too Big</label>';
                            }
                        }
                        else{
                            $errorMessage = 4;
                            $message ='<labe>You cannot uplaod the Crop Image of this kind</label>';
                        }
                    }
                    else{
                        $errorMessage = 3;
                        $message ='<labe>Crop Price Should Be Positive</label>';
                    }
                }
                else{
                    $errorMessage = 3;
                    $message ='<labe>Crop Price Should not be Zero</label>';
                }
            }
            else{
                $errorMessage = 2;
                $message ='<labe>Crop Quantity Should be Positive</label>';
            }
        }
        else{
            $errorMessage = 2;
            $message ='<labe>Crop Quantity Should not be Zero</label>';
        }
    }

    if(isset($_POST['edit_crop_detail_submit']))
    {
        $_SESSION['CropCategoryName'] = $_POST['CropCategoryName'];
        $_SESSION['CropCategory'] = $_POST['CropCategory'];
        $_SESSION['CropQuantity'] = $_POST['Quantity'];
        $_SESSION['CropPrice'] = $_POST['CropPrice'];
        $editcropidhiddenvalue = $_POST['edit_crop_id'];
        $_SESSION['crop_description'] = $_POST['crop_description'];
        
        $CropImage = $_FILES['CropImage']['name'];
        $CropImagetmplocation = $_FILES['CropImage']['tmp_name'];
        $CropImageSize = $_FILES['CropImage']['size'];
        
        $CropImageext=explode('.', $CropImage);
        $CropImageactualext = strtolower(end($CropImageext));
        $CropImageallowed=array('jpg','jpeg','png');

        if(preg_match("/^[1-9]{1,}/",$_SESSION['CropQuantity']))
        {
            if(!preg_match("/^((\-(\d*)))$/", $_SESSION['CropQuantity']))
            {
                if(preg_match("/^[1-9]{1,}/",$_SESSION['CropPrice']))
                {
                    if(!preg_match("/^((\-(\d*)))$/", $_SESSION['CropPrice']))
                    {
                        if(in_array($CropImageactualext,$CropImageallowed))
                        {
                            if($CropImageSize<(1*1024*1024))
                            {   
                                $email_given = $_SESSION['SecureLoginSession'];
                                $email_split = explode('@',$email_given,2);
                                $Croplocation = '../UploadedFarmerDocuments/'.$email_split[0].'/UploadedCrop';
                                $Cropnamenew = "CropImage_".$_SESSION['CropCategoryName']."_".$random1.".".$CropImageactualext;
                                $CropImagedestination= $Croplocation."/".$Cropnamenew;
                                move_uploaded_file($CropImagetmplocation, $CropImagedestination);

                                $editcropidimageremove = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE Crop_id=:Crop_id");
                                $editcropidimageremove->execute(array(':Crop_id' => $editcropidhiddenvalue));
                                $fetcheditimagefromtable = $editcropidimageremove->fetch(PDO::FETCH_ASSOC);

                                $Inserteditedcropitem=$pdo->prepare("UPDATE add_crop_image_table SET Crop_id = :Crop_id, crop_name = :crop_name, crop_status= :crop_status, crop_category = :crop_category, 
                                                                    crop_quantity= :crop_quantity, crop_price = :crop_price, crop_description = :crop_description,  crop_image = :crop_image WHERE Crop_id = $editcropidhiddenvalue");
                                $Inserteditedcropitem->execute(array(
                                        ':Crop_id' => $random2,
                                        ':crop_name' => $_SESSION['CropCategoryName'],
                                        ':crop_status' => $NotApproved,
                                        ':crop_category' => $_SESSION['CropCategory'],
                                        ':crop_quantity' => $_SESSION['CropQuantity'],
                                        ':crop_price' => $_SESSION['CropPrice'],
                                        ':crop_description' => $_SESSION['crop_description'],
                                        ':crop_image' => $CropImagedestination
                                ));
                                unlink($fetcheditimagefromtable['crop_image']);

                                $_SESSION['CropName'] = '';
                                $_SESSION['CropCategory'] = '';
                                $_SESSION['CropQuantity'] = '';
                                $_SESSION['CropPrice'] = '';
                                echo '<script>swal("Farmer Crop Data Edited Successfully","We will varify your Crop with in 30 minutes","success")</script>';
                            }
                            else{
                                $errorMessage = 4;
                                $message ='<labe>Crop Image size is too Big</label>';
                            }
                        }
                        else{
                            $errorMessage = 4;
                            $message ='<labe>You cannot uplaod the Crop Image of this kind</label>';
                        }
                    }
                    else{
                        $errorMessage = 3;
                        $message ='<labe>Crop Price Should Be Positive</label>';
                    }
                }
                else{
                    $errorMessage = 3;
                    $message ='<labe>Crop Price Should not be Zero</label>';
                }
            }
            else{
                $errorMessage = 2;
                $message ='<labe>Crop Quantity Should be Positive</label>';
            }
        }
        else{
            $errorMessage = 2;
            $message ='<labe>Crop Quantity Should not be Zero</label>';
        }
    }
     
    if(isset($_POST['DeleteCropData'])){
        $deletecropId = $_POST['deletecropname'];

        $selectCropSqlQuery = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE Crop_id=:Crop_id");
        $selectCropSqlQuery->execute(array(':Crop_id' => $deletecropId));
        $fetchCropDetailed = $selectCropSqlQuery -> fetch(PDO::FETCH_ASSOC);

        $deleteCropSqlQuery = $pdo->prepare("DELETE FROM add_crop_image_table WHERE Crop_id=:Crop_id");
        $deleteCropSqlQuery->execute(array(':Crop_id' => $deletecropId));
        unlink($fetchCropDetailed['crop_image']);

        echo '<script>swal(" '.$fetchCropDetailed['crop_name'].' Deleted Successfully","Uploed The New Crop Item","success")</script>';
    }

    if(isset($_POST['close_modal'])){
        header('Location: AddCropComponentFarmer.php');
    }

    if(isset($_POST['backtohomefromaddcrop'])){
        header('location: ../FarmerHomePageFolder/HomePageFarmerPortal.php');
    }

    if(isset($_POST['addaddressbeforecropupload'])){
        header('Location: ProfileAndPersonalInformation.php');
    }

    if(isset($_POST['closeordermodel'])){
        header('Location: AddCropComponentFarmer.php');
    }

    if(isset($_POST['okordermodal'])){
        header('Location: AddCropComponentFarmer.php');
    }

    if(isset($_POST['backtosamepage'])){
        header('Location: AddCropComponentFarmer.php');
    }
    if(isset($_POST['increasequantityofcrop']))
    {
        $increasecropid = $_POST['increaseidcrop'];
        $increasecropquantity = $_POST['SelectQuantitytoincrease'];

        if(preg_match("/^[1-9]{1,}/",$increasecropquantity))
        {
            if(!preg_match("/^((\-(\d*)))$/", $increasecropquantity))
            {
                $selectQuantityofincreasecrop=$pdo->prepare("UPDATE add_crop_image_table SET crop_quantity = :crop_quantity WHERE Crop_id = :Crop_id");
                $selectQuantityofincreasecrop->execute(array(':crop_quantity'=> $increasecropquantity,':Crop_id' => $increasecropid));
                $fetchbuyqantity = $selectQuantityofincreasecrop ->fetch(PDO::FETCH_ASSOC);

                echo '<script>swal("Crop Quantity Inceased Successfully"," ","success")</script>';
            }
            else{
                $message ='<labe>Crop Quantity Should be Positive</label>';
            }
        }
        else{
            $message ='<labe>Crop Quantity Should not be Zero</label>';
        }
    }

?>

<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
    }
    .nav-tabs{
        overflow-x: auto;
        overflow-y:hidden;
        flex-wrap: nowrap;
    }
    .nav-tabs .nav-item{
        white-space: nowrap;
    }
    .form-control-md{
        max-width: -webkit-fill-available;
    }
    #main_div_center{
        margin-inline: auto;
        padding: 2.0rem !important;
    }
    .paddingcontainer{
        padding: 1rem 1.2rem;
    }
    .maincontainer{
        margin-top: 4rem;
    }
    #editCropItem{
        margin-left: 4.3rem !important;
    }
</style>

<?php
    nav_bar_Add_to_crop();
?>

<!-- orderdetails crop model starts-->
    <div class="modal fade" id="orderdetailscropmodel" tabindex="-1" role="dialog" aria-hidden="true" style="max-width: 100%;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h4 class="modal-title text-success">Purchaser Infromation</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center" id="odrededcropdetailsinfromation">
                
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
<!-- orderdetails crop model ends-->

<!-- increase Quantity model starts-->
    <div class="modal fade" id="increasecropquantity" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Increase Quantity</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" id="closeaddaddressmodel" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body" id="increaseformid">
                        <h5 class="form-label"><b>Enter Quantity In Kg </b></h5>
                        <input type="number" name="SelectQuantitytoincrease" id="SelectQuantitytoincrease" onkeyup="cropQuantityvalidationincrease()" placeholder="Enter Quantity" class="form-control form-control-lg ml-0" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="increasequantityofcrop">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- increase Quantity model ends-->

<div class="container-fluid">

    <!-- Back and add crop button starts -->
    <div class="row" style="margin-top: 4.8rem !important;">
        <div class="col-2 col-sm-6 col-md-6 col-lg-6 mr-auto justify-content-center">
            <form method="post">
                <button class="btn btn-primary btn-md" name="backtohomefromaddcrop" text="Back To Home"><i class="fa fa-arrow-left fa-lg mr-2 text-danger"></i>Back</button>
            </form>
        </div>
        <div class="col-10 col-sm-6 col-md-6 col-lg-6 ml-auto">
            <?php
            if(isset($_SESSION['SecureLoginSession']))
            {
                if($_SESSION['LoginFarmerUserType'] == 'FARMER')
                {
                    $selectExistemail=$pdo->prepare("SELECT COUNT(E_mail_id) AS emailuniqueforaddcrop FROM add_crop_image_table WHERE E_mail_id = :E_mail_id");
                    $selectExistemail->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                    $fetch_unique_email = $selectExistemail ->fetch(PDO::FETCH_ASSOC);

                    if($fetch_unique_email['emailuniqueforaddcrop'] > 0)
                    {
                        echo '<button class="btn btn-primary btn-lg pl-5 pr-5 pt-1 pb-1 float-right" id="add_crop_item_modal" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_another_crop_items"><i class="fa fa-plus-circle pr-3"></i> Add Crop</button>';
                    }
                }
            }
            
            ?> 
        </div>
    </div>
    <div class="col-md-12">
        <?php
            if(isset($message)){
                echo '<div class="alert alert-danger p-1 col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><h4>'.$message.'</h4></div>';
            }
        ?>
    </div>
    <!-- Back and add crop button ends -->

    <!-- status of the crop and oparation starts -->
    <div class="row">
        <?php
            if(isset($_SESSION['SecureLoginSession']))
            {   
                if($_SESSION['LoginFarmerUserType'] == 'FARMER')
                {
                    $selectExistemail=$pdo->prepare("SELECT COUNT(E_mail_id) AS emailuniqueforaddcrop FROM add_crop_image_table WHERE E_mail_id = :E_mail_id");
                    $selectExistemail->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                    $fetch_unique_email = $selectExistemail ->fetch(PDO::FETCH_ASSOC);

                    $selectExistemailaddress=$pdo->prepare("SELECT COUNT(E_mail_id) AS emailuniqueforaddaddress FROM farmer_user_address_table WHERE E_mail_id = :E_mail_id");
                    $selectExistemailaddress->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                    $fetch_unique_email_address = $selectExistemailaddress ->fetch(PDO::FETCH_ASSOC);

                    if($fetch_unique_email_address['emailuniqueforaddaddress'] == 0)
                    {
                        echo '<div class="col-10 col-sm-12 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-4" id="main_div_center" style="border-radius:0.5rem;border: 2px solid #000;">
                                <h3>Please Enter the address Before Add the Crop Into the Website</h3>
                                <form method="post">
                                    <button class="btn btn-primary" name="addaddressbeforecropupload">Add Address</button>
                                </form>
                            </div>';
                    }
                    elseif($fetch_unique_email['emailuniqueforaddcrop'] == 0)
                    {
                        echo '<div class="col-10 col-sm-12 col-md-8 col-lg-5 justify-content-center align-items-center bg-white" id="main_div_center" style="border-radius:0.5rem;border: 2px solid #000;">
                                <h2 class="text-success text-center">Add Crop</h2>
                                <form method="post" class="paddingcontainer" enctype="multipart/form-data">
                                <label class="form-label"><b>Category</b></label>
                                <select name="CropCategory" id="CropCategoryNoCrop" class="custom-select form-control-lg" required="required">
                                    <option value = "Select">-- Select --</option>';
                                        $SqlSelectCategory = $pdo->prepare("SELECT * FROM crop_category");
                                        $SqlSelectCategory->execute();
                                        while($FetchIdAndCategory = $SqlSelectCategory -> fetch(PDO::FETCH_ASSOC)){
                                            $Category_Id = $FetchIdAndCategory['ID'];
                                            $Category_name = $FetchIdAndCategory['category_name'];
                                            echo '<option value = "'.$Category_Id.'">'.$Category_name.'</option>';
                                        }
                                echo '</select><br><br> 
                                <label class="form-label"><b>Name of crop</b></label>
                                <select name="CropCategoryName" id="CropCategoryNameNoCrop" class="custom-select form-control-lg" required="required">
                                    <option value = "Select">-- Select --</option>
                                </select><br><br>
                                
                                <label class="form-label" id="editcropid"><b>Quantity</b></label>
                                    <input type="number" name="Quantity" id="Quantity" onkeyup="cropQuantityvalidation()" placeholder="Enter Quantity in Kg" class="form-control form-control-lg ml-0" required="required"> 
                                    
                                <label class="form-label"><b>Crop Price per Kg</b></label>
                                    <input type="text" name="CropPrice" id="CropPrice" onkeyup="cropPricevalidation()" placeholder="Enter Crop Price in Rupees per Kg" autocomplete="off" class="form-control form-control-lg ml-0" required="required"><br>

                                <label class="form-label"><b>Descriptoin About Crop</b></label>
                                    <textarea rows="3" name="crop_description" maxlength="150" id="crop_description" placeholder="Enter Descriptoin About Crop" class="form-control form-control-lg ml-0" required="required"></textarea>
                                
                                <label class="form-label"><b>Crop Image</b></label>
                                <div class="mb-3 input-group">
                                    <input class="form-control form-control-lg" type="file" name="CropImage"  id="CropImage" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="far fa-image fa-lg"></i></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-2" name="AddToCropSubmitButton">Upload Crop</button>
                            </form>
                            </div>
                        
                    ';
                    }
                    else
                    {
                        $selectApprovedcount= $pdo->prepare("SELECT COUNT(crop_status) AS Approved_count FROM add_crop_image_table WHERE crop_status = :crop_status AND E_mail_id = :E_mail_id");
                        $selectApprovedcount -> execute(array(':crop_status' => $Approved,':E_mail_id'=>$_SESSION['SecureLoginSession']));
                        $fetch_Approved_count = $selectApprovedcount -> fetch(PDO::FETCH_ASSOC);

                        $selectnotApprovedcount= $pdo->prepare("SELECT COUNT(crop_status) AS NotApproved_count FROM add_crop_image_table WHERE crop_status = :crop_status AND E_mail_id = :E_mail_id");
                        $selectnotApprovedcount -> execute(array(':crop_status' => $NotApproved,':E_mail_id'=>$_SESSION['SecureLoginSession']));
                        $fetch_notapproved_count = $selectnotApprovedcount -> fetch(PDO::FETCH_ASSOC);

                        $selectrejectedcount= $pdo->prepare("SELECT COUNT(crop_status) AS Rejected_count FROM add_crop_image_table WHERE crop_status =:crop_status AND E_mail_id = :E_mail_id");
                        $selectrejectedcount -> execute(array(':crop_status' => $Rejected,':E_mail_id'=>$_SESSION['SecureLoginSession']));
                        $fetch_rejected_count = $selectrejectedcount -> fetch(PDO::FETCH_ASSOC);
                                    
                        echo '
                        <div class="col-12">
                            <ul class="nav nav-tabs pl-5">
                                <li class="mr-5 nav-item"><a class="nav-link active text-success" data-bs-toggle="tab" href="#Crop_approved_items"><i class="fas fa-check fa-lg mr-2 text-success"></i>Approved Crops ('.$fetch_Approved_count['Approved_count'].')</a></li>
                                <li class="mr-5 nav-item"><a class="nav-link text-warning" data-bs-toggle="tab" href="#Crop_not_approved_items"><i class="fa fa-spinner fa-lg mr-2 text-warning"></i>In Progress Crops ('.$fetch_notapproved_count['NotApproved_count'].')</a></li>
                                <li class="mr-5 nav-item"><a class="nav-link text-danger" data-bs-toggle="tab" href="#Crop_rejected_items"><i class="fa fa-times-circle fa-lg mr-2 text-danger"></i>Rejected Crops ('.$fetch_rejected_count['Rejected_count'].')</a></li>
                            </ul>
                        </div>';

                        echo '<div class="tab-content">';

                            echo '<div id="Crop_approved_items" class="tab-pane active">
                            <div class="container ml-0" style="max-width: 100%;">
                                <div class="row text-center">';
                                    if($fetch_Approved_count['Approved_count'] > 0)
                                    {
                                        $SelectApprovedCrop = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE E_mail_id = :E_mail_id AND crop_status =:crop_status");
                                        $SelectApprovedCrop->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession'],':crop_status' =>$Approved));

                                        while($FetchApprovedCrop = $SelectApprovedCrop->fetch(PDO::FETCH_ASSOC))
                                        {
                                            echo '<div class="col-xs-12 col-sm-7 col-md-3 my-3 mx-3 bg-white" style="width: 13rem; height:20rem;" id="row">
                                                    <div class="card-shadow">
                                                        <div class="card-shadow my-2 mr-3">
                                                            <img src='.$FetchApprovedCrop['crop_image'].' alt="image1" class="img-fluid card-img-top rounded mr-2">
                                                        </div>
                                                        <div class="col-12 rounded alert-success p-1">
                                                            <span class="fa fa-check fa-lg text-check"></span><span class="ml-2">Approved</span>
                                                        </div>
                                                        
                                                        <div class="card-body pt-2 ml-0"> 
                                                            <h5><p class="card-title m-0 ">'.$FetchApprovedCrop['crop_name']."(".$FetchApprovedCrop['crop_category'].")".'</p></h5>
                                                            <h5>
                                                                <span class="text-success">₹ Rs '.$FetchApprovedCrop['crop_price'].' ('.$FetchApprovedCrop['crop_quantity'].'Kg)</span>
                                                            </h5>
                                                        </div>';
                                                        if($FetchApprovedCrop['crop_quantity'] < 1)
                                                        {
                                                            echo '<div class="row" style="overflow-x: auto;overflow-y:hidden;flex-wrap: nowrap;">
                                                                    <div class="col-6 col-md-6">';
                                                                        $selectcountofpurchasedcrop = $pdo->prepare("SELECT COUNT(Crop_id) AS CropIdpurchasedCount FROM purchased_crop_item WHERE farmer_E_mail_id = :farmer_E_mail_id AND Crop_id =:crop_id");
                                                                        $selectcountofpurchasedcrop->execute(array(':farmer_E_mail_id' => $_SESSION['SecureLoginSession'], ':crop_id' => $FetchApprovedCrop['Crop_id']));
                                                                        $FetchApprovedcount = $selectcountofpurchasedcrop->fetch(PDO::FETCH_ASSOC);
                                                                        echo '<button type="button" class="btn btn-success btn-md" value="'.$FetchApprovedCrop['Crop_id'].'" id="veiworderedpurcherdetails" data-bs-toggle="modal" data-toggle="modal" data-target="#orderdetailscropmodel"><i class="fas fa-eye mr-2 text-white fa-lg"></i><span class="badge badge-primary">'.$FetchApprovedcount['CropIdpurchasedCount'].'</span></button>
                                                                    </div>
                                                                    <div class="col-6 col-md-6 pl-3">
                                                                        <button class="btn btn-success btn-md" value="'.$FetchApprovedCrop['Crop_id'].'" id="increasequantity" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#increasecropquantity"><i class="fas fa-arrow-up text-white fa-lg"></i></button>
                                                                    </div>
                                                                </div>
                                                            ';
                                                        }
                                                        else{
                                                            echo '<div class="col-12 col-md-12">';
                                                                    $selectcountofpurchasedcrop = $pdo->prepare("SELECT COUNT(Crop_id) AS CropIdpurchasedCount FROM purchased_crop_item WHERE farmer_E_mail_id = :farmer_E_mail_id AND Crop_id =:crop_id");
                                                                    $selectcountofpurchasedcrop->execute(array(':farmer_E_mail_id' => $_SESSION['SecureLoginSession'], ':crop_id' => $FetchApprovedCrop['Crop_id']));
                                                                    $FetchApprovedcount = $selectcountofpurchasedcrop->fetch(PDO::FETCH_ASSOC);
                                                                    echo '<button type="button" class="btn btn-success btn-md" value="'.$FetchApprovedCrop['Crop_id'].'" id="veiworderedpurcherdetails" data-bs-toggle="modal" data-toggle="modal" data-target="#orderdetailscropmodel"><i class="fas fa-eye mr-2 text-white fa-lg"></i><span class="badge badge-primary">'.$FetchApprovedcount['CropIdpurchasedCount'].'</span></button>
                                                                </div>';
                                                        }
                                                    echo '</div>
                                            </div>';                                        
                                        }
                                    }
                                    else{
                                        echo '
                                            <div class="container-fluid maincontainer p-4">
                                                <div class="row p-3">
                                                    <div class="col-12 col-sm-9 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-4" id="main_div_center">
                                                        <h2 text-white>You dont have any Approved Crops</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                   echo '</div>
                                </div>
                            </div>';

                            echo '<div id="Crop_not_approved_items" class="tab-pane">
                                    <div class="container ml-0" style="max-width: 100%;">
                                        <div class="row text-center">';
                                        if($fetch_notapproved_count['NotApproved_count'] > 0)
                                        {
                                            $SelectNotApprovedCrop = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE E_mail_id = :E_mail_id AND crop_status =:crop_status");
                                            $SelectNotApprovedCrop->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession'],':crop_status' =>$NotApproved));
                                            while($FetchNotApprovedCrop = $SelectNotApprovedCrop->fetch(PDO::FETCH_ASSOC))
                                            {
                                                crop_product_for_perticular_farmer($FetchNotApprovedCrop['Crop_id'],$FetchNotApprovedCrop['crop_name'],$FetchNotApprovedCrop['crop_category'],$FetchNotApprovedCrop['crop_quantity'],$FetchNotApprovedCrop['crop_price'],$FetchNotApprovedCrop['crop_image'], $FetchNotApprovedCrop['crop_status']);
                                            }
                                        }
                                        else{
                                            echo '
                                                <div class="container-fluid maincontainer">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-9 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-4" id="main_div_center">
                                                            <h2 text-white>You dont have any In Progress     Crops</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                   echo '</div>
                                </div>
                            </div>';

                            echo '<div id="Crop_rejected_items" class="tab-pane">
                                    <div class="container ml-0" style="max-width: 100%;">
                                        <div class="row text-center">';
                                        if($fetch_rejected_count['Rejected_count'] > 0)
                                        {
                                            $SelectRejectedCrop = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE E_mail_id = :E_mail_id AND crop_status =:crop_status");
                                            $SelectRejectedCrop->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession'],':crop_status' =>$Rejected));
                                            while($FetchRejectedCrop = $SelectRejectedCrop->fetch(PDO::FETCH_ASSOC))
                                            {
                                                crop_product_for_perticular_farmer($FetchRejectedCrop['Crop_id'],$FetchRejectedCrop['crop_name'],$FetchRejectedCrop['crop_category'],$FetchRejectedCrop['crop_quantity'],$FetchRejectedCrop['crop_price'],$FetchRejectedCrop['crop_image'], $FetchRejectedCrop['crop_status']);
                                            }
                                        }
                                        else{
                                            echo '
                                            <div class="container-fluid maincontainer">
                                                <div class="row">
                                                    <div class="col-12 col-sm-9 col-md-8 col-lg-5 mt-3 justify-content-center align-items-center bg-white p-5" id="main_div_center">
                                                        <h2 text-white>You dont have any Rejected Crops</h2>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                                        }
                                   echo '</div>
                                </div>
                            </div>';

                        echo '</div>';
                    }
                }
                else{
                    echo '<h1 class="text-danger">You Are Not Outherised as a farmer</h1>';
                }
            }
        ?>
    </div>
    <!-- status of the crop and oparation ends -->
</div> 

<!-- ------------------- Model for crop upload ----------------->
        
    <div class="modal fade" id="add_another_crop_items" tabindex="-1" aria-labelledby="add_another_crop_items_text" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border:3px solid green";>
                <div class="modal-header">
                    <h3 class="modal-title" id="add_another_crop_items_text">Add Crop</h3>
                    <form method="post">
                        <button name="close_modal" type="submit" class="btn-close"></button>
                    </form>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-8 col-lg-12 justify-content-center align-items-center bg-white">
                        <form method="post" class="paddingcontainer" id="formforeditandadd" enctype="multipart/form-data">
                            <label class="form-label"><b>Category</b></label>
                            <select name="CropCategory" id="CropCategory" class="custom-select form-control-lg" required="required">
                                <option value = "Select">-- Select --</option>
                                <?php 
                                    $SqlSelectCategory = $pdo->prepare("SELECT * FROM crop_category");
                                    $SqlSelectCategory->execute();
                                    while($FetchIdAndCategory = $SqlSelectCategory -> fetch(PDO::FETCH_ASSOC)){
                                        $Category_Id = $FetchIdAndCategory['ID'];
                                        $Category_name = $FetchIdAndCategory['category_name'];
                                        echo '<option value = "'.$Category_Id.'">'.$Category_name.'</option>';
                                    }
                                ?>
                            </select><br><br> 
                            <label class="form-label"><b>Name of crop</b></label>
                            <select name="CropCategoryName" id="CropCategoryName" class="custom-select form-control-lg" required="required">
                                <option value = "Select">-- Select --</option>
                            </select><br><br>
                            
                            <label class="form-label"><b>Quantity</b></label>
                                <input type="number" name="Quantity" id="Quantity" onkeyup="cropQuantityvalidation()" placeholder="Enter Quantity in Kg" class="form-control form-control-lg ml-0" required="required"> 
                                
                            <label class="form-label"><b>Crop Price per Kg</b></label>
                                <input type="text" name="CropPrice" id="CropPrice" onkeyup="cropPricevalidation()" placeholder="Enter Crop Price in Rupees per Kg" autocomplete="off" class="form-control form-control-lg ml-0" required="required"><br>

                            <label class="form-label"><b>Descriptoin About Crop</b></label>
                                <textarea rows="3" name="crop_description" maxlength="150" id="crop_description" placeholder="Enter Descriptoin About Crop" class="form-control form-control-lg ml-0" required="required"></textarea>
                            
                            <label class="form-label"><b>Crop Image</b></label>
                            <div class="mb-3 input-group">
                                <input class="form-control form-control-lg" type="file" name="CropImage"  id="CropImage" required="required">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-image fa-lg"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" id="add_crop_item" name="AddToCropSubmitButton">Upload Crop</button><br><br>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ------------------- Model for crop upload ----------------->

<!-- delete crop model starts-->
    <div class="modal fade" id="deletecropmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletecropmodal_text">Delete Crop</h5>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <h4>Are you sure You want to Delete the Crop</h4>
                        <input type="hidden" name="deletecropname" id="deletecropId">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" name="backtosamepage">Close</button>
                        <button type="submit" class="btn btn-danger" name="DeleteCropData">Delete Crop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
<!-- delete crop model ends-->

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#CropCategory').change(function () { 
            var cropCategoryid = $(this).val();
            console.log(cropCategoryid);
            $.ajax({
                type: 'post',
                url: 'RetriveDataForCropName.php',
                data: {categoryId: cropCategoryid},
                dataType: 'JSON',
                success: function (response) {
                    var len = response.length;
                    $('#CropCategoryName').empty();
                    
                    for(var i=0; i < len; i++){
                        var ID = response[i].id;
                        var NAME = response[i].name;
                        console.log(ID);
                        $('#CropCategoryName').append("<option value='"+ID+"'>"+NAME+"</option>");
                    }
                }
            });
        });
    });
    
    $(document).on('click','#increasequantity',function(e){
        e.preventDefault();
        var increasecropid = $(this).val();

        var hiddeninput = "<input type='hidden' id='increaseidcropidid' value='"+increasecropid+"' name='increaseidcrop'>";
        $(hiddeninput).appendTo('.modal-body#increaseformid');
        
    });
    
    $(document).on('click','#closeaddaddressmodel',function()
    {
        $('#increaseidcropidid').remove();
        $('form').trigger('reset');
    });
</script>

 <script type="text/javascript">
        $(document).on('click','#deleteCropItem',function (e) {
            e.preventDefault();
            $("#deletecropId").val("");
            var deletecropid = $(this).val();
            $('#deletecropId').val(deletecropid);
            $('#deletecropmodal').modal('show');
            
            
        });

        $(document).on('click','#veiworderedpurcherdetails',function (e) {
            e.preventDefault();
            var orderDetailscropId = $(this).val();
            console.log(orderDetailscropId);
            $.ajax({
                type: "post",
                url: "ReteriveOrderedDetails.php",
                data: {oderdetailsid: orderDetailscropId},
                dataType: "JSON",
                success: function (response) {
                    var len = response.length;
                    $('#odrededcropdetailsinfromation').empty();
                    if(len > 0)
                    {
                        for(var i=0; i < len; i++)
                        {
                            var order_id1 = response[i].order_id;
                            var selected_quantity1 = response[i].selected_quantity;
                            var Purchaser_name1 = response[i].Purchaser_name;
                            var purchaser_phone_number1 = response[i].purchaser_phone_number;
                            var profile_image1 = response[i].purchaser_profileimage;
                            var crop_price_per_kg = response[i].crop_price_p_kg;
                            var Total_cost = response[i].total_cost;
                            var profileimage = "<div class='col-12 col-md-5'><img src='"+profile_image1+"' class='img-responsive p-3' style='width:100%;height:17rem;border-radius:2rem;'></div>";
                            var orderdetailsinfo = "<div class='col-12 col-md-7'><table class='table table-bordered' style='border: 1.2px solid #5e5e5c;line-height:1.5rem;'><tbody><tr class='text-success'><th><h5>Order ID</h5></th><th><h5>"+order_id1+"</h5></th><tr><th>Purchser Name</th><th>"+Purchaser_name1+"</th></tr><tr><th>Mobile Number</th><th>"+purchaser_phone_number1+"</th></tr><th>Crop Price/Kg</th><th>₹ "+crop_price_per_kg+" Rs</th></tr><tr><th>Purchased Qantity</th><th>"+selected_quantity1+" Kg</th></tr><tr class='text-success'><th><h5>Total amount</h5></th><th><h5>₹ "+Total_cost+" Rs</h5></th></tr></tbody></table></div><hr>";
                            $(profileimage).appendTo('.row#odrededcropdetailsinfromation');
                            $(orderdetailsinfo).appendTo('.row#odrededcropdetailsinfromation');
                        }
                    }
                    else{
                        var profileimage = "<div class='col-md-12 text-center'><h3>Product is Not purchased By any body</h3></div>";
                        $(profileimage).appendTo('.row#odrededcropdetailsinfromation');
                    }
                }
            });
        });

        $(document).on('click','#editCropItem',function (e) {
            e.preventDefault();
            var editcropid = $(this).val();
            $.ajax({
                type: "post",
                url: "RejectedCropEdit.php",
                data: {cropid: editcropid},
                dataType: "JSON",
                success: function (response) {
                    if(response){
                        $("#add_another_crop_items_text").text('Edit Crop');
                        $('#CropCategory').val(response.crop_category);
                        $('#Quantity').val(response.crop_quantity);
                        $('#CropPrice').val(response.crop_price);
                        $('#crop_description').val(response.crop_description);
                        var input_hidden = "<input type='hidden' name='edit_crop_id' value='"+response.crop_id+"' >";
                        $(input_hidden).appendTo('form#formforeditandadd');
                        $('#add_crop_item').remove();
                        var button_edit = "<button type='submit' class='btn btn-primary btn-lg btn-block' name='edit_crop_detail_submit'>Update Crop</button>";
                        $(button_edit).appendTo('form#formforeditandadd');
                    }
                }
            });
        });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#CropCategoryNoCrop').change(function () { 
            var cropCategoryid = $(this).val();
            $.ajax({
                type: 'post',
                url: 'RetriveDataForCropName.php',
                data: {categoryId: cropCategoryid},
                dataType: 'JSON',
                success: function (response) {
                    var len = response.length;
                    $('#CropCategoryNameNoCrop').empty();

                    for(var i=0; i < len; i++){
                        var ID = response[i].id;
                        var NAME = response[i].name;
                        console.log(ID);
                        $('#CropCategoryNameNoCrop').append("<option value='"+ID+"'>"+NAME+"</option>");
                    }
                }
            });
        });
    });
</script>

</body>


<script>
    
    function cropQuantityvalidationincrease()
    {
        var CropQuantityInput=document.getElementById('SelectQuantitytoincrease').value;
        var cropQuantityvalidation4=/^[1-9]{1,}/;
        var cropQuantityNagative = /^((\-(\d*)))$/;
            if(cropQuantityvalidation4.test(CropQuantityInput) && !cropQuantityNagative.test(CropQuantityInput)){
                document.getElementById('SelectQuantitytoincrease').style.border='3px dashed green';
            }
            else{
                document.getElementById('SelectQuantitytoincrease').style.border='3px dashed red';
            }
    }
    
    function cropQuantityvalidation() 
    { 
        var CropQuantityInput=document.getElementById('Quantity').value;
        var cropQuantityvalidation=/^[1-9]{1,}/;
        var cropQuantityNagative = /^((\-(\d*)))$/;
            if(cropQuantityvalidation.test(CropQuantityInput) && !cropQuantityNagative.test(CropQuantityInput)){
                document.getElementById('Quantity').style.border='3px dashed green';
            }
            else{
                document.getElementById('Quantity').style.border='3px dashed red';
            }
    }
    function cropPricevalidation() 
    { 
        var CropPriceInput=document.getElementById('CropPrice').value;
        var cropPricevalidation=/^[1-9]{1,}/;
        var cropPriceNagative = /^((\-(\d*)))$/;
            if(cropPricevalidation.test(CropPriceInput) && !cropPriceNagative.test(CropPriceInput)){
                document.getElementById('CropPrice').style.border='3px dashed green';
            }
            else{
                document.getElementById('CropPrice').style.border='3px dashed red';
            }
    }

</script>
</html>
