<?php
session_start();
    if(isset($_POST['LogoutAsFarmerPortal'])){
        unset($_SESSION['SecureLoginSession']);
        session_unset();
        session_destroy();
        header('location: ../');
    }
?>