<?php
    require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
    $crop_id = $_POST['cropid'];

    $SelectCropDetails = $pdo->prepare("SELECT * FROM add_crop_image_table WHERE Crop_id = :Crop_id");
    $SelectCropDetails -> execute(array(':Crop_id' => $crop_id));

    $crop_array = array();
    while($FetchCropDetails = $SelectCropDetails->fetch(PDO::FETCH_ASSOC)){
        $Farmer_email = $FetchCropDetails['E_mail_id'];
        $Crop_name = $FetchCropDetails['crop_name'];
        $crop_category = $FetchCropDetails['crop_category'];
        $crop_quantity = $FetchCropDetails['crop_quantity'];
        $crop_price = $FetchCropDetails['crop_price'];
        $crop_id = $FetchCropDetails['Crop_id'];
        $crop_description = $FetchCropDetails['crop_description'];
        
        $crop_array = array("Farmer_email" => $Farmer_email,
                            "crop_category" => $crop_category,
                            "crop_quantity" => $crop_quantity,
                            "crop_price" => $crop_price,
                            "Crop_name" => $Crop_name,
                            "crop_id" => $crop_id,
                            "crop_description" => $crop_description);
    }
    echo json_encode($crop_array);
?>