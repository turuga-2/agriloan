<?php
include "../config/databaseconfig.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>

    
    <form action="reset_password_request.php" method="post">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="reset_request">Reset Password</button>
    </form>

</body>
</html>
