<?php
session_start();
// Check if it's a POST request with the expected data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cartTotal'])) {
    // Get the cartTotal value from the POST data
    $cartTotal = isset($_POST['cartTotal']) ? $_POST['cartTotal'] : 0;

    // Store the cartTotal value in the session variable
    $_SESSION['cartTotal'] = $cartTotal;

    
    
    // Send a response back to the client (optional)
    echo 'Cart total 1 saved to session successfully.';
   echo json_encode(['success' => true, 'cartTotal' => $cartTotal]);
   exit;
} else {
   //Invalid request
   echo json_encode(['success' => false, 'message' => 'Invalid request']);
   exit;
}