<?php
// Include the configuration file
include '../config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $sql = "SELECT id, username, password FROM customers WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $db_password)) {
            // Password is correct, start a session
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;

            // Redirect to the desired page after login
            header('Location: view_dishes.php');
            exit();
        } else {
            $error_message = "Invalid password";
        }
    } else {
        $error_message = "Invalid username";
    }

    $stmt->close();
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

    <div class="container">
        <h2 class="text-center mb-4">Login</h2>

        <?php
        if (isset($error_message)) {
            echo "<div class='alert alert-danger error-message' role='alert'>
                    $error_message
                </div>";
        }
        ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
