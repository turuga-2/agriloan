<?php
session_start();

// Check if the 'totalPrice' is sent through AJAX
if (isset($_POST['totalPrice'])) {
    // Retrieve the total price from the AJAX request
    $totalPrice = $_POST['totalPrice'];

    // Store the total price in the session
    $_SESSION['totalPrice'] = $totalPrice;

    // Return a response (you can customize the response based on your needs)
    echo json_encode(['success' => true, 'message' => 'Total price stored successfully']);
} else {
    // Return an error response if 'totalPrice' is not set
    echo json_encode(['success' => false, 'message' => 'Total price not provided']);
}


?>
