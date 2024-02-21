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
            width: 150px;
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
        
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
      <header>
            <h1>Loan Approval </h1>
    </header>


    <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Loan Approval</a>
        <a href="logoutadmin.php">Logout</a>
    </div> 
<div class="content">


    <!-- HTML form with a button -->
        <form id="loanForm"onsubmit="return fetchDetailsAndPredictLoan(event)">
        <h1>Fetch Farmer Details</h1>

        <label for="idNumber">Enter Farmer's ID Number:</label>
            <input type="text" id="idNumber" placeholder="Enter ID Number" required>
            <button type="submit" onclick="updateDetailsContainer()">Get Details</button>

        <button type="button" onclick="predictLoan(responseData)">Predict Loan</button>
        </form>


        <!-- Display retrieved details -->
        <div id="detailsContainer" >
        <h2>Farmer Details</h2>
        
        <div id="statusresultContainer">

        </div>
        
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
    var detailsContainer = $('#detailsContainer');
    detailsContainer.html('<h2>Farmer Details</h2>');
    
    // Display the fetched data in the container
    if (data) {
        detailsContainer.append('<p>IdNumber: ' + data.idNumber + '</p>');
        detailsContainer.append('<p>Name: ' + data.fname + data.lname + '</p>');
        detailsContainer.append('<p>Phone Number: ' + data.phoneNumber + '</p>');
        detailsContainer.append('<p>Email Address: ' + data.email + '</p>');
        detailsContainer.append('<p>County: ' + data.county + '</p>');
        detailsContainer.append('<p>Gender: ' + data.gender + '</p>');
        detailsContainer.append('<p>Marital Status: ' + data.maritalstatus + '</p>');
        detailsContainer.append('<p>Number of Dependents: ' + data.dependents + '</p>');
        detailsContainer.append('<p>Education Level: ' + data.educationlevel + '</p>');
        detailsContainer.append('<p>Employment: ' + data.employment + '</p>');
        detailsContainer.append('<p>Income: ' + data.income + '</p>');



        // Add more details as `needed`
    } else {
        detailsContainer.append('<p>No details found for the given ID number</p>');
    }

    // Show the details container
    toggleDetailsContainer();
}

function predictLoan(response) {
    console.log('redpons', response)
    if (response) {
        // Extract relevant data for loan prediction
        var input_data = {
            'Gender': response.gender === 'male' ? '1' : '0',
            'Married': response.maritalstatus === 'Married' ? '1' : '0',
            'Dependents': response.dependents,
            'Education': response.educationlevel === 'Graduate' ? '1' : '0',
            'ApplicantIncome': response.income,
            // 'LoanAmount': response.loanAmount === response.loanAmount ? response.loanAmount : '5000',  // Add the correct property name for loan amount
            // 'Loan_Amount_Term': response.loanTerm === response.Loan_Amount_Term ? response.Loan_Amount_Term : '360',  // Add the correct property name for loan term
            'LoanAmount': '500000', 
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

                // Display prediction result
                if (predictionResponse && predictionResponse.prediction !== undefined) {
                    resultContainer.append('Loan Prediction Result: ' + predictionResponse.prediction);
                } else {
                    resultContainer.append('Error in API response');
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

