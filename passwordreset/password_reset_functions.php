<?php
include "../config/databaseconfig.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random token
function generateToken() {
    return bin2hex(random_bytes(16));
}

function sendResetEmail($to, $token) {
    require 'vendor/autoload.php'; // Assuming you have PHPMailer installed via Composer

    $reset_link = "https://7e82-154-159-237-165.ngrok-free.app/passwordreset/reset_password.php?token=$token";
    $subject = "Password Reset";
    $message = "Click the following link to reset your password: $reset_link";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'bisquitbutter22@gmail.com'; // Replace with your SMTP username
        $mail->Password = '#turunye'; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@example.com', 'Your Name'); // Replace with your sender email and name
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'Email sent successfully';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>