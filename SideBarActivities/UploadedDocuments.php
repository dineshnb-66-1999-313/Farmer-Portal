<?php

    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";

    if(isset($_POST['backtohomefromaddcrop'])){
        header('location: ../FarmerHomePageFolder/HomePageFarmerPortal.php');
    }

?>
<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
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
    iframe::-webkit-scrollbar {
        width: 4px;
    }
    iframe::-webkit-scrollbar-thumb {
        background: orange;
        border-radius: 20px;
    }
    .img-fluid{
        max-width:17rem;
        height:17rem;
        border:2px solid #000;
        margin-left: 5rem;
        padding: 1rem;
    }

</style>
<?php
    nav_bar_Add_to_crop();
?>

<div class="container-fluid">
    <div class="row" style="margin-top: 4.8rem !important;">
        <div class="col-5 col-sm-1 col-md-3 mr-auto">
            <form method="post">
                <button class="btn btn-primary btn-md" name="backtohomefromaddcrop"><i class="fa fa-arrow-left mr-3 text-danger"></i>Back To Home</button>
            </form>
        </div>
    </div>
    <div class="row">
        <?php
        if(isset($_SESSION['SecureLoginSession']))
        {
            $sqlforshowactivedoc = $pdo->prepare("SELECT * FROM sign_up_farmer_information WHERE E_mail_id = :E_mail_id");
            $sqlforshowactivedoc ->execute(array(':E_mail_id' => $_SESSION['SecureLoginSession']));
            $fetchactivedoc = $sqlforshowactivedoc->fetch(PDO::FETCH_ASSOC);
        echo'
        <div class="alert alert-success col-12 col-sm-12 col-md-12 col-lg-9 offset-md-1 text-center" id="address_center" role="alert">
            <h5 class="text-dark"> <i class="fas fa-check-circle fa-lg mr-3 text-success"></i> Your Documents Have been Varified </h5>
        </div>
        <div class="col-md-6">
            <div class="card pt-3" style="width: 35rem;border-bottom-left-radius: 1rem;border-bottom-right-radius: 1rem">
                <iframe class="sidenav" src="'.$fetchactivedoc['land_document'].'" width="100%" style=""></iframe>
                <div class="card-body p-1" style="border-top: 2px solid #000;">
                    <h3><i class="fas fa-file-pdf-o fa-2x ml-3 pt-2 text-danger"></i><span class="ml-4 mr-4"><cite>Land Document in PDF</cite></span><i class="fas fa-check-circle fa-sm  mr-3 text-success"> Varified</i></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card pt-3" style="width: 35rem;border-bottom-left-radius: 1rem;border-bottom-right-radius: 1rem">
                <iframe class="sidenav" src="'.$fetchactivedoc['aadhar_document'].'" width="100%" style=""></iframe>
                <div class="card-body p-1" style="border-top: 2px solid #000;">
                    <h3><i class="fas fa-file-pdf-o fa-2x ml-3 pt-2 text-danger"></i><span class="ml-4 mr-4"><cite>Aadhar Document in PDF</cite></span><i class="fas fa-check-circle fa-sm  mr-3 text-success"> Varified</i></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-md-4 offset-3">
            <div class="card" style="border-bottom-left-radius: 1rem;border-bottom-right-radius: 1rem;padding-top:2rem;">
                <img id="image-fluid" class="img-fluid card-img-top mr-3" src="'.$fetchactivedoc["profile_picture"].'" style="border-radius:50%;">
                <h4></h4>

                <div class="card-body p-1" style="border-top: 2px solid #000;">
                    <h3><i class="fas fa-user-circle fa-2x ml-3 pt-2 text-primary"></i><span class="ml-4 mr-4"><cite>Profile Picture</cite></span><i class="fas fa-check-circle fa-sm  mr-3 text-success"> Varified</i></h3>
                </div>
            </div>
        </div>
    </div>
    '; }?>
</div>

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>