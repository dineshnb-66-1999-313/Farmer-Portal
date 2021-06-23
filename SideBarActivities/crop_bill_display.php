<?php
    require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
    $oder_id = $_POST['order_id'];

    $crop_bill_array = array();

    $sqlforcropbilldisplay = $pdo->prepare("SELECT * FROM purchased_crop_item WHERE order_id = :order_id");
    $sqlforcropbilldisplay->execute(array(':order_id' => $oder_id));

    while($fetchcropbill = $sqlforcropbilldisplay->fetch(PDO::FETCH_ASSOC)){
        $crop_bill_array = array(
            'order_id' => $fetchcropbill['order_id'],
            'crop_name' => $fetchcropbill['crop_name'],
            'crop_category' => $fetchcropbill['crop_category'],
            'crop_price' => $fetchcropbill['crop_price'],
            'selected_quantity' => $fetchcropbill['selected_quantity'],
            'total_price' => $fetchcropbill['total_price'],
            'date_of_order' => $fetchcropbill['date_of_order']
        );
    }
    echo json_encode($crop_bill_array);

?>