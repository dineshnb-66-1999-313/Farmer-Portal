<?php
    $pincode = $_POST['pincode'];
    $stateAndcitydata = file_get_contents('http://postalpincode.in/api/pincode/'.$pincode);
    $stateAndcitydata = json_decode($stateAndcitydata);
    $array=array();
    if(isset($stateAndcitydata->PostOffice))
    {
        $array[] = $stateAndcitydata->PostOffice;
        echo json_encode($array);
    }
    else{
        echo 'no';
    }
?>