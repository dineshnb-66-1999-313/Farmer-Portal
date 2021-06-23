<style>
  footer a {
    color: #fff;
    text-decoration: none;
  }
  footer a:hover {
    color: #fff;
    text-decoration: none;
  }
  .navbar {
    border-bottom: 3px solid green;
  }
  #adrress_center {
    margin-inline: auto;
  }
  body::-webkit-scrollbar {
    width: 10px;
  }
  body::-webkit-scrollbar-thumb {
    background: orange;
    border-radius: 0px;
  }
  #farmerportallogo {
    width: 17%;
    height: 30px;
    border-radius: 50%;
    margin-left: 0.7rem;
  }
</style>
<?php
  require_once "header.php";


function nav_bar_default()
{
  echo '
      <nav class="navbar navbar-expand-lg navbar-light bg-info fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" style="margin-right: -11rem;" href=""><img src="../Images/Farmer_Logo.png" style="width: 14%;height: 30px;border-radius: 50%;" /><b>Farmer Portal</b></a>
        </div>
      </nav>
  ';
}

function nav_bar_home()
{
  echo '<div class="modal fade" id="logoutmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:10%;";>
    <div class="modal-dialog">
        <div class="modal-content" style="border:3px solid red";>
        <div class="modal-header">
            <h3 class="modal-title text-danger" id="exampleModalLabel">Logout</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h4>Are you sure You want to logout</h4>
        </div>
        <div class="modal-footer">
            <form action="../FarmerHomePageFolder/LogicForFarmerPortal.php" method="post">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="LogoutAsFarmerPortal">Logout</button>
            </form>
        </div>
        </div>
    </div>
  </div>';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-info fixed-top">
      <div class="container-fluid">
      <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <a class="navbar-brand" style="margin-right: -11rem;" href="../"><img src="../Images/Farmer_Logo.png" style="width: 14%;height:30px;border-radius: 50%;" /><b>Farmer Portal</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-2">';
              if(isset($_SESSION['SecureLoginSession'])){
                  if($_SESSION['LoginFarmerUserType'] == 'FARMER'){
                    echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>Welcome : '.$_SESSION['LoginFarmerFirstName'].' '.$_SESSION['LoginFarmerLastName'].'</b></a></li></h5>';
                  }
                  else{
                    echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>Welcome : '.$_SESSION['LoginUserFullName'].'</b></a></li></h5>';
                  }
              }
          echo '</ul>
          <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-1">
          <form action="SearchFarmerCropItem.php" method="post" class="d-flex text-center">
            <input class="form-control form-control-md mr-3 ml-4" style="max-width: -webkit-fill-available;" type="search" placeholder="Search Here" aria-label="Search" name="value_field" required="required">
            <button class="btn btn-outline-success mr-3" name="SearchCropItem" type="submit">Search</button>
          </form>
            </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-1">';
          
          if(isset($_SESSION['SecureLoginSession']))
          {
              echo '<button type="button" class="btn btn-danger me-lg-2 mb-3" data-bs-toggle="modal" data-bs-target="#logoutmodel" title="Log out">Logout<i class="fa fa-sign-out ml-2 text-white"></i></button>';
          } 
          else
          {
          echo '
          <form action="LogicForFarmerPortal.php" method="post">
            <button class="btn btn-outline-primary" type="submit" name="MoveToSignUpPageFarmer"><i class="fa fa-user-plus mr-2 text-warning"></i>SIGNUP FARMER</button>
            <button class="btn btn-outline-primary" type="submit" name="MoveToSignUpPageUser"><i class="fa fa-user-plus mr-2 text-warning"></i>SIGNUP USER</button>
            <button class="btn btn-outline-primary" type="submit" name="MoveToLoginPage"><i class="fa fa-sign-in mr-3 text-warning"></i>LOGIN</a></button>
          </form>';}
          echo '</div>
        </div>
      </div>
  </nav>';
}
function nav_bar_Add_to_crop()
{
    echo '<nav class="navbar navbar-expand-sm navbar-light bg-info fixed-top" style="border-bottom: 3px solid green;">
            <a class="navbar-brand" style="margin-right: -11rem;" href="../"><img src="../Images/Farmer_Logo.png" style="width: 14%;height: 30px;border-radius: 50%;" /><b>Farmer Portal</b></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent">
                  <span class="navbar-toggler-icon"></span>
                </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">';
                echo '<ul class="navbar-nav ml-auto">';
                if(isset($_SESSION['SecureLoginSession']))
                {
                    if($_SESSION['LoginFarmerUserType'] == 'FARMER'){
                      echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>'.$_SESSION['LoginFarmerFirstName'].' '.$_SESSION['LoginFarmerLastName'].'</b></a></li></h5>';
                    }
                    else{
                      echo '';
                    }
                }
                echo '</ul>';
                echo '</div>
        </nav>';
}

function nav_bar_profile()
{
  echo '<nav class="navbar navbar-expand-sm navbar-light bg-info fixed-top" style="border-bottom: 3px solid green;">
        <a class="navbar-brand" style="margin-right: -11rem;" href="../"><img src="../Images/Farmer_Logo.png" style="width: 14%;height: 30px;border-radius: 50%;" /><b>Farmer Portal</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent">
              <span class="navbar-toggler-icon"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">';
            echo '<ul class="navbar-nav ml-auto">';
            if(isset($_SESSION['SecureLoginSession']))
            {
                if($_SESSION['LoginFarmerUserType'] == 'FARMER'){
                  echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>'.$_SESSION['LoginFarmerFirstName'].' '.$_SESSION['LoginFarmerLastName'].'</b></a></li></h5>';
                }
                else{
                  echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>'.$_SESSION['LoginUserFullName'].'</b></a></li></h5>';
                }
            }
            echo '</ul>';
            echo '</div>
      </nav>';
}

function nav_bar_serach()
{
  echo '<nav class="navbar navbar-expand-sm navbar-light bg-info fixed-top" style="border-bottom: 3px solid green;">
        <a class="navbar-brand" style="margin-right: -11rem;" href="../"><img src="../Images/Farmer_Logo.png" style="width: 14%;height: 30px;border-radius: 50%;" /><b>Farmer Portal</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent">
              <span class="navbar-toggler-icon"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="col-md-8">
              <form action="SearchFarmerCropItem.php" method="post" class="d-flex">
              <div class="input-group">
                <input type="search" class="form-control form-control-md ml-5 mt-2" placeholder="Search Crop" style="max-width: -webkit-fill-available;" name="value_field" required="required" aria-describedby="button-addon2">
                <button class="btn btn-outline-success btn-sm mt-2" name="SearchCropItem" type="submit" id="button-addon2"><i class="fas fa-search fa-lg mr-2"></i>Search</button>
              </div>
              
              </form>
          </div>';
            echo '<ul class="navbar-nav ml-auto">';
            if(isset($_SESSION['SecureLoginSession']))
            {
                if($_SESSION['LoginFarmerUserType'] == 'FARMER'){
                  echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>'.$_SESSION['LoginFarmerFirstName'].' '.$_SESSION['LoginFarmerLastName'].'</b></a></li></h5>';
                }
                else{
                  echo '<h5><li class="nav-item text-dark ml-5" style="margin-left:3rem!important"><a class="nav-link"><b>'.$_SESSION['LoginUserFullName'].'</b></a></li></h5>';
                }
            }
            echo '</ul>';
            echo '</div>
      </nav>';
}

function nav_bar_sign_up()
{
    echo '<nav class="navbar navbar-expand-sm navbar-light bg-info fixed-top">
            <div class="container-fluid">
            <a class="navbar-brand" style="margin-right: -11rem;" href="../"><img src="../Images/Farmer_Logo.png" style="width: 16%;height: 40px;border-radius: 58%;" /><b>Farmer Portal</b></a>
            </div>
        </nav>';
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

