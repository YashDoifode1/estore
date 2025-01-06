<?php
include "..\includes/header.php";
// session_start();
include "..\includes/db.php"; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ..\login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="..\css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .profile-header {
            text-align: center;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile-details {
            text-align: center;
        }
        .profile-details h2 {
            margin: 0;
        }
        .profile-details p {
            color: #666;
        }
        .logout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .logout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="..\<?= htmlspecialchars($user['image']) ?>" alt="Profile Picture">
        </div>
        <div class="profile-details">
            <h2><?= htmlspecialchars($user['username']) ?></h2>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
        <a href="..\logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
<?php 
include "..\includes/footer.php";
 ?>