<?php include "../config/databaseconfig.php";
if (!isset($_SESSION['idNumberadmin'])) {
    // Redirect to the login page
    header("Location: ../adminlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>APPROVE LOANS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
    table {
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        border-collapse: collapse;
        margin-top: 30px;
        width: 100%; /* Make the table full width */
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        color: #fff;
    }
    thead{
        background-color: #05234a; /* Header background color */

    }

    /* Add borders between columns */
    th:not(:last-child),
    td:not(:last-child) {
        border-right: 1px solid black;
    }

    /* Add hover effect on rows */
    tbody tr:hover {
        background-color: #f5f5f5;
    }
    /* Style for delete button */
    .Btn {
            background-color: #009CFF;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }
        .Btnd {
            background-color: #808080;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }
        .Btnc {
            background-color: #e44d26;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }
    </style>
        

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    // Define the toggleDetailsContainer function
    let responseData
    function toggleDetailsContainer() {
        $('#detailsContainer').toggle();
    }
    
  function fetchDetailsAndPredictLoan(loanid) {
    event.preventDefault();

    

    $.ajax({
        url: '../fetchfarmerdetails.php',
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
        // Create a modal container
        const modalContainer = document.createElement('div');
        modalContainer.className = 'modal fade';
        modalContainer.id = 'detailsModal';
        modalContainer.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Farmer Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Loanid:</strong> ${data.loanid}</p>
                        <p><strong>IdNumber:</strong> ${data.idNumber}</p>
                        <p><strong>Name:</strong> ${data.fname}</p>
                        <p><strong>Gender:</strong> ${data.gender}</p>
                        <p><strong>Marital Status:</strong> ${data.maritalstatus}</p>
                        <p><strong>Number of Dependents:</strong> ${data.dependents}</p>
                        <p><strong>Education Level:</strong> ${data.educationlevel}</p>
                        <p><strong>Employment:</strong> ${data.employment}</p>
                        <p><strong>Income:</strong> ${data.income}</p>
                        <p><strong>Loaned amount:</strong> ${data.loaned_amount}</p>
                        <p><strong>Credit history:</strong> ${data.Credithistory}</p>
                        <p><strong>Loan status:</strong> ${data.loanstatus}</p>
                    </div>
                    <div class="modal-footer">
                    <button class='Btn'onclick='predictLoan(responseData)'> Predict Eligibility </button>
                    </div>
                </div>
            </div>
        `;

        // Append the modal container to the body
        document.body.appendChild(modalContainer);

        // Show the modal
        $('#detailsModal').modal('show');
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
            'Credit_History': response.Credithistory === '1' ? 1 : 0
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
function approve (loanid){
    Swal.fire({
            title: 'Are you sure?',
            text: 'You want to approve this loan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a PHP script to handle the deletion
                $.ajax({
                    type: 'POST',
                    url: '../approval.php', // Adjust the file name accordingly
                    data: { loanid: loanid },
                    success: function (response) {
                        console.log(response);
                        // Handle the response (e.g., show a success message)
                        Swal.fire({
                            title: 'Approved!',
                            text: 'The Loan has been approved.',
                            icon: 'success'
                        });
                        
                        $(`#row_${loanid}`).remove();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
}
function deny (loanid){
    Swal.fire({
            title: 'Are you sure?',
            text: 'You want to deny this loan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, deny it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a PHP script to handle the deletion
                $.ajax({
                    type: 'POST',
                    url: '../deny.php', // Adjust the file name accordingly
                    data: { loanid: loanid },
                    success: function (response) {
                        // Handle the response (e.g., show a success message)
                        Swal.fire({
                            title: 'Denied!',
                            text: 'The Loan has been denied.',
                            icon: 'success'
                        });
                        
                        $(`#row_${loanid}`).remove();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
}

</script>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="home.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">Dashboard</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                    </div>
                    <div class="ms-3">
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="home.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="farmers.php" class="nav-item nav-link "><i class="fa fa-th me-2"></i>Farmers</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Loans</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="loanreport.php" class="dropdown-item">All loans</a>
                            <a href="pendingloans.php" class="dropdown-item">Pending Loans</a>
                            <a href="approvedloans.php" class="dropdown-item">Approved Loans</a>
                            <a href="deniedloans.php" class="dropdown-item">Denied Loans</a>

                        </div>
                    </div>
                    
                    <a href="approveloans.php" class="nav-item nav-link active"><i class="fa fa-keyboard me-2"></i>Approve Loans</a>
                    <a href="dispatch.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Dispatch Goods</a>
                    <a href="dispatched.php" class="nav-item nav-link "><i class="fa fa-table me-2"></i>Dispatched Loans</a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Products</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="viewproducts.php" class="dropdown-item">View Products</a>
                            <a href="addproduct.php" class="dropdown-item">Add product</a>
                            <a href="removeproduct.php" class="dropdown-item">Remove product</a>
                        </div>
                    </div>
                    <a href="logout.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Logout</a>

                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content" style="width: 100%;">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="home.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
            <!-- Navbar End -->
            <div class="align-items-center ms-auto ">
            <!-- <div class="table-responsive"> -->
            <table id="myTable" class="table-responsive">
                <thead>
                <h2>Pending loans</h2>
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
                        <th>Credit_History</th>
                        <th>Loan Status</th>
                        <th>Application Date</th>
                        <th>Pending Days</th>
                        <th colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function calculateDaysDifference($applicationDateString) {
                        // Convert application date string to timestamp
                        $applicationTimestamp = strtotime($applicationDateString);
                    
                        // Get the current timestamp
                        $currentTimestamp = time();
                    
                        // Calculate the difference in seconds
                        $differenceInSeconds = $currentTimestamp - $applicationTimestamp;
                    
                        // Convert seconds to days
                        $differenceInDays = ceil($differenceInSeconds / (60 * 60 * 24));
                    
                        return $differenceInDays;
                    }
                    try {
                        // Fetch data from the farmers table
                        $sql = "SELECT * FROM farmer_details WHERE loanstatus = 'Pending'";                        $result = mysqli_query($conn, $sql);

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
                                echo "<td>" . $row['Credithistory'] . "</td>";
                                echo "<td>" . $row['loanstatus'] . "</td>";
                                
                                // Calculate and display the number of days
                                $daysDifference = calculateDaysDifference($row['Application date']);
                                echo "<td>" . $row['Application date'] . "</td>";
                                echo "<td>" . $daysDifference . "</td>";

                                

                                echo "<td><button class='Btnd' onclick='fetchDetailsAndPredictLoan(\"" . $row['loanid'] . "\")'>Check Loan Eligibility</button></td>";
                                echo "<td><button class='Btn' onclick='approve(\"" . $row['loanid'] . "\")'> Approve </button> </td>";
                                echo "<td><button class='Btnc' onclick='deny(\"" . $row['loanid'] . "\")'> Deny </button> </td>";


                                echo "</tr>";
                            }
                            
                           

                        } else {
                            echo "<p>No data found</p>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    //mysqli_close($conn);
                    ?>
                </tbody>
            </table>
                </div>


                    


            

            

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>