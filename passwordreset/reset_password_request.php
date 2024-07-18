<?php
// Include necessary files
include "../config/databaseconfig.php";
include 'password_reset_functions.php';

// Step 1: User requests password reset
if (isset($_POST['reset_request'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT idNumber, email FROM farmers WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Generate and store the reset token and expiry time
        $token = generateToken();
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $idNumber = $user['idNumber'];

        $update_query = "UPDATE farmers SET reset_token = '$token', reset_token_expiry = '$expiry_time' WHERE idNumber = $idNumber";
        $conn->query($update_query);

        // Send reset email
        sendResetEmail($email, $token);

        echo "Password reset email sent. Please check your email.";
    } else {
        echo "Email not found in the database.";
    }
}

$conn->close();
?>
