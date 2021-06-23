<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";

    if(isset($_POST['backtohomefromaddcrop']))
    {
        header('location: ../FarmerHomePageFolder/HomePageFarmerPortal.php');
    }

    if(isset($_POST['view_crop_detail']))
    {
        $_SESSION['View_Crop_Id'] = $_POST['favourite_crop_view_detailes'];
        header('Location: ../FarmerHomePageFolder/CropViewPageDetails.php');
    }

    if(isset($_POST['DeletefavouriteCropData']))
    {
        $cropfavouriteid = $_POST['deletefavouritecropname'];

        $sqlforremovefavouritecrop = $pdo->prepare("DELETE FROM farmer_user_favourite WHERE Crop_id = :Crop_id AND E_mail_id = :E_mail_id");
        $sqlforremovefavouritecrop->execute(array(':Crop_id' => $cropfavouriteid, ':E_mail_id' => $_SESSION['SecureLoginSession']));

        $message ='<labe><i class="fas fa-check fa-lg mr-3"></i>Crop Remove From Favourites Successfuly</label>';

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
</style>

<div class="container-fluid" width="100%">
    <div class="row" style="margin-top: 5.5rem !important">
        <div class="row">
            <div class="col-md-3">
                <form method="post">
                    <button class="btn btn-primary btn-md" name="backtohomefromaddcrop"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To Home</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-10 justify-content-md-center item-align-center" id="main_div_center">
                <?php
                    if(isset($_SESSION['SecureLoginSession']))
                    {
                        $sqlforemptycart = $pdo->prepare("SELECT COUNT(E_mail_id) AS emailisemptycartcount FROM farmer_user_favourite WHERE E_mail_id=:E_mail_id");
                        $sqlforemptycart->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                        $fetchemptycartcount = $sqlforemptycart->fetch(PDO::FETCH_ASSOC);

                        if($fetchemptycartcount['emailisemptycartcount'] > 0)
                        {
                            if(isset($message)){
                                echo '<div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-12 text-center" id="address_center" role="alert"><span>'.$message.'</span></div>';
                            }
                            $sqlforselectfavoritecrop = $pdo->prepare("SELECT * FROM farmer_user_favourite INNER JOIN add_crop_image_table ON farmer_user_favourite.Crop_id = add_crop_image_table.Crop_id WHERE farmer_user_favourite.E_mail_id = :E_mail_id");
                            $sqlforselectfavoritecrop->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
                            while($fetchcropinformation = $sqlforselectfavoritecrop->fetch(PDO::FETCH_ASSOC))
                            {
                                favourite_crop_items($fetchcropinformation['Crop_id'],$fetchcropinformation['first_name'], $fetchcropinformation['last_name'], $fetchcropinformation['crop_name'], $fetchcropinformation['crop_quantity'],$fetchcropinformation['crop_category'], $fetchcropinformation['crop_price'], $fetchcropinformation['crop_image'],$fetchcropinformation['crop_description']);
                            }
                            
                        }
                        else{
                            echo '
                            <div class="container-fluid maincontainer">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-8 offset-md-1 bg-white">
                                        <img class="img-responsive" src="../Images/emptycart.png" style="width:100%;height:20rem;">
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

<!-- delete favourite crop model starts-->
<div class="modal fade" id="deletefavouritecropmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remove Favourite Crop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <h4>Are you sure You want to Remove the Crop Form Favourite ?</h4>
                    <input type="hidden" name="deletefavouritecropname" id="deletefavouritecropId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="DeletefavouriteCropData">Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
<!-- delete crop model ends-->

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>

<script>
    $(document).on('click','#removefromfavorite',function (e) {
        e.preventDefault();
        var deletefavouritecropid = $(this).val();
        $('#deletefavouritecropId').val(deletefavouritecropid);
        $('#deletefavouritecropmodal').modal('show');
    });
</script>