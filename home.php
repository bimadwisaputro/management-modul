<?php include('view/include/header.php'); ?>
<?php include('view/include/sidebar.php'); ?>

<?php
if (isset($_GET['page'])) {
    if (file_exists('view/' . $_GET['page'] . '.php')) {
        include('view/' . $_GET['page'] . '.php');
    } else {
        include('view/dashboard.php');
    }
} else {
    include('view/dashboard.php');
}
?>

<?php include('view/include/footer.php'); ?>