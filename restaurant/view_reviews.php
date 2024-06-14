<?php
// Include the configuration file
include '../config.php';
session_start();

if (!isset($_SESSION['manager_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Fetch reviews from the database
$sql_reviews = "SELECT r.id, r.rating, r.comment, r.review_date, c.username AS customer_name, o.id AS order_id
               FROM reviews r
               JOIN customers c ON r.customer_id = c.id
               JOIN orders o ON r.order_id = o.id
               ORDER BY r.review_date DESC";
$result_reviews = $conn->query($sql_reviews);
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
        <h2>View Reviews</h2>

        <!-- Display Reviews in a Table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Review ID</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Review Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_reviews->num_rows > 0) {
                    while ($row = $result_reviews->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['order_id'] . '</td>
                            <td>' . $row['customer_name'] . '</td>
                            <td>' . $row['rating'] . '</td>
                            <td>' . $row['comment'] . '</td>
                            <td>' . $row['review_date'] . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No reviews found.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
