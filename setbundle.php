<?php include "config/databaseconfig.php";?>

<?php
session_start();
// Check if the 'totalPrice' is sent through AJAX
if (isset($_POST['grandTotal'])) {
    // Retrieve the total price from the AJAX request
    $grandTotal = $_POST['grandTotal'];

    // Store the total price in the session
    $_SESSION['grandTotal'] = $grandTotal;

    // Return a response (you can customize the response based on your needs)
    echo json_encode(['success' => true, 'message' => 'Grand Total  stored successfully']);
} else {
    // Return an error response if 'totalPrice' is not set
    echo json_encode(['success' => false, 'message' => ' Grand Total  not provided']);
}
?>

