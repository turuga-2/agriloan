<?php
//include 'dbconnection.php';
include "../config/databaseconfig.php";
$idNumber = $_SESSION['idNumber'];
$dbloanid = $_SESSION['dbloanid'];
header("Content-Type: application/json");
$stkCallbackResponse = file_get_contents('php://input');
$logFile = "Mpesastkresponse.json";
$log = fopen($logFile, "a");
fwrite($log, $stkCallbackResponse);
fclose($log);

$data = json_decode($stkCallbackResponse);

$MerchantRequestID = $data->Body->stkCallback->MerchantRequestID;
$CheckoutRequestID = $data->Body->stkCallback->CheckoutRequestID;
$ResultCode = $data->Body->stkCallback->ResultCode;
$ResultDesc = $data->Body->stkCallback->ResultDesc;
$Amount = $data->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$TransactionId = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$UserPhoneNumber = $data->Body->stkCallback->CallbackMetadata->Item[4]->Value;

//CHECK IF THE TRASACTION WAS SUCCESSFUL 
if ($ResultCode == 0) {
  //STORE THE TRANSACTION DETAILS IN THE DATABASE
  try {
    // Assuming $conn is your database connection
    $stmt = $conn->prepare("INSERT INTO transactions (MerchantRequestID, F_loanid, F_idNumber, CheckoutRequestID, ResultCode, Amount, MpesaReceiptNumber, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Assuming $MerchantRequestID, $idNumber, $dbloanid, $CheckoutRequestID, $ResultCode, $Amount, $TransactionId, $UserPhoneNumber are your variables
    $stmt->bind_param("ssissdss", $MerchantRequestID, $idNumber, $dbloanid, $CheckoutRequestID, $ResultCode, $Amount, $TransactionId, $UserPhoneNumber);

    // Execute the statement
    $result = $stmt->execute();

    // Check if the execution was successful
    if ($result) {
        echo "Transaction details inserted successfully.";
    } else {
        throw new Exception("Error: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();

} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage();
}

}