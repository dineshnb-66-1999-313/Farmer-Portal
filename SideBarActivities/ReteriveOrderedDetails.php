<?php
    require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
    $oderdetailsidcrop = $_POST['oderdetailsid'];

    $sqlfoeorderddetails = $pdo->prepare("SELECT * FROM purchased_crop_item WHERE Crop_id = :Crop_id");
    $sqlfoeorderddetails -> execute(array(':Crop_id' => $oderdetailsidcrop));

    $ordered_crop_detialsfar = array(); 
    $ordered_crop_detialspur = array();
    $alladdorderdetails = array();  

    while($fetchorderdetails = $sqlfoeorderddetails->fetch(PDO::FETCH_ASSOC))
    {
        if($fetchorderdetails['User_Type'] == 'PURCHASER')
        {
            $sqlforprofilepur = $pdo->prepare("SELECT Actual_profile_image FROM user_profile_information WHERE E_mail_id = :E_mail_id");
            $sqlforprofilepur->execute(array(':E_mail_id' => $fetchorderdetails['purchaser_E_mail_id']) );
            while($fetchpurprofilepic = $sqlforprofilepur->fetch(PDO::FETCH_ASSOC))
            {
                $ordered_crop_detialspur[] = array("order_id" => $fetchorderdetails['order_id'],
                                        "selected_quantity" => $fetchorderdetails['selected_quantity'],
                                        "Purchaser_name" => $fetchorderdetails['purchaser_name'],
                                        "purchaser_phone_number" => $fetchorderdetails['purchaser_phone_number'],
                                        "purchaser_profileimage" => $fetchpurprofilepic['Actual_profile_image'],
                                        "crop_price_p_kg" => $fetchorderdetails['crop_price'],
                                        "total_cost" => $fetchorderdetails['total_price']);
            }
        }
        else{
            $sqlforprofilefar = $pdo->prepare("SELECT profile_picture FROM sign_up_farmer_information WHERE E_mail_id = :E_mail_id");
            $sqlforprofilefar->execute(array(':E_mail_id' => $fetchorderdetails['purchaser_E_mail_id']) );
            while($fetchfarprofilepic = $sqlforprofilefar->fetch(PDO::FETCH_ASSOC))
            {
                $ordered_crop_detialsfar[] = array("order_id" => $fetchorderdetails['order_id'],
                                        "selected_quantity" => $fetchorderdetails['selected_quantity'],
                                        "Purchaser_name" => $fetchorderdetails['purchaser_name'],
                                        "purchaser_phone_number" => $fetchorderdetails['purchaser_phone_number'],
                                        "purchaser_profileimage" => $fetchfarprofilepic['profile_picture'],
                                        "crop_price_p_kg" => $fetchorderdetails['crop_price'],
                                        "total_cost" => $fetchorderdetails['total_price']);
            }
            
        }
        $alladdorderdetails = array_merge($ordered_crop_detialspur, $ordered_crop_detialsfar);
    }
    echo json_encode($alladdorderdetails);
?>