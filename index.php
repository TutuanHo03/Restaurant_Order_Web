<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include the configuration file
include 'config.php';

// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom styles -->
    <style>
        body {
            background-image: url('/image/bg.jpg'); /* Path to your background image */
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000000; /* Set text color to white for better contrast */
        }

        .container {
            max-width: 400px; /* Adjust width as needed */
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 10px;
        }

        .error-message {
            color: #dc3545; /* Bootstrap's danger color */
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center"><?php echo SITE_NAME; ?></h1>

        <div class="text-center mt-3">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // If logged in, display a welcome message or redirect to the user's dashboard
                echo "<p class='lead'>Welcome, " . $_SESSION['username'] . "!</p>";
                echo "<a href='customer/view_dishes.php' class='btn btn-primary'>View Dishes</a>";
                // Add more links or content for logged-in users
            } else {
                // If not logged in, display login and registration links
                echo "<a href='customer/login.php' class='btn btn-success'>Login</a> 
                      <a href='customer/register.php' class='btn btn-outline-secondary'>Register</a>";
            }
            ?>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
