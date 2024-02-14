<?php include "config/databaseconfig.php";
session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #9da8a2; /* Green header color */
            padding: 15px;
            text-align: center;
          }

        #sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            left: 0;
            background-color: #333;
            padding-top: 20px;
        }

        #sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        #sidebar a:hover {
            background-color: #555;
        }

        #content {
            margin-left: 500px;
            padding: 20px;
        }
        #loanform{
            margin-left: 500px;
            padding: 20px;
        }
        #detailsContainer {
            
            background-color: pink;
        }
        
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
      <header>
            <h1>Loan Approval </h1>
    </header>


    <!-- <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="registeration.php">Register agrodealer</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Loan Approval</a>
        <a href="logoutadmin.php">Logout</a>
    </div> -->
<div class="content">


    <!-- HTML form with a button -->
        <form id="loanForm">
        <h1>Fetch Farmer Details</h1>

        <label for="idNumber">Enter Farmer's ID Number:</label>
            <input type="text" id="idNumber" placeholder="Enter ID Number" required>
            <button type="submit">Get Details</button>

        <!-- <button type="button" onclick="predictLoan()">Predict Loan</button>-->
        <button type="button" onclick="updateDetailsContainer()">Show farmer details</button> 

        </form>


        <!-- Display retrieved details -->
        <div id="detailsContainer" >
        <h2>Farmer Details</h2>
        <button type="button" onclick="updateDetailsContainer()">Show farmer details</button>

        
        </div>
</div>
<script>
  function fetchDetailsAndPredictLoan(event) {
    event.preventDefault();

    var idNumber = $('#idNumber').val();

    $.ajax({
        url: 'fetchfarmerdetails.php',
        type: 'POST',
        data: { idNumber: idNumber },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                updateDetailsContainer(response.data);
            } else {
                console.error('Error fetching farmer details:', response.message);
            }
        },
        error: function() {
            console.error('AJAX request to fetchfarmerdetails.php failed');
        }
    });
}

// Update your updateDetailsContainer function
function updateDetailsContainer(data) {
    var detailsContainer = $('#detailsContainer');
    detailsContainer.html('<h2>Farmer Details</h2>');
    
    // Display the fetched data in the container
    if (data) {
        detailsContainer.append('<p>idNumber: ' + data.idNumber + '</p>');
        detailsContainer.append('<p>fname: ' + data.fname + '</p>');
        // Add more details as needed
    } else {
        detailsContainer.append('<p>No details found for the given ID number</p>');
    }

    // Show the details container
    toggleDetailsContainer();
}

// function predictLoan(farmerData) {
//     // Use farmerData in place of the hardcoded input_data
//     // You can access the fields like farmerData.Gender, farmerData.Married, etc.
//     // Perform your loan prediction logic here
//     // ...
// }

// // Example: Call fetchDetailsAndPredictLoan when the button is clicked
// $('#predictLoanBtn').click(function() {
//     fetchDetailsAndPredictLoan();
// });

</script>
    


</body>

</html>
<?php
    $idNumber = $_SESSION['idNumber'];
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM farmers WHERE idNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fetch = $result->fetch_assoc();}

?>
