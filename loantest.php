<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Prediction App</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<!-- HTML form with a button -->
<form id="loanForm">
    <button type="button" onclick="predictLoan()">Predict Loan</button>
</form>

<!-- Container to display results -->
<div id="resultContainer"></div>

<script>
function predictLoan() {
    // Input features for loan prediction
    var input_data = {
        'Gender': '1',
        'Married': '0',
        'Dependents': '0',
        'Education': '1',
        'ApplicantIncome': 5000,
        'LoanAmount': 200,
        'Loan_Amount_Term': 360,
        'Credit_History': 1
    };

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
        success: function(response) {
            // Display input data
            $('#resultContainer').html('Input Data: <pre>' + JSON.stringify(input_data, null, 2) + '</pre>');

            // Display prediction result
            if (response && response.prediction !== undefined) {
                $('#resultContainer').append('Loan Prediction Result: ' + response.prediction);
            } else {
                $('#resultContainer').append('Error in API response');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#resultContainer').html('Error in making API request: ' + textStatus + ' - ' + errorThrown);
        }
    });
}
</script>

</body>
</html>
