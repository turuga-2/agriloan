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
    <title>FARMERS</title>
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
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #333;
        color: black;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .dt-paging {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .dt-paging a,
    .dt-paging span {
        display: inline-block;
        padding: 10px 15px; /* Increase the padding */
        margin: 0 5px;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        cursor: pointer;
        border-radius: 4px;
        background-color: #fff;
        font-size: 14px; /* Increase the font size */
    }

    .dt-paging a:hover {
        background-color: #f5f5f5;
    }

    .dt-paging .current {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
    }
    .dt-search{
        margin-left: 60%;
    }
    .dt-input{
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        color: inherit;
        margin-left: 3px;
    }
    /* Add additional styles for your table here if needed */
</style>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css"> -->


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
    <style>
        /* Add additional styles for your table here if needed */
        @media print {
            body {
                display: none;
            }

            .table-to-print {
                display: table;
            }
            /* Add black borderlines for better visibility when printing */
        .table-to-print {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000; /* Black border */
            margin-top: 30px;
        }

        .table-to-print th, .table-to-print td {
            border: 1px solid #000; /* Black border */
            padding: 8px;
            text-align: left;
        }

        .table-to-print th {
            background-color: #333;
            color: white;
        }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

    <script>
        function printTable() {
            var printContent = document.getElementById('farmerdetails-table').innerHTML;

            // Create a new window or iframe
            var printWindow = window.open('', '_blank');

            // Populate the new window or iframe with the card content
            printWindow.document.write('<html><head><title>Print</title></head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');

            // Trigger the print dialog in the new window or iframe
            printWindow.print();

            // Close the new window or iframe
            printWindow.close();

         
        }
    </script>
            <script>
                
                function filterTable() {
                var genderFilter = document.getElementById("genderFilter").value;
                var countyFilter = document.getElementById("countyFilter").value;
                var maritalFilter = document.getElementById("maritalFilter").value;
                var employmentFilter = document.getElementById("employmentFilter").value;
                var educationFilter = document.getElementById("educationFilter").value;


                var table = $('#farmerdetails-table').DataTable();

                // Clear existing search
                table.search('').draw();

                // Apply new search based on gender
                if (genderFilter !== 'all') {
                    // table.column(5).search(genderFilter).draw();
                    table.column(5).search('^' + genderFilter + '$', true, false).draw();

                }else {
                    // 'All' selected for county, remove the county filter
                    table.column(5).search('').draw();
                }
                // Apply new search based on employment
                if (employmentFilter !== 'all') {
                    // table.column(5).search(employmentFilter).draw();
                    table.column(9).search('^' + employmentFilter + '$', true, false).draw();

                }else {
                    // 'All' selected for county, remove the county filter
                    table.column(9).search('').draw();
                }
                // Apply new search based on maritalstatus
                if (maritalFilter !== 'all') {
                    // table.column(5).search(genderFilter).draw();
                    table.column(6).search('maritalFilter').draw();
                }else {
                    // 'All' selected for county, remove the county filter
                    table.column(6).search('').draw();
                }

                // Apply new search based on education
                if (educationFilter !== 'all') {
                    // table.column(5).search(educationFilter).draw();
                    table.column(8).search('^' + educationFilter + '$', true, false).draw();

                }else {
                    // 'All' selected for county, remove the county filter
                    table.column(8).search('').draw();
                }

                // Apply new search based on county
                if (countyFilter !== 'all') {
                    table.column(4).search(countyFilter).draw();
                }else {
                    // 'All' selected for county, remove the county filter
                    table.column(4).search('').draw();
                }

                
            }
            
            </script>
     <script>
        $(document).ready(function() {
            //     $('table').dataTable();
            //     columnDefs: [
            //     { targets: [4, 5], orderable: false } // Disable sorting for columns 4 (County) and 5 (Gender)
            // ]
            var table = $('#farmerdetails-table').DataTable({
                "columnDefs": [
                    { "targets": [2, 3, 4, 5, 6, 8, 9], "orderable": false }, // Disable sorting for columns 4 (County) and 5 (Gender)
                    { "targets": '_all', "orderable": true } // Enable sorting for all other columns
                ]
            });

               // $('#dispatchtable').DataTable();
            }); 
    function generateReport() {
        document.querySelector('.generator').style.display = 'block';
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
                toggleModal();
            }
        };
        xhr.open("POST", "../generatefarmersreport.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("columns=" + JSON.stringify(selectedColumns));
    }
    // Define closeModal function
    // Toggle modal using Bootstrap
    function toggleModal() {
        $('#myModal').modal('toggle');
    }

    function customise(elementId) {
    // Show the "generator" div
    var generatorDiv = document.getElementById('generator');
    generatorDiv.style.display = 'block';
}
    

    function printCard(cardId, modalId) {
    // Get the HTML content of the specified card

    // Create a new window or iframe
    var printWindow = window.open('', '_blank');

    // Populate the new window or iframe with the card content
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');

    // Trigger the print dialog in the new window or iframe
    printWindow.print();

    // Close the new window or iframe
    printWindow.close();
    toggleModal()

}

    function closeModal() {
        $('#myModal').modal('hide');
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
                    <a href="farmers.php" class="nav-item nav-link active"><i class="fa fa-th me-2"></i>Farmers</a>
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
                
                <div class="navbar-nav align-items-center ms-auto">
                </div>
            </nav>

            <!-- Navbar End -->
            <div class="align-items-center ms-auto">
                        <div id="card" >
                            <h2>Farmers Data</h2>
                            <table id="farmerdetails-table" class="table table-to-print">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>phoneNumber</th>
                                        <th>Email</th>
                                        <th>County
                                        <select id="countyFilter" onchange="filterTable()">
                                                <option value="all">All</option>
                                                <option value="UasinGishu">UasinGishu</option>
                                                <option value="TransNzoia">TransNzoia</option>
                                            </select>
                                        </th>
                                        <th>
                                            Gender
                                            <select id="genderFilter" onchange="filterTable()">
                                                <option value="all">All</option>
                                                <option value="male">male</option>
                                                <option value="female">female</option>
                                            </select>   
                                        </th>
                                        <th>Marital Status
                                        <select id="maritalFilter" onchange="filterTable()">
                                                <option value="all">All</option>
                                                <option value="single">single</option>
                                                <option value="married">married</option>
                                            </select>
                                        </th>
                                        <th>Dependents</th>
                                        <th>Education Level
                                        <select id="educationFilter" onchange="filterTable()">
                                                <option value="all">All</option>
                                                <option value="graduate">graduate</option>
                                                <option value="notgraduate">notgraduate</option>
                                            </select>
                                        </th>
                                        <th>Employment
                                        <select id="employmentFilter" onchange="filterTable()">
                                                <option value="all">All</option>
                                                <option value="employed">employed</option>
                                                <option value="self-employed">self-employed</option>
                                            </select>
                                        </th>
                                        <th>Income</th>
                                        <!-- <th>Credit History</th> -->
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
                                                echo "<td>" . $row['fname'] ." ".$row['lname']. "</td>";
                                                echo "<td>" . $row['phoneNumber'] . "</td>";
                                                echo "<td>" . $row['email'] . "</td>";
                                                echo "<td>" . $row['county'] . "</td>";
                                                echo "<td>" . $row['gender'] . "</td>";
                                                echo "<td>" . $row['maritalstatus'] . "</td>";
                                                echo "<td>" . $row['dependents'] . "</td>";
                                                echo "<td>" . $row['educationlevel'] . "</td>";
                                                echo "<td>" . $row['employment'] . "</td>";
                                                echo "<td>" . $row['income'] . "</td>";
                                                // echo "<td>" . $row['Credithistory'] . "</td>";
                                                echo "</tr>";

                                                // Add income to total
                                                $totalIncome += $row['income'];
                                            }

                                        } else {
                                            echo "<tr><td colspan='3'>No data found</td></tr>";
                                        }
                                        // // Print total income row
                                        // echo "<tr>";
                                        // echo "<td colspan='13'>Total Income" . $totalIncome ."</td>";
                                        // echo "</tr>";

                                        mysqli_close($conn);
                                        
                                        ?>
                                        
                                        </tbody>
                                        </table>

                                        <button type="button" class="btn btn-primary" onclick="customise(generator)">Customized Report</button>

                                        <button type="button" class="btn btn-primary" onclick="printTable()">Print Table</button>

                                    <div id="generator" style="display: none;">
                                        <form id="columnSelectorForm" action="generate_report.php" method="post">
                                            <label><h4>Select Columns to Generate a Report:</h4></label><br>
                                        <?php
                                        $columns = ["idNumber", "fname", "lname", "phoneNumber", "email", "county", "gender", "maritalstatus", "dependents", "educationlevel", "employment", "income", "Credithistory"];
                                        foreach ($columns as $column) {
                                        echo "<input type='checkbox' name='columns[]' value='$column'>$column<br>";
                                        }
                                        ?>
                                        <br>
                                        <button type="button" class="btn btn-primary" onclick="generateReport()">Generate Report</button>

                                    </form>
                                    </div>
                                        </div>

                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="display: flex; justify-content: space-between;">
                                                        <h5 class="modal-title" id="exampleModalLabel">Generated Report</h5>
                                                        <button type="button" class="close"  onclick="closeModal()" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" id="modalBody">
                                                        <!-- Report content will be dynamically populated here -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary" onclick="printCard('modalBody', 'myModal')">Print Report</button>
                                                    </div>
                                                </div>
                                            </div>
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