<?php
// Include necessary files
include "../config/databaseconfig.php";
include 'password_reset_functions.php'; 

// Step 2: User clicks on the reset link in the email
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid and not expired
    $query = "SELECT idNumber, reset_token_expiry FROM farmers WHERE reset_token = '$token'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $idNumber = $user['idNumber'];
        $expiry_time = strtotime($user['reset_token_expiry']);

        if (time() < $expiry_time) {
            // Token is valid; display the password reset form
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Password Reset</title>
            </head>
            <body>
                <h2>Password Reset</h2>
                <form action="reset_password.php" method="post">
                    <input type="hidden" name="idNumber" value="<?php echo $idNumber; ?>">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                    <button type="submit" name="reset_password">Reset Password</button>
                </form>
            </body>
            </html>

            <?php
        } else {
            echo "Reset token has expired.";
        }
    } else {
        echo "Invalid reset token.";
    }
}

// Step 3: User submits the new password
if (isset($_POST['reset_password'])) {
    $idNumber = $_POST['idNumber'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Update the password in the database
    $update_query = "UPDATE farmers SET password = '$new_password', reset_token = NULL, reset_token_expiry = NULL WHERE idNumber = $idNumber";
    $conn->query($update_query);

    echo "Password reset successful. You can now <a href='../farmerlogin.php'>LOGIN</a> with your new password.";
}

$conn->close();
?>
