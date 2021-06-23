<?php
    require_once "../ComponentFolder/DataBaseConnectionForFarmerPortal.php";
    $address_id = 7;

    $SelectaddressDetails = $pdo->prepare("SELECT * FROM farmer_user_address_table WHERE ID = :ID");
    $SelectaddressDetails -> execute(array(':ID' => $address_id));

    $address_array = array();
    while($FetchAddressDetails = $SelectaddressDetails->fetch(PDO::FETCH_ASSOC))
    {
        $Address_ID = $FetchAddressDetails['ID'];
        $E_mail_id = $FetchAddressDetails['E_mail_id'];
        $pin_code = $FetchAddressDetails['pin_code'];
        $country = $FetchAddressDetails['country'];
        $state = $FetchAddressDetails['user_state'];
        $city = $FetchAddressDetails['user_city'];
        $house_number = $FetchAddressDetails['house_number'];
        $landmark = $FetchAddressDetails['landmark'];
        
        $address_array = array("address_id" => $Address_ID,
                                "E_mail_id" => $E_mail_id,
                                "pincode" => $pin_code,
                                "country" => $country,
                                "state" => $state,
                                "city" => $city,
                                "house_number" => $house_number,
                                "landmark" => $landmark);
    }
    echo json_encode($address_array);
?>