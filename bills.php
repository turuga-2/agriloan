<?php 
include "config/databaseconfig.php";
// Check if idNumber is not set in the session
if (!isset($_SESSION['idNumber'])) {
    // Redirect to the login page
    header("Location: farmerlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}
$idNumber = $_SESSION['idNumber'];
$dbloanid = $_SESSION['dbloanid'];

//print_r($_SESSION);

try{
    $balancesql = "SELECT * FROM repayments_view WHERE idNumber = '$idNumber' AND loanid ='$dbloanid'";
    $balanceresult = mysqli_query($conn, $balancesql);

    if (!$balanceresult) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($balanceresult) > 0) {
        $fetch = mysqli_fetch_assoc($balanceresult);
        $LoanTotal = $fetch['LoanTotal'];
        $repaidAmount = $fetch['repaidAmount'];
        $balance = $fetch['balance'];
        // $Approval_date = $fetch['Approval_date'];
    }
    if ($balance <= 0) {
        // Handle the case when the balance is 0
        $updateloansql ="UPDATE loans SET loanstatus = 'Cleared' WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
        $resultupdateloansql = mysqli_query($conn, $updateloansql);
        if ($resultupdateloansql){
            echo "<script>console.log('Your balance is 0. No further actions are required.We have updated the loan status')</script>";
        }
        //echo "Your balance is 0. No further actions are required.";
    } else {
        // Continue with the rest of your code
            // Query to select approval date and penalty from the loans table
            $selectQuery = "SELECT approvaldate, penalty, last_penalty_update FROM loans WHERE F_idNumber = '$idNumber'";
            $result = mysqli_query($conn, $selectQuery);
        
            // Check if the query was successful
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                // Get approval date and penalty from the result
                $ApprovalDate = strtotime($row['approvaldate']);
                $weekselapsed = ceil((time() - $ApprovalDate) / (60 * 60 * 24 * 7)); // Calculate elapsed weeks since achukue loan
                
                //$daysafterdeadline = ceil((time() - $ApprovalDate) / (60 * 60 * 24)); // Calculate elapsed days
 
                // Check if the difference between approval date and current week is greater than 25 weeks
                if ($weekselapsed >= 25) {
                    $checkExistingQuery = "SELECT * FROM defaulters WHERE idNumber = '$idNumber' AND loanid = '$dbloanid'";
                    $existingResult = mysqli_query($conn, $checkExistingQuery);
                
                    if (!$existingResult) {
                        throw new Exception("Error checking existing row: " . mysqli_error($conn));
                    }
                
                    if (mysqli_num_rows($existingResult) > 0) {
                        // A row with the same idNumber and loanid already exists
                        echo "<script>console.log('Record with idNumber $idNumber and loanid $dbloanid already exists in defaulters table.')</script>";
                    } else {
                        // Insert into defaulters table
                        $insertdefaulters = "INSERT INTO defaulters (idNumber, loanid, loanedamount, balance) VALUES ('$idNumber', '$dbloanid', '$LoanTotal', '$balance')";
                        $insertResult = mysqli_query($conn, $insertdefaulters);
                
                        if (!$insertResult) {
                            throw new Exception("Error inserting into defaulters table: " . mysqli_error($conn));
                        }
                
                        // ... (remaining code)
                
                    }
             
                    //this means amepitisha repayment period
                                // Calculate the number of weeks after the 25th week
                                $weeksAfter25Weeks = $weekselapsed - 25;
                                $daysafterdeadline = $weeksAfter25Weeks * 7;
                            // Get the last penalty update date from the database
                            $lastPenaltyUpdate = strtotime($row['last_penalty_update']);
                            // Check if a day has passed since the last penalty update
                            $daysSinceLastUpdate = floor((time() - $lastPenaltyUpdate) / (60 * 60 * 24));
        
                            // Check if a new day has started since the last update
                            if ($daysSinceLastUpdate > 0) {
                                // Calculate the new penalty (increased by 50 for each passing day after the 25th week)
                                $newPenalty = $row['penalty'] + ($daysafterdeadline * 50);

                                // Update the table with the new penalty and the last penalty update date
                                $updateQuery = "UPDATE loans SET penalty = $newPenalty, last_penalty_update = NOW() WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
                                $updateResult = mysqli_query($conn, $updateQuery);
                                }
                                
                                echo'<script>console.log ("A day has not elapsed")</script>';
                        }
}
                    
        
            }
    //fetch the penalty value
    $selectpena ="SELECT penalty FROM loans WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
                    $resultpena = mysqli_query($conn, $selectpena);

                    if ($resultpena) {
                        $rowpena = mysqli_fetch_assoc($resultpena);
                        $penaValue = $rowpena['penalty'];
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }

                    
    
    // Fetch data from repayments table
    $repaymentsQuery = "SELECT * FROM repayment WHERE F_idNumber = '$idNumber' AND F_loanid = '$dbloanid'";
    $repaymentsResult = mysqli_query($conn, $repaymentsQuery);

    if ($repaymentsResult) {

?>
<!DOCTYPE html>
<html>
<head>
        <title>Agriloan-MyBills</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
            body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    header {
      background-color: #287247; /* Green header color */
      padding: 15px;
      text-align: center;
    }
    .date-time {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 17px;
        
    }


    .navbar {
    background-color: rgb(71, 160, 118);
    overflow: hidden;
    }

 /* Style the navigation bar links */
    .navbar a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        margin-left: 20px;
        margin-right: 20px;
    }
    /* Change the color of links on hover */
    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    .navbar a:active,
        .navbar a.active {
            background-color: #2c5e3f;
            color: black;
        }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>
    <body>

    <header>
            <h1>My Bills</h1>
    </header>

    <div class="navbar">

            <a href="home.php"> Home </a>
            <a href="profile.php"> My profile</a>
            <a href="loanapplication.php">Loan Application</b></a>
            <a href="bills.php" class="active">My bills</b></a>
            <a href="loanrepayment.php">Loan Repayment</a>
            <a href="logout.php">Logout </a>
            
          </div>

          <div id="loan_amount">
          <h3>Loan id: <?php echo $dbloanid ?? 0; ?></h3>
          <h3>Loan amount: <?php echo $LoanTotal ?? 0; ?></h3>
          <h3>Repaid amount: <?php echo $repaidAmount ?? 0; ?></h3>
          <h3>Balance: <?php echo $balance ?? 0; ?></h3>
          <h3>Penalty: <?php echo $penaValue ?? 0; ?></h3>
          </div>

          <div>
          <?php
            if (mysqli_num_rows($repaymentsResult) > 0) {
                ?>
                <h2>Your Transactions</h2>
         
         <table border="1">
             <thead>
                 <tr>
                     <th>Repaymentid</th>
                     <th>Mpesa_Receipt_Number</th>
                     <th>PhoneNumber</th>
                     <th>Transaction_date</th>
                     <th>Amount</th>
                     
                 </tr>
             </thead>
             <tbody>
             <?php
                        while ($repaymentRow = mysqli_fetch_assoc($repaymentsResult)) {
                            echo "<tr>";
                            echo "<td>{$repaymentRow['repaymentid']}</td>";
                            echo "<td>{$repaymentRow['MpesaReceiptNumber']}</td>";
                            echo "<td>{$repaymentRow['PhoneNumber']}</td>";
                            echo "<td>{$repaymentRow['transactiondate']}</td>";
                            echo "<td>{$repaymentRow['Amount']}</td>";
                            echo "</tr>";
                        }
                        ?>
             </tbody>
         </table>
         <?php
            } else {
                echo "<p>You have no transactions.</p>";
            }
            ?>
     </div>
    </body>
</html>
<?php
    } else {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    // Handle the exception, you can log or display an error message as needed
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Close the database connection
    if ($conn) {
        mysqli_close($conn);
    }
}
?>
     

