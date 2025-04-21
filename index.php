<?php

session_start();
include('php/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Modul - Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/landing/img/icon.png" rel="icon">
    <link href="../assets/landing/img/icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- css spinner load -->
    <link rel="stylesheet" href="css/loading_spinner.css" type="text/css">
    <!-- Vendor CSS Files -->
    <link href="assets/adminlte/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/adminlte/assets/css/style.css" rel="stylesheet">
    <!-- izitoast -->
    <link href="assets/iziToast/dist/css/iziToast.css" rel="stylesheet">
    <style>
        body {
            background-color: #efefef;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 304 304' width='304' height='304'%3E%3Cpath fill='%2392a8f3' fill-opacity='0.4' d='M44.1 224a5 5 0 1 1 0 2H0v-2h44.1zm160 48a5 5 0 1 1 0 2H82v-2h122.1zm57.8-46a5 5 0 1 1 0-2H304v2h-42.1zm0 16a5 5 0 1 1 0-2H304v2h-42.1zm6.2-114a5 5 0 1 1 0 2h-86.2a5 5 0 1 1 0-2h86.2zm-256-48a5 5 0 1 1 0 2H0v-2h12.1zm185.8 34a5 5 0 1 1 0-2h86.2a5 5 0 1 1 0 2h-86.2zM258 12.1a5 5 0 1 1-2 0V0h2v12.1zm-64 208a5 5 0 1 1-2 0v-54.2a5 5 0 1 1 2 0v54.2zm48-198.2V80h62v2h-64V21.9a5 5 0 1 1 2 0zm16 16V64h46v2h-48V37.9a5 5 0 1 1 2 0zm-128 96V208h16v12.1a5 5 0 1 1-2 0V210h-16v-76.1a5 5 0 1 1 2 0zm-5.9-21.9a5 5 0 1 1 0 2H114v48H85.9a5 5 0 1 1 0-2H112v-48h12.1zm-6.2 130a5 5 0 1 1 0-2H176v-74.1a5 5 0 1 1 2 0V242h-60.1zm-16-64a5 5 0 1 1 0-2H114v48h10.1a5 5 0 1 1 0 2H112v-48h-10.1zM66 284.1a5 5 0 1 1-2 0V274H50v30h-2v-32h18v12.1zM236.1 176a5 5 0 1 1 0 2H226v94h48v32h-2v-30h-48v-98h12.1zm25.8-30a5 5 0 1 1 0-2H274v44.1a5 5 0 1 1-2 0V146h-10.1zm-64 96a5 5 0 1 1 0-2H208v-80h16v-14h-42.1a5 5 0 1 1 0-2H226v18h-16v80h-12.1zm86.2-210a5 5 0 1 1 0 2H272V0h2v32h10.1zM98 101.9V146H53.9a5 5 0 1 1 0-2H96v-42.1a5 5 0 1 1 2 0zM53.9 34a5 5 0 1 1 0-2H80V0h2v34H53.9zm60.1 3.9V66H82v64H69.9a5 5 0 1 1 0-2H80V64h32V37.9a5 5 0 1 1 2 0zM101.9 82a5 5 0 1 1 0-2H128V37.9a5 5 0 1 1 2 0V82h-28.1zm16-64a5 5 0 1 1 0-2H146v44.1a5 5 0 1 1-2 0V18h-26.1zm102.2 270a5 5 0 1 1 0 2H98v14h-2v-16h124.1zM242 149.9V160h16v34h-16v62h48v48h-2v-46h-48v-66h16v-30h-16v-12.1a5 5 0 1 1 2 0zM53.9 18a5 5 0 1 1 0-2H64V2H48V0h18v18H53.9zm112 32a5 5 0 1 1 0-2H192V0h50v2h-48v48h-28.1zm-48-48a5 5 0 0 1-9.8-2h2.07a3 3 0 1 0 5.66 0H178v34h-18V21.9a5 5 0 1 1 2 0V32h14V2h-58.1zm0 96a5 5 0 1 1 0-2H137l32-32h39V21.9a5 5 0 1 1 2 0V66h-40.17l-32 32H117.9zm28.1 90.1a5 5 0 1 1-2 0v-76.51L175.59 80H224V21.9a5 5 0 1 1 2 0V82h-49.59L146 112.41v75.69zm16 32a5 5 0 1 1-2 0v-99.51L184.59 96H300.1a5 5 0 0 1 3.9-3.9v2.07a3 3 0 0 0 0 5.66v2.07a5 5 0 0 1-3.9-3.9H185.41L162 121.41v98.69zm-144-64a5 5 0 1 1-2 0v-3.51l48-48V48h32V0h2v50H66v55.41l-48 48v2.69zM50 53.9v43.51l-48 48V208h26.1a5 5 0 1 1 0 2H0v-65.41l48-48V53.9a5 5 0 1 1 2 0zm-16 16V89.41l-34 34v-2.82l32-32V69.9a5 5 0 1 1 2 0zM12.1 32a5 5 0 1 1 0 2H9.41L0 43.41V40.6L8.59 32h3.51zm265.8 18a5 5 0 1 1 0-2h18.69l7.41-7.41v2.82L297.41 50H277.9zm-16 160a5 5 0 1 1 0-2H288v-71.41l16-16v2.82l-14 14V210h-28.1zm-208 32a5 5 0 1 1 0-2H64v-22.59L40.59 194H21.9a5 5 0 1 1 0-2H41.41L66 216.59V242H53.9zm150.2 14a5 5 0 1 1 0 2H96v-56.6L56.6 162H37.9a5 5 0 1 1 0-2h19.5L98 200.6V256h106.1zm-150.2 2a5 5 0 1 1 0-2H80v-46.59L48.59 178H21.9a5 5 0 1 1 0-2H49.41L82 208.59V258H53.9zM34 39.8v1.61L9.41 66H0v-2h8.59L32 40.59V0h2v39.8zM2 300.1a5 5 0 0 1 3.9 3.9H3.83A3 3 0 0 0 0 302.17V256h18v48h-2v-46H2v42.1zM34 241v63h-2v-62H0v-2h34v1zM17 18H0v-2h16V0h2v18h-1zm273-2h14v2h-16V0h2v16zm-32 273v15h-2v-14h-14v14h-2v-16h18v1zM0 92.1A5.02 5.02 0 0 1 6 97a5 5 0 0 1-6 4.9v-2.07a3 3 0 1 0 0-5.66V92.1zM80 272h2v32h-2v-32zm37.9 32h-2.07a3 3 0 0 0-5.66 0h-2.07a5 5 0 0 1 9.8 0zM5.9 0A5.02 5.02 0 0 1 0 5.9V3.83A3 3 0 0 0 3.83 0H5.9zm294.2 0h2.07A3 3 0 0 0 304 3.83V5.9a5 5 0 0 1-3.9-5.9zm3.9 300.1v2.07a3 3 0 0 0-1.83 1.83h-2.07a5 5 0 0 1 3.9-3.9zM97 100a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-48 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 96a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-144a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM49 36a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM33 68a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 240a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm80-176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm112 176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 180a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 84a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'%3E%3C/path%3E%3C/svg%3E");
        }

        .logologin img {
            max-height: 100px;
        }
    </style>
</head>

<body>
    <div id="loading">
        <div class="loader">
            <div class="inner one"></div>
            <div class="inner two"></div>
            <div class="inner three"></div>
        </div>
    </div>
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="logologin justify-content-center align-items-center   ">
                                <img src="assets/img/logo.png" alt=""><br>
                            </div>
                            <div class="justify-content-center py-4">
                                <a href="index.php" class="logo d-flex align-items-center w-auto">
                                    <span class="d-none d-lg-block" style="font-family:'Nunito', sans-serif;">Manajemen Modul</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">


                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Welcome Back !</h5>
                                        <p class="text-center small">Please Enter your Email & password to login</p>
                                    </div>

                                    <div class="row g-3 needs-validation" novalidate>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope"></i></span>
                                                <input type="email" name="username" class="form-control" id="email" required>
                                                <div class="invalid-feedback">Please enter your Email.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-lock-fill"></i></span>
                                                <input type="password" name="password" class="form-control" id="password" required>
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <!-- <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">Remember me</label> -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="button" id="login">Login</button>
                                        </div>
                                        <!-- tidak register jika ada admin yang mendaftarkan users -->
                                        <!-- <div class="col-12">
                                                <p class="small mb-0">Don't have account? <a href="?form=register">Register</a></p>
                                            </div> -->
                                        <div class="col-12">
                                            <div id="info"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="#">@ppkd</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Jquery -->
    <script src=" https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="assets/adminlte/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/adminlte/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/adminlte/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/adminlte/assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/adminlte/assets/vendor/quill/quill.js"></script>
    <script src="assets/adminlte/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/adminlte/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/adminlte/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/adminlte/assets/js/main.js"></script>
    <!-- izitoast -->
    <script src="assets/iziToast/dist/js/iziToast.js"></script>

    <script>
        iziToast.settings({
            timeout: 3000, // default timeout
            resetOnHover: true,
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX',
            position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            onOpen: function() {
                console.log('callback abriu!');
            },
            onClose: function() {
                console.log("callback fechou!");
            }
        });


        // info
        $('#infoClick').click(function() {
            iziToast.info({
                position: "center",
                title: 'Hello',
                message: 'iziToast.info()'
            });
        }); // ! click

        // success
        $('#successClick').click(function() {
            iziToast.success({
                timeout: 5000,
                icon: 'fa fa-chrome',
                title: 'OK',
                message: 'iziToast.sucess() with custom icon!'
            });
        }); // ! .click

        // warning
        $('#warningClick').click(function() {
            iziToast.warning({
                position: "bottomLeft",
                title: 'Caution',
                message: '日本語環境のテスト'
            });
        });

        // error
        $('#errorClick').click(function() {
            iziToast.error({
                title: 'Error',
                message: 'Illegal operation'
            });
        });

        // custom toast
        $('#customClick').click(function() {

            iziToast.show({
                color: 'dark',
                icon: 'fa fa-user',
                title: 'Hey',
                message: 'Custom Toast!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button>Ok</button>',
                        function(instance, toast) {
                            alert("Hello world!");
                        }
                    ],
                    [
                        '<button>Close</button>',
                        function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ]
                ]
            });

        }); // ! .click()



        $(document).ready(function() {
            $("#email").focus();
            setTimeout(function() {
                $('#loading').hide();
            }, 2000);
        })

        $(document).on('click', '[id=login]', function() {
            checkform();
        })

        $(document).on('keypress', '[id=password]', function(e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                checkform();
            }
        });

        function checkform() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;

            if (email == "" || password == "") {
                $("#info").html('<div class="alert alert-danger" role="alert">Email / Password Masih Kosong !</div>')
                iziToast.error({
                    timeout: 5000,
                    icon: 'fa fa-close',
                    title: 'Login Failed',
                    message: 'Email / Password Masih Kosong !'
                });
            }

            if (email != "" && password != "") {

                if (!emailPattern.test(email)) {
                    $("#info").html('<div class="alert alert-warning" role="alert">Email Tidak Valid! Gunakan format email</div>')
                    iziToast.warning({
                        timeout: 5000,
                        icon: 'fa fa-close',
                        title: 'Login Failed',
                        message: 'Email Tidak Valid! Gunakan format email'
                    });
                    $("#email").focus();
                    return false;
                }

                console.log(password);
                console.log(passwordPattern.test(password));
                // return false;

                if (!passwordPattern.test(password)) {
                    // console.log(password)
                    $("#info").html('<div class="alert alert-warning" role="alert">Password harus terdiri dari 8 karakter... 1 huruf besar, 1 huruf kecil , 1 angka dan 1 karakter khusus. </div>')
                    iziToast.warning({
                        timeout: 5000,
                        icon: 'fa fa-close',
                        title: 'Login Failed',
                        message: 'Password harus terdiri dari 8 karakter... 1 huruf besar, 1 huruf kecil , 1 angka dan 1 karakter khusus.'
                    });
                    $("#password").focus();
                    return false;
                }

                //post login ke php
                $('#loading').show();
                dataMap = {};
                dataMap['email'] = email;
                dataMap['password'] = password;
                $.post('php/login.php', dataMap, function(response) {
                    // Log the response to the consol
                    console.log(response);
                    var res = JSON.parse(response);
                    if (res.login_status == 1) {
                        $("#info").html('<div class="alert alert-success" role="alert">Login Success!</div>')
                        iziToast.success({
                            timeout: 5000,
                            icon: 'fa fa-check',
                            title: 'Login Success',
                            message: 'Loading Page.. !'
                        });
                        setTimeout(function() {
                            window.location.href = "home?page=dashboard";
                        }, 3000);
                    } else {
                        iziToast.error({
                            timeout: 5000,
                            icon: 'fa fa-close',
                            title: 'Login Failed',
                            message: '' + res.message + ''
                        });
                        $("#info").html('<div class="alert alert-danger" role="alert">' + res.message + '</div>')
                    }
                    setTimeout(function() {
                        $('#loading').hide();
                    }, 3000);
                });

            }

        }
    </script>

</body>

</html>
<?php

?>