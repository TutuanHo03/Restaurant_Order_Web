<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Background Image -->
    <style>
        body {
            background-image: url('/image/bg2.jpg'); /* Adjust the path as needed */
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
    // Check if the form is submitted for removing an item
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
        // Get the dish ID to be removed
        $dish_id_to_remove = $_POST['remove_from_cart'];

        // Find the index of the item in the cart
        $item_index = array_search($dish_id_to_remove, array_column($_SESSION['cart'], 'id'));

        // If the item is found, remove it from the cart
        if ($item_index !== false) {
            unset($_SESSION['cart'][$item_index]);
            // Reset array keys to maintain sequential index
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    // Display the items in the shopping cart
    foreach ($_SESSION['cart'] as $item) {
        echo '
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">' . $item['name'] . '</h5>
                <p class="card-text">Price: $' . $item['price'] . ' | Quantity: ' . $item['quantity'] . '</p>
                <form method="post" action="">
                    <input type="hidden" name="remove_from_cart" value="' . $item['id'] . '">
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </div>
        </div>';
    }

        echo '
    <form method="post" action="order_payment.php">
        <button type="submit" class="btn btn-primary">Proceed to Order Payment</button>
    </form>';

} else {
    echo '<p class="mt-3">Your shopping cart is empty! <a href="view_dishes.php">See dishes list</a></p>';
}

?>
</div>
<!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
