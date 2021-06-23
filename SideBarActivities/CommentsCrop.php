<?php
    require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
    $order_crop_id = $_POST['commentsidcrop'];

    $SelectCropDetails = $pdo->prepare("SELECT * FROM purchased_crop_item WHERE order_id = :order_id");
    $SelectCropDetails -> execute(array(':order_id' => $order_crop_id));

    $comments_crop_array = array();
    while($FetchCropDetails = $SelectCropDetails->fetch(PDO::FETCH_ASSOC)){
        $comments_crop_array = array("order_id" => $FetchCropDetails['order_id'],
                                     "purchaser_name" => $FetchCropDetails['purchaser_name'],
                                     "crop_id" => $FetchCropDetails['Crop_id']);
    }
    echo json_encode($comments_crop_array);
?>