<?php
// Include the configuration file
include '../config.php';
session_start();

if (!isset($_SESSION['staff_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}


// Fetch all dishes
$sql = "SELECT * FROM dishes";
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
            background-image: url('/image/bg1.jpg'); /* Adjust the path as needed */
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
          <a class="nav-link" href="view_orders.php">View Order</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_dishes.php">View Dishes</a>
        </li>
      </ul>

    </div>
  </div>
</nav>
    <div class="container mt-5">
        <h2>View Dishes</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Dish ID: ' . $row['id'] . '</h5>
                        <p class="card-text">Dish Name: ' . $row['name'] . '</p>
                        <p class="card-text">Dish Description: ' . $row['description'] . '</p>
                        <p class="card-text">Dish Price: ' . $row['price'] . '</p>
                        <p class="card-text">Dish Status: ' . $row['dish_status'] . '</p>
                        <!-- Add more order details as needed -->
                        <a href="edit_dish_status.php?dish_id=' . $row['id'] . '" class="btn btn-success">Edit Dish Status</a>
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
