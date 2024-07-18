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
    <title>PENDING LOANS</title>
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script>
            $(document).ready(function() {
                $('table').dataTable();

               // $('#dispatchtable').DataTable();
            }); 
            </script>

    <script>
    function printCard(cardId) {
    // Get the reference to the element
    var cardElement = document.getElementById(cardId);

    // Create a hidden iframe
    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);

    // Include necessary styles for printing
    var styles = '<style>';
    styles += 'body { background-color: #fff; }';
    styles += 'table { border-collapse: collapse; width: 100%; margin: 10px 0; }';
    styles += 'th, td { border: 1px solid #000; padding: 8px; }';
    styles += 'th { background-color: #333; color: #fff; }';
    styles += '</style>';

    // Write the HTML content with styles to the iframe
    iframe.contentDocument.write('<html><head><title>Print</title></head><body>');
    iframe.contentDocument.write('<style>' + styles + '</style>');
    iframe.contentDocument.write('<table>');
    
    // Clone the card element and append it to the iframe
    var clone = cardElement.cloneNode(true);
    iframe.contentDocument.body.appendChild(clone);
    
    iframe.contentDocument.write('</table></body></html>');

    // Trigger the print dialog in the iframe
    iframe.contentWindow.print();

    // Remove the iframe after printing
    document.body.removeChild(iframe);
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
                    <a href="farmers.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Farmers</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Loans</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="loanreport.php" class="dropdown-item">All loans</a>
                            <a href="pendingloans.php" class="dropdown-item active">Pending Loans</a>
                            <a href="approvedloans.php" class="dropdown-item">Approved Loans</a>
                            <a href="deniedloans.php" class="dropdown-item">Denied Loans</a>

                        </div>
                    </div>
                    
                    <a href="approveloans.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Approve Loans</a>
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
        <div class="content">
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
            <div class="align-items-center ms-auto">
                        
                            <h2>Pending loans</h2>
                            <table id="pendingloans" class="table">
                                <thead>
                                    <tr>
                                        <th>Loan ID</th>
                                        <th>ID Number</th>
                                        <th>No.of Acres</th>
                                        <th>Loan Total</th>
                                        <th>Interest</th>
                                        <th>Loan Status</th>
                                        <th>Aplication date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- PHP code to fetch data from the farmers table in the database -->
                                        <?php
                                        // Initialize variables to store totals
                                        $totalInterest = 0;
                                        $totalLoanTotal = 0;
                                        $totalAcres = 0;

                                        $sql = "SELECT * FROM loans WHERE loanstatus='Pending'";
                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['loanid'] . "</td>";
                                                echo "<td>" . $row['F_idNumber']. "</td>";
                                                echo "<td>" . $row['acreage'] . "</td>";
                                                echo "<td>" . $row['grandtotal'] . "</td>";
                                                echo "<td>" . $row['interest'] . "</td>";
                                                echo "<td>" . $row['loanstatus'] . "</td>";
                                                echo "<td>" . $row['applicationdate'] . "</td>";
                                                echo "</tr>";
                                                // Accumulate totals
                                                $totalInterest += $row['interest'];
                                                $totalLoanTotal += $row['grandtotal'];
                                                $totalAcres += $row['acreage'];
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No data found</td></tr>";
                                        }

                                        mysqli_close($conn);
                                        ?>
                                         <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>Total Acres: <br><?php echo $totalAcres; ?></td>
                                                <td>Total Loan Total:<br> <?php echo $totalLoanTotal; ?></td>
                                                <td>Total Interest:<br> <?php echo $totalInterest; ?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                        </tbody>
                                        </table>
                            
                                        <button type="button" class="btn btn-primary" onclick="printCard('pendingloans')">Print Report</button>


            


            

            
            </div>
        </div>
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
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