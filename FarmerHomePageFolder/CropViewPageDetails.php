<?php
    session_start();

    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";

    if(isset($_POST['backtohomefromaddcrop']))
    {
        header('Location: HomePageFarmerPortal.php');
    }

    if(isset($_POST['Back_to_address_page']))
    {
        $_SESSION['Add_address'] = "Please Add Address Before Buy The Crop";
        header('Location: ../SideBarActivities/ProfileAndPersonalInformation.php#');
    }

    if(isset($_POST['close_qantity_select_model']))
    {
        header('Location: CropViewPageDetails.php');
    }

    if(isset($_POST['addquantityforselctedcrop']))
    {
        $crop_quantity_selected = $_POST['SelectQuantity'];

        $selectQuantityofselectedcrop=$pdo->prepare("SELECT crop_quantity FROM add_crop_image_table WHERE Crop_id = :Crop_id");
        $selectQuantityofselectedcrop->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
        $fetchbuyqantity = $selectQuantityofselectedcrop ->fetch(PDO::FETCH_ASSOC);

        if($crop_quantity_selected <= $fetchbuyqantity['crop_quantity'])
        {
            if(preg_match("/^[1-9]{1,}/",$crop_quantity_selected))
            {
                if(!preg_match("/^((\-(\d*)))$/", $crop_quantity_selected))
                {
                    $_SESSION['crop_quantity_selected'] = $crop_quantity_selected;

                    header("location: OrderSummary.php");
                }
                else{
                    $message ='<labe>Crop Quantity Should be Positive</label>';
                }
            }
            else{
                $message ='<labe>Crop Quantity Should not be Zero</label>';
            }
        }
        else{
            $message='<label>You Have Entered More Quantity</label>';
        }

    }

    if(isset($_POST['gotofavourites']))
    {
        header('location: ../SideBarActivities/MyFavouriteFarmerUser.php');
    }

    if(isset($_POST['addtofavourites']))
    {
        $sqlforcropdetailsselection = $pdo->prepare("SELECT * FROM sign_up_farmer_information INNER JOIN add_crop_image_table ON add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND add_crop_image_table.Crop_id = :Crop_id");
        $sqlforcropdetailsselection->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
        $fetchfarmerdetils = $sqlforcropdetailsselection->fetch(PDO::FETCH_ASSOC);

        $sqlforfavouritescropinsert = $pdo->prepare("INSERT INTO farmer_user_favourite (Crop_id, E_mail_id, first_name, last_name) 
                                                    VALUES (:Crop_id, :E_mail_id, :first_name, :last_name)");
        $sqlforfavouritescropinsert->execute(array(
                    ':Crop_id' => $_SESSION['View_Crop_Id'],
                    ':E_mail_id' => $_SESSION['SecureLoginSession'],
                    ':first_name' => $fetchfarmerdetils['first_name'],
                    ':last_name' => $fetchfarmerdetils['last_name']
        ));
        $successAddTofavourite = '<labe>Crop Successfully Added To Favourites</label>';
    }
    
    
?>
<?php
    nav_bar_profile();
?>
<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
    }
    #main_div_center{
        margin-inline: auto;
    }
    #address_center{
        margin-inline: auto;
    }
    #box_shadow{
        box-shadow: 0px 0px 10px;
    }
</style>

<!-- add Quantity model starts-->
    <div class="modal fade" id="select_qantity_for_buy" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Quantity</h5>
                    <form method="post">
                        <button type="submit" class="btn-close" name="close_qantity_select_model"></button>
                    </form>
                </div>
                <form method="post">
                    <div class="modal-body">
                    <?php
                        $selectQuantityofselectedcrop=$pdo->prepare("SELECT crop_quantity FROM add_crop_image_table WHERE Crop_id = :Crop_id");
                        $selectQuantityofselectedcrop->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
                        $fetchbuyqantity = $selectQuantityofselectedcrop ->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <h5 class="form-label"><b>Enter Quantity Out Of <?php echo $fetchbuyqantity['crop_quantity']?> Kg </b></h5>
                        <input type="number" name="SelectQuantity" id="SelectQuantity" onkeyup="cropQuantityvalidation()" placeholder="How Much You Buy" class="form-control form-control-lg ml-0" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="addquantityforselctedcrop">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    
    </div>
 <!-- add Quantity model ends-->

 <!-- view all comments starts -->
    <div class="modal fade" id="viewallcomments" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border:2px solid orange";>
            <div class="modal-header">
                <?php
                    $sqlforavgrating = $pdo->prepare("SELECT AVG(crop_rating) AS cropavgrating FROM crop_comments WHERE Crop_id =:Crop_id");
                    $sqlforavgrating->execute(array(':Crop_id'=>$_SESSION['View_Crop_Id']));
                    $fetchforavgrating = $sqlforavgrating->fetch(PDO::FETCH_ASSOC);
                ?>
                <h3 class="modal-title" id="exampleModalLabel">Ratings And Comments <?php echo '<span class="bg-success text-white pl-2 pr-2 rounded pt-1 pb-1">'.round($fetchforavgrating['cropavgrating'],1).'<i class="fas fa-star ml-2"></i></span>' ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <?php
                    $sqlallcomments = $pdo->prepare("SELECT * FROM crop_comments WHERE Crop_id =:Crop_id ORDER BY crop_rating DESC");
                    $sqlallcomments->execute(array(":Crop_id" => $_SESSION['View_Crop_Id']));
                    while($fetchallcomments = $sqlallcomments->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '
                            <ul>
                                <li><h4>
                                    <span>---'.$fetchallcomments['purchaser_name'].'</span><span class="pl-3"></span>';
                                        for($i=0; $i<$fetchallcomments['crop_rating'];$i++){
                                            echo '<i class="fas fa-star fa-md text-success"></i>';
                                        }
                                        for($j=0; $j<(5 - $fetchallcomments['crop_rating']);$j++){
                                            echo '<i class="far fa-star fa-md"></i>';
                                        }
                                        echo '</h4>
                                    <h5><cite>"'.$fetchallcomments['comments'].'"</cite> || '.$fetchallcomments['date_of_comments'].'</h5>
                                </li><hr>
                            </ul>
                        ';
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">View Less<i class="fas fa-eye ml-2"></i></button>
            </div>
            </div>
        </div>
    
    </div>
 <!-- view all commnets ends -->

<div class="container-fluid" style="width:95%;">
    <div class="row">
        <div class="col-5 col-sm-1 col-md-3 mr-auto" style="margin-top: 5rem !important;">
            <form method="post">
                <button class="btn btn-primary btn-md" name="backtohomefromaddcrop"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To Home</button>
            </form>
        </div>
        <?php
            if(isset($_SESSION['SecureLoginSession']))
            {
                if(isset($_SESSION['View_Crop_Id']))
                {
                    $Select_perticular_crop_details = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                            add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND Crop_id = :Crop_id");
                    $Select_perticular_crop_details->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
                    $FetchPerticularCrop = $Select_perticular_crop_details->fetch(PDO::FETCH_ASSOC);
                    
                    $sqlforavgrating = $pdo->prepare("SELECT AVG(crop_rating) AS cropavgrating FROM crop_comments WHERE Crop_id =:Crop_id");
                    $sqlforavgrating->execute(array(':Crop_id'=>$_SESSION['View_Crop_Id']));
                    $fetchforavgrating = $sqlforavgrating->fetch(PDO::FETCH_ASSOC);

                    if(isset($message)){
                        echo '<div class="alert alert-danger col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
                    }
                    if(isset($successAddTofavourite)){
                        echo '<div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><h5>'.$successAddTofavourite.'</h5></div>';
                    }
                    
                    echo '<div class="row bg-white" id="main_div_center" style="border: 2px solid green;width:100%">
                            <div class="row p-2">
                                <h3 class="text-success text-center">Crop And Farmer Details Are Mentioned Below</h3>
                            </div><hr>

                            <div class="row p-3">
                                <div class="col-md-5">
                                    <img src="'.$FetchPerticularCrop['crop_image'].'" class="img-responsive rounded" style="width:100%;height:17rem;">
                                </div>
                                <div class="col-md-7 pt-3">
                                    <table class="table table-striped table-bordered" style="line-height:1rem;">
                                        <tbody>
                                            <tr>
                                                <th><h5>Crop Name</h5></th>
                                                <th><h5>'.$FetchPerticularCrop['crop_name'].'</h5></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Crop category</h5></th>
                                                <th><h5>'.$FetchPerticularCrop['crop_category'].'</h5></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Price per Kg</h5></th>
                                                <th><h5>₹ Rs '.$FetchPerticularCrop['crop_price'].'</h5></th>
                                            </tr>
                                            <tr>
                                                <th><h5>Qantity in Kg</h5></th>
                                                <th><h5>'.$FetchPerticularCrop['crop_quantity'].' Kg</h5></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h5><p><cite>&emsp;&emsp;"'.$FetchPerticularCrop['crop_description'].'"</cite></p></h5>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-12 col-md-5 pt-4 pl-4">
                                    <div class="row">
                                        <h2 class="text-success">Ratings And Comments <span class="bg-success text-white pl-2 pr-2 rounded pt-1 pb-1">'.round($fetchforavgrating['cropavgrating'],1).'<i class="fas fa-star ml-2"></i></span></h2>';
                                            $sqlcomments = $pdo->prepare("SELECT * FROM crop_comments WHERE Crop_id =:Crop_id AND crop_rating > 3 ORDER BY crop_rating DESC LIMIT 4");
                                            $sqlcomments->execute(array(":Crop_id" => $_SESSION['View_Crop_Id']));

                                            $sqlforcommentscount = $pdo->prepare("SELECT COUNT(Crop_id) AS Crop_id_Count FROM crop_comments WHERE Crop_id =:Crop_id");
                                            $sqlforcommentscount->execute(array(":Crop_id" => $_SESSION['View_Crop_Id']));
                                            $fetchcommentscount = $sqlforcommentscount->fetch(PDO::FETCH_ASSOC);

                                            if($fetchcommentscount['Crop_id_Count'] > 0)
                                            {
                                                while($fetchcomments = $sqlcomments->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    echo '
                                                        <ul>
                                                            <li><h4>
                                                                <span>---'.$fetchcomments['purchaser_name'].'</span><span class="pl-3"></span>';
                                                                    for($i=0; $i<$fetchcomments['crop_rating'];$i++){
                                                                        echo '<i class="fas fa-star fa-md text-success"></i>';
                                                                    }
                                                                    for($j=0; $j<(5 - $fetchcomments['crop_rating']);$j++){
                                                                        echo '<i class="far fa-star fa-md"></i>';
                                                                    }
                                                                    echo '</h4>
                                                                <h5><cite>"'.$fetchcomments['comments'].'"</cite> || '.$fetchcomments['date_of_comments'].'</h5>
                                                            </li>
                                                        </ul>
                                                    ';
                                                }
                                            }
                                            else{
                                                echo '<div class="row"><div class="col-12 p-4 mt-5" id="box_shadow">
                                                        <h3 class="text-center">No Rating And Comments</h3>
                                                    </div></div>
                                                ';
                                            }
                                            if($fetchcommentscount['Crop_id_Count'] > 0)
                                            {
                                                echo '<div class="col-12 col-md-10">
                                                    <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#viewallcomments" title="Veiw">View More<i class="fas fa-eye ml-2 text-white"></i></button>
                                                    </div>
                                                ';
                                            }

                                    echo '</div>
                                </div>
                            
                                <div class="col-md-7 mt-3 pl-3">
                                    <div class="row">
                                        <div class="col-12 col-sm-4 col-md-4 col-lg-3" style="border-right: 1px solid #5e5e5c">
                                            <img src="'.$FetchPerticularCrop['profile_picture'].'" class="img-fluid" width="100%">
                                        </div>
                                        <div class="col-12 col-sm-8 col-md-8 col-lg-8 pt-3">
                                            <h4 class="text-success"><i class="fas fa-user mr-3"></i><span>'.$FetchPerticularCrop['first_name']." ".$FetchPerticularCrop['last_name'].'</span></h4>
                                            <h4 class="text-success"><i class="fas fa-envelope mr-3"></i><span>'.$FetchPerticularCrop['E_mail_id'].'</span></h4>
                                            <h4 class="text-success"><i class="fas fa-phone mr-3"></i><span>'.$FetchPerticularCrop['phone_number'].'</span></h4>
                                        </div>
                                    </div><hr>
                                    <div class="row pl-3 pt-3">';
                                        $Sqlfordefaultaddress = $pdo->prepare("SELECT * FROM farmer_user_address_table INNER JOIN add_crop_image_table ON add_crop_image_table.E_mail_id = farmer_user_address_table.E_mail_id WHERE Crop_id = :Crop_id AND default_address = :default_address");
                                        $Sqlfordefaultaddress->execute(array(':Crop_id' => $_SESSION['View_Crop_Id'], ':default_address' => 'DEFAULT'));
                                        $fetchDefaultaddress = $Sqlfordefaultaddress->fetch(PDO::FETCH_ASSOC);

                                        list_of_address_inbooking($fetchDefaultaddress['first_name'],$fetchDefaultaddress['last_name'],$fetchDefaultaddress['full_name'],$fetchDefaultaddress['phone_number'],$fetchDefaultaddress['pin_code'],$fetchDefaultaddress['country'],$fetchDefaultaddress['user_state'],$fetchDefaultaddress['user_city'],$fetchDefaultaddress['village'],$fetchDefaultaddress['house_number'],$fetchDefaultaddress['landmark']);
                                echo '</div>
                                </div>
                            </div>

                            <div class="row p-2" style="border-top: 1px solid #5e5e5c;">
                                <div class="col-md-6 pt-1">';
                                    echo '<form method="post">';
                                        $sqlfrocrop_idunique = $pdo->prepare("SELECT COUNT(Crop_id) AS countofcropid FROM farmer_user_favourite WHERE Crop_id = :Crop_id AND E_mail_id = :E_mail_id");
                                        $sqlfrocrop_idunique->execute(array(':Crop_id' => $_SESSION['View_Crop_Id'], ':E_mail_id' => $_SESSION['SecureLoginSession']));
                                        $fetchcropidthereinfavourite = $sqlfrocrop_idunique->fetch(PDO::FETCH_ASSOC);

                                        if($fetchcropidthereinfavourite['countofcropid'] < 1)
                                        {
                                            echo '<button class="btn btn-warning btn-block btn-lg" name="addtofavourites">Add To Favourite</button>';
                                        }
                                        else{
                                            echo '<button class="btn btn-warning btn-block btn-lg" name="gotofavourites">Go To Favourite </button>';
                                        }
                                
                                    echo '</form>
                                </div>

                                <div class="col-md-6 pt-1">';
                                    $Sqladdressthereintable=$pdo->prepare("SELECT COUNT(E_mail_id) AS emailexistforaddress FROM farmer_user_address_table WHERE E_mail_id = :E_mail_id");
                                    $Sqladdressthereintable->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                                    $fetch_unique_email_address = $Sqladdressthereintable ->fetch(PDO::FETCH_ASSOC);
                                    if($fetch_unique_email_address['emailexistforaddress'] < 1)
                                    {
                                        echo '<form method="post">
                                                <button class="btn btn-success btn-lg btn-block" name="Back_to_address_page">Buy Crop</button>
                                            </form>';
                                    }
                                    else{
                                        echo '<button class="btn btn-success btn-lg btn-block" data-inline="true" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#select_qantity_for_buy">Buy Crop</button>';
                                    }
                            echo '</div>
                        </div>
                    </div>';
                }
            }
        ?>
    </div>
</div>

<div class="container-fluid" style="width:95%;">
    <div class="row text-center">
        <?php
            if(isset($_SESSION['SecureLoginSession']))
            {
                if(isset($_SESSION['View_Crop_Id']))
                {
                    $crop_category_of_view_id =  $pdo->prepare("SELECT * FROM add_crop_image_table WHERE Crop_id = :Crop_id");
                    $crop_category_of_view_id->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
                    $fetchCropCategoryOfVeiwcrop = $crop_category_of_view_id->fetch(PDO::FETCH_ASSOC);

                    $sugestionForCrop = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                        add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND add_crop_image_table.E_mail_id != :E_mail_id WHERE Crop_id != :Crop_id AND crop_category = :crop_category AND crop_status = 'APPROVED' AND crop_quantity > 0 LIMIT 5");
                    $sugestionForCrop->execute(array(':crop_category' => $fetchCropCategoryOfVeiwcrop['crop_category'], ':E_mail_id' => $_SESSION['SecureLoginSession'], ':Crop_id' => $_SESSION['View_Crop_Id']));
                    while($fetchSugestion = $sugestionForCrop->fetch(PDO::FETCH_ASSOC))
                    {
                        crop_product_items_approved_in_home_page($fetchSugestion['Crop_id'],$fetchSugestion['first_name'],$fetchSugestion['last_name'],$fetchSugestion['crop_name'],$fetchSugestion['crop_quantity'], $fetchSugestion['crop_category'],$fetchSugestion['crop_price'],$fetchSugestion['crop_image']);
                    }
                    
                }
            }
        ?>
    </div>
</div>

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>

<script>
    function cropQuantityvalidation() 
    {
        var CropQuantityInput=document.getElementById('SelectQuantity').value;
        var cropQuantityvalidation=/^[1-9]{1,}/;
        var cropQuantityNagative = /^((\-(\d*)))$/;
            if(cropQuantityvalidation.test(CropQuantityInput) && !cropQuantityNagative.test(CropQuantityInput)){
                document.getElementById('SelectQuantity').style.border='3px dashed green';
            }
            else{
                document.getElementById('SelectQuantity').style.border='3px dashed red';
            }
    }
</script>
</body>
</html>