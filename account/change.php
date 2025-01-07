<?php
include "../includes/header.php";
include "../includes/db.php"; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch user's current password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $hashed_password)) {
        echo "<p style='color: red;'>Current password is incorrect.</p>";
    } elseif ($new_password !== $confirm_password) {
        echo "<p style='color: red;'>New password and confirm password do not match.</p>";
    } else {
        // Hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "<p style='color: green;'>Password changed successfully!</p>";
        } else {
            echo "<p style='color: red;'>Something went wrong. Try again.</p>";
        }

        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 30%; margin: 100px auto; }
        input { display: block; width: 100%; margin: 10px 0; padding: 10px; }
        button { padding: 10px; background: green; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form method="post" action="">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
<?php
include "../includes/footer.php";?>