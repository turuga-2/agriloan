<?php
include "config/databaseconfig.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['idNumber'])) {
        $idNumber = $_SESSION['idNumber'];
        $cartItems = json_decode($_POST['cartItems'], true);
        $grandTotal = $_POST['grandTotal'];

        // Insert order into the orders table
        $insertOrderQuery = "INSERT INTO orders (F_idNumber, total_amount) VALUES (?, ?)";
        $insertOrderStmt = $conn->prepare($insertOrderQuery);
        $insertOrderStmt->bind_param("id", $idNumber, $grandTotal);
        $insertOrderStmt->execute();

        $orderId = $insertOrderStmt->insert_id; // Get the ID of the inserted order

        // Insert order details into the order_details table
        $insertOrderDetailsQuery = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $insertOrderDetailsStmt = $conn->prepare($insertOrderDetailsQuery);

        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['id'];
            $quantity = 1; // Assuming quantity is always 1, you can modify as needed
            $price = $cartItem['price'];

            $insertOrderDetailsStmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
            $insertOrderDetailsStmt->execute();
        }

        $insertOrderStmt->close();
        $insertOrderDetailsStmt->close();

        // Get data from the AJAX request
    $idNumber = $_POST['idNumber'];
    $acreage = $_POST['acreage'];
    $bundle = $_POST['bundle'];
    $orderId = $_POST['orderId'];
    $totalPrice = $_POST['totalPrice'];

    // Perform database insertion (Make sure to use prepared statements to prevent SQL injection)
    $sql = "INSERT INTO loans (idNumber, acreage, bundle, orderId, total) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Adjust the type specifier string based on the actual types
    $stmt->bind_param("iisid", $idNumber, $acreage, $bundle, $orderId, $totalPrice);
    $stmt->execute();
    $stmt->close();
    // Send a JSON response to the client
    
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the AJAX request
    $idNumber = $_POST['idNumber'];
    $acreage = $_POST['acreage'];
    $bundle = $_POST['bundle'];
    $orderId = $_POST['orderId'];
    $totalPrice = $_POST['totalPrice'];

    // Perform database insertion (Make sure to use prepared statements to prevent SQL injection)
    $sql = "INSERT INTO loans (idNumber, acreage, bundle, orderId, total) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Adjust the type specifier string based on the actual types
    $stmt->bind_param("iisid", $idNumber, $acreage, $bundle, $orderId, $totalPrice);
    $stmt->execute();
    $stmt->close();
    // Send a JSON response to the client
    echo json_encode(['success' => true]);
} else {
    // Send a JSON response for invalid requests
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
