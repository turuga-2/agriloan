<?php
include "config\databaseconfig.php";
$idNumber = $_SESSION['idNumber'];
$dbloanid = $_SESSION['dbloanid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the AJAX request
    $phoneNumber = $_POST['phoneNumber'];
    $amount = $_POST['amount'];

    // Initialize the response array
    $response = array();

    try {
        // Assuming $conn is your database connection, ensure it is properly established before this point

        $transactionsql = "SELECT * FROM transactions WHERE PhoneNumber = '$phoneNumber' AND amount = '$amount'";
        $transactionresult = mysqli_query($conn, $transactionsql);

        if (!$transactionresult) {
            throw new Exception("Error executing query: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($transactionresult) > 0) {
            $row = mysqli_fetch_assoc($transactionresult);
            $MpesaReceiptNumber = $row['MpesaReceiptNumber'];
            $PhoneNumber = $row['PhoneNumber'];
            $Amount = $row['Amount'];
            $transactiondate = $row['transactiondate'];

            $repaymentsql = "INSERT INTO repayment (F_idNumber, F_loanid, MpesaReceiptNumber, PhoneNumber, Amount, transactiondate)
                     VALUES ('$idNumber','$dbloanid','$MpesaReceiptNumber', '$PhoneNumber', '$Amount', '$transactiondate')";

            // Execute the INSERT query
            if (mysqli_query($conn, $repaymentsql)) {
                $response['status'] = 'success';
                $response['message'] = 'Repayment record inserted successfully';
            } else {
                throw new Exception("Error inserting repayment record: " . mysqli_error($conn));
            }
        } else {
            throw new Exception("No matching transaction found for the given criteria");
        }

        // Convert the response array to JSON and echo it
        echo json_encode($response);

    } catch (Exception $e) {
        // Handle the exception, you can log or display an error message as needed
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    } finally {
        // Close the database connection
        if ($conn) {
            mysqli_close($conn);
        }
    }
} else {
    // Handle other types of requests or show an error message
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
