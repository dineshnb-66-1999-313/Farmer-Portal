<?php
    session_start();
    require_once "../dompdf/autoload.inc.php";

    use Dompdf\Dompdf;
    $document = new Dompdf();

    $pdo=new PDO('mysql:host=localhost;post=3306;dbname=farmer_portal_website','root','dineshnb66@D');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $selectorderdetails = $pdo->prepare("SELECT * FROM purchased_crop_item WHERE order_id = :order_id");
    $selectorderdetails->execute(array(':order_id' => $_SESSION['ORDER_ID']));
    $fetchorderdetails = $selectorderdetails->fetch(PDO::FETCH_ASSOC);

    $selectfarmeretails = $pdo->prepare("SELECT * FROM purchased_crop_item INNER JOIN sign_up_farmer_information ON purchased_crop_item.farmer_E_mail_id = sign_up_farmer_information.E_mail_id WHERE order_id = :order_id");
    $selectfarmeretails->execute(array(':order_id' => $_SESSION['ORDER_ID']));
    $fetchfarmerdetails = $selectfarmeretails->fetch(PDO::FETCH_ASSOC);

    $Sqlfordefaultaddressfarmer = $pdo->prepare("SELECT * FROM farmer_user_address_table INNER JOIN purchased_crop_item ON farmer_user_address_table.E_mail_id = purchased_crop_item.farmer_E_mail_id WHERE order_id = :order_id AND default_address = :default_address");
    $Sqlfordefaultaddressfarmer->execute(array(':order_id' => $_SESSION['ORDER_ID'], ':default_address' => 'DEFAULT'));
    $fetchfarmeraddress = $Sqlfordefaultaddressfarmer->fetch(PDO::FETCH_ASSOC);

    $Sqlfordefaultaddressuser = $pdo->prepare("SELECT * FROM farmer_user_address_table INNER JOIN purchased_crop_item ON farmer_user_address_table.E_mail_id = purchased_crop_item.purchaser_E_mail_id WHERE order_id = :order_id AND default_address = :default_address");
    $Sqlfordefaultaddressuser->execute(array(':order_id' => $_SESSION['ORDER_ID'], ':default_address' => 'DEFAULT'));
    $fetchuseraddress = $Sqlfordefaultaddressuser->fetch(PDO::FETCH_ASSOC);


    $html = '
    <!DOCTYPE html>
            <html lang="en">
            <head>
                <title>Farmer Portal</title>
                <link rel="icon" type="image/png" href="../Images/Farmer_Logo.png">
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
            </head>
            <body>
        <div class="col-md-10 justify-content-center bg-white p-3" id="main_div_center" style="border: 2px solid red;">
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
        </div>
        </body>
        </html>
    ';
    $document->loadHtml($html);

    $document->setPaper('A4', 'landscape');

    $document->render();

    $document->stream("Bill generation", array("Attachment" => 0));

    //1: Download
    //0: preview



?>