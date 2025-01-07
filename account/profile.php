<?php
include "../includes/header.php";
include "../includes/db.php"; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT username, email, phone, address, image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $image = $user['image']; // Default to existing image

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowed_types)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image = "uploads/" . basename($_FILES["image"]["name"]); // Save relative path
        } else {
            echo "<p style='color:red;'>Invalid image file type!</p>";
        }
    }

    // Update user details in the database
    $update_sql = "UPDATE users SET username=?, email=?, phone=?, address=?, image=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $username, $email, $phone, $address, $image, $user_id);

    if ($update_stmt->execute()) {
        echo "<p style='color:green;'>Profile updated successfully!</p>";
        header("Refresh:1; url=profile.php"); // Refresh the page after update
    } else {
        echo "<p style='color:red;'>Error updating profile.</p>";
    }
    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .profile-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .profile-container input, .profile-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .profile-container button {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .profile-container button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <img src="..\<?= htmlspecialchars($user['image']) ?>" alt="Profile Picture">
        
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required placeholder="Full Name">
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required placeholder="Email">
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required placeholder="Phone Number">
            <textarea name="address" required placeholder="Address"><?= htmlspecialchars($user['address']) ?></textarea>
            <input type="file" name="image" accept="image/*">
            
            <button type="submit">Update Profile</button>
        </form>
        
        <a href="../logout.php" class="logout-btn" style="display:block; margin-top:15px; color:white; background:red; padding:10px; border-radius:5px; text-decoration:none;">Logout</a>
    </div>
</body>
</html>

<?php 
include "../includes/footer.php";
?>
