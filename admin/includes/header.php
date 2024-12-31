<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
    <script>
        // JavaScript for additional functionality
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        .container {
            display: flex;
        }
        #sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            height: 100vh;
            padding: 15px;
            transition: width 0.3s;
        }
        #sidebar.collapsed {
            width: 70px;
        }
        #sidebar ul {
            list-style: none;
            padding: 0;
        }
        #sidebar ul li {
            padding: 10px 0;
        }
        #sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }
        #main {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            background: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin-bottom: 10px;
        }
        .logout-btn {
            margin-top: 20px;
            padding: 10px;
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header">
    <!--  -->
        <h1>Admin Panel</h1>
    </div>
    <div class="container">
        <div id="sidebar">
            <button onclick="toggleSidebar()">. / .</button>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Manage Users</a></li>
                <li><a href="product.php">Manage Products</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="<?= APP_URL ?>/logout.php" class="logout-btn">Logout</a></li>

            </ul>
        </div>