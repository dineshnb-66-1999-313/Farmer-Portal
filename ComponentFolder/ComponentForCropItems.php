<style>
    .img-fluid {
        max-width: 12rem;
        height: 9.4rem;
    }
    .rounded{
        border-radius: 1rem!important;
    }
    #row {
        box-shadow: -10px 10px 5px rgba(0, 0, 0, 0.5);
        border: 2px solid #000;
        transition: 0.5s;
        border-radius: 5px;
    }
    .card-shadow {
        border-bottom: 2px solid green;
        width: 11.5rem;
        height: 10rem;
    }
    .card-body {
        flex: 1 1 auto;
        padding: 0rem 1rem;
    }
    #crop_name_and_category{
        margin-left: -1rem !important;
    }
    #box_shadow{
        box-shadow: 0px 0px 5px;
    }
</style>

<?php
    require_once "header.php";
    require_once "DataBaseConnectionForFarmerPortal.php";
    
function crop_product_items_approved_in_home_page($crop_id,$farmer_first_name, $farmer_last_name, $crop_name, $crop_quantity,$crop_category, $crop_price, $crop_image)
{
    echo '<div class="col-xs-12 col-sm-7 col-md-2 col-xl-1 my-3 mx-3 bg-white" style="width: 13.8rem; height:23rem;" id="row">
            <form action="HomePageFarmerPortal.php" method="post">
                <div class="card-shadow1">
                    <div class="card-shadow my-2">
                        <img src='."$crop_image".' alt="image1" class="img-fluid card-img-top rounded mr-3">
                    </div>
                    <div class="card-body pt-0" id="crop_name_and_category"> 
                        <h4><cite>---'.$farmer_first_name." ".$farmer_last_name.'</cite></h4>
                        <h5><p class="card-title ml-0">'."$crop_name"."  (".$crop_category.")".'</p></h5>
                        <h5><span class="text-success">₹ '."$crop_price"."Rs (".$crop_quantity." Kg)".'</span></h5>
                    </div>
                    <div class="col-12">
                        <button id="crop_view_id" class="btn-md btn btn-warning mt-4" target="_blank" name="view_crop_detail">View Detail <i class="fa fa-arrow-right pl-2"></i></button>
                        <input type="hidden" name="crop_view_detailes" value="'.$crop_id.'">
                    </div>
                </div>
            </form>
        </div>';
}

function crop_product_for_perticular_farmer($crop_id,$crop_name,$crop_category, $crop_quantity, $crop_price, $crop_image,$crop_status)
{
    $NotApproved = 'NOTAPPROVED';
    $Approved = 'APPROVED';
    $Rejected = 'REJECTED';
    echo '<div class="col-xs-12 col-sm-7 col-md-3 my-3 mx-3 bg-white" style="width: 13rem; height:20rem;" id="row">
            <form method="post">
            <div class="card-shadow">
                <div class="card-shadow my-2 mr-3">
                    <img src='.$crop_image.' alt="image1" class="img-fluid card-img-top rounded mr-2">
                </div>';
                if($crop_status === $NotApproved){
                    echo '<div class="col-12 p-1 rounded" style="background: #fdde6c;">
                            <span class="fa fa-spinner fa-lg fa-fw text-danger"></span><span class="ml-2">In Progess</span>
                        </div>';
                }
                else if ($crop_status === $Approved) {
                    echo '<div class="col-12 rounded alert-success p-1">
                            <span class="fa fa-check fa-lg text-check"></span><span class="ml-2">Approved</span>
                        </div>';
                }
                else{
                    echo '<div class="col-12 rounded alert-danger p-1 m-1">
                            <span class="fa fa-times-circle fa-lg fa-fw text-danger"></span><span class="ml-2">Rejected</span>
                        </div>';
                }
                echo '<div class="card-body pt-2 ml-0"> 
                        <h5><p class="card-title m-0 ">'.$crop_name."(".$crop_category.")".'</p></h5>
                        <h5>
                            <span class="text-success">₹ Rs '.$crop_price.' ('.$crop_quantity.'Kg)</span>
                        </h5>
                    </div>';
                    if($crop_status == $Rejected){
                        echo '<div class="col-12">
                            <button class="btn btn-success btn-sm" value="'.$crop_id.'" id="editCropItem" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_another_crop_items"><i class="fas fa-pencil-alt text-white fa-lg"></i></button>
                            <button class="float-right btn btn-danger btn-sm" value="'.$crop_id.'" id="deleteCropItem"><i class="fas fa-trash-alt text-white fa-lg"></i></button>
                        </div>';
                    }
            echo '</div>
        </form>
    </div>';
}

function add_address_user_farmer_one($first_name, $last_name, $full_name,$phone_number_farmer, $phone_number_user, $email_one)
{
    $FARMER = 'FARMER';   
    echo '<form action="../SideBarActivities/ProfileAndPersonalInformation.php" method="post" id="formforaddressedit">

        <div class="row">';
            if($_SESSION['LoginFarmerUserType'] === $FARMER)
            {
                echo '
                    <div class="col-md-6">
                        <label class="form-label"><b>First Name</b></label>
                            <input type="text" name="AddressFirstName" value="'.$first_name.'" placeholder="Enter First Name" autocomplete="off" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><b>Last Name</b></label>
                        <input type="text" name="AddressLastName" value="'.$last_name.'" placeholder="Enter Last Name" autocomplete="off" class="form-control form-control-lg">
                    </div>
                ';
            }
            else{
                echo '
                <div class="col-md-12">
                    <label class="form-label"><b>Full Name</b></label>
                        <input type="text" name="AddressFullName" value="'.$full_name.'" placeholder="Enter Full Name" autocomplete="off" class="form-control form-control-lg">
                </div>
                ';
            }
                
        echo '</div>

        <div class="row">';
            if($_SESSION['LoginFarmerUserType'] === $FARMER){
                echo '
                    <div class="col-md-12">
                        <label class="form-label"><b>Phone Number</b></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone fa-lg"></i></span>
                            <input type="tel" placeholder="Enter Phone Number" value="'.$phone_number_farmer.'" name="farmer_Mobile" autocomplete="off" class="form-control form-control-lg ml-0">
                        </div>
                    </div>
                ';
            }
            else{
                echo'
                <div class="col-md-12">
                    <label class="form-label"><b>Phone Number</b></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone fa-lg"></i></span>
                        <input type="tel" placeholder="Enter Phone Number" value="'.$phone_number_user.'" name="farmer_Mobile" autocomplete="off" class="form-control form-control-lg ml-0">
                    </div>
                </div>';
            }
        echo '</div> 

        <div class="row">
            <label class="form-label"><b>Enter Pin Code</b></label>
            <div class="input-group mb-3">
                <input type="text" name="addresspincode" id="pincodeaddress" placeholder="Enter Pin Code" autocomplete="off" class="form-control form-control-lg" required="required">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label"><b>Country</b></label>
                <input type="text" readonly id="country" name="AddressCountry" placeholder="Enter Country" autocomplete="off" class="form-control form-control-lg">
            </div>
            <div class="col-md-6">
                <label class="form-label"><b>State</b></label>
                <input type="text" readonly id="state" name="AddressState" placeholder="Enter State" autocomplete="off" class="form-control form-control-lg">
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label"><b>City</b></label>
                <input type="text" readonly id="city" name="AddressCity" placeholder="Enter City" autocomplete="off" class="form-control form-control-lg">
            </div>
            <div class="col-md-6">
                <label class="form-label"><b>Select village</b></label>
                <select name="addressvillageName" id="villageName" class="custom-select form-control-lg" required="required">
                </select>
            </div>

        </div><br>

        <div class="row">
            <div class="col-md-12">
                <label class="form-label"><b>House No., Building Name</b></label>
                    <input type="text" id="house_number" name="AddressHouseBuilding" placeholder="Enter House No., Building Name" autocomplete="off" class="form-control form-control-lg" required="required">
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-12">
                <label class="form-label"><b>LandMark</b></label>
                <input type="text" id="landmark" name="AddressLandmark" placeholder="Enter LandMark" autocomplete="off" class="form-control form-control-lg" required="required">
            </div>
        </div><br>
        <div class="row">
            <button class="btn btn-primary btn-lg" name="confirmandsaveaddressFarmer">Confirm And Save Address</button>
        </div>';
    echo '</form>';
}

function product_items($product_name,$color,$actual_price,$Price,$model_name,$product_img,$Quantity,$product_id,$rating)
{
    echo '<div class="col-2 col-sm-7 col-md-2 col-xl-1  my-3 mx-3" style="width: 13rem; height:23.5rem;" id="row">
        <form action="sports_shopping_home_page.php" method="post">
            <div class="card-shadow1">
                <div class="card-shadow my-2">
                    <img src='."$product_img".' alt="image1" class="img-fluid card-img-top rounded mr-3">
                </div>
                <div class="card-body"> 
                    <h7><b>'."$product_name"." (".$color.") ".'</b></h7>
                    <h9>'.$model_name.'</h9>
                    <h6>
                        <span class="text-success">₹ '."$Price".'</span>
                        <small><s>₹ '."$actual_price".'</s>'."(".$Quantity.")".'</small>
                    </h6>';
            echo '<h6>';
                    for($i=0;$i<$rating;$i++){
                        echo '<i class="fa fa-star text-success"></i>';
                    }
                    for($j=0;$j<5-$rating;$j++){
                        echo '<i class="far fa-star"></i>';
                    }
                    echo "(".$rating.")";
            echo '</h6>';
                    echo '
                        <button type="submit" class="btn-md btn btn-warning mt-4" name="add_to_cart">Add to cart <i class="fa fa-cart-plus pl-2"></i></button>
                        <input type="hidden" name="product_id" value="'.$product_id.'">    
                </div>
            </div>
        </form>
        </div>';
}

function favourite_crop_items($crop_id,$farmer_first_name, $farmer_last_name, $crop_name, $crop_quantity,$crop_category, $crop_price, $crop_image,$crop_descrpition)
{
    echo '
    <form action="MyFavouriteFarmerUser.php" method="post" class = "cart-items">
        <div class="border-rounded mb-3">
            <div class="row bg-white">
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 text-center" style="border-right:1px solid #FFE4C4;">
                    <img src="'.$crop_image.'" alt="" class = "img-responsive rounded p-3" style="width:100%;height:15rem;">
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-8" style="border-right:2px solid #FFE4C4;">
                    <div class="row pt-3 pl-3">
                        <h4><span>'.$crop_name.'('.$crop_category.') <cite> --- '.$farmer_first_name.' '.$farmer_last_name.' </cite></span></h4>
                        <h4 class=""></h4>
                        <h4>
                            <span class="text-success">₹ '."$crop_price".' Rs /Kg</span>
                            <span class="text-success">('."$crop_quantity".' Kg)</span>
                        </h4>
                        <h5 class="p-2"><cite>"'.$crop_descrpition.'"</cite></h5>';
                        if($crop_quantity < 1){
                            echo '<h4 class="text-danger">Out of Stock</h4>';
                        } 
                    echo '</div> 
                    <hr>
                    <div class="row">
                        <div class="col-6 text-end">
                            <button class="btn btn-danger mb-2" value="'.$crop_id.'" id="removefromfavorite">Remove Crop<i class="fa fa-trash fa-lg ml-2"></i></button>
                        </div>
                        <div class="col-6 text-start">';
                            if($crop_quantity > 0){
                                echo '<form method="post">
                                        <button class="btn btn-warning mb-2 ml-3" name="view_crop_detail">View Details<i class="fa fa-arrow-right ml-2"></i></button>
                                        <input type="hidden" name="favourite_crop_view_detailes" value="'.$crop_id.'">
                                    </form>';
                            }
                            else{
                                echo '<button class="btn btn-warning mb-2 ml-3" disabled>View Details<i class="fa fa-arrow-right ml-2"></i></button>';
                            }
                        echo'</div>
                    </div>
                </div>
            </div>
        </div>
    </form>';
}

function purchased_crop_items($order_id,$crop_name, $crop_category, $crop_img, $Crop_Price_per_kg,$selected_quantity, $total_price)
{
    echo '
    <div class="mt-4" style="border: 2px solid green;">
        <div class="row bg-white">
            <div class="col-4 col-sm-6 col-md-6 col-lg-4 text-center p-2" style="border-right:1px solid #FFE4C4;">
                <img src="'.$crop_img.'" alt="" class ="img-responsive rounded mt-3" style="width:15rem;height:10rem">
            </div>
            <div class="col-8 col-sm-6 col-md-6 col-lg-8 p-3" style="border-right:1px solid #FFE4C4;">
                <div class="row ">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mt-2 text-success"><b>Order ID: '.$order_id.'</b></h3>
                            <h4 class="text-dark">'.$crop_name.' ('.$crop_category.')</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <i type="button" class="fas fa-map-marker-alt text-success fa-3x" data-toggle="tooltip" data-bs-html="true" title="<em>Tooltip</em> <u>with</u> <b>HTML</b>">

                            </i>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h5 >Price/Kg</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>Seleted Quantity</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>Total</h5>
                        </div>
                    </div><hr>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4>'.$Crop_Price_per_kg.' /Kg</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>'.$selected_quantity.'</h4>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-success"><b>₹ '.$total_price.' Rs</b></h4>
                        </div>
                    </div>
                </div>
                <div class="row">';
            echo '</div>
            </div>
        </div>
    </div>';
}

function list_of_address_in_profile($ID,$first_name,$last_name,$full_name,$phone_number,$pin_code,$country,$user_state,$user_city,$village,$house_number,$landmark, $default_address)
{
    $FARMER = 'FARMER';
    if($default_address == 'DEFAULT'){
        echo '
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 bg-white mb-3" style="border: 3px dashed green;">
                <h6 class="text-success pt-2">ADDRESS DETAILS ('.$default_address.')</h6><hr>
                    <div class="col-md-12">';
                    if($_SESSION['LoginFarmerUserType'] === $FARMER)
                    {
                        echo '<h5><b>'.$first_name.' '.$last_name.'</b></h5>';
                    }
                    else{
                        echo '<h5><b>'.$full_name.'</b></h5>';
                    }
                    echo '<p class="text-dark">
                    '.$landmark.', '.$house_number.', '.$village.', '.$user_city.'
                    , '.$user_state.', '.$country.' - '.$pin_code.'
                    </p> 
                    <div class="row">
                        <h6><b>'.$phone_number.'</b></h6>
                    </div>
                </div>
            </div>';
    }
    else{
        echo '
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 bg-white mb-3" id="box_shadow">
                <h6 class="text-success pt-2">ADDRESS DETAILS ('.$default_address.')</h6><hr>
                    <div class="col-md-12">';
                    if($_SESSION['LoginFarmerUserType'] === $FARMER)
                    {
                        echo '<h5><b>'.$first_name.' '.$last_name.'</b></h5>';
                    }
                    else{
                        echo '<h5><b>'.$full_name.'</b></h5>';
                    }
                    echo '<p class="text-dark">
                    '.$landmark.', '.$house_number.', '.$village.', '.$user_city.'
                    , '.$user_state.', '.$country.' - '.$pin_code.'
                    </p> 
                    <div class="row">
                        <div class="col-12 col-sm-2 col-md-4 col-lg-6">
                            <h6><b>'.$phone_number.'</b></h6>
                        </div>
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 auto-right">
                            <form action="../SideBarActivities/ProfileAndPersonalInformation.php" method="post">
                                <button type="submit" class="btn btn-primary btn-sm" id="makedefaultaddress" name="make_default">Make Default</button>
                                <input type="hidden" value="'.$ID.'" name="default_id">
                                <button type="submit" class="btn btn-danger p-2" value="'.$ID.'" id="deleteaddressid"><i class="fas fa-trash-alt text-white fa-lg"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
    }
}

function list_of_address_inbooking($first_name,$last_name,$full_name,$phone_number,$pin_code,$country,$user_state,$user_city,$village,$house_number,$landmark)
{
    $FARMER = 'FARMER';
    echo '
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10 col-xl-12 bg-white mb-3" id="box_shadow">
        <h6 class="text-success pt-2">ADDRESS DETAILS</h6><hr>
            <div class="col-md-12">
                <h5><b>'.$first_name.' '.$last_name.'</b></h5>
                <h5><b>'.$full_name.'</b></h5>
            <p class="text-dark">
                '.$landmark.', '.$house_number.', '.$village.', '.$user_city.'
                , '.$user_state.', '.$country.' - '.$pin_code.'
            </p> 
            <div class="row">
                <div class="col-12 col-sm-2 col-md-4 col-lg-6">
                    <h6><b>'.$phone_number.'</b></h6>
                </div>
            </div>
        </div>
    </div>';
}

function Farmer_list_of_address_in_order($first_name,$last_name,$full_name,$phone_number,$pin_code,$country,$user_state,$user_city,$village,$house_number,$landmark)
{
    $FARMER = 'FARMER';
    echo '
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10 col-xl-12 bg-white mb-3" id="box_shadow">
        <h6 class="text-success pt-2">Farmer Address details</h6><hr>
            <div class="col-md-12">
                <h5><b>'.$first_name.' '.$last_name.'</b></h5>
                <h5><b>'.$full_name.'</b></h5>
            <p class="text-dark">
                '.$landmark.', '.$house_number.', '.$village.', '.$user_city.'
                , '.$user_state.', '.$country.' - '.$pin_code.'
            </p> 
            <div class="row">
                <div class="col-12 col-sm-2 col-md-4 col-lg-6">
                    <h6><b>'.$phone_number.'</b></h6>
                </div>
            </div>
        </div>
    </div>';
}

function User_list_of_address_in_order($first_name,$last_name,$full_name,$phone_number,$pin_code,$country,$user_state,$user_city,$village,$house_number,$landmark)
{
    $FARMER = 'FARMER';
    echo '
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10 col-xl-12 bg-white mb-3" id="box_shadow">
        <h6 class="text-success pt-2">Purchaser Address details</h6><hr>
            <div class="col-md-12">
            <h5><b>'.$first_name.' '.$last_name.'</b></h5>
            <h5><b>'.$full_name.'</b></h5>
            <p class="text-dark">
                '.$landmark.', '.$house_number.', '.$village.', '.$user_city.'
                , '.$user_state.', '.$country.' - '.$pin_code.'
            </p> 
            <div class="row">
                <div class="col-12 col-sm-2 col-md-4 col-lg-6">
                    <h6><b>'.$phone_number.'</b></h6>
                </div>
            </div>
        </div>
    </div>';
}

?>
