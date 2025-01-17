<?php include "..\includes/db.php"; ?>

<?php

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$image = $_FILES['image'];

// Hash password for security
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Handle image upload
$target_dir = "..\uploads/";
$target_file = $target_dir . basename(preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES["image"]["name"]));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is valid
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        die("File is not an image.");
    }
}

// Additional checks
if (file_exists($target_file)) die("Sorry, file already exists.");
if ($_FILES["image"]["size"] > 500000) die("Sorry, your file is too large.");
if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");

if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    // Insert data into the database
    $sql = "INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssss", $username, $email, $hashed_password, $target_file);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ..\login.php");
        exit();
    } else {
        die("Error inserting data: " . $stmt->error);
    }

    $stmt->close();
} else {
    die("Sorry, there was an error uploading your file.");
}

$conn->close();
?>
