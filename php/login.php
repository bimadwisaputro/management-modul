<?php
session_start();
require_once('connect.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = mysqli_prepare($conn, "SELECT  a.*,b.role_id  FROM users a left join (SELECT min(role_id) role_id,user_id from user_role group by user_id ) b on a.id=b.user_id WHERE a.email = ? ");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    if ($rows && password_verify($password, $rows['password'])) {
        $_SESSION['login'] = 1;
        $_SESSION['email'] = $email;
        $_SESSION['is_active'] = $rows['is_active'];
        $_SESSION['fullname'] = $rows['name'];
        $_SESSION['photo'] = 'uploads/profile/noprofile.png';
        $_SESSION['userid'] = $rows['id'];
        $_SESSION['role_id'] = $rows['role_id'];
        //check role user
        $getrole = mysqli_query($conn, "SELECT a.*,b.name rolename from user_role a left join roles b on a.role_id=b.id where a.user_id='" . $rows['id'] . "'");
        $numrole = mysqli_num_rows($getrole);
        $rowrole = mysqli_fetch_all($getrole, MYSQLI_ASSOC);
        $_SESSION['roles'] = $rowrole;
        $listrole = '';
        foreach ($rowrole as $rowrl) {
            $listrole .= $rowrl['rolename'] . ',';
            if ($rowrl['role_id'] == '4') {
                $getdatap = mysqli_query($conn, "SELECT * from instructors where user_id='" . $rows['id'] . "'");
                $numdp = mysqli_num_rows($getdatap);
                $rowdp = mysqli_fetch_all($getdatap, MYSQLI_ASSOC);
                if ($numdp > 0) {
                    foreach ($rowdp as $rowp) {
                        $_SESSION['instructor_id'] = $rowp['id'];
                        $_SESSION['photo'] = $rowp['photo'];
                        $_SESSION['gender'] = $rowp['gender'];
                        $_SESSION['address'] = $rowp['address'];
                        $_SESSION['phone'] = $rowp['phone'];
                        $_SESSION['title'] = $rowp['title'];
                    }
                }
            }

            if ($rowrl['role_id'] == '5') {
                $getdatap = mysqli_query($conn, "SELECT * from students where user_id='" . $rows['id'] . "'");
                $numdp = mysqli_num_rows($getdatap);
                $rowdp = mysqli_fetch_all($getdatap, MYSQLI_ASSOC);
                if ($numdp > 0) {
                    foreach ($rowdp as $rowp) {
                        $_SESSION['student_id'] = $rowp['id'];
                        $_SESSION['photo'] = $rowp['photo'];
                        $_SESSION['gender'] = $rowp['gender'];
                        $_SESSION['date_of_birth'] = $rowp['date_of_birth'];
                        $_SESSION['place_of_birth'] = $rowp['place_of_birth'];
                    }
                }
            }
        }
        $_SESSION['listrole'] = rtrim($listrole, ",");
        $json['login_status'] = 1;
    } else {
        $_SESSION['login'] = 0;
        $json['message'] = 'Email atau password salah!';
        $json['login_status'] = 0;
    }
} else {
    $_SESSION['login'] = 0;
    $json['message'] = 'Error, Undifined Email & Password';
    $json['login_status'] = 0;
}
echo json_encode($json);
