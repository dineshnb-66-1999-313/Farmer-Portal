<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";

    if(isset($_POST['backtohomefromorderitems']))
    {
        header('location: ../FarmerHomePageFolder/HomePageFarmerPortal.php');
    }

    if(isset($_POST['SubmitCommet']))
    {
        $orderid = $_POST['OrderIdFromComment'];
        $crop_id = $_POST['CropID'];
        $purchaser_name = $_POST['NameOfPurchaser'];
        $rating = $_POST['croprating'];
        $comment = $_POST['comments_for_order_id'];

        $sqlfrocommentsinsertion = $pdo -> prepare("INSERT INTO crop_comments (Crop_id, order_id, purchaser_name, crop_rating, comments, date_of_comments) 
                                    VALUES (:Crop_id, :order_id, :purchaser_name, :crop_rating, :comments, now())");
        $sqlfrocommentsinsertion ->execute(array(":Crop_id" => $crop_id,
                                                 ":order_id" => $orderid,
                                                 ":purchaser_name" => $purchaser_name,
                                                 ":crop_rating" => $rating,
                                                 ":comments" => $comment));
        echo '<script>swal("Thanks For Rating the Crop Product"," ","success")</script>';
    }

?>
<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
    }
</style>

<?php
    nav_bar_Add_to_crop();
?>

<div class="container-fluid">
    <div class="row" style="margin-top: 4.8rem !important;">
        <div class="row">
            <div class="col-12 col-sm-1 col-md-12 mr-auto">
                <form method="post">
                    <button class="btn btn-primary btn-md" name="backtohomefromorderitems"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To Home</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 offset-md-1" id="main_div_center">
            <?php
                if(isset($_SESSION['SecureLoginSession']))
                {
                    $sqlforemptyorder = $pdo->prepare("SELECT COUNT(purchaser_E_mail_id	) AS emailisemptyordercount FROM purchased_crop_item WHERE purchaser_E_mail_id=:purchaser_E_mail_id");
                    $sqlforemptyorder->execute(array(':purchaser_E_mail_id' => $_SESSION['SecureLoginSession']));
                    $fetchemptyordercount = $sqlforemptyorder->fetch(PDO::FETCH_ASSOC);

                    if($fetchemptyordercount['emailisemptyordercount'] > 0)
                    {
                        $sqlfropurchasedlist = $pdo->prepare("SELECT * FROM purchased_crop_item WHERE purchaser_E_mail_id = :E_mail_id");
                        $sqlfropurchasedlist->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                        
                        while($fetchpurchseditems = $sqlfropurchasedlist->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '
                                <div class="mt-4" style="border: 2px solid green;">
                                    <div class="row bg-white">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 text-center p-2" style="border-right:1px solid #FFE4C4;">
                                            <img src="'.$fetchpurchseditems['crop_image'].'" alt="" class ="img-responsive rounded mt-3" style="width:18rem;height:13rem">
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-8 p-3" style="border-right:1px solid #FFE4C4;">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <h3 class="mt-2 text-success"><b>Order ID: '.$fetchpurchseditems['order_id'].'</b></h3>
                                                    <h4 class="text-dark">'.$fetchpurchseditems['crop_name'].' ('.$fetchpurchseditems['crop_category'].')</h4>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="row">
                                                        <div class="col-4 col-md-4 mt-3 text-center">
                                                            <button class="btn btn-warning" title="Crop Bill Download" id="downloadbill" value="'.$fetchpurchseditems['order_id'].'"><i class="fas fa-download text-success fa-2x"></i></button>
                                                        </div>
                                                        <div class="col-4 col-md-4 mt-2 text-center">';
                                                            $Sqlfordefaultaddressfarmer = $pdo->prepare("SELECT * FROM farmer_user_address_table INNER JOIN purchased_crop_item ON farmer_user_address_table.E_mail_id = purchased_crop_item.farmer_E_mail_id WHERE order_id = :order_id AND default_address = :default_address");
                                                            $Sqlfordefaultaddressfarmer->execute(array(':order_id' => $fetchpurchseditems['order_id'], ':default_address' => 'DEFAULT'));
                                                            $fetchfarmeraddress = $Sqlfordefaultaddressfarmer->fetch(PDO::FETCH_ASSOC);

                                                            echo '<a tabindex="0" id="addresspopoverbutton" type="button" class="fas fa-map-marker-alt text-success fa-3x nav-link" data-bs-placement="right" data-bs-html="true" data-bs-trigger="focus" title="Farmer Address" 
                                                                    data-bs-content="
                                                                        <div>
                                                                            <h5><b>'.$fetchfarmeraddress['first_name'].' '.$fetchfarmeraddress['last_name'].'</b></h5>
                                                                            <p>
                                                                                '.$fetchfarmeraddress['landmark'].', '.$fetchfarmeraddress['house_number'].', '.$fetchfarmeraddress['village'].', '.$fetchfarmeraddress['user_city'].'
                                                                                , '.$fetchfarmeraddress['user_state'].', '.$fetchfarmeraddress['country'].' - '.$fetchfarmeraddress['pin_code'].'
                                                                            </p> 
                                                                            <h6><b>'.$fetchfarmeraddress['phone_number'].'</b></h6>
                                                                        </div>" data-toggle="popover">
                                                                </a>  
                                                        </div>
                                                        <div class="col-4 col-md-4 mt-2 text-center">';
                                                            $selectuniquecomment = $pdo->prepare("SELECT COUNT(order_id) AS orderidcommentsunique FROM crop_comments WHERE order_id = :order_id");
                                                            $selectuniquecomment->execute(array(":order_id" => $fetchpurchseditems['order_id']));
                                                            $fetchcommentorderid = $selectuniquecomment->fetch(PDO::FETCH_ASSOC);
                                                            if($fetchcommentorderid['orderidcommentsunique'] < 1)
                                                            {
                                                                echo '<button class="btn" type="button" title="Comments" id="commentscropitem" value="'.$fetchpurchseditems['order_id'].'"><i class="fas fa-comments text-primary fa-3x"></i></button>';
                                                            }
                                                            else{
                                                                echo '';
                                                            }
                                                       echo'</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row text-center">
                                                <div class="col-3 col-md-4">
                                                    <h5 >Price/Kg</h5>
                                                </div>
                                                <div class="col-5 col-md-4">
                                                    <h5>Seleted Quantity</h5>
                                                </div>
                                                <div class="col-4 col-md-4">
                                                    <h5>Total</h5>
                                                </div>
                                            </div><hr>
                                            <div class="row text-center">
                                                <div class="col-3 col-md-4">
                                                    <h4>'.$fetchpurchseditems['crop_price'].' /Kg</h4>
                                                </div>
                                                <div class="col-5 col-md-4">
                                                    <h4>'.$fetchpurchseditems['selected_quantity'].'</h4>
                                                </div>
                                                <div class="col-4 col-md-4">
                                                    <h4 class="text-success"><b>₹ '.$fetchpurchseditems['total_price'].' Rs</b></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                    else{
                        echo '
                            <div class="container-fluid maincontainer">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-8 offset-md-1">
                                        <img class="img-responsive" src="../Images/order_empty.png" style="width:100%;height:20rem;">
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
                else{
                    echo '
                        <div class="container-fluid maincontainer">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-10 offset-md-1">
                                    <img class="img-responsive" src="../Images/404_error.jpg" style="width:100%;height:20rem;">
                                </div>
                            </div>
                        </div>
                    ';
                }
            ?>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>

<!-- delete crop model starts-->
<div class="modal fade" id="downloadbillmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 189%; left: -13rem;position:absolute;">
            <div class="modal-header">
                <h4 class="modal-title text-success" id="deletecropmodal_text"><b>Crop Bill</b></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php
                echo '<div class="row pt-4 justify-content-center" id="main_div_center1">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-start">
                                <h5><b>Mobile: +91 8660706741</b></h5>
                            </div>
                            <div class="col-md-6 text-end pr-3">
                                <h4 id="dateoforder"></h4>
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
                                </div><hr>
                            </div>
                            <div class="row text-center text-success pt-3 pb-3">
                                <div class="col-md-2">
                                    <h5 id="orderid"></h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 id="cropname"></h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 id="cropcategory"></h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 id="cropprice"></h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 id="selectedquantity"></h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 id="totalprice"></h5>
                                </div><hr>
                            </div>
                            <div class="row">
                                <div class="col md-12 pr-5 text-end">
                                    <h2 class="text-success"><b id="totalprice2"></b></h2>
                                </div><hr>
                            </div>
                        </div>
                    </div>
                </div>';
            ?>
            </div>
            <div class="col-md-10 justify-content-center p-3">
                <div class="col-md-10 offset-2 text-end">
                    <button class="btn btn-warning btn-lg btn-block" id="billbuttonid" value="" onClick="generatepdf()"><i class="fa fa-download mr-2"></i>Download Bill</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div> 
<!-- delete crop model ends-->

<!-- ------------------- Model for crop upload ----------------->
        
<div class="modal fade" id="commentsordercrop" tabindex="-1" aria-labelledby="add_another_crop_items_text" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border:3px solid green";>
            <div class="modal-header">
                <h3 class="modal-title" id="add_another_crop_items_text">Comment Here</h3>
                <button type="button" id="closecommentmodel" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-12 justify-content-center align-items-center bg-white">
                    <form method="post" class="paddingcontainer" id="formforeditandadd">
                        <label class="form-label"><b>Crop Rating</b></label>
                        <select name="croprating" id="croprating" class="custom-select form-control-lg" required="required">
                            <?php
                                for($i=5;$i>0;$i--){
                                    echo '<option value = "'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select><br><br>

                        <input type="hidden" id="commentorderID" name="OrderIdFromComment">
                        <input type="hidden" id="nameofpurchaser" name="NameOfPurchaser">
                        <input type="hidden" id="crop_ID" name="CropID">

                        <label class="form-label"><b>Comments About Crop</b></label>
                            <textarea rows="3" id="commentsection" name="comments_for_order_id" maxlength="150" placeholder="Enter Comment" class="form-control form-control-lg ml-0" required="required"></textarea>
                        
                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-4" id="add_crop_item" name="SubmitCommet">Submit</button><br><br>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ------------------- Model for crop upload ----------------->

<script>
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    var p = $("#addresspopoverbutton").popover();
    p.on("show.bs.popover", function(e){
        p.data("bs.popover").tip().css({"max-width": "700px"});
    });

    $('.popover-dismiss').popover({
        trigger: 'focus'
    });

</script>

<script type="text/javascript">
    $(document).on('click','#downloadbill',function(e){
        e.preventDefault();
        var downloadbillid = $(this).val();
        $.ajax({
            type: "post",
            url: "crop_bill_display.php",
            data: {order_id: downloadbillid},
            dataType: "JSON",
            success: function (response) {
                    console.log(response.order_id);
                    $("#orderid").text(response.order_id);
                    $("#cropname").text(response.crop_name);
                    $("#cropcategory").text(response.crop_category);
                    $("#cropprice").text(response.crop_price);
                    $("#selectedquantity").text(response.selected_quantity);
                    $("#totalprice").text(response.total_price);
                    $("#dateoforder").text('Date: '+response.date_of_order);
                    $("#totalprice2").text('Total: ₹ '+response.total_price+'Rs');
                    $("#billbuttonid").val(response.order_id);
            $('#downloadbillmodal').modal('show');
            }
        });
    });
    
    $(document).on('click','#closecommentmodel',function(){
        $('form').trigger('reset');
        
    });

    $(document).on('click','#commentscropitem',function(e){
        e.preventDefault();
        var commentscropid = $(this).val();
        console.log(commentscropid);
        $.ajax({
            type: "post",
            url: "CommentsCrop.php",
            data: {commentsidcrop: commentscropid},
            dataType: "JSON",
            success: function (response){
                $("#commentorderID").val(response.order_id);
                $("#nameofpurchaser").val(response.purchaser_name);
                $("#crop_ID").val(response.crop_id);
                $('#commentsordercrop').modal('show');
            }
        });
    });

    function generatepdf(){
        const billelement = document.getElementById('main_div_center1');
        var filename1 = document.getElementById('billbuttonid').value;

        const option = {
                margin:     0,
                filename:     'Crop_Bill_'+filename1+'.pdf',
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(option).from(billelement).save();

    }
</script>