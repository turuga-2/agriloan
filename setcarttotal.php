 <?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data received from the AJAX request
    $cartItemsJson = $_POST['cartItems'];
    $cartItems = json_decode($cartItemsJson, true);

    // Validate and update the session variable
    if (is_array($cartItems)) {
        $_SESSION['cartItems'] = $cartItems;

        // You can also update other session variables, perform database operations, etc.

        // Send a success response
        $response = array('success' => true, 'message' => 'Cart items saved successfully');
        echo json_encode($response);
       
    } else {
        // Send an error response if the received data is not valid
        $response = array('success' => false, 'message' => 'Invalid cart items data');
        echo json_encode($response);
        exit;
    }
} else {
    // Send an error response for non-POST requests
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
    exit;
}



?>


