<?php include "includes/header.php"?>


<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
     <style>.login-container {
    border: 1px solid #ccc;
    padding: 20px;
    margin: 20px auto;
    width: 300px;
}</style>
</head>
<body>
<br><br><br><br><br><br><br><br><br><br><br>  
    <div class="login-container">
        <h2>Login</h2>
        <form action="backend/log.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <center><button type="submit">Login</button></center>
        </form>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br>  
    <br><br>
    <script src="script.js"></script>
</body>

</html>

    <?php 
    // include "includes/footer.php"
    ?>