<?php
session_start();
include "config/databaseconfig.php";
$idNumber = $_SESSION['idNumber'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loantotal'])) {

    $acreage = $_POST['enteredValue'];
    $bundlePrice = $_POST['bundlePrice']; // Accessing directly from $_POST
    // TOTAL LOAN AMOUNT
    $loantotal = $_POST['loantotal'];
    //$_SESSION['loantotal'] = $loantotal;

    $interest = $_POST['interest'];
    $_SESSION['interest'] = $interest;

    $grandtotal = $_POST['grandtotal'];
    $_SESSION['grandtotal'] = $grandtotal;

    $cartItems = $_SESSION['cartItems'];

    try {
        // Prepare the statement for loans insertion
        $insertLoanStmt = $conn->prepare("INSERT INTO loans (`F_idNumber`, `acreage`, `totalbundleprice`, `loanamount`, `interest`, `grandtotal`) VALUES (?, ?, ?, ?, ?, ?)");
        // Bind parameters to the prepared statement
         $insertLoanStmt->bind_param("sddddd", $idNumber, $acreage, $bundlePrice, $grandtotal, $interest, $grandtotal);
         echo "Loan data saved successfully. ";

        // Execute the prepared statement
        if (!$insertLoanStmt->execute()) {
            throw new Exception("Error executing statement: " . $insertLoanStmt->error);

        } 
        $loanid = $insertLoanStmt->insert_id;
        
        $_SESSION['loanid'] = $loanid; 
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        // Prepare the statement for loandetails insertion
        $insertLoandetailsStmt = $conn->prepare("INSERT INTO loandetails (`F_loan_id`, `product_id`, `quantity`, `price`) VALUES (?, ?, ?, ?)");

        // Check if the preparation was successful
        if (!$insertLoandetailsStmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        // Loop through cart items and insert into loandetails table
        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['id'];
            $quantity = 1; // Assuming quantity is always 1, you can modify as needed
            $price = $cartItem['price'];

            // Bind parameters to the prepared statement
            $insertLoandetailsStmt->bind_param("iiid", $loanid, $productId, $quantity, $price);

            // Execute the prepared statement
            if ($insertLoandetailsStmt->execute()) {
                echo "Loan details saved successfully.";
            } else {
                throw new Exception("Error executing statement: " . $insertLoandetailsStmt->error);
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
