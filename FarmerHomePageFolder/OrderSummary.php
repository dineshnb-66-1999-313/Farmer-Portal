<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";

    $random3 = substr(number_format(time() * rand(),0,'',''),0,12);

    if(isset($_POST['backtoviewdetailPage'])){
        header('Location: CropViewPageDetails.php');
    }

    if(isset($_POST['confirm_And_Place_Order']))
    {
        $sqlforselectcropdetails = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE Crop_id = :Crop_id");
        $sqlforselectcropdetails->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
        $fetchcropdetails = $sqlforselectcropdetails->fetch(PDO::FETCH_ASSOC);

        $sqlforfarmerdetails = $pdo->prepare("SELECT * FROM sign_up_farmer_information WHERE E_mail_id = :E_mail_id");
        $sqlforfarmerdetails->execute(array(':E_mail_id' => $fetchcropdetails['E_mail_id']));
        $fetchfarmerdetails = $sqlforfarmerdetails->fetch(PDO::FETCH_ASSOC);

        $sqlforfarmerprofiledetails = $pdo->prepare("SELECT * FROM sign_up_farmer_information WHERE E_mail_id = :E_mail_id");
        $sqlforfarmerprofiledetails->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
        $fetchfarmerprofiledetails = $sqlforfarmerprofiledetails->fetch(PDO::FETCH_ASSOC);

        $sqlforuserdetails = $pdo->prepare("SELECT * FROM sign_up_user_information WHERE E_mail_id = :E_mail_id");
        $sqlforuserdetails->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
        $fetchuserdetails = $sqlforuserdetails->fetch(PDO::FETCH_ASSOC);

        $sqlforfarmerpurchsedetails = $pdo->prepare("SELECT * FROM sign_up_farmer_information WHERE E_mail_id = :E_mail_id");
        $sqlforfarmerpurchsedetails->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
        $fetchfarmerpurchasedetails = $sqlforfarmerpurchsedetails->fetch(PDO::FETCH_ASSOC);

        $farmername = $fetchfarmerpurchasedetails['first_name']." ".$fetchfarmerpurchasedetails['last_name'];

        $sqlforprofileuser = $pdo->prepare("SELECT * FROM user_profile_information WHERE E_mail_id = :E_mail_id");
        $sqlforprofileuser->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
        $fetchprofileuser = $sqlforprofileuser->fetch(PDO::FETCH_ASSOC);

        $updatecropquantity = (int) ($fetchcropdetails['crop_quantity'] - $_SESSION['crop_quantity_selected']);

        $sqlforupdatecropdetails = $pdo->prepare("UPDATE add_crop_image_table SET crop_quantity = :crop_quantity WHERE Crop_id = :Crop_id");
        $sqlforupdatecropdetails->execute(array(':crop_quantity' => $updatecropquantity,':Crop_id' => $_SESSION['View_Crop_Id']));

        $total_price = (int) ($fetchcropdetails['crop_price'] * $_SESSION['crop_quantity_selected']);

        if($_SESSION['LoginFarmerUserType'] == 'FARMER')
        {
            $sqlforinertorderdetails = $pdo->prepare("INSERT INTO purchased_crop_item (order_id, User_Type, Crop_id, crop_name, crop_category, crop_image, crop_price, total_quantity, selected_quantity, total_price, purchaser_name, purchaser_phone_number, farmer_E_mail_id, purchaser_E_mail_id, date_of_order)
                                        VALUES (:order_id,:User_Type, :Crop_id, :crop_name, :crop_category, :crop_image, :crop_price, :total_quantity, :selected_quantity, :total_price, :purchaser_name, :purchaser_phone_number, :farmer_E_mail_id, :purchaser_E_mail_id, now())");
            $sqlforinertorderdetails -> execute(array(
                                        ':order_id' => $random3,
                                        ':User_Type' => 'FARMER',
                                        ':Crop_id' => $_SESSION['View_Crop_Id'],
                                        ':crop_name' => $fetchcropdetails['crop_name'],
                                        ':crop_category' => $fetchcropdetails['crop_category'],
                                        ':crop_image' => $fetchcropdetails['crop_image'],
                                        ':crop_price' => $fetchcropdetails['crop_price'],
                                        ':total_quantity' => $fetchcropdetails['crop_quantity'],
                                        ':selected_quantity' => $_SESSION['crop_quantity_selected'],
                                        ':total_price' => $total_price,
                                        ':purchaser_name' => $farmername,
                                        ':purchaser_phone_number' => $fetchfarmerpurchasedetails['phone_number'],
                                        ':farmer_E_mail_id' => $fetchfarmerdetails['E_mail_id'],
                                        ':purchaser_E_mail_id' => $fetchfarmerpurchasedetails['E_mail_id']
            ));
        }
        else
        {
            $sqlforinertorderdetails = $pdo->prepare("INSERT INTO purchased_crop_item (order_id,User_Type, Crop_id, crop_name, crop_category, crop_image, crop_price, total_quantity, selected_quantity, total_price, purchaser_name, purchaser_phone_number, farmer_E_mail_id, purchaser_E_mail_id, date_of_order)
                                            VALUES (:order_id,:User_Type, :Crop_id, :crop_name, :crop_category, :crop_image, :crop_price, :total_quantity, :selected_quantity, :total_price, :purchaser_name, :purchaser_phone_number, :farmer_E_mail_id, :purchaser_E_mail_id, now())");
            $sqlforinertorderdetails -> execute(array(
                                        ':order_id' => $random3,
                                        ':User_Type' => 'PURCHASER',
                                        ':Crop_id' => $_SESSION['View_Crop_Id'],
                                        ':crop_name' => $fetchcropdetails['crop_name'],
                                        ':crop_category' => $fetchcropdetails['crop_category'],
                                        ':crop_image' => $fetchcropdetails['crop_image'],
                                        ':crop_price' => $fetchcropdetails['crop_price'],
                                        ':total_quantity' => $fetchcropdetails['crop_quantity'],
                                        ':selected_quantity' => $_SESSION['crop_quantity_selected'],
                                        ':total_price' => $total_price,
                                        ':purchaser_name' => $fetchuserdetails['full_name'],
                                        ':purchaser_phone_number' => $fetchuserdetails['phone_number'],
                                        ':farmer_E_mail_id' => $fetchfarmerdetails['E_mail_id'],
                                        ':purchaser_E_mail_id' => $fetchuserdetails['E_mail_id']
            ));
        }
        $_SESSION['order_placed_message'] = "Order Placed Successfully<i class='fas fa-check fa-lg mr-2'></i>";
        $_SESSION['ORDER_ID'] = $random3;
        unset($_SESSION["View_Crop_Id"]);
        unset($_SESSION["crop_quantity_selected"]);
        header('Location: BillGenerationPage.php');
        // echo '<script>swal("Order Placed Successfully","","success").then(function(){window.location = "../FarmerHomePageFolder/HomePageFarmerPortal.php";})</script>';
        
    }
?>
<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
    }
    #main_div_center{
        margin-inline: auto;
    }
    #box_shadow{
        box-shadow: 0px 0px 5px;
    }
</style>

<?php
    nav_bar_profile();
?>

<div class="container-fluid" style="width:84%;">
    <div class="row">
        <div class="col-5 col-sm-1 col-md-3 mr-auto" style="margin-top: 5rem !important;">
            <form method="post">
                <button class="btn btn-primary btn-md" name="backtoviewdetailPage"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To View Details</button>
            </form>
        </div>
    </div>
    <!-- crop Details starts -->
    <?php
     if(isset($_SESSION['SecureLoginSession']))
     {
        if(isset($_SESSION['View_Crop_Id']))
        {
            if(isset($_SESSION['crop_quantity_selected']))
            {
                echo '<div class="row bg-white p-4" style="border:2px solid green">';
                        echo '<div class="row">
                                <div class="col-md-6">
                                    <div class="row text-success pt-3"><h3>Crop Details</h3></div>
                                    <div class="row pt-5 pl-3">';
                                        $Select_perticular_crop_details = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                            add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND Crop_id = :Crop_id");
                                        $Select_perticular_crop_details->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
                                        $FetchPerticularCrop = $Select_perticular_crop_details->fetch(PDO::FETCH_ASSOC);
                                        echo '<div class="col-md-4">
                                                <h4>Crop Name</h4>
                                                <h4>Crop Categoty</h4>
                                                <h4>Farmer Name</h4>
                                                <h4>Contact Details</h4>
                                            
                                            </div>';
                                        echo '<div class="col-md-8">';
                                                echo '
                                                    <h4>'.$FetchPerticularCrop['crop_name'].'</h4>
                                                    <h4>'.$FetchPerticularCrop['crop_category'].'</h4>
                                                    <h4><cite>'.$FetchPerticularCrop['first_name'].' '.$FetchPerticularCrop['last_name'].'<cite></h4>
                                                    <h4><cite>--'.$FetchPerticularCrop['phone_number'].'</h4>
                                                    <h4><cite>--'.$FetchPerticularCrop['E_mail_id'].'</h4>
                                                ';
                                        echo '</div>
                                    </div>
                                </div>';
                                echo '<div class="col-md-6">
                                    <img src="'.$FetchPerticularCrop['crop_image'].'" class="image-responsive rounded p-2" style="width:100%;height:21rem;">
                                </div>';
                        echo '</div><hr>';
                        
                        echo '<div class="row pt-4">';
                            echo '<div class="col-md-5">';
                                    $selectuserfarmeraddresstable = $pdo->prepare("SELECT * FROM farmer_user_address_table WHERE E_mail_id = :E_mail_id AND default_address = :default_address");
                                    $selectuserfarmeraddresstable->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession'], ':default_address' => 'DEFAULT'));
                                    $fetchDefaultaddress = $selectuserfarmeraddresstable->fetch(PDO::FETCH_ASSOC);

                                    list_of_address_inbooking($fetchDefaultaddress['first_name'],$fetchDefaultaddress['last_name'],$fetchDefaultaddress['full_name'],$fetchDefaultaddress['phone_number'],$fetchDefaultaddress['pin_code'],$fetchDefaultaddress['country'],$fetchDefaultaddress['user_state'],$fetchDefaultaddress['user_city'],$fetchDefaultaddress['village'],$fetchDefaultaddress['house_number'],$fetchDefaultaddress['landmark']);
                                echo '</div>';

                                echo '<div class="col-md-7 pt-3 pl-3 bg-white" id="box_shadow">';
                                        echo '<h6 class="text-success">CROP PRICE DETAILS</h6>
                                            <hr>
                                            <div class="row price-details">
                                                <div class="col-6 col-sm-6 col-md-6 pl-3 col-lg-6">';
                                                    $select_crop_price_details = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE Crop_id = :Crop_id");
                                                    $select_crop_price_details->execute(array(':Crop_id' => $_SESSION['View_Crop_Id']));
                                                    $fetch_crop_deatils = $select_crop_price_details->fetch(PDO::FETCH_ASSOC);
                                                    $total = (int) ($fetch_crop_deatils['crop_price'] * $_SESSION['crop_quantity_selected']);
                                                    echo '<h5> '.$fetch_crop_deatils['crop_name'].' Per Kg</h5>
                                                        <h5>Total Quantity in Kg</h5>
                                                        <h5>Selected Quantity in Kg</h5>
                                                        <h5>Delivary charges</h5>
                                                        <hr>
                                                        <h4 class="text-success">Total Amount</h4>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-6 pl-5">
                                                    <h5> ₹ '.$fetch_crop_deatils['crop_price'].' Rs</h5>
                                                    <h5>'.$fetch_crop_deatils['crop_quantity'].' Kg</h5>
                                                    <h5 class="text-success">'.$_SESSION['crop_quantity_selected'].' Kg</h5>
                                                    <h5 class="text-success"><b>FREE</b></h5>
                                                    <hr>
                                                    <h3><b> ₹ '.$total.' Rs</b></h3>
                                                </div>
                                            </div>';
                                echo '</div>';
                                
                            echo'</div>';
                            echo '<div class="row pt-4">';
                            echo '<form method="post">
                                    <button class="btn btn-success btn-lg btn-block" name="confirm_And_Place_Order">CONFIRM AND PLACE ORDER</button>
                                </form>';
                echo '</div></div>';
                echo '</div>';
                
            }
        }
    }
    ?>
    
</div>
<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>