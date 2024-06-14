<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['manager_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}else{
     header('Location: manage_dishes.php');
    exit();
}
?>


