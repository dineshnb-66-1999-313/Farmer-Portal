<?php
require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Out Page Farmer Portal</title>
    <link rel="icon" type="image/png" href="https://i1.wp.com/www.telugustories.org/wp-content/uploads/2018/02/cpsia-kid-safe-logo.gif?ssl=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body{
            margin: 0;
            padding: 0;
            background: #063146;
            display: flex;
            background-size: cover;
            background-position: center;
        }
        .container{
            top:210px;
            left:490px;
            background: lightgreen;
            width:400px;
            height: 150px;
            position: absolute;
            border-radius: 10px;
        }
        .container i{
            color:green;
            padding-right: 20px;
            position: absolute;
            padding: 15px;
            
        }
        .container lable{
            color: white;
            font-size: 18px;
            position: absolute;
            padding: 40px 10px 100px 90px;
            font-style:italic;
        }
        .container a{
            color: blue;
            font-size: 15px;
            position: absolute;
            padding: 70px 10px 100px 90px;
            font-style:italic;
        }
        .container a:hover{
            cursor: pointer;
            
        }
    </style>
</head>
<body>
    
    <div class="container">
        <i class="fa fa-smile-o fa-5x"></i><lable>You are log out successfully</lable>
        <a href="../SignUpAndLoginFolder/LoginPageFarmerPortal.php">login again</a>
    </div>
    
</body>
</html>

