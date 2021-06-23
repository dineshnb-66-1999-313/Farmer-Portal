<?php
try{
    $pdo=new PDO('mysql:host=localhost;post=3306;dbname=farmer_portal_website','dineshnb66D','dineshnb66@890D');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOExeption $e){
        echo 'connection faied:'.$e->getMessage();
}