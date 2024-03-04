<?php
include "config/databaseconfig.php";
session_start();

try {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loanid = $_POST['loanid'];
        

        // Use prepared statements to prevent SQL injection
        $sql = "UPDATE `loans` SET `dispatch_status`='Dispatched', `dispatchdate` = CURRENT_TIMESTAMP WHERE loanid = ?";
        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            throw new Exception("Error in preparing the statement: " . $conn->error);
        }

        $stmt->bind_param("s", $loanid);

        if (!$stmt->execute()) {
            throw new Exception("Error executing the statement: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();

        // Send a JSON response
        $response = array('status' => 'success', 'message' => 'Loan status updated successfully');
        echo json_encode($response);
    }
} catch (Exception $e) {
    // Send an error JSON response
    $errorResponse = array('status' => 'error', 'message' => 'Error: ' . $e->getMessage());
    echo json_encode($errorResponse);
} finally {
    // Close the database connection
    mysqli_close($conn);
}
?>
