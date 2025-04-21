<?php
session_start();
include('connect.php');
if (isset($_POST)) {
    $delete = mysqli_query($conn, "
        DELETE FROM " . $_POST['tipe'] . "  
        where id= '" . $_POST['tid'] . "' 
    ");
    if ($delete) {
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }
    echo json_encode($json);
}
