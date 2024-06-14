<?php
// Include the configuration file
include '../config.php';

session_start();

if (!isset($_SESSION['delivery_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Check if the order ID is provided in the URL
if (!isset($_GET['delivery_id'])) {
    // Redirect to view_orders.php if order ID is not provided
    header('Location: view_orders.php');
    exit();
}

$order_id = $_GET['delivery_id'];

// Fetch order details
$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Redirect to view_orders.php if the order does not exist
    header('Location: view_orders.php');
    exit();
}

$row = $result->fetch_assoc();

// Fetch order items
$sql_items = "SELECT * FROM order_items WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param('i', $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

// Check if the form is submitted for order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_status'])) {
    // Process the order status update logic here
    $order_status = $_POST['order_status'];

    // Update the order status in the database
    $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $order_status, $order_id);
    $update_stmt->execute();

    // Display a success message
    echo '<p class="alert alert-success">Order status updated successfully!</p>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Order - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Process Delivery</h2>

        <?php
        // Display order details
        echo '
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order ID: ' . $row['id'] . '</h5>
                <p class="card-text">Order Date: ' . $row['order_date'] . '</p>
                <p class="card-text">Delivery Address: ' . $row['delivery_address'] . '</p>
                <p class="card-text">Delivery Time: ' . $row['delivery_time'] . '</p>
                <p class="card-text">Order Status: ' . $row['status'] . '</p>
            </div>
        </div>';

        // Display order items
if ($result_items->num_rows > 0) {
    echo '<table class="table">
            <thead>
                <tr>
                    <th scope="col">Dish ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>';

    while ($item = $result_items->fetch_assoc()) {
        // Fetch dish details for the current order item
        $dish_id = $item['dish_id'];
        $sql_dish = "SELECT * FROM dishes WHERE id = ?";
        $stmt_dish = $conn->prepare($sql_dish);
        $stmt_dish->bind_param('i', $dish_id);
        $stmt_dish->execute();
        $result_dish = $stmt_dish->get_result();

        if ($result_dish->num_rows > 0) {
            $dish = $result_dish->fetch_assoc();

            // Display dish details for the current order item
            echo '
                <tr>
                    <td>' . $dish['id'] . '</td>
                    <td>' . $dish['name'] . '</td>
                    <td>' . $dish['description'] . '</td>
                    <td>$' . $dish['price'] . '</td>
                    <td>' . $item['quantity'] . '</td>
                    <!-- Add more columns as needed -->
                </tr>';
        } else {
            echo '<p>No dish found for Dish ID: ' . $dish_id . '</p>';
        }

        $stmt_dish->close();
    }

    echo '</tbody></table>';
} else {
    echo '<p>No items found in the order.</p>';
}
        ?>

        <!-- Order processing form -->
        <form method="post" action="">
    <div class="mb-3">
        <label for="order_status" class="form-label">Order Status</label>
        <select class="form-select" id="order_status" name="order_status">
            <option value="Shipping">Shipping</option>
            <option value="Delivered">Delivered</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success" name="update_order_status">Update Delivery Status</button>
    <a class="btn btn-danger" href="view_orders.php">Back to orders view</a>

</form>

    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
