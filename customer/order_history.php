<?php
// Include the configuration file
include '../config.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch past orders for the logged-in customer
$customer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE customer_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $customer_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Background Image -->
    <style>
        body {
            background-image: url('/image/bg3.jpg'); /* Adjust the path as needed */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?php echo SITE_NAME; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="view_dishes.php">View Dishes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="shopping_cart.php">View Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="order_history.php">Order History</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
        <div class="container mt-5">

    <div class="container mt-5">
        <h2>Order History</h2>

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
                        <p class="card-text">Status: ' . $row['status'] . '</p>
                        <!-- You can display more order details as needed -->
                        <a href="evaluate_order.php?order_id=' . $row['id'] . '" class="btn btn-primary">Evaluate Order</a>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No past orders found.</p>';
        }
        ?>
        </div>
        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
