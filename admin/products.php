<?php
include("includes/auth.php");
include("includes/header.php");
include("includes/db.php");

// Handle Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Image Upload
    $targetDir = "..\uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $description, $imageName);
    $stmt->execute();
    header("Location: products.php");
}

// Handle Edit Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "..\uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("sdssi", $name, $price, $description, $imageName, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
        $stmt->bind_param("sdsi", $name, $price, $description, $id);
    }
    
    $stmt->execute();
    header("Location: products.php");
}

// Handle Delete Product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: products.php");
}

// Fetch all products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
     <style>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

.sidebar {
    width: 250px;
    height: 100vh;
    background: #2C3E50;
    color: white;
    position: fixed;
    padding-top: 20px;
}

.sidebar h2 {
    text-align: center;
}

.sidebar a {
    display: block;
    color: white;
    padding: 15px;
    text-decoration: none;
    text-align: center;
}

.sidebar a:hover {
    background: #34495E;
}

.content {
    margin-left: 250px;
    padding: 20px;
    width: 100%;
}

h1 {
    color: #333;
}

form input, form select {
    display: block;
    margin: 5px;
    padding: 8px;
}

button {
    padding: 10px;
    background: blue;
    color: white;
    border: none;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid black;
}

th {
    background: #f4f4f4;
}

#editForm {
    margin-top: 20px;
    padding: 10px;
    background: #f8f8f8;
    border: 1px solid #ccc;
}
</style>
</head>
<body>

    <!-- <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">Dashboard</a>
        <a href="products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
    </div> -->

    <div class="content">
        <h1>Manage Products</h1>

        <h3>Add New Product</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="file" name="image" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <h3>All Products</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" width="50"></td>
                <td>
                    <button onclick="editProduct('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['description']; ?>')">Edit</button>
                    <a href="products.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>

        <div id="editForm" style="display:none;">
            <h3>Edit Product</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="name" id="editName" required>
                <input type="number" name="price" id="editPrice" step="0.01" required>
                <textarea name="description" id="editDescription" required></textarea>
                <input type="file" name="image">
                <button type="submit" name="edit_product">Update</button>
                <button type="button" onclick="document.getElementById('editForm').style.display='none'">Cancel</button>
            </form>
        </div>

    </div>

    <script>
        function editProduct(id, name, price, description) {
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editPrice").value = price;
            document.getElementById("editDescription").value = description;
            document.getElementById("editForm").style.display = "block";
        }
    </script>

</body>
</html>
