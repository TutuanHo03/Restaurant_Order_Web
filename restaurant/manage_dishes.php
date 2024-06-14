<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include the configuration file
include '../config.php';

session_start();

if (!isset($_SESSION['manager_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Process form submissions for adding, editing, or deleting dishes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (unchanged code for form processing)
}

// Fetch all dishes from the database
$sql = "SELECT * FROM dishes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Dishes - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Background Image -->
    <style>
        body {
            background-image: url('/image/bg4.jpg'); /* Adjust the path as needed */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white; /* Set text color to white */
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
        <h2>Manage Dishes</h2>

        <!-- Add Dish Form -->
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success" name="add_dish">Add Dish</button>
        </form>

        <!-- Display Dishes in a Table -->
         <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($dish = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . $dish['id'] . '</td>
                            <td>' . $dish['name'] . '</td>
                            <td>' . $dish['description'] . '</td>
                            <td>$' . $dish['price'] . '</td>
                            <td>
                                <!-- Edit Dish Button -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal' . $dish['id'] . '">
                                    Edit
                                </button>

                                <!-- Delete Dish Form -->
                                <form method="post" action="">
                                    <input type="hidden" name="dish_id" value="' . $dish['id'] . '">
                                    <button type="submit" class="btn btn-danger" name="delete_dish">Delete</button>
                                </form>
                            </td>
                        </tr>';

                        // Edit Dish Modal
                        echo '
                        <div class="modal fade" id="editModal' . $dish['id'] . '" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Dish</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Edit Dish Form (similar to add form) -->
                                        <form method="post" action="">
                                            <input type="hidden" name="dish_id" value="' . $dish['id'] . '">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="' . $dish['name'] . '" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3">' . $dish['description'] . '</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" value="' . $dish['price'] . '" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="edit_dish">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<tr><td colspan="5">No dishes found.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>