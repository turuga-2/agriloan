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
    }try {
        // Check if the idNumber exists in the table
        $checkIdStmt = $conn->prepare("SELECT F_idNumber FROM loans WHERE F_idNumber = ?");
        $checkIdStmt->bind_param("s", $idNumber);
        
        if ($checkIdStmt->execute()) {
            $checkIdStmt->store_result();
    
            // If the idNumber exists, update the credit history to 1
            if ($checkIdStmt->num_rows > 0) {
                $updateCreditStmt = $conn->prepare("UPDATE loans SET credithistory = 1 WHERE F_idNumber = ? AND balance = 0");
                $updateCreditStmt->bind_param("s", $idNumber);
    
                if ($updateCreditStmt->execute()) {
                    echo "Credit history updated successfully.";
                } else {
                    throw new Exception("Error updating credit history: " . $updateCreditStmt->error);
                }
            }
        } else {
            throw new Exception("Error executing statement: " . $checkIdStmt->error);
        }
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
