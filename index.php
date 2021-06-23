<?php
    require_once "./ComponentFolder/header.php";
    if(isset($_POST['MoveToLoginPage'])){
        header('location: ./SignUpAndLoginFolder/LoginPageFarmerPortal.php');
    }
    if(isset($_POST['MoveToSignUpPageFarmer'])){
        header('location: ./SignUpAndLoginFolder/BasicDetailSignUp.php');
    }
    if(isset($_POST['MoveToSignUpPageUser'])){
        header('location: ./SignUpAndLoginFolder/SignUpUser.php');
    }
?>
<style>
    body {
        background: url("https://i.pinimg.com/originals/2b/c9/70/2bc97013f49592c6d7d095ab5407d3bf.jpg");
        font-family: "roboto";
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
    <?php
        nav_bar_default();
    ?>
    <div class="container-fluid" id="containertop">
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

    </div>

<?php
    require_once "./ComponentFolder/FooterFarmerPortal.php";
?>
</body>
</html>