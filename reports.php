<?php include "config/databaseconfig.php";
session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
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
            position: absolute;
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
            margin-left: 240px;
            padding: 20px;
        }
        #card {
            display: none;
           
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        #card2 {
            display: none;
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        #card3 {
            display: none;
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table {
            width: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
   

    <script>
        function toggleCard() {
            var card = document.getElementById('card');
            card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        }
        function toggleCard2() {
            var card = document.getElementById('card2');
            card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        }
        function toggleCard3() {
            var card = document.getElementById('card3');
            card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        }
    </script>
    <script>
    function generateReport() {
        var form = document.getElementById("columnSelectorForm");
        var selectedColumns = [];

        // Get the selected columns
        for (var i = 0; i < form.elements.length; i++) {
            var element = form.elements[i];
            if (element.type === "checkbox" && element.checked) {
                selectedColumns.push(element.value);
            }
        }

        // Send an AJAX request to the server with the selected columns
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Update the card with the new report
                document.getElementById("modalBody").innerHTML = xhr.responseText;
                // Show the modal
                $('#myModal').modal('show');
            }
        };
        xhr.open("POST", "generatefarmersreport.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("columns=" + JSON.stringify(selectedColumns));
    }
    // Define closeModal function
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
    document.body.classList.remove('modal-open'); // Remove the modal-open class
    var modalBackdrops = document.getElementsByClassName('modal-backdrop');
    // Remove any existing modal backdrops
    while (modalBackdrops[0]) {
        modalBackdrops[0].parentNode.removeChild(modalBackdrops[0]);
    }
}
    function printCard(cardId, modalId) {
            // Get the HTML content of the specified card
    var printContent = document.getElementById(modalId).innerHTML;

// Store the original body content
var originalContent = document.body.innerHTML;

// Replace the entire body content with the card content
document.body.innerHTML = printContent;

// Trigger the browser's print dialog
window.print();

// Restore the original body content after printing
document.body.innerHTML = originalContent;

// Debugging: Log a message to check if the closeModal function is being called
console.log("Before closing modal");

// Close the modal after printing (assuming you have a function named closeModal)
closeModal(modalId);

// Debugging: Log a message after attempting to close the modal
console.log("After closing modal");
        }
</script>
</head>

<body>
      <header>
            <h1>Reports</h1>
    </header>


    <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Loan Approval</a>
        <a href="logoutadmin.php">Logout</a>
    </div> 

    <div id="content">

        Reports
        <button onclick="toggleCard()">Farmer Details </button>

                <div id="card">
                    <h2>Farmers Data</h2>
                    <table id="farmerdetails-table">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>phoneNumber</th>
                                <th>Email</th>
                                <th>County</th>
                                <th>Gender</th>
                                <th>Marital Status</th>
                                <th>Dependents</th>
                                <th>Education Level</th>
                                <th>Employment</th>
                                <th>Income</th>
                                <!-- <th>Credit History</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PHP code to fetch data from the farmers table in the database -->
                            <?php

                            $sql = "SELECT * FROM farmers";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['idNumber'] . "</td>";
                                    echo "<td>" . $row['fname'] .$row['lname']. "</td>";
                                    echo "<td>" . $row['phoneNumber'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['county'] . "</td>";
                                    echo "<td>" . $row['gender'] . "</td>";
                                    echo "<td>" . $row['maritalstatus'] . "</td>";
                                    echo "<td>" . $row['dependents'] . "</td>";
                                    echo "<td>" . $row['educationlevel'] . "</td>";
                                    echo "<td>" . $row['employment'] . "</td>";
                                    echo "<td>" . $row['income'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No data found</td></tr>";
                            }

                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                    
                    <form id="columnSelectorForm" action="generate_report.php" method="post">
                        <label>Select Columns:</label><br>
                        <?php
                        $columns = ["idNumber", "fname", "lname", "phoneNumber", "email", "county", "gender", "maritalstatus", "dependents", "educationlevel", "employment", "income"];
                        foreach ($columns as $column) {
                            echo "<input type='checkbox' name='columns[]' value='$column'>$column<br>";
                        }
                        ?>
                        <br>
                        <button type="button" onclick="generateReport()">Generate Report</button>
                    </form>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Generated Report</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modalBody">
                                    <!-- Report content will be dynamically populated here -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="printCard('modalBody', 'myModal')">Print Report</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--  -->

    <button onclick="toggleCard3()">Pending Loans </button>
    
        <div id="card3">
                <table>
                    <thead>
                        Pending loans
                        <tr>
                            <th>Loan Id</th>
                            <th>IdNumber</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th>Dependents</th>
                            <th>Education Level</th>
                            <th>Employment</th>
                            <th>Income</th>
                            <th>Loan Amount</th>
                            <th>Loan Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        // Fetch data from the farmers table
                        $sql = "SELECT * FROM farmer_details WHERE loanstatus = 'Pending'";                        $result = mysqli_query($conn, $sql);

                        if ($result === false) {
                            throw new Exception("Error executing the query: " . mysqli_error($conn));
                        }

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['loanid'] . "</td>";
                                echo "<td>" . $row['idNumber'] . "</td>";
                                echo "<td>" . $row['fname'] . "</td>";
                                echo "<td>" . $row['gender'] . "</td>";
                                echo "<td>" . $row['maritalstatus'] . "</td>";
                                echo "<td>" . $row['dependents'] . "</td>";
                                echo "<td>" . $row['educationlevel'] . "</td>";
                                echo "<td>" . $row['employment'] . "</td>";
                                echo "<td>" . $row['income'] . "</td>";
                                echo "<td>" . $row['loaned_amount'] . "</td>";
                                echo "<td>" . $row['loanstatus'] . "</td>";

                                


                                echo "</tr>";
                            }
                        } else {
                            echo "<p>No data found</p>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    mysqli_close($conn);
                    ?>
                    </tbody>
                </table>
        </div> 
        
        
    </div>
    
    

</body>

</html>
