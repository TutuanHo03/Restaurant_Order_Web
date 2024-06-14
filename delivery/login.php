<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $username = $_POST['username'];
    $password = $_POST['password'];



        // Verify the password
        if (($username === delivery_username) && ($password === delivery_password)) {
            // Password is correct, start a session
            session_start();
            $_SESSION['delivery_logged'] = 'true';

            header('Location: view_orders.php');
            exit();
        } else {
            echo "Invalid";
        }
    

}

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
        <h2>Login</h2>

        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>