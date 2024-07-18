<?php
include "../config/databaseconfig.php";

// Function to get farmer gender data
function getFarmerGenderData($conn) {
    $sql = "SELECT gender, COUNT(*) as Count FROM farmers GROUP BY gender";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['gender']] = $row['Count'];
    }

    return $data;
}

// Get farmer gender data
$farmerGenderData = getFarmerGenderData($conn);

// Function to get farmer county data
function getFarmerCountyData($conn) {
    $sql = "SELECT county, COUNT(*) as Count FROM farmers GROUP BY county";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['county']] = $row['Count'];
    }

    return $data;
}

// Get farmer county data
$farmerCountyData = getFarmerCountyData($conn);

// Function to get loan status data
function getLoanStatusData($conn) {
    $sql = "SELECT loanstatus, COUNT(*) as Count FROM loans GROUP BY loanstatus";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['loanstatus']] = $row['Count'];
    }

    return $data;
}

// Get loan status data
$loanStatusData = getLoanStatusData($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                <a href="index.html" class="navbar-brand mx-4 mb-3">
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
                <a href="home.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="farmers.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Farmers</a>
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
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                
                
            </nav>
            <!-- Navbar End -->


            <!-- Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Farmers based on Gender</h6>
                            <canvas id="genderChart"></canvas>
                            <!-- <canvas id="line-chart"></canvas> -->
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Farmers based on County</h6>
                            <canvas id="countyChart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Loans</h6>
                            <canvas id="loanStatusChart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Multiple Bar Chart</h6>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <!-- <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Pie Chart</h6>
                            <canvas id="pie-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Doughnut Chart</h6>
                            <canvas id="doughnut-chart"></canvas>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- Chart End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="../HighTechIT-1.0.0/index.html">Agriloan</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <script>
    // Chart for farmer gender
    var genderData = <?php echo json_encode($farmerGenderData); ?>;
    var genderLabels = Object.keys(genderData);
    var genderValues = Object.values(genderData);

    var genderChartCanvas = document.getElementById('genderChart').getContext('2d');
    var genderChart = new Chart(genderChartCanvas, {
        type: 'pie',
        data: {
            labels: genderLabels,
            datasets: [{
                data: genderValues,
                backgroundColor: ['#e83e8c', '#007bff'] // Customize colors as needed
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Farmer Gender Distribution'
            }
        }
    });

    // Chart for farmer county
    var countyData = <?php echo json_encode($farmerCountyData); ?>;
    var countyLabels = Object.keys(countyData);
    var countyValues = Object.values(countyData);

    var countyChartCanvas = document.getElementById('countyChart').getContext('2d');
    var countyChart = new Chart(countyChartCanvas, {
        type: 'bar',
        data: {
            labels: countyLabels,
            datasets: [{
                label: 'Number of Records',
                data: countyValues,
                backgroundColor: '#007bff' // Customize colors as needed
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Number of Records by County'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Records'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'County'
                    }
                }
            }
        }
    });
</script>
<script>
    // Chart for loan status
    var loanStatusData = <?php echo json_encode($loanStatusData); ?>;
    var loanStatusLabels = Object.keys(loanStatusData);
    var loanStatusValues = Object.values(loanStatusData);

    // Define different colors for each bar
    var barColors = ['#007bff', '#e83e8c', '#28a745', '#ffc107', '#dc3545', '#6f42c1'];

    var loanStatusChartCanvas = document.getElementById('loanStatusChart').getContext('2d');
    var loanStatusChart = new Chart(loanStatusChartCanvas, {
        type: 'bar',
        data: {
            labels: loanStatusLabels,
            datasets: [{
                label: 'Number of Loans',
                data: loanStatusValues,
                backgroundColor: barColors // Use the defined array of colors
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Number of Loans by Status'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Loans'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Loan Status'
                    }
                }
            }
        }
    });
    </script>

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