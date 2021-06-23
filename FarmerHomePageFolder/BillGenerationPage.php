<?php
    session_start();

    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";

    if(isset($_POST['backtohomefrombillpage']))
    {
        unset($_SESSION['ORDER_ID']);
        header('Location: HomePageFarmerPortal.php');
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
</style>
<?php
    nav_bar_profile();
?>
<div class="container-fluid" style="width:90%;">
    <!-- first row starst -->
    <div class="row">
        <div class="col-5 col-sm-1 col-md-3 mr-auto" style="margin-top: 5rem !important;">
            <form method="post">
                <button class="btn btn-primary btn-md" name="backtohomefrombillpage"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To Home</button>
            </form>
        </div>
    </div>
    <!-- first row ends -->

    <?php
        if(isset($_SESSION['SecureLoginSession']))
        {
            if(isset($_SESSION['ORDER_ID']))
            {
                if(isset($_SESSION['order_placed_message'])){
                    echo '<div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-10 offset-md-1 text-center" id="address_center" role="alert"><h4>'.$_SESSION['order_placed_message'].'</h4></div>';
                }
                $selectorderdetails = $pdo->prepare("SELECT * FROM purchased_crop_item WHERE order_id = :order_id");
                $selectorderdetails->execute(array(':order_id' => $_SESSION['ORDER_ID']));
                $fetchorderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);

                $selectfarmeretails = $pdo->prepare("SELECT * FROM purchased_crop_item INNER JOIN sign_up_farmer_information ON purchased_crop_item.farmer_E_mail_id = sign_up_farmer_information.E_mail_id WHERE order_id = :order_id");
                $selectfarmeretails->execute(array(':order_id' => $_SESSION['ORDER_ID']));
                $fetchfarmerdetails = $selectfarmeretails->fetch(PDO::FETCH_ASSOC);

                $Sqlfordefaultaddressfarmer = $pdo->prepare("SELECT * FROM farmer_user_address_table INNER JOIN purchased_crop_item ON farmer_user_address_table.E_mail_id = purchased_crop_item.farmer_E_mail_id WHERE order_id = :order_id AND default_address = :default_address");
                $Sqlfordefaultaddressfarmer->execute(array(':order_id' => $_SESSION['ORDER_ID'], ':default_address' => 'DEFAULT'));
                $fetchfarmeraddress = $Sqlfordefaultaddressfarmer->fetch(PDO::FETCH_ASSOC);

                $Sqlfordefaultaddressuser = $pdo->prepare("SELECT * FROM farmer_user_address_table INNER JOIN purchased_crop_item ON farmer_user_address_table.E_mail_id = purchased_crop_item.purchaser_E_mail_id WHERE order_id = :order_id AND default_address = :default_address");
                $Sqlfordefaultaddressuser->execute(array(':order_id' => $_SESSION['ORDER_ID'], ':default_address' => 'DEFAULT'));
                $fetchuseraddress = $Sqlfordefaultaddressuser->fetch(PDO::FETCH_ASSOC);

                echo '<div class="row pt-4 justify-content-center" id="main_div_center">
                    <div class="col-md-10 justify-content-center bg-white p-3" style="border: 2px solid green;">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <img src="../Images/Farmer_Logo.png" class="img-responsive" style="width: 9rem;height: 6rem; border-radius:50%;">
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-success">FARMER PORTAL</h3>
                                <h5>11th cross, 8th main road, brundavanbus stop</h5>
                                <h5> peenya 2nd stage - 560039</h5>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-start">
                                <h5><b>Mobile: +91 8660706741</b></h5>
                            </div>
                            <div class="col-md-6 text-end pr-3">
                                <h4>Date: '.$fetchorderdetails['date_of_order'].' </h4>
                            </div>
                        </div><hr class="text-secondary"><hr class="text-secondary">
                        <div class="row pt-3 pb-2">
                            <div class="row text-center">
                                <div class="col-md-2">
                                    <h5>Order ID</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Crop Name</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Crop Category</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Price/Kg</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Seleted Quantity</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Total</h5>
                                </div>
                            </div><hr>
                            <div class="row text-center text-success pt-3 pb-3">
                                <div class="col-md-2">
                                    <h5>'.$fetchorderdetails['order_id'].'</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>'.$fetchorderdetails['crop_name'].'</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>'.$fetchorderdetails['crop_category'].'</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>'.$fetchorderdetails['crop_price'].'</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>'.$fetchorderdetails['selected_quantity'].'</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>'.$fetchorderdetails['total_price'].'</h5>
                                </div>
                            </div><hr>
                            <div class="row">
                                <div class="col md-12 pr-5 text-end">
                                    <h2 class="text-success"><b>Total : ₹ '.$fetchorderdetails['total_price'].' Rs</b></h2>
                                </div>
                            </div><hr>
                            <div class="row">
                                <div class="col-md-6 text-start">';
                                    Farmer_list_of_address_in_order($fetchfarmeraddress['first_name'],$fetchfarmeraddress['last_name'],$fetchfarmeraddress['full_name'],$fetchfarmeraddress['phone_number'],$fetchfarmeraddress['pin_code'],$fetchfarmeraddress['country'],$fetchfarmeraddress['user_state'],$fetchfarmeraddress['user_city'],$fetchfarmeraddress['village'],$fetchfarmeraddress['house_number'],$fetchfarmeraddress['landmark']);
                                echo '</div>';
                                echo '<div class="col-md-6 text-start">';
                                    User_list_of_address_in_order($fetchuseraddress['first_name'],$fetchuseraddress['last_name'],$fetchuseraddress['full_name'],$fetchuseraddress['phone_number'],$fetchuseraddress['pin_code'],$fetchuseraddress['country'],$fetchuseraddress['user_state'],$fetchuseraddress['user_city'],$fetchuseraddress['village'],$fetchuseraddress['house_number'],$fetchuseraddress['landmark']);
                               echo '</div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-10 justify-content-center p-3">
                        <div class="col-md-6 offset-md-7 text-end">
                            <button class="btn btn-warning btn-lg btn-block" id="billbuttonid" value="'.$fetchorderdetails['order_id'].'" onClick="generatepdf()"><i class="fa fa-download mr-2"></i>Download Bill</button>
                        </div>
                    </div>
                ';
            }
        } 
    ?>
</div>

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>
<script>
    function generatepdf(){
        const billelement = document.getElementById('main_div_center');
        var filename1 = document.getElementById('billbuttonid').value;

        const option = {
                margin:     0,
                filename:     'Crop_Bill_'+filename1+'.pdf',
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(option).from(billelement).save();

    }
</script>
    