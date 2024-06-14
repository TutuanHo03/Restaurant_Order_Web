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

// Check if the order ID is provided in the URL
if (!isset($_GET['order_id'])) {
    // Redirect to order_history.php if order ID is not provided
    header('Location: order_history.php');
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details for the logged-in customer
$customer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE id = ? AND customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $order_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the order belongs to the logged-in customer
if ($result->num_rows == 0) {
    // Redirect to order_history.php if the order does not belong to the customer
    header('Location: order_history.php');
    exit();
}

$row = $result->fetch_assoc();

// Check if the order is in a status that allows evaluation (e.g., Delivered)
if ($row['status'] != 'Delivered') {
    // Redirect to order_history.php if the order is not delivered
    header('Location: order_history.php');
    exit();
}

// Check if the form is submitted for order evaluation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evaluate_order'])) {
    // Process the order evaluation logic here
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    // Insert the review into the reviews table
    $insert_sql = "INSERT INTO reviews (customer_id, order_id, rating, comment) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param('iiis', $customer_id, $order_id, $rating, $feedback);
    
    if ($insert_stmt->execute()) {
        echo '<p class="alert alert-success">Order evaluated successfully!</p>';
    } else {
        echo '<p class="alert alert-danger">Failed to evaluate the order.</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate Order - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Evaluate Order</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo $row['id']; ?></h5>
                <p class="card-text">Order Date: <?php echo $row['order_date']; ?></p>
                <p class="card-text">Delivery Address: <?php echo $row['delivery_address']; ?></p>
                <p class="card-text">Delivery Time: <?php echo $row['delivery_time']; ?></p>
                <p class="card-text">Status: <?php echo $row['status']; ?></p>
                <!-- You can display more order details as needed -->

                <!-- Order Evaluation Form -->
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5)</label>
                        <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                    </div>

                    <div class="mb-3">
                        <label for="feedback" class="form-label">Feedback</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" name="evaluate_order">Submit Evaluation</button>
                                    <a class="btn btn-danger" href='order_history.php'>Back to history order</a>

                </form>
            </div>
        </div>

        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
