<?php
include("includes/header.php");
include("includes/auth.php");
include("includes/db.php");

// Handle Add User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    header("Location: users.php");
}

// Handle Edit User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $role, $id);
    $stmt->execute();
    header("Location: users.php");
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: users.php");
}

// Fetch all users
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- <link rel="stylesheet" href="users.css"> -->
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
        <a href="users.php">Manage Users</a>
        <a href="logout.php">Logout</a>
    </div> -->

    <div class="content">
        <h1>Manage Users</h1>

        <h3>Add New User</h3>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <button type="submit" name="add_user">Add User</button>
        </form>

        <h3>All Users</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <button onclick="editUser('<?php echo $row['id']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['role']; ?>')">Edit</button>
                    <a href="users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>

        <div id="editForm" style="display:none;">
            <h3>Edit User</h3>
            <form method="POST">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="username" id="editUsername" required>
                <select name="role" id="editRole">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button type="submit" name="edit_user">Update</button>
                <button type="button" onclick="document.getElementById('editForm').style.display='none'">Cancel</button>
            </form>
        </div>

    </div>

    <script>
        function editUser(id, username, role) {
            document.getElementById("editId").value = id;
            document.getElementById("editUsername").value = username;
            document.getElementById("editRole").value = role;
            document.getElementById("editForm").style.display = "block";
        }
    </script>

</body>
</html>
