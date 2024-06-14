<?php

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "data";

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Other configuration constants
define('SITE_NAME', 'Restaurent Food Order');



define('staff_username', 'staff');
define('staff_password', 'test');

define('delivery_username', 'delivery');
define('delivery_password', 'test');

define('manager_username', 'manager');
define('manager_password', 'test');

?>
