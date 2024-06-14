<?php
// Include the configuration file
include '../config.php';

session_start();

if (!isset($_SESSION['manager_logged'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
// Process form submissions for adding, editing, or deleting customers
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (unchanged code for form processing)
}

// Fetch all customers from the database
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - <?php echo SITE_NAME; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Background Image -->
    <style>
        body {
            background-image: url('/image/bg5.jpg'); /* Adjust the path as needed */
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
        <h2>Manage Customers</h2>

        <!-- Add Customer Form -->
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-success" name="add_customer">Add Customer</button>
        </form>

        <!-- Display Customers in a Table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($customer = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . $customer['id'] . '</td>
                            <td>' . $customer['username'] . '</td>
                            <td>' . $customer['email'] . '</td>
                            <td>
                                <!-- Edit Customer Button -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal' . $customer['id'] . '">
                                    Edit
                                </button>

                                <!-- Delete Customer Form -->
                                <form method="post" action="">
                                    <input type="hidden" name="customer_id" value="' . $customer['id'] . '">
                                    <button type="submit" class="btn btn-danger" name="delete_customer">Delete</button>
                                </form>
                            </td>
                        </tr>';

                        // Edit Customer Modal
                        echo '
                        <div class="modal fade" id="editModal' . $customer['id'] . '" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Customer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Edit Customer Form (similar to add form) -->
                                        <form method="post" action="">
                                            <input type="hidden" name="customer_id" value="' . $customer['id'] . '">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="' . $customer['username'] . '" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="' . $customer['email'] . '" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="edit_customer">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<tr><td colspan="4">No customers found.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
