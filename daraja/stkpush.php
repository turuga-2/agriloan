<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get data from the AJAX request
  $phoneNumber = $_POST['phoneNumber'];
  $amount = $_POST['amount'];

  // Process the data as needed

  // Example response
  echo json_encode(['status' => 'success', 'message' => 'Payment processed successfully']);
} else {
  // Handle other types of requests or show an error message
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
//INCLUDE THE ACCESS TOKEN FILE
include 'accessToken.php';
date_default_timezone_set('Africa/Nairobi');
$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$callbackurl = 'https://f3a5-102-1-180-1.ngrok-free.app/daraja/callback.php';
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
// ENCRIPT  DATA TO GET PASSWORD
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
$phone = $phoneNumber;//phone number to receive the stk push
$money = $amount;
$PartyA = $phone;
$PartyB = '254708374149';
$AccountReference = 'AGRILOAN';
$TransactionDesc = 'stkpush test';
$Amount = $money;
$stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];
//INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $Amount,
  'PartyA' => $PartyA,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' => $PartyA,
  'CallBackURL' => $callbackurl,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
echo $curl_response = curl_exec($curl);
//ECHO  RESPONSE
$data = json_decode($curl_response);
$CheckoutRequestID = $data->CheckoutRequestID;
$ResponseCode = $data->ResponseCode;
if ($ResponseCode == "0") {
  echo "The CheckoutRequestID for this transaction is : " . $CheckoutRequestID;
}