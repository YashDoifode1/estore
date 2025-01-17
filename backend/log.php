<?php
include "../includes/db.php"; // Ensure the DB connection is set up

session_start();

// Google reCAPTCHA Secret Key
$recaptcha_secret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
";

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate reCAPTCHA
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $response_data = json_decode($verify);

    if (!$response_data->success) {
        header("Location: ../login.php?error=Invalid reCAPTCHA");
        exit();
    }

    // Prepare and execute query to fetch user by username
    $sql = "SELECT id, username, password, role, email, phone FROM users WHERE username = ?";
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
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Store role in session
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];

            header("Location: ../index.php"); // Redirect to home page
            exit();
        } else {
            header("Location: ../login.php?error=Invalid credentials");
            exit();
        }
    } else {
        header("Location: ../login.php?error=Invalid credentials");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../login.php");
    exit();
}
?>
