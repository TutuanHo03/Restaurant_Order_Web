<?php
// Include the configuration file
include '../config.php';

session_start();

if (!isset($_SESSION['staff_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Check if the dish ID is provided in the URL
if (!isset($_GET['dish_id'])) {
    // Redirect to view_dishs.php if dish ID is not provided
    header('Location: view_dishes.php');
    exit();
}

$dish_id = $_GET['dish_id'];

// Fetch dish details
$sql = "SELECT * FROM dishes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $dish_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Redirect to view_dishs.php if the dish does not exist
    header('Location: view_dishes.php');
    exit();
}

$row = $result->fetch_assoc();



// Check if the form is submitted for dish status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_dish_status'])) {
    // Process the dish status update logic here
    $dish_id = $_POST['dish_id'];
    $dish_status = $_POST['dish_status'];

    // Update the dish status in the database
    $update_sql = "UPDATE dishes SET dish_status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $dish_status, $dish_id);
    $update_stmt->execute();

    // Display a success message
    echo '<p class="alert alert-success">Dish status updated successfully!</p>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dish Status - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Edit Dish Status</h2>

        <?php
        // Display dish details
        echo '
        <div class="card mb-3">
            <div class="card-body">
                        <h5 class="card-title">Dish ID: ' . $row['id'] . '</h5>
                        <p class="card-text">Dish Name: ' . $row['name'] . '</p>
                        <p class="card-text">Dish Description: ' . $row['description'] . '</p>
                        <p class="card-text">Dish Price: ' . $row['price'] . '</p>
                        <p class="card-text">Dish Status: ' . $row['dish_status'] . '</p>
            </div>
        </div>';

        // Display dish items with dish status editing options
        if ($result->num_rows > 0) {
        echo '
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Dish ID: ' . $row['id'] . '</h5>

                <!-- Dish status editing form -->
                <form method="post" action="">
                    <input type="hidden" name="dish_id" value="' . $row['id'] . '">
                    <div class="mb-3">
                        <label for="dish_status" class="form-label">Dish Status</label>
                        <select class="form-select" id="dish_status" name="dish_status">
                            <option value="Available">Available</option>
                            <option value="Sold Out">Sold Out</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_dish_status">Update Dish Status</button>
                    <a class="btn btn-danger" href="view_dishes.php">Back to dishes view</a>

                </form>
            </div>
        </div>';
    
} else {
    echo '<p>No items found in the dish.</p>';
}
        ?>

    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
