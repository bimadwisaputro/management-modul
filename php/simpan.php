<?php
session_start();
include('connect.php');

if (isset($_POST)) {
    $mode = $_POST['mode'];
    // if (in_array($_POST['tipe'], ['pickups'])) { //for transaction table
    //     $tipe = 'tx_' . $_POST['tipe'];
    // } else {
    //     $tipe = $_POST['tipe'];
    // }
    $tipe = $_POST['tipe'];

    if ($mode == 'Add') {
        $field = '';
        $isi = '';
        $no = 1;
        // var_dump($_POST);
        // die();
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe', 'photo', 'photo_ktp', 'password', 'userroleform', 'majorsdetailform', 'learning_modulsformdetail'])) {
                if ($no == 1) {
                    $field .= "`" . $indexname . "`";
                    $isi .= "'" . $_POST[$indexname] . "'";
                } else {
                    // die($rows);
                    $field .= ",`" . $indexname . "`";
                    $isi .= ",'" . $_POST[$indexname] . "'";
                }
                $no++;
            }
        }
        $field_opt = "";
        $isi_opt = "";
        if ($tipe == 'users') {
            $field_opt .= ",password";
            $hashpass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $isi_opt .= ",'" . $hashpass . "' ";
        }

        // $field_opt .= ",created_id";
        // $isi_opt .= ",'" . $_SESSION['userid'] . "' ";

        if (!isset($_POST['photo']) && $_FILES['photo']['error'] == 0 && !isset($_POST['profileform'])) {
            $result = mysqli_query($conn, "SHOW TABLE STATUS LIKE '" . $tipe . "'");
            $data = mysqli_fetch_assoc($result);
            $fillname = $data['Auto_increment'];
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fillpath = "../uploads/" . $tipe . "/" . $fillname . '.' . $ext;
            if ($_FILES['photo']['error'] == 0) {
                $photo = "uploads/" . $tipe . "/" . $fillname . '.' . $ext;
            }

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $fillpath)) {
                $field .= ",photo";
                $isi .= ",'" . $photo . "' ";
            }
        }
        // var_dump("INSERT INTO " . $tipe . " (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . ")");
        // die(); 
        $runsql = mysqli_query($conn, "INSERT INTO " . $tipe . " (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . ")");

        if ($runsql) {
        }
    }
    if ($mode == 'Edit') {
        $tid = $_POST['tid'];
        $set = '';
        $no = 1;
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe', 'photo', 'photo_ktp', 'password', 'userroleform', 'majorsdetailform', 'learning_modulsformdetail'])) {
                if ($no == 1) {
                    $set .= "`" . $indexname . "` = '" . $_POST[$indexname] . "'";
                } else {
                    $set .= ",`" . $indexname . "`  = '" . $_POST[$indexname] . "'";
                }
                $no++;
            }
        }
        // $set .= ",`updated_id`  = '" . $_SESSION['userid'] . "'";
        if ($tipe == 'users') {
            // $set .= ",`password`  = '" . password_hash($_POST['password'], PASSWORD_BCRYPT) . "'";
        }

        if (!isset($_POST['photo']) && $_FILES['photo']['error'] == 0 && !isset($_POST['profileform'])) {
            $fillname = $tid;
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fillpath = "../uploads/" . $tipe . "/" . $fillname . '.' . $ext;
            if ($_FILES['photo']['error'] == 0) {
                $photo = "uploads/" . $tipe . "/" . $fillname . '.' . $ext;
            }

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $fillpath)) {
                $set .= ",`photo`  = '" . $photo . "'";
            }
        }

        $runsql = mysqli_query($conn, "UPDATE " . $tipe . "  SET " . $set . "  WHERE id='" . $tid . "'");

        if ($runsql) {
        }
    }


    if ($runsql) {
        // if ($_POST['tipe'] == 'pickups' && $mode == 'Add') {
        //     $oderupdate = mysqli_query($conn, "UPDATE tx_orders  SET status='1'  WHERE id='" . $_POST['user_id'] . "'");
        //     $oderdetailupdate = mysqli_query($conn, "UPDATE tx_orders_d  SET status='1'  WHERE user_id='" . $_POST['user_id'] . "'");
        // }
        if ($mode == 'Add') {
            $last_id = $conn->insert_id;
        }
        if ($mode == 'Edit') {
            $last_id = $tid;
        }
        if (isset($_POST['userroleform'])) {

            $dataDetail = $_POST['userroleform'];
            $detaillist = json_decode($dataDetail);
            if (count($detaillist) > 0) {
                $getdata = mysqli_query($conn, "SELECT * FROM user_role WHERE user_id='" . $last_id . "'"); //and a.id not in (1) administrator
                $checknum = mysqli_num_rows($getdata);
                if ($checknum > 0) {
                    $delete =  mysqli_query($conn, "DELETE FROM user_role WHERE user_id='" . $last_id . "'");
                }
                $noc = 1;
                $valuesins = '';
                foreach ($detaillist as $indexname => $rows) {
                    $field2[$noc] = '';
                    $isi2[$noc] = '';
                    $no = 1;
                    foreach ($rows[1] as $index => $row) {
                        if (!in_array($index, ['counter'])) {

                            if ($no == 1) {
                                $field2[$noc] .= "`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= "'" . $row . "'";
                            } else {
                                // die($rows);
                                $field2[$noc] .= ",`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= ",'" . $row . "'";
                            }
                            $no++;
                        }
                    }
                    // var_dump("INSERT INTO user_role  (`user_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");
                    // die();
                    $runsql_details = mysqli_query($conn, "INSERT INTO user_role  (`user_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");

                    // $noc++;
                }
                // die();
            }
        }
        if (isset($_POST['majorsdetailform'])) {

            $dataDetail = $_POST['majorsdetailform'];
            $detaillist = json_decode($dataDetail);
            if (count($detaillist) > 0) {
                $getdata = mysqli_query($conn, "SELECT * FROM majors_detail WHERE majors_id='" . $last_id . "'"); //and a.id not in (1) administrator
                $checknum = mysqli_num_rows($getdata);
                if ($checknum > 0) {
                    $delete =  mysqli_query($conn, "DELETE FROM majors_detail WHERE majors_id='" . $last_id . "'");
                }
                $noc = 1;
                $valuesins = '';
                foreach ($detaillist as $indexname => $rows) {
                    $field2[$noc] = '';
                    $isi2[$noc] = '';
                    $no = 1;
                    foreach ($rows[1] as $index => $row) {
                        if (!in_array($index, ['counter'])) {

                            if ($no == 1) {
                                $field2[$noc] .= "`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= "'" . $row . "'";
                            } else {
                                // die($rows);
                                $field2[$noc] .= ",`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= ",'" . $row . "'";
                            }
                            $no++;
                        }
                    }
                    // var_dump("INSERT INTO user_role  (`user_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");
                    // die();
                    $runsql_details = mysqli_query($conn, "INSERT INTO majors_detail  (`majors_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");

                    // $noc++;
                }
                // die();
            }
        }

        if (isset($_POST['learning_modulsformdetail'])) {

            $dataDetail = $_POST['learning_modulsformdetail'];
            $detaillist = json_decode($dataDetail);
            if (count($detaillist) > 0) {
                $getdata = mysqli_query($conn, "SELECT * FROM learning_modul_details WHERE learning_modul_id='" . $last_id . "'"); //and a.id not in (1) administrator
                $checknum = mysqli_num_rows($getdata);
                if ($checknum > 0) {
                    $delete =  mysqli_query($conn, "DELETE FROM learning_modul_details WHERE learning_modul_id='" . $last_id . "'");
                }
                $noc = 1;
                $valuesins = '';
                foreach ($detaillist as $indexname => $rows) {
                    $field2[$noc] = '';
                    $isi2[$noc] = '';
                    $no = 1;
                    foreach ($rows[1] as $index => $row) {
                        if (!in_array($index, ['counter', 'photo' . $rows[0]])) {

                            if ($no == 1) {
                                $field2[$noc] .= "`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= "'" . $row . "'";
                            } else {
                                // die($rows);
                                $field2[$noc] .= ",`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= ",'" . $row . "'";
                            }
                            $no++;
                        }
                    }
                    var_dump($_FILES['photo' . $rows[0]]);
                    die();
                    if (isset($_FILES['photo' . $rows[0]]) && count($_FILES['photo' . $rows[0]]) > 0) {
                        foreach ($_FILES['photo' . $rows[0]]['name']  as $key => $value) {

                            $fillname = strtolower(substr(md5(uniqid(mt_rand(), true)), 0, 8));
                            $ext = pathinfo($_FILES['photo' . $rows[0] . '']['name'][$key], PATHINFO_EXTENSION);

                            $folder_path = "uploads/learning_moduls/" . $last_id;
                            if (!file_exists($folder_path)) {
                                mkdir($folder_path, 0777, true);
                            }

                            $fillpath = "uploads/learning_moduls/" . $last_id . "/" . $fillname . '.' . $ext;
                            if ($_FILES['photo' . $rows[0] . '']['error'][$key] == 0) {
                                $photo = "uploads/learning_moduls/" . $last_id . "/" . $fillname . '.' . $ext;
                            }

                            if (move_uploaded_file($_FILES['photo' . $rows[0] . '']['tmp_name'][$key], $fillpath)) {
                                $field2[$noc] .= ",file_name";
                                $isi2[$noc] .= ",'" . $fillname . '.' . $ext . "' ";
                                $field2[$noc] .= ",file";
                                $isi2[$noc] .= ",'" . $photo . "' ";
                            }
                        }
                    }
                    var_dump("INSERT INTO learning_modul_details  (`learning_modul_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");
                    die();
                    $runsql_details = mysqli_query($conn, "INSERT INTO learning_modul_details  (`learning_modul_id`, " . $field2[$noc] . ")  VALUES ('" . $last_id . "'," . $isi2[$noc] . ")");

                    // $noc++;
                }
                // die();
            }
        }
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }

    echo json_encode($json);
}
