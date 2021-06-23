<?php
    session_start();
    require_once "../ComponentFolder/header.php";
    require_once "../ComponentFolder/ComponentForCropItems.php";
    $crop_Approved = 'APPROVED';
    $crop_vegetable = 'Vegetable';
    $crop_fruits = 'Fruits';
    $crop_millets = 'Millets';
    $crop_foodGrains = 'FoodGrains';
    $farmer_user = 'FARMER';

    if(isset($_POST['view_crop_detail'])){
        $_SESSION['View_Crop_Id'] = $_POST['crop_view_detailes'];
        header('Location: CropViewPageDetails.php');
    }
    
    if(isset($_POST['MoveToLoginPage'])){
        header('location: ../SignUpAndLoginFolder/LoginPageFarmerPortal.php');
    }
    if(isset($_POST['MoveToSignUpPageFarmer'])){
        header('location: ../SignUpAndLoginFolder/BasicDetailSignUp.php');
    }
    if(isset($_POST['MoveToSignUpPageUser'])){
        header('location: ../SignUpAndLoginFolder/SignUpUser.php');
    }

?>

<?php
    if(isset($_SESSION['SecureLoginSession'])){
        nav_bar_home();
    }
    else{
        nav_bar_default();
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
    .sidenav {
        height: 100%;
        width: 257px;
        position: fixed;
        z-index: 1111;
        background: #042331;
        top: 0;
        left: -257px;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 21px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 60px;
    }

    @media screen and (max-height: 450px) {
    .sidenav {
        padding-top: 15px;
    }
    .sidenav a {
        font-size: 18px;
    }
    }
    #closebtn {
        color: red;
        top: -1%;
        position: absolute;
        left: 53%;
        font-size: 2rem;
    }
    .profile_img {
        width: 68%;
        height: 21%;
        border-radius: 50%;
        position: absolute;
        top: 2%;
        left: 12%;
        border: 1px solid #fff;
    }
    .profile_img1 {
        width: 68%;
        height: 21%;
        border-radius: 50%;
        position: absolute;
        top: 2%;
        left: 12%;
    }
    .list {
    /* background: green; */
        top: 25%;
        position: absolute;
        border-top: 3px solid green;
        width: 104%;
        left: -5%;
    }
    .list ul {
        display: block;
        width: 120%;
        height: 10%;
        line-height: 70px;
        font-size: 17px;
        color: #fff;
        box-sizing: border-box;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid #000;
        transition: 0.4s;
        padding-right: 20%;
    }
    .list li {
        left: -10%;
        position: relative;
        text-decoration: none;
    }
    .list ul a {
        display: block;
        width: 110%;
        line-height: 60px;
        font-size: 17px;
        color: #fff;
        padding-right: 49px;
        box-sizing: border-box;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid #000;
        transition: 0.7s;
    }
    .list ul a i {
        color: greenyellow;
    }
    .list ul li a:hover {
        background: #818ebc;
        text-decoration: none;
        color: #1ef707;
        border-radius: 0 50px 50px 0;
    }
    .list ul a i {
        margin-right: 15px;
    }
    .sidenav::-webkit-scrollbar {
        width: 4px;
    }
    .sidenav::-webkit-scrollbar-thumb {
        background: orange;
        border-radius: 10px;
    }
    .Approved{
        background: green;
        position: absolute;
        line-height: initial;
        padding: 0.2rem;
        left: 11rem;
        border-radius: 9%;
        z-index: 1123;
    }
    #rowtop1{
        margin-top:2rem !important;
    }
    #rowtop2{
        margin-top:3rem !important;
    }
    #containertop{
        margin-top:5.6rem !important;
    }
</style>

<!-- --------------------side bar starts----------------- -->
<div id="mySidenav" class="sidenav">
    <a class="closebtn" id="closebtn" onclick="closeNav()"><i class="fas fa-arrow-left"></i></a>
    <?php
        if(isset($_SESSION['SecureLoginSession']))
        {
            if($_SESSION['LoginFarmerUserType'] === 'FARMER')
            {
                $SqlProfileImg=$pdo->prepare("SELECT profile_picture FROM sign_up_farmer_information WHERE E_mail_id=:E_mail_id");
                $SqlProfileImg->execute(array(':E_mail_id'=> $_SESSION['SecureLoginSession']));
                $FetchProfileFamerImage=$SqlProfileImg->fetch(PDO::FETCH_ASSOC);

                echo "<img src=".$FetchProfileFamerImage['profile_picture']." class='profile_img'>";
            }
            else{
                $SqlUserProfileImg=$pdo->prepare("SELECT * FROM user_profile_information WHERE E_mail_id=:E_mail_id");
                $SqlUserProfileImg->execute(array(':E_mail_id'=> $_SESSION['SecureLoginSession']));
                $FetchProfileUserImage=$SqlUserProfileImg->fetch(PDO::FETCH_ASSOC);

                if($FetchProfileUserImage['Actual_profile_image'] == 1)
                {
                    echo "<img src=".$FetchProfileUserImage['Actual_profile_image']." class='profile_img'>";
                }
                else
                {
                    echo "<img src=".$FetchProfileUserImage['Actual_profile_image']." class='profile_img'>";
                }
            }
        }
        else{
            echo "<img src='../Images/Farmer_Logo.png' class='profile_img1'>";
        }
    ?>
    <div class="list">
        <ul>
            <li><a href="../SideBarActivities/ProfileAndPersonalInformation.php"><i class="fas fa-user"></i>Profile</a></li>
            <?php
                if($_SESSION['LoginFarmerUserType'] === 'FARMER'){
                    echo '
                        <li><a href="../SideBarActivities/AddCropComponentFarmer.php"><i class="fas fa-tractor"></i>Add Crop</a></li>
                        <h6 class="Approved">APPROVED</h6>
                        <li><a href="../SideBarActivities/UploadedDocuments.php"><i class="fas fa-id-card"></i>Uploaded Documents</a></li>
                    ';
                }
            ?>
            <li><a href="../SideBarActivities/OrderDetailsFarmerUser.php"><i class="fas fa-arrow-up"></i>My Orders</a></li>
            <li><a href="../SideBarActivities/MyFavouriteFarmerUser.php"><i class="fas fa-heart"></i>My favourite</a></li>
            <li><a href="#"><i class="fa fa-calendar"></i>Events</a></li>
            <li><a href="#"><i class="fa fa-cog fa-spin"></i>Setting</a></li>
            <li><a href="#"><i class="fa fa-phone"></i>contact-info</a></li>
        </ul>
    </div>
</div>
<!-- --------------------side bar ends----------------- -->

<!-- ------------------------------body section starts------------------------------------------- -->
<div class="col-md-12" id="container" style="margin-top:5.4rem!important">
    <?php
        if(isset($_SESSION['SecureLoginSession']))
        {
            echo '
            <ul class="nav nav-tabs pl-2" id="mytab" role="tablist">
                <li class="mr-3 nav-item active" role="preentation"><a class="nav-link active" role="tab" area-controls="Vegetable_Crop_items" data-toggle="tab" href="#Vegetable_Crop_items"><i class="fas fa-carrot fa-lg mr-2 text-warning"></i>Vegetable</a></li>
                <li class="mr-3 nav-item" role="preentation"><a class="nav-link" role="tab" area-controls="Fruits_crop_items" data-toggle="tab" href="#Fruits_crop_items"><i class="fas fa-apple-alt fa-lg mr-2 text-danger"></i>Fruits</a></li>
                <li class="mr-3 nav-item" role="preentation"><a class="nav-link" role="tab" area-controls="FoodGrains_crop_items" data-toggle="tab" href="#FoodGrains_crop_items"><i class="fad fa-wheat fa-lg mr-2 text-success"></i>Food Grains</a></li>
                <li class="mr-3 nav-item" role="preentation"><a class="nav-link" role="tab" area-controls="Millets_crop_items" data-toggle="tab" href="#Millets_crop_items"><i class="fad fa-wheat fa-lg mr-2 text-success"></i>Millets</a></li>
            </ul>
            ';
        }
        else
        {
            echo '
           <div class="row">
            <div id="myslideshow" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li class="active bg-success" data-bs-target="#myslideshow" data-bs-slide-to="0"></li>
                    <li class="bg-success" data-bs-target="#myslideshow" data-bs-slide-to="1"></li>
                    <li class="bg-success" data-bs-target="#myslideshow" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner bg-white">
                    <div class="carousel-item active" data-bs-interval="3000">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 offset-md-1 align-self-center">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyDdnTp-KBLNRmKfUaaFu9G524gSRGEqQhHw&usqp=CAU" class="img-responsive rounded mx-auto d-block p-3" style="max-width:100%;height:15rem;">
                            </div>
                            <div class="col-6 col-md-5 d-none d-md-block">
                                <h1>Groundnut </h1>
                                <p>Groundnut, popularly known as the peanut is a leguminous crop cultivated for edible purposes. It is found exclusively in tropical and subtropical regions of the world.</p>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 offset-md-1 align-self-center">
                                <img src="https://moderndiplomacy.eu/wp-content/uploads/2020/12/india-farmer-agriculture.jpg" class="img-responsive rounded mx-auto d-block p-3" style="max-width:100%;max-height:15rem;">
                            </div>
                            <div class="col-6 col-md-5 d-none d-md-block">
                                <h1>About Farmer</h1>
                                <p>The farmer is the only man in our economy who buys everything at retail, sells everything at wholesale, and pays the freight both ways...lets change it now...!!!</p>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 offset-md-1">
                                <img src="https://mkisan.gov.in/images/poster.jpg" class="img-responsive rounded mx-auto d-block p-3" style="max-width:100%;max-height:15rem;">
                            </div>
                            <div class="col-6 col-md-6 d-none d-md-block">
                                <h1>Farmers Portal</h1>
                                <p>Agriculture is the backbone of the Indian Economy"- said Mahatma Gandhi six decades ago. Even today, the situation is still the same, with almost the entire economy being sustained by agriculture, which is the mainstay of the villages.</p>
                            </div>
                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>
                    <a class="carousel-control-prev" role="button" data-bs-target="#myslideshow" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon btn btn-success" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" role="button" data-bs-target="#myslideshow" data-bs-slide="next">
                        <span class="carousel-control-next-icon btn btn-success" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" id="rowtop2">
            <form method="post">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 col-lg-4">
                        <button class="btn btn-primary btn-lg mt-2 btn-block" type="submit" name="MoveToSignUpPageFarmer"><i class="fa fa-user-plus mr-2 text-warning"></i>SIGNUP FARMER</button>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                        <button class="btn btn-primary btn-lg mt-2 btn-block" type="submit" name="MoveToSignUpPageUser"><i class="fa fa-user-plus mr-2 text-warning"></i>SIGNUP USER</button>
                    </div>
                    <div class="col-12 col-sm-6 col-md-12 col-lg-4">
                        <button class="btn btn-primary btn-lg mt-2 btn-block" type="submit" name="MoveToLoginPage"><i class="fa fa-sign-in mr-3 text-warning"></i>LOGIN</a></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row" id="rowtop1">
            <div class="col-12 col-md-10 p-5">
                <blockquote className="home_center">
                    <cite class="text-white"><h1><b>The farmer is the only man in our economy who buys everything at retail, sells everything at wholesale, and pays the freight both ways...</b></h1></cite>
                    <cite class="text-warning float-right"><h2><b>lets change it now...!!!</b></h2></cite>
                </blockquote>
            </div>
        </div>
';
        }
    ?>
    
    <div class="tab-content">

        <!-- vagetable tabs in the website starts -->
        <div id="Vegetable_Crop_items" class="tab-pane active" role="tabpanel">
            <div class="container ml-0" style="max-width: 100%;">
                <div class="row text-center">
                <?php
                    if(isset($_SESSION['SecureLoginSession'])){
                        if($_SESSION['LoginFarmerUserType'] === $farmer_user ){
                            $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                             add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND add_crop_image_table.E_mail_id != :E_mail_id AND crop_quantity > 0");
                            $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_vegetable, ':E_mail_id' => $_SESSION['SecureLoginSession']));
                            while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                            {
                                crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                            }
                        }
                        else{
                            $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                             add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND crop_quantity > 0");
                            $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_vegetable));
                            while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                            {
                                crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                            }
                        }
                        
                    }
                    else{
                        echo '';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- vagetable tabs in the website ends -->

        <!-- Fruits tabs in the website starts -->

        <div id="Fruits_crop_items" class="tab-pane" role="tabpanel">
            <div class="container" style="max-width: 100%;">
                <div class="row text-center">
                    <?php
                        if(isset($_SESSION['SecureLoginSession']))
                        {
                            if($_SESSION['LoginFarmerUserType'] === $farmer_user )
                            {
                                $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                                    add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND add_crop_image_table.E_mail_id != :E_mail_id AND crop_quantity > 0");
                                $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_fruits,':E_mail_id' => $_SESSION['SecureLoginSession']));
                                while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                                {
                                    crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                                }
                            }
                            else{
                                $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                                    add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND crop_quantity > 0");
                                $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_fruits));
                                while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                                {
                                    crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                                }
                            }
                        }
                        else{
                            echo '';
                        }
                        ?>
                </div>
            </div>
        </div>
        <!-- Fruits tabs in the website ends -->

        <!-- FoodCrops tabs in the website starts -->
        <div id="FoodGrains_crop_items" class="tab-pane" role="tabpanel">
            <div class="container" style="max-width: 100%;">
                <div class="row text-center">
                    <?php
                        if(isset($_SESSION['SecureLoginSession']))
                        {
                            if($_SESSION['LoginFarmerUserType'] === $farmer_user )
                            {
                                $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                                        add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND add_crop_image_table.E_mail_id != :E_mail_id AND crop_quantity > 0");
                                $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_foodGrains,':E_mail_id' => $_SESSION['SecureLoginSession']));
                                while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                                {
                                    crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                                }
                            }
                            else{
                                $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                                        add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND crop_quantity > 0");
                                $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_foodGrains));
                                while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                                {
                                    crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                                }
                            }
                        }
                        else{
                            echo '';
                        }
                    ?> 
                </div>
            </div>
        </div>
        <!-- FoodCrops tabs in the website ends -->

        <!-- millets tabs in the website starts -->
        <div id="Millets_crop_items" class="tab-pane" role="tabpanel">
            <div class="container" style="max-width: 100%;">
                <div class="row text-center">
                    <?php
                        if(isset($_SESSION['SecureLoginSession']))
                        {
                            if($_SESSION['LoginFarmerUserType'] === $farmer_user )
                            {
                                $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                                        add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND add_crop_image_table.E_mail_id != :E_mail_id AND crop_quantity > 0");
                                $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_millets, ':E_mail_id' => $_SESSION['SecureLoginSession']));
                                while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                                {
                                    crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                                }
                            }
                            else{
                                $InnerJoinToFetchFarmerName = $pdo->prepare("SELECT * FROM add_crop_image_table INNER JOIN sign_up_farmer_information ON 
                                                                                        add_crop_image_table.E_mail_id = sign_up_farmer_information.E_mail_id AND crop_status = :crop_status AND crop_category = :crop_category AND crop_quantity > 0");
                                $InnerJoinToFetchFarmerName->execute(array(':crop_status' =>$crop_Approved, ':crop_category' => $crop_millets));
                                while($FetchFarmerName = $InnerJoinToFetchFarmerName->fetch(PDO::FETCH_ASSOC))
                                {
                                    crop_product_items_approved_in_home_page($FetchFarmerName['Crop_id'],$FetchFarmerName['first_name'],$FetchFarmerName['last_name'],$FetchFarmerName['crop_name'],$FetchFarmerName['crop_quantity'], $FetchFarmerName['crop_category'],$FetchFarmerName['crop_price'],$FetchFarmerName['crop_image']);
                                }
                            }
                        }
                        else{
                            echo '';
                        }
                    ?> 
                </div>
            </div>
        </div>
        <!-- millets tabs in the website ends -->

    </div>

</div>
    
<!-- ------------------------------body section ends------------------------------------------- -->

<?php
    require_once "../ComponentFolder/FooterFarmerPortal.php";
?>
<script type="" src="custom.js"></script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.left = "0px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.left = "-257px";
        }

        window.addEventListener("load",function(){
        const loader=document.querySelector(".loaderclass");
        console.log(loader);
        loader.className += " hidden";
    });
    $(document).ready(function () {
        $('#container').click(function()
        {
            $('#mySidenav').css("left","-257px");
        });
    });
    </script>

    <script>
        var url = document.location.tostring();
        if(url.match('#')){
            $('.nav-tabs a[href="#' + url.split('#')[1]+ '"]').tab('show');
        }
        $('.nav-tabs a').on('show.bs.tab',function(e){
            window.location.hash = e.target.hash;
        });
    </script>
    
</body>
</html>