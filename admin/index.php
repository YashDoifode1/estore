<?php
session_start();

define('APP_URL', 'http://localhost/estore/admin');

include __DIR__ . "/includes/header.php"; 
include __DIR__ . "/includes/db.php"; 
include("includes/auth.php"); // Ensure only admins access this page

// Fetch existing settings
$sql = "SELECT * FROM settings LIMIT 1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $site_name = $_POST['site_name'];
    $about = $_POST['about'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];

    $update_sql = "UPDATE settings SET 
        site_name = ?, 
        about = ?, 
        address = ?, 
        email = ?, 
        phone = ?, 
        facebook = ?, 
        twitter = ?, 
        instagram = ?, 
        linkedin = ? 
        WHERE id = 1";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssss", $site_name, $about, $address, $email, $phone, $facebook, $twitter, $instagram, $linkedin);
    
    if ($stmt->execute()) {
        $message = "Footer settings updated successfully!";
        header("Location: footer_settings.php?success=1");
        exit();
    } else {
        $message = "Error updating settings.";
    }
}
?>
<style>
    .content {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-top: 10px;
}

input, textarea {
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
}

button {
    margin-top: 15px;
    padding: 10px;
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background: #0056b3;
}

    </style>
<div class="content">
    <h2>Manage Footer Settings</h2>
    
    <?php if (isset($_GET['success'])) echo "<p style='color: green;'>Settings updated successfully!</p>"; ?>

    <form method="post">
        <label>Site Name:</label>
        <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>

        <label>About:</label>
        <textarea name="about" required><?php echo htmlspecialchars($settings['about']); ?></textarea>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($settings['address']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($settings['email']); ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($settings['phone']); ?>" required>

        <label>Facebook Link:</label>
        <input type="url" name="facebook" value="<?php echo htmlspecialchars($settings['facebook']); ?>">

        <label>Twitter Link:</label>
        <input type="url" name="twitter" value="<?php echo htmlspecialchars($settings['twitter']); ?>">

        <label>Instagram Link:</label>
        <input type="url" name="instagram" value="<?php echo htmlspecialchars($settings['instagram']); ?>">

        <label>LinkedIn Link:</label>
        <input type="url" name="linkedin" value="<?php echo htmlspecialchars($settings['linkedin']); ?>">

        <button type="submit">Update Settings</button>
    </form>
</div>


