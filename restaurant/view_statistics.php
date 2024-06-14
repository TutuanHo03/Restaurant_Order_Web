<?php
// Include the configuration file
include '../config.php';
session_start();

if (!isset($_SESSION['manager_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Fetch order statistics from the database
$sql_statistics = "SELECT id, order_date, delivery_address, delivery_time, status
                   FROM orders
                   ORDER BY order_date DESC";
$result_statistics = $conn->query($sql_statistics);
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
            background-image: url('/image/bg7.jpg'); /* Adjust the path as needed */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="manage_dishes.php">Manage dishes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_customers.php">Manage Customer</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_reviews.php">View Review</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_statistics.php">View Statistic</a>
        </li>
      </ul>

    </div>
  </div>
</nav>
    <div class="container mt-5">
        <h2>View Statistics</h2>

        <!-- Display Orders in a Table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Delivery Address</th>
                    <th scope="col">Delivery Time</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_statistics->num_rows > 0) {
                    while ($row = $result_statistics->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['order_date'] . '</td>
                            <td>' . $row['delivery_address'] . '</td>
                            <td>' . $row['delivery_time'] . '</td>
                            <td>' . $row['status'] . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No orders found.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
