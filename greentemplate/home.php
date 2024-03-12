<?php 
include "../config/databaseconfig.php";
// Check if idNumber is not set in the session
if (!isset($_SESSION['idNumber'])) {
    // Redirect to the login page
    header("Location: ../farmerlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}

$idNumber = $_SESSION['idNumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Home</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
	<style>
		.content-box {
			border: 1px solid #ddd; /* Light grey border */
			border-radius: 10px; /* Increased border-radius for rounded corners */
			box-shadow: 0 0 10px rgba(128, 128, 128, 0.5); /* Updated box shadow with grey color */
			padding: 30px; /* Increased padding */
			background-color: #fff; /* White background */
			width: 80%;
			height: 60vh; /* 60% of the viewport height */
			margin-top: 30px;
		}
		.detail{
			background-color: aliceblue; 
			background-image: url(../Beans.jpg);
		}
	</style>
</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="home.php">
								<h3 class="orange-text">Agriloan</h3>
								
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="#">Home</a></li>
								<li><a href="profile.php">My Profile</a></li>
								
								<li><a href="loanapplication.php">Loan Application</a></li>
								<li><a href="bills.php">My bills</a></li>
									
								<li><a href="loanrepayment.php">Loan Repayment</a></li>
								<li><a href="logout.php">Logout</a></li>

				
							</ul>
						</nav>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>HOME</p>
							
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	
	<!-- hero area -->
	
	<div class="hero-area hero-bg detail" >
		<div class="container">
			<div class="row">
				<!-- <div class="col-lg-9 offset-lg-2 text-center"> -->
				<!-- <div class="col-lg-9 offset-lg-2 "> -->

					<!-- <div class="hero-text"> -->
						<!-- <div class="hero-text-tablecell"> -->
							<div class="content-box">
						<?php

				try {       
				$sql = "SELECT fname FROM farmers WHERE idNumber = $idNumber";
				$select = mysqli_query($conn, $sql);

				if (!$select) {
					throw new Exception("Error executing query: " . mysqli_error($conn));
				}

				if (mysqli_num_rows($select) > 0) {
					$fetch = mysqli_fetch_assoc($select);
					$fname = $fetch['fname'];
					echo "<h3>Hello <i>".  $fname ."</i> Welcome to Agriloan </h3>";
				}
					// Query to check if the farmer has a loan id
					$loanCheckQuery = "SELECT loanid, loanstatus, dispatch_status, dispatchdate FROM loans WHERE F_idNumber = '$idNumber' ORDER BY loanid DESC LIMIT 1";
					$loanCheckResult = mysqli_query($conn, $loanCheckQuery);
				
					if (!$loanCheckResult) {
						throw new Exception("Error executing query: " . mysqli_error($conn));
					}
				
					// Check if the query returned any rows
					if (mysqli_num_rows($loanCheckResult) > 0) {
						// Fetch the loan id
						$fetch = mysqli_fetch_assoc($loanCheckResult);
						$dbloanid = $fetch['loanid'];
						$_SESSION['dbloanid'] = $dbloanid;
						$dbloanstatus = $fetch['loanstatus'];
						$_SESSION['dbloanstatus'] = $dbloanstatus;
						$dispatch_status = $fetch['dispatch_status'];
						$dispatchdate = $fetch['dispatchdate'];
				
						// Check if the loan status is "active" before displaying dispatch status and date
						if ($dbloanstatus == 'Active') {
							echo "<h4>Your loan status for loan id <i>" . $dbloanid . "</i> is <i>" . $dbloanstatus . "</i></h4>";
							echo "<h4>Your Dispatch status is <i>" . $dispatch_status. "</i> It was dispatched on <i>" . $dispatchdate . "</i></h4>";
						} else {
							echo "<h4>Your loan status for loan id <i>" . $dbloanid . "</i> is <i>" . $dbloanstatus . "</i></h4>";
							echo "<h4>No dispatch information available for non-active loans.</h4>";
						}

					} else {
						// Echo a message if no loan id exists
						echo "<h4>You have no loans currently.</h4>";
					}
				?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->
			<?php
		} catch (Exception $e) {
			// Handle the exception, you can log or display an error message as needed
			echo "Error: " . $e->getMessage();
		} finally {
			// Close the database connection
			if ($conn) {
				mysqli_close($conn);
			}
		}

		?>

	

	<!-- product section -->
	<!-- <div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Our</span> Products</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			
			
		</div>
	</div> -->
	<!-- end product section -->

	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
				<p>Copyrights &copy; 2024 - <a href="../HighTechIT-1.0.0/index.html">Agriloan</a>,  All Rights Reserved.
					<p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.<br>
						Distributed By - <a href="https://themewagon.com/">Themewagon</a>
					</p>
				</div>
				
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

</body>
</html>