<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";
    $Approved = 'APPROVED';

    if(isset($_POST['backtohomefrombillpage']))
    {
        unset($_SESSION['ORDER_ID']);
        header('Location: HomePageFarmerPortal.php');
    }
?>

<?php
    nav_bar_serach();
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
<div class="container" style="max-width: 100%;">
    <div class="row">
        <div class="col-5 col-sm-1 col-md-3 mr-auto" style="margin-top: 6rem !important;">
            <form method="post">
                <button class="btn btn-primary btn-md" name="backtohomefrombillpage"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To Home</button>
            </form>
        </div>
    </div>
    <div class="row text-center">
        <?php
            if(isset($_SESSION['SecureLoginSession']))
            {
                if(isset($_POST['SearchCropItem']))
                {
                    $_SESSION['value_feild'] = $_POST['value_field'];
                    $value_filter = $_SESSION['value_feild'];

                    $SqlforcropSearchitem = $pdo->prepare("SELECT COUNT(*) AS cropIdCount FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                            add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND add_crop_image_table.E_mail_id != :E_mail_id AND (crop_name LIKE '%$value_filter%' OR crop_category LIKE '%$value_filter%') AND crop_status = :crop_status AND crop_quantity > 0");
                    $SqlforcropSearchitem->execute(array(':crop_status'=> $Approved, ':E_mail_id' =>$_SESSION['SecureLoginSession']));
                    $fetchacropcount = $SqlforcropSearchitem->fetch(PDO::FETCH_ASSOC);
                    if($fetchacropcount['cropIdCount'] > 0)
                    {
                        echo '<div class="row text-center">
                            <h3 class="text-white"><b>There are <span class="text-warning">'.$fetchacropcount['cropIdCount'].'</span> matching record.</b></h3>
                        </div>';
                    }
                
                    $searchcropitemsapproved = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                        add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND add_crop_image_table.E_mail_id != :E_mail_id AND (crop_name LIKE '%$value_filter%' OR crop_category LIKE '%$value_filter%') AND crop_status = :crop_status AND crop_quantity > 0");
                    $searchcropitemsapproved->execute(array(':crop_status' =>$Approved, ':E_mail_id' =>$_SESSION['SecureLoginSession']));
                    if($fetchacropcount['cropIdCount'] > 0)
                    {
                        while($fetchsearchcropitem = $searchcropitemsapproved->fetch(PDO::FETCH_ASSOC))
                        {
                            crop_product_items_approved_in_home_page($fetchsearchcropitem['Crop_id'],$fetchsearchcropitem['first_name'],$fetchsearchcropitem['last_name'],$fetchsearchcropitem['crop_name'],$fetchsearchcropitem['crop_quantity'], $fetchsearchcropitem['crop_category'],$fetchsearchcropitem['crop_price'],$fetchsearchcropitem['crop_image']);
                        }
                    }
                    else{
                        echo '
                            <div class="container-fluid maincontainer">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-8 offset-md-1">
                                        <img class="img-responsive" src="../Images/empty_result.png" style="width:100%;height:20rem;">
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    
                }
            }
            ?>
    </div>
</div>

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>
</body>
</html>
    
