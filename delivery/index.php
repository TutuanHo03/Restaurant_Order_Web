<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['delivery_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}else{
     header('Location: view_orders.php');
    exit();
}
?>


