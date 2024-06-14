<?php
// Include the configuration file
include '../config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Fetch the list of available dishes from the database
$sql = "SELECT * FROM dishes";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Dishes - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: url('/image/dishes/bg.jpg') center/cover fixed; background-filter: blur(60%);">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?php echo SITE_NAME; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">View Dishes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="shopping_cart.php">View Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="order_history.php">Order History</a>
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
        <h2>Available Dishes</h2>

        <div class="row">
            <?php
            // Display each dish
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="/image/dishes/' . $row['id'] . '.jpg" class="card-img-top" alt="' . $row['name'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['name'] . '</h5>
                            <p class="card-text">' . $row['description'] . '</p>
                            <a href="view_dish_details.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>