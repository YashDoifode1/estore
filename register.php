<?php include "includes/header.php"?>



<!-- Registration Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
     <style>.registration-container {
    border: 1px solid #ccc;
    padding: 20px;
    margin: 20px auto;
    width: 300px;
}</style>
</head>
<body>
<br><br><br><br><br><br><br><br><br><br><br> 
    <div class="registration-container">
        <h2>Registration</h2>
        <form action="backend/reg.php" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="image">Profile Picture:</label>
            <input type="file" id="image" name="image"><br><br>

            <center><button type="submit">Register</button></center>
        </form>
    </div>
    <br><br><br><br><br> <br><br>
    <script src="script.js"></script>
</body>
</html>

<?php 
// include "includes/footer.php"
?>