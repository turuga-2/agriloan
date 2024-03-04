<?php 
include "config\databaseconfig.php";
// Check if idNumber is not set in the session
if (!isset($_SESSION['idNumber'])) {
    // Redirect to the login page
    header("Location: farmerlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}

$idNumber = $_SESSION['idNumber'];
?>
<!DOCTYPE html>
<html>
<head>
        <title>Home Page</title>
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
            <h1>Home Page</h1>
    </header>

    
        
        <div class="navbar">

            <a href="home.php"class="active"> Home </a>
            <a href="profile.php"> My profile</a>
            <a href="loanapplication.php">Loan Application</b></a>
            <a href="bills.php">My bills</b></a>
            <a href="loanrepayment.php">Loan Repayment</a>
            <a href="logout.php">Logout </a>
            
          </div>

          <?php

           try {       
    $balancesql = "SELECT balance FROM repayments_view WHERE idNumber = '$idNumber' AND loanid ='$dbloanid'";
    $balanceresult = mysqli_query($conn, $balancesql);

    if (!$balanceresult) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($balanceresult) > 0) {
        $fetch = mysqli_fetch_assoc($balanceresult);
        $balance = $fetch['balance'];
    }
    if ($balance <= 0) {
        // Handle the case when the balance is 0
        $updateloansql ="UPDATE loans SET loanstatus = 'Cleared' WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
        $resultupdateloansql = mysqli_query($conn, $updateloansql);
        if ($resultupdateloansql){
            echo "<script>console.log('Your balance is 0. No further actions are required.We have updated the loan status')</script>";
        }} 
            $sql = "SELECT fname FROM farmers WHERE idNumber = $idNumber";
            $select = mysqli_query($conn, $sql);
        
            if (!$select) {
                throw new Exception("Error executing query: " . mysqli_error($conn));
            }
        
            if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
                $fname = $fetch['fname'];
                echo "<h3>Hello <i>".  $fname ."</i> Welcome to Agriloan </h3>";
            }
                // Query to check if the farmer has a loan id
                $loanCheckQuery = "SELECT loanid, loanstatus, dispatch_status, dispatchdate FROM loans WHERE F_idNumber = '$idNumber' ORDER BY loanid DESC LIMIT 1";
                $loanCheckResult = mysqli_query($conn, $loanCheckQuery);
            
                if (!$loanCheckResult) {
                    throw new Exception("Error executing query: " . mysqli_error($conn));
                }
            
                // Check if the query returned any rows
                if (mysqli_num_rows($loanCheckResult) > 0) {
                    // Fetch the loan id
                    $fetch = mysqli_fetch_assoc($loanCheckResult);
                    $dbloanid = $fetch['loanid'];
                    $_SESSION['dbloanid'] = $dbloanid;
                    $dbloanstatus = $fetch['loanstatus'];
                    $_SESSION['dbloanstatus'] = $dbloanstatus;
                    $dispatch_status = $fetch['dispatch_status'];
                    $dispatchdate = $fetch['dispatchdate'];
            
                    // Continue with your logic or display the loan id
                    echo "<h4>Your loan status for loan id <i>" . $dbloanid . "</i> is <i>" . $dbloanstatus . "</i></h4>";

                    echo "<h4>Your Dispatch status is <i>" . $dispatch_status. "</i> It was dispatched on <i>" . $dispatchdate . "</i></h4>";

                } else {
                    // Echo a message if no loan id exists
                    echo "<h4>You have no loans currently.</h4>";
                }
       ?>
          
       
    </body>
</html>
<?php
} catch (Exception $e) {
    // Handle the exception, you can log or display an error message as needed
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    if ($conn) {
        mysqli_close($conn);
    }
}

?>