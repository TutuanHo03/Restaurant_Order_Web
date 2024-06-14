<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order payment - <?php echo SITE_NAME; ?></title>
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
          <a class="nav-link active" aria-current="page" href="shopping_cart.php">View Cart</a>
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
    
    
<?php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
        // Get delivery details from the form
        $delivery_address = $_POST['delivery_address'];
        $delivery_time = $_POST['delivery_time'];

        // Insert order details into the orders table
        $customer_id = $_SESSION['user_id'];  // Assuming you have a user_id in the session after login
        $status = 'Processing';  // You can set the default status

        $insert_order_sql = "INSERT INTO orders (customer_id, delivery_address, delivery_time, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_order_sql);
        $stmt->bind_param('isss', $customer_id, $delivery_address, $delivery_time, $status);
        $stmt->execute();
        
        // Get the order ID of the newly inserted order
        $order_id = $stmt->insert_id;

        // Insert order items into the order_items table
        foreach ($_SESSION['cart'] as $item) {
            $dish_id = $item['id'];
            $quantity = $item['quantity'];

            $insert_order_item_sql = "INSERT INTO order_items (order_id, dish_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_order_item_sql);
            $stmt->bind_param('iii', $order_id, $dish_id, $quantity);
            $stmt->execute();
        }

        // Clear the shopping cart after placing the order
        unset($_SESSION['cart']);
        //session_destroy();

        echo '<p class="alert alert-success">Order placed successfully! Thank you for your purchase.</p>';
    } else {
        // Display the order summary and the form for entering delivery details
        echo '<h2>Order Summary</h2>';
        
        foreach ($_SESSION['cart'] as $item) {
            echo '<p>' . $item['name'] . ' - Price: $' . $item['price'] . ' - Quantity: ' . $item['quantity'] . '</p>';
        }

        // Form for entering delivery details
        echo '
        <form method="post" action="">
            <div class="mb-3">
                <label for="delivery_address" class="form-label">Delivery Address</label>
                <input type="text" class="form-control" id="delivery_address" name="delivery_address" required>
            </div>

            <div class="mb-3">
                <label for="delivery_time" class="form-label">Delivery Time</label>
                <input type="datetime-local" class="form-control" id="delivery_time" name="delivery_time" required>
            </div>

            <button type="submit" class="btn btn-primary" name="place_order">Place Order</button>
        </form>';
    }
} else {
    echo '<p>Your shopping cart is empty. Please add items to your cart before placing an order.</p>';
}

?>
</div>
<!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>