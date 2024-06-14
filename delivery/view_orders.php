<?php
// Include the configuration file
include '../config.php';

session_start();

if (!isset($_SESSION['delivery_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch all orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reviews - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Background Image -->
    <style>
        body {
            background-image: url('/image/bg6.jpg'); /* Adjust the path as needed */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2>View Delivery</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Order ID: ' . $row['id'] . '</h5>
                        <p class="card-text">Order Date: ' . $row['order_date'] . '</p>
                        <p class="card-text">Delivery Address: ' . $row['delivery_address'] . '</p>
                        <p class="card-text">Delivery Time: ' . $row['delivery_time'] . '</p>
                        <p class="card-text">Delivery Status: ' . $row['status'] . '</p>
                        <!-- Add more order details as needed -->';
                        if($row['status'] === 'Delivered for shipping'){
                            echo'<a href="update_delivery_status.php?delivery_id=' . $row['id'] . '" class="btn btn-success">Process Delivery</a>';
                        }
                        echo'
                    </div>
                </div>';
            }
        } else {
            echo '<p>No orders found.</p>';
        }
        ?>

    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
