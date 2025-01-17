<?php
include "..\includes/db.php"; // Ensure the DB connection is set up

// Start session
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare and execute query to fetch user by username
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password hash
        if (password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Store role in session
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];

            header("Location: ..\index.php "); // Redirect to dashboard
            exit();
        } else {
            // Invalid password
            header("Location: ..\login.php?error=invalid_credentials");
            exit();
        }
    } else {
        // User not found
        header("Location: ..\login.php?error=invalid_credentials");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request method
    header("Location: login.php");
    exit();
}
?>
