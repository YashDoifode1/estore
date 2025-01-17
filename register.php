<?php include "includes/header.php"?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            /* display: flex; */
            align-items: center;
            justify-content: center;
        }

        .registration-container {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 90%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        /* Error Message */
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .registration-container {
                padding: 20px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="file"] {
                font-size: 14px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <center><div class="registration-container">
        <h2>Create an Account</h2>

        <!-- Display error messages -->
        <?php
        // session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Remove error message after displaying
        }
        ?>

        <form action="backend/reg.php" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="image">Profile Picture:</label>
            <input type="file" id="image" name="image">

            <button type="submit">Register</button>
        </form>
    </div></center>
</body>
</html>

<?php 
include "includes/footer.php"
?>
