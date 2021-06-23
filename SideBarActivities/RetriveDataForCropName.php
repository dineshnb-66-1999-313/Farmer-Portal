<?php
    require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
    $cropcategory = $_POST['categoryId'];
    $SqlForCropCategoryName = $pdo->prepare("SELECT * FROM crop_category_items WHERE Crop_Category = :Crop_Category");
    $SqlForCropCategoryName -> execute(array(':Crop_Category' => $cropcategory));

    $cropName_arr = array();     

    while($FetchCategoryName = $SqlForCropCategoryName->fetch(PDO::FETCH_ASSOC)){
        $CropCategoryId = $FetchCategoryName['ID'];
        $CropCategoryname = $FetchCategoryName['name'];
        
        $cropName_arr[] = array("id" => $CropCategoryId, "name" => $CropCategoryname);
    }

    echo json_encode($cropName_arr);
?>
