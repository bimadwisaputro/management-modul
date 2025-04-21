<?php
session_start();
include('connect.php');

if (isset($_POST)) {
    $price = $_POST['price'];
    $result = mysqli_query($conn, "SELECT * FROM services 
                                            WHERE start_cost <= " . $price . " 
                                            and  IF(end_cost <= 0, 9999999999, end_cost) >= " . $price . "  
                            ");
    $checkdata = mysqli_num_rows($result);
    if ($checkdata > 0) {
        $data = mysqli_fetch_assoc($result);
        if ($data['percentage'] == '1') {
            $json['fee'] =  round($price * ($data['price'] / 100));
        } else {
            $json['fee'] = round($data['price']);
        }
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }


    echo json_encode($json);
}
