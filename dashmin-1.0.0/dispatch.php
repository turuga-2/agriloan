<?php
include "../config/databaseconfig.php";
if (!isset($_SESSION['idNumberadmin'])) {
    // Redirect to the login page
    header("Location: ../adminlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}
// Your SQL query to select data from the "loans" table where loanstatus is "Active"
$select = "SELECT * FROM loans WHERE loanstatus = 'Active' AND dispatch_status = 'Pending'";
$result = mysqli_query($conn, $select);

// Check if the query was successful
if ($result) {
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DISPATCH</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: pink; /* Header background color */
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
    
        .Btn {
            background-color: #e44d26;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        
    </style>
        <script>
           src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" 
</script>
        <script> src="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css"</script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script>
            $(document).ready(function() {
                $('table').dataTable();

               // $('#dispatchtable').DataTable();
            }); 
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
                    
                    <a href="approveloans.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Approve Loans</a>
                    
                    <a href="dispatch.php" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Dispatch Goods</a>
                    <a href="dispatched.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Dispatched Loans</a>

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
            <!-- <div class="navbar-nav align-items-center ms-auto"> -->
                <!-- Create a table to display the results -->
                <h2>Dispatch</h2>
    <table border="1" class="table" style="padding: 20px;">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>F_idNumber</th>
                <th>Loan Amount</th>
                <th>Loan status</th>
                <th>Application Date</th>
                <th>Approval Date</th>
                <th>Dispatch status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display them in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr id='row_" . $row['loanid'] . "'>";
                echo "<td>" . $row['loanid'] . "</td>"; 
                echo "<td>" . $row['F_idNumber'] . "</td>";
                echo "<td>" . $row['grandtotal'] . "</td>";
                echo "<td>" . $row['loanstatus'] . "</td>";
                echo "<td>" . $row['applicationdate'] . "</td>"; 
                echo "<td>" . $row['approvaldate'] . "</td>";
                echo "<td>" . $row['dispatch_status'] . "</td>";
                echo "<td><button class='Btn' onclick='dispatch(\"" . $row['loanid'] . "\")'> Dispatch </button> </td>";
                echo "</tr>";
            }
        } else {
            // If the query was not successful, display an error message
            echo "Error executing query: " . mysqli_error($conn);
        }
        
        // Close the database connection
        mysqli_close($conn);
            ?>
        </tbody>
    </table>
    </div>
    
    

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script>
    function dispatch (loanid){
    Swal.fire({
            title: 'Are you sure?',
            text: 'You want to dispatch this loan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, dispatch it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a PHP script to handle the deletion
                $.ajax({
                    type: 'POST',
                    url: '../dispatching.php', // Adjust the file name accordingly
                    data: { loanid: loanid },
                    success: function (response) {
                        // Handle the response (e.g., show a success message)
                        Swal.fire({
                            title: 'Dispatch!',
                            text: 'The goods have been dispatched to the farmer.',
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
    <!-- JavaScript Libraries -->
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