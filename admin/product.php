<?php
include('includes/header.php');
// Include database connection (adjust with your own DB credentials)
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Handle the file upload
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp_name = $image['tmp_name'];
    $image_error = $image['error'];
    $image_size = $image['size'];

    // Define the target directory to save the image
    $target_dir = "uploads2/";
    $target_file = $target_dir . basename($image_name);
    $image_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check for errors during file upload
    if ($image_error === 0) {
        if ($image_size < 5000000) { // 5MB limit
            if (in_array($image_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (move_uploaded_file($image_tmp_name, $target_file)) {
                    // Insert product details into the database
                    $query = "INSERT INTO products (name, description, price, category_id, image) 
                              VALUES ('$name', '$description', '$price', '$category_id', '$target_file')";

                    if (mysqli_query($conn, $query)) {
                        echo "<script>alert('Product created successfully!');</script>";
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Error uploading image.');</script>";
                }
            } else {
                echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
            }
        } else {
            echo "<script>alert('File size is too large. Maximum size is 5MB.');</script>";
        }
    } else {
        echo "<script>alert('Error uploading the file.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            /* display: flex; */
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Create Product</h2>
        <form action="gen.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category_id" required>
                    <option value="">Select Category</option>
                    <option value="1">Electronics</option>
                    <option value="2">Furniture</option>
                    <option value="3">Clothing</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Create Product</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php include('includes/footer.php'); ?>
