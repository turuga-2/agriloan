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
            margin-left: 750px;
            padding: 40px;
        }
        #loanform{
            margin-left: 500px;
            padding: 20px;
        }
        #detailsContainer {
            
            background-color: pink;
        }
        #detailsTable{
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            border-collapse: collapse;
            margin-top: 20px;
        }
         #detailsTable th,
         #detailsTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

         #detailsTable th {
            background-color: #333;
            color: white;
        }

        /* Style for delete button */
        .Btn {
            background-color: #e44d26;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
      <header>
            <h1>Loan Approval </h1>
    </header>


    <!-- <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Loan Approval</a>
        <a href="logoutadmin.php">Logout</a>
    </div>  -->
<div class="content">
        <button type="button" onclick="predictLoan(responseData)">Predict Loan</button>
        </form>


        <!-- Display retrieved details 
        <div id="detailsContainer" >-->
        <table id="detailsTable">
                <thead>
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
                        $sql = "SELECT * FROM farmer_details";
                        $result = mysqli_query($conn, $sql);

                        if ($result === false) {
                            throw new Exception("Error executing the query: " . mysqli_error($conn));
                        }

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr id='row_" . $row['loanid'] . "'>";
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

                                echo "<td><button class='Btn' onclick='fetchDetailsAndPredictLoan(\"" . $row['loanid'] . "\")'>Get Details</button></td>";
                                echo "<td><button class='Btn'onclick='predictLoan(responseData)'> Predict Loan </button> </td>";

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
        <h2>Farmer Details</h2>
        
        <div id="statusresultContainer">

        </div>

        <div id="resultContainer">

</div>
</div>

<script>
    // Define the toggleDetailsContainer function
    let responseData
    function toggleDetailsContainer() {
        $('#detailsContainer').toggle();
    }
    
  function fetchDetailsAndPredictLoan(loanid) {
    event.preventDefault();

    

    $.ajax({
        url: 'fetchfarmerdetails.php',
        type: 'POST',
        data: { loanid: loanid },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                updateDetailsContainer(response.data);
                responseData = response.data
                console.log('resoonseswwas', responseData)
            } else {
                console.error('Error fetching farmer details:', response.message);
            }
        },
        error: function() {
            console.error('AJAX request to fetchfarmerdetails.php failed');
        }
    });
    return false; // Prevent the default form submission behavior
}

// Update your updateDetailsContainer function
function updateDetailsContainer(data) {
    if (data) {
        Swal.fire({
            title: 'Farmer Details',
            html:
                '<p><strong>Loanid:</strong> ' + data.loanid + '</p>' +
                '<p><strong>IdNumber:</strong> ' + data.idNumber + '</p>' +
                '<p><strong>Name:</strong> ' + data.fname + '</p>' +
                '<p><strong>Gender:</strong> ' + data.gender + '</p>' +
                '<p><strong>Marital Status:</strong> ' + data.maritalstatus + '</p>' +
                '<p><strong>Number of Dependents:</strong> ' + data.dependents + '</p>' +
                '<p><strong>Education Level:</strong> ' + data.educationlevel + '</p>' +
                '<p><strong>Employment:</strong> ' + data.employment + '</p>' +
                '<p><strong>Income:</strong> ' + data.income + '</p>' +
                '<p><strong>Loaned amount:</strong> ' + data.loaned_amount + '</p>' +
                '<p><strong>Loan status:</strong> ' + data.loanstatus + '</p>',
            icon: 'info'
        });
    } else {
        Swal.fire({
            title: 'No details found',
            text: 'No details found for the given ID number',
            icon: 'warning'
        });
    }
    
}

function predictLoan(response) {
    console.log('redpons', response)
    if (response) {
        // Extract relevant data for loan prediction
        var input_data = {
            'Gender': response.gender === 'male' ? '1' : '0',
            'Married': response.maritalstatus === 'married' ? '1' : '0',
            'Dependents': response.dependents,
            'Education': response.educationlevel === 'graduate' ? '1' : '0',
            'ApplicantIncome': response.income,
            // 'LoanAmount': response.loanAmount === response.loanAmount ? response.loanAmount : '5000',  // Add the correct property name for loan amount
            // 'Loan_Amount_Term': response.loanTerm === response.Loan_Amount_Term ? response.Loan_Amount_Term : '360',  // Add the correct property name for loan term
            'LoanAmount': response.loaned_amount, 
            'Loan_Amount_Term': '360',
            'Credit_History': response.creditHistory === '1' ? 1 : 0
        };
        console.log('inpuuttt', input_data)
        // Convert data to JSON format
        var json_data = JSON.stringify(input_data);

        // API endpoint
        var api_url = 'http://127.0.0.1:5000/predict_loan_approval';

        // Make a POST request using jQuery
        $.ajax({
            type: 'POST',
            url: api_url,
            contentType: 'application/json',
            data: json_data,
            success: function(predictionResponse) {
                console.log('Loan Prediction Result:',predictionResponse.prediction)
                // Display input data
                var resultContainer = $('#resultContainer');
                resultContainer.html('Input Data: <pre>' + JSON.stringify(input_data, null, 2) + '</pre>');

                // Display prediction result using SweetAlert2
if (predictionResponse && predictionResponse.prediction !== undefined) {
    // Use SweetAlert2 to show the prediction result
    Swal.fire({
        title: 'Loan Prediction Result',
        text: 'Prediction: ' + predictionResponse.prediction,
        icon: 'info'
    });
} else {
    // Show an error message if the prediction result is not available
    Swal.fire({
        title: 'Error',
        text: 'Error in API response',
        icon: 'error'
    });
}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                resultContainer.html('Error in making API request: ' + textStatus + ' - ' + errorThrown);
            }
        });
    } else {
        console.error('Invalid response from fetchfarmerdetails.php');
    }
}

</script>
    


</body>

</html>

