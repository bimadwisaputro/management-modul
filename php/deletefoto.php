<?php
session_start();
include('connect.php');
if (isset($_POST)) {
    if (in_array($_POST['tipe'], ['transaction_photo'])) {
        $update = mysqli_query($conn, "
        UPDATE " . $_POST['tipe'] . " 
            SET deleted_at = now(),
            deleted_id='" . $_SESSION['userid'] . "' 
         where id= '" . $_POST['tid'] . "' 
    ");
    } else {
        $update = mysqli_query($conn, "
        UPDATE " . $_POST['tipe'] . " 
            SET 
        " . $_POST['tfd'] . " = '' 
        where id= '" . $_POST['tid'] . "' 
    ");
    }
    if ($update) {
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }
    echo json_encode($json);
}
