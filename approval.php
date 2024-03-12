<?php
include "config/databaseconfig.php";
session_start();

try {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loanid = $_POST['loanid'];
        $_SESSION['loanid'] = $loanid;

        // Fetch grandtotal from the loans table
        $grandtotalQuery = "SELECT grandtotal FROM loans WHERE loanid = '$loanid'";
        $grandtotalResult = mysqli_query($conn, $grandtotalQuery);

        if ($grandtotalResult) {
            $row = mysqli_fetch_assoc($grandtotalResult);
            $grandtotal = $row['grandtotal'];

            // Update the loans table
            $updateLoanQuery = "UPDATE loans SET loanstatus='Active', approvaldate = CURRENT_TIMESTAMP, balance = $grandtotal WHERE loanid = $loanid";

            if (mysqli_query($conn, $updateLoanQuery)) {
                // Send a JSON response with grandtotal
                $response = array('status' => 'success', 'message' => 'Loan status updated successfully', 'grandtotal' => $grandtotal);
                echo json_encode($response);
            } else {
                throw new Exception("Error updating loan status: " . mysqli_error($conn));
            }
        } else {
            throw new Exception("Error fetching grandtotal: " . mysqli_error($conn));
        }
    } else {
        throw new Exception("Invalid request method");
    }
} catch (Exception $e) {
    // Send an error JSON response
    $errorResponse = array('status' => 'error', 'message' => 'Caught Exception: ' . $e->getMessage());
    echo json_encode($errorResponse);
} finally {
    // Close the database connection
    mysqli_close($conn);
}
?>
