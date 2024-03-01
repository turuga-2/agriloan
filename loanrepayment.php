<?php 
//include "processloan.php";
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
    $sql = "SELECT phoneNumber FROM farmers WHERE idNumber = $idNumber";
    $result=  mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    $statussql = "SELECT * FROM loans WHERE F_idNumber = '$idNumber' AND loanid ='$dbloanid'";
    $statusselect = mysqli_query($conn, $statussql);

    if (!$statusselect) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($statusselect) > 0) {
        $fetch = mysqli_fetch_assoc($statusselect);
        $interest = $fetch['interest'];
        $grandtotal = $fetch['grandtotal'];
    }


    if (mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);
        $phoneNumber = $fetch['phoneNumber'];
    }
}catch (Exception $e) {
    // Handle the exception, you can log or display an error message as needed
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    if ($conn) {
        mysqli_close($conn);
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Loan Repayment- Agriloan</title>
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
        .container{
            margin-left: 30%;
            align-items: center;
            justify-content: space-between;
            display: flexbox;
        }
        .choices {
            margin-top: 20px;
        }

        .weekly, .monthly {
            padding: 10px;
            margin: 5px;
            cursor: pointer;
            border: none;
            outline: none;
        }

        .weekly.selected, .monthly.selected {
            background-color: #4caf50; /* Green color for selected button */
            color: white;
        }

        .bundle-info {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            display: none;
        }
    
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <header>
            <h1>Loan Repayment </h1>
          </header>
          <div class="date-time">
            <?php
                echo"Today's date:",date("d-m-y, h:m:s")

            ?>

    </div>
       
        
        <div class="navbar">

        <a href="home.php"> Home </a>
        <a href="profile.php"> My profile</a>
        <a href="loanapplication.php">Loan Application</a>
        <a href="bills.php">My bills</b></a>
        <a href="loanrepayment.php" class="active">Loan Repayment</a>
        <a href="logout.php">Logout </a>
            
          </div>
          <div class="container">
            <p>You are required to start by paying off your interest until the 
                5th month and on the 6th month you will be required to repay back the full loaned amount</p>
               
                Your active loan is loanid number <?php echo $dbloanid;?>
            <p>Your loan amount is <?php echo $grandtotal;?></p>
            <p>Your interest to be repaid is <?php echo $interest;?></p>
          
            <form method="post" id="paymentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
           <p>This Safaricom number will be used to pay </p>
           <br>
           <p>You will be prompted to make payment</p>
           
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo $fetch['phoneNumber']; ?>" oninput="phoneNumbers(this)" required>

                <p>Please enter the Amount to pay </p>
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" placeholder="amount" oninput="restrictInputToNumbers(this);" required>
                <input type="submit" value="Make Payment">
           </form>
           <button onclick="processtransaction()">view my transactions</button>
          </div>
          
          <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
           <script>
            function restrictInputToNumbers(inputField) {
            // Replace non-numeric characters with an empty string
            inputField.value = inputField.value.replace(/[^0-9]/g, '');
            }

            function phoneNumbers(inputField) {
            // Remove non-numeric characters using a regular expression
            inputField.value = inputField.value.replace(/[^0-9]/g, '');

            // Optionally, you can trim the input to only keep the first 8 characters
            inputField.value = inputField.value.slice(0, 12);
        }
        $(document).ready(function() {
        $('#paymentForm').submit(function(event) {
            event.preventDefault();

            // Get form data
            const phoneNumber = $('#phoneNumber').val();
            const amount = $('#amount').val();
            const loanid = <?php echo $dbloanid;?>;
            const idNumber = <?php echo $idNumber?>;
console.log(loanid,idNumber);

            $.ajax({
                url: 'daraja/stkpush.php',
                method: 'POST',
                data: {
                    phoneNumber: phoneNumber,
                    amount: amount,
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                    icon: 'success',
                    title: 'Request accepted for processing',
                    text: 'Please enter your mpesa pin when prompted', // You can customize this based on your response data
                });
                },
                error: function() {
                    console.error('Error sending detailsto stkpush');
                }
            });
            
    
            
            
        });
    });
    function processtransaction(){
        const phoneNumber = $('#phoneNumber').val();
            const amount = $('#amount').val();
        $.ajax({
                url: 'transactionprocessing.php',
                method: 'POST',
                data: {
                    phoneNumber: phoneNumber,
                    amount: amount,
                },
                success: function(response) {
                    console.log(response);
                   
                },
                error: function() {
                    console.error('Error sending details to transaction');
                }
            });
    }
        </script>

        
        
          

    </body>
</html>


