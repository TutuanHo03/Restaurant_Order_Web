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

// Check if dish ID is provided in the URL
if (isset($_GET['id'])) {
    $dish_id = $_GET['id'];

    // Fetch dish details from the database
    $sql = "SELECT * FROM dishes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $dish_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dish = $result->fetch_assoc();

        // Check if the "Add to Cart" button is clicked
        if (isset($_POST['add_to_cart'])) {
            // Initialize the shopping cart session if not already done
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            // Add the dish to the shopping cart
            $cart_item = array(
                'id' => $dish['id'],
                'name' => $dish['name'],
                'price' => $dish['price'],
                'quantity' => 1
            );

            // Check if the item is already in the cart
            $item_index = array_search($dish['id'], array_column($_SESSION['cart'], 'id'));
            if ($item_index !== false) {
                // If yes, increase the quantity
                $_SESSION['cart'][$item_index]['quantity'] += 1;
            } else {
                // If no, add a new item to the cart
                $_SESSION['cart'][] = $cart_item;
            }

            // Display a success message
            echo "<script>alert('This dish has been added to the cart!'); window.location.href = 'view_dishes.php';  </script>";
            exit();
        }

    } else {
        // Redirect to view_dishes.php if the dish ID is not valid
        header('Location: view_dishes.php');
        exit();
    }

    $stmt->close();
} else {
    // Redirect to view_dishes.php if dish ID is not provided
    header('Location: view_dishes.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dish['name']; ?> - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Background Image CSS -->
    <style>
        body {
            background: url('/image/dishes/bg.jpg') center/cover fixed;
            background-filter: blur(60%);
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
        <h2><?php echo $dish['name']; ?></h2>
        <div class="card">
        <img src="/image/dishes/chad<?php echo $row['id']; ?>.jpg" class="card-img-top" alt="<?php echo $row['name']; ?>">
            <div class="card-body">
                <p class="card-text"><?php echo $dish['description']; ?></p>
                <p class="card-text">Price: <?php echo $dish['price']; ?></p>

                <!-- Add to Cart form -->
                <form method="post" action="">
                    <input type="hidden" name="add_to_cart" value="1">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
