<?php
session_start();
include('connect.php');

if (isset($_POST)) {
    $mode = $_POST['mode'];
    $tipe = $_POST['tipe'];
    if ($mode == 'Add') {
        $field = '';
        $isi = '';
        $no = 1;
        // var_dump($_FILES);
        // die();
        $decode_detail = json_decode($_POST['dataDetail']);
        // $getn = count($decode_detail) - 1;
        // $statusobj = 'status' . $getn;
        // $ads = $decode_detail[$getn][1];
        // var_dump($ads->$statusobj);
        // die();
        // $status = $ads->$statusobj;
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe', 'dataDetail', 'fee']) && !in_array(substr($indexname, 0, 5), ['photo'])) {
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

        // var_dump("INSERT INTO transactions (" . $field . " " . $field_opt . " ,status) VALUES (" . $isi . " " . $isi_opt . " , '" . $status . "')");
        // die();

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $result = mysqli_query($conn, "SHOW TABLE STATUS LIKE '" . $tipe . "'");
            $data = mysqli_fetch_assoc($result);
            $fillname = strtolower(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fillpath = "uploads/learning_moduls/" . $fillname . '.' . $ext;
            if ($_FILES['photo']['error'] == 0) {
                $photo = "uploads/learning_moduls/" . $fillname . '.' . $ext;
            }

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $fillpath)) {
                $field .= ",photo";
                $isi .= ",'" . $photo . "' ";
            }
        }

        // $field_opt .= " ,status ";
        // $isi_opt .= " , '" . $status . "' ";
        // $field_opt .= " ,created_id ";
        // $isi_opt .= " , '" . $_SESSION['userid'] . "' ";
        $runsql = mysqli_query($conn, "INSERT INTO learning_moduls (" . $field . " " . $field_opt . ") VALUES (" . $isi . " " . $isi_opt . "  )");
    }
    if ($mode == 'Edit') {
        $tid = $_POST['tid'];
        $set = '';
        $no = 1;
        foreach ($_POST as $indexname => $rows) {
            if (!in_array($indexname, ['tid', 'mode', 'tipe', 'dataDetail', 'fee']) && !in_array(substr($indexname, 0, 5), ['photo'])) {
                if ($no == 1) {
                    $set .= "`" . $indexname . "` = '" . $_POST[$indexname] . "'";
                } else {
                    $set .= ",`" . $indexname . "`  = '" . $_POST[$indexname] . "'";
                }
                $no++;
            }
        }

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $result = mysqli_query($conn, "SHOW TABLE STATUS LIKE '" . $tipe . "'");
            $data = mysqli_fetch_assoc($result);
            $fillname = strtolower(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fillpath = "uploads/learning_moduls/" . $fillname . '.' . $ext;
            if ($_FILES['photo']['error'] == 0) {
                $photo = "uploads/learning_moduls/" . $fillname . '.' . $ext;
            }

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $fillpath)) {
                $set .= ",`photo`  = '" . $photo . "'";
            }
        }

        // $set .= ",`updated_id`  = '" . $_SESSION['userid'] . "'";
        $decode_detail = json_decode($_POST['dataDetail']);
        $getn = count($decode_detail) - 1;
        $statusobj = 'status' . $getn;
        $ads = $decode_detail[$getn][1];
        // var_dump($ads->$statusobj);
        // die();
        // $status = $ads->$statusobj;
        // $set .= ",`status`  = '" . $status . "'";
        $runsql = mysqli_query($conn, "UPDATE learning_moduls  SET " . $set . "  WHERE id='" . $tid . "'");
    }


    if ($runsql) {

        if ($mode == 'Add') {
            $last_id = $conn->insert_id;
        }
        if ($mode == 'Edit') {
            $last_id = $tid;
        }
        $dataDetail = $_POST['dataDetail'];
        $detaillist = json_decode($dataDetail);
        if (count($detaillist) > 0) {
            $getdata = mysqli_query($conn, "SELECT * FROM learning_modul_details WHERE learning_modul_id='" . $last_id . "'"); //and a.id not in (1) administrator
            $checknum = mysqli_num_rows($getdata);
            if ($checknum > 0) {
                $delete =  mysqli_query($conn, "DELETE FROM learning_modul_details WHERE learning_modul_id='" . $last_id . "'");
            }
            $noc = 1;
            $valuesins = '';
            $arr_last_id = '';
            foreach ($detaillist as $indexname => $rows) {
                $field2[$noc] = '';
                $isi2[$noc] = '';
                $set2[$noc] = '';
                // mysqli_close($conn);
                $no = 1;
                $trxid = 'transaction_id' . $rows[0] . '';
                foreach ($rows[1] as $index => $row) {
                    if (!in_array($index, ['counter', 'photo' . $rows[0] . '', 'transaction_id' . $rows[0] . ''])) {
                        if (in_array($index, ['file' . $rows[0] . '', 'file_name' . $rows[0] . ''])) {
                            if ($row != '') {
                                // die($rows);
                                $field2[$noc] .= ",`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                                $isi2[$noc] .= ",'" . $row . "'";
                                $set2[$noc] .= ", `" . str_replace('' . $rows[0] . '', '', $index) . "` = '" . $row . "'";
                            }
                        } else {
                            // die($rows);
                            $field2[$noc] .= ",`" . str_replace('' . $rows[0] . '', '', $index) . "`";
                            $isi2[$noc] .= ",'" . $row . "'";
                            $set2[$noc] .= ", `" . str_replace('' . $rows[0] . '', '', $index) . "` = '" . $row . "'";
                        }
                        $no++;
                    }
                }


                if (isset($_FILES['photo' . $rows[0]]) && count($_FILES['photo' . $rows[0]]) > 0) {

                    foreach ($_FILES['photo' . $rows[0]]['name']  as $key => $value) {
                        $fillname = strtolower(substr(md5(uniqid(mt_rand(), true)), 0, 8));
                        $ext = pathinfo($_FILES['photo' . $rows[0] . '']['name'][$key], PATHINFO_EXTENSION);
                        $result = mysqli_query($conn, "SHOW TABLE STATUS LIKE 'learning_modul_details'");
                        $data = mysqli_fetch_assoc($result);
                        $folder_path = "../uploads/learning_moduls/" . $data['Auto_increment'];
                        // var_dump(file_exists($folder_path));
                        if (!file_exists($folder_path)) {
                            mkdir($folder_path, 0777, true);
                        }

                        $fillpath = "../uploads/learning_moduls/" . $data['Auto_increment'] . "/" . $fillname . '.' . $ext;
                        if ($_FILES['photo' . $rows[0] . '']['error'][$key] == 0) {
                            $photo = "uploads/learning_moduls/" . $data['Auto_increment'] . "/" . $fillname . '.' . $ext;
                        }

                        if (move_uploaded_file($_FILES['photo' . $rows[0] . '']['tmp_name'][$key], $fillpath)) {
                            $field2[$noc] .= ",`file` , `file_name`";
                            $isi2[$noc] .= ",'" . $photo . "','" . $fillname . '.' . $ext . "'";
                            $set2[$noc] .= ", `file` = '" . $photo . "' , `file_name` = '" . $fillname . '.' . $ext . "' ";
                        }
                    }
                }


                // $valuesins  .= "('" . $last_id . "'," . $isi2[$noc] . ") ";

                // var_dump("INSERT INTO transaction_details 
                // (`transaction_id`, " . $field2[$noc] . ") 
                //   VALUES 
                // ('" . $last_id . "'," . $isi2[$noc] . ")
                // ");
                // if ($rows[1]->$trxid > 0) {
                //     $runsql_details = mysqli_query($conn, "UPDATE learning_modul_details SET   " . $set2[$noc] . " WHERE id = '" . $rows[1]->$trxid . "' ");
                // } else {
                // $as .= "INSERT INTO learning_modul_details  (`learning_modul_id` " . $field2[$noc] . ")  VALUES ('" . $last_id . "' " . $isi2[$noc] . ")";

                $runsql_details = mysqli_query($conn, "INSERT INTO learning_modul_details  (`learning_modul_id` " . $field2[$noc] . ")  VALUES ('" . $last_id . "' " . $isi2[$noc] . ")");
                // }

                if ($runsql_details) {


                    // $last_id2 = $conn->insert_id;

                    // if ($noc == 1) {
                    //     $arr_last_id  .= $last_id2;
                    // } else {
                    //     $arr_last_id  .= ',' . $last_id2;
                    // }

                    // $last_id2 = $conn->insert_id;
                    // var_dump($_FILES['photo' . $rows[0]]);
                    // die();

                }
                $noc++;
            }
            // var_dump($as);
            // die();
            // var_dump("UPDATE transaction_details SET deleted_at=now(), deleted_id='" . $_SESSION['userid'] . "' WHERE id not in (" . $arr_last_id . ") and transaction_id='" . $last_id . "'");
            // die();
            // $deletedetail =  mysqli_query($conn, "UPDATE transaction_details SET deleted_at=now(), deleted_id='" . $_SESSION['userid'] . "' WHERE id not in (" . $arr_last_id . ") and transaction_id='" . $last_id . "'");
            // $deletedetail_photo =  mysqli_query($conn, "UPDATE transaction_photo SET deleted_at=now(), deleted_id='" . $_SESSION['userid'] . "' WHERE transaction_detail_id not in (" . $arr_last_id . ") and transaction_id='" . $last_id . "'");
            // die();
        }
        $json['status'] = 1;
    } else {
        $json['status'] = 0;
    }

    echo json_encode($json);
}
