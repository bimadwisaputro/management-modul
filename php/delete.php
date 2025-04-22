<?php
session_start();
include('connect.php');
if (isset($_POST)) {


    if (in_array($_POST['tipe'], ['learning_moduls'])) {
        $delete_detail = mysqli_query($conn, "
        DELETE FROM learning_modul_details  
        where learning_modul_id ='" . $_POST['tid'] . "' 
       ");
    }

    if (in_array($_POST['tipe'], ['majors'])) {
        $delete_detail = mysqli_query($conn, "
        DELETE FROM " . $_POST['tipe'] . "_detail
        where " . $_POST['tipe'] . "_id='" . $_POST['tid'] . "' 
        ");
    }

    $delete = mysqli_query($conn, "
        DELETE FROM " . $_POST['tipe'] . "  
        where id='" . $_POST['tid'] . "' 
    ");
    if ($delete) {
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }
    echo json_encode($json);
}
