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
    <title>Add products</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    

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
                    <a href="dispatch.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Dispatch Goods</a>
                    <a href="dispatched.php" class="nav-item nav-link "><i class="fa fa-table me-2"></i>Dispatched Loans</a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Products</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="viewproducts.php" class="dropdown-item">View Products</a>
                            <a href="addproduct.php" class="dropdown-item active">Add product</a>
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
            <h2>Add a New Product</h2>
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
                
                <label for="productName">Product Name:</label>
                <input type="text" name="productName" required><br>

                <label for="productImage">Upload Image:</label>
                <input type="file" name="productImage" accept="image/*" required><br>

                <label for="category">Select Category:</label>
                <select name="category" required>
                    <option value="seeds">seeds</option>
                    <option value="fertiliser">fertiliser</option>
                    <option value="agrochemicals">agrochemicals</option>
                    <!-- Add more categories as needed -->
                </select><br>

                <label for="price">Price (ksh):</label>
                <input type="number" name="price" step="0.01" oninput="restrictInputToNumbers(this);" required><br>

                <input type="submit" value="Submit">
            </form>
            </div>
            <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];
    $category = $_POST["category"];
    $price = $_POST["price"];

    // Image Upload
    $targetDir = "../greentemplate/uploads/"; // Create a folder named "uploads" in your project directory
    $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
    move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile);

    // Insert data into the products table
    $sql = "INSERT INTO products (image_path, productName, category, price ) VALUES ('$targetFile', '$productName', '$category', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Product added Successfully!',
                showConfirmButton: false,
                timer: 1500
            });
          </script>";
        //echo "Product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

            


            

            

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script>
        function restrictInputToNumbers(inputField) {
            // Remove non-numeric characters using a regular expression
            inputField.value = inputField.value.replace(/[^0-9]/g, '');
        }
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
