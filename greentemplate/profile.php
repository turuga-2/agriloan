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
	<title>My Profile </title>

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
		.details-container {
			display: flex;
			flex-direction: column;
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			background-color: #fff;
			border-radius: 8px;
			width: 60%;
		}

		.detail-row {
			display: flex;
			margin-bottom: 10px;
			border-bottom: 1px solid #ddd;
			padding-bottom: 10px;
		}

		label {
			width: 150px;
			font-weight: bold;
			padding-right: 10px;
		}

		.text-area {
			flex-grow: 1;
		}

		.separator {
			width: 1px;
			background-color: #ddd;
			margin: 0 10px; /* Adjust the margin as needed */
		}

		#editProfileBtn {
			background-color: #F28123;
			color: #051922;
			font-weight: 700;
			text-transform: uppercase;
			font-size: 15px;
			border: none !important;
			cursor: pointer;
			padding: 15px 25px;
			border-radius: 3px;
			margin-top: 20px;
		}
	</style>

	<script>
    function updateprofile(){
      window.location.href = "../updateprofile.php";

    }
    function cancel(){
      document.getElementById('editProfileCard').style.display = 'none';
    }
    function update(){
      document.getElementById('editProfileCard').style.display = 'none';

    }

      // This is just a placeholder alert to indicate a successful submission.
      //alert('Profile updated successfully!');
  ;
  </script>

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
								<li><a href="home.php">Home</a></li>
								<li class="current-list-item"><a href="profile.php">My Profile</a></li>

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
	<div style="height: 200px;" class="breadcrumb-section breadcrumb-bg" >
		 <div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					 <div class="breadcrumb-text">
						 <p>MY PROFILE</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	<!-- latest news -->
				<div class="latest-news mt-150 mb-150">
					<div class="container">
						<div class="row">
							<!-- <div class="col-lg-4 col-md-6"> -->
							<!-- <div class="col-lg-4 "> -->

							<?php

								$sql = "SELECT * FROM farmers WHERE idNumber = $idNumber";
								$select = mysqli_query($conn, $sql);

								if (mysqli_num_rows($select) > 0) {
									$fetch = mysqli_fetch_assoc($select);
								}
								?>

							<div class="details-container">
								<div class="detail-row">
									<label for="idNumber">ID Number:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['idNumber']; ?></div>
								</div>

								<div class="detail-row">
									<label for="firstname">First Name:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['fname']; ?></div>
								</div>

								<div class="detail-row">
									<label for="secondname">Second Name:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['lname']; ?></div>
								</div>

								<div class="detail-row">
									<label for="phone">Phone Number:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['phoneNumber']; ?></div>
								</div>

								<div class="detail-row">
									<label for="email">Email Address:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['email']; ?></div>
								</div>

								<div class="detail-row">
									<label for="county">County:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['county']; ?></div>
								</div>

								<!-- Display the new fields -->

								<div class="detail-row">
									<label for="gender">Gender:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['gender']; ?></div>
								</div>

								<div class="detail-row">
									<label for="maritalstatus">Marital Status:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['maritalstatus']; ?></div>
								</div>

								<div class="detail-row">
									<label for="dependents">No. of Dependents:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['dependents']; ?></div>
								</div>

								<div class="detail-row">
									<label for="educationlevel">Education Level:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['educationlevel']; ?></div>
								</div>

								<div class="detail-row">
									<label for="employment">Employment:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['employment']; ?></div>
								</div>

								<div class="detail-row">
									<label for="income">Income:</label>
									<div class="separator"></div>
									<div class="text-area"><?php echo $fetch['income']; ?></div>
								</div>
								<button id="editProfileBtn" onclick="updateprofile()">Update Profile</button>
							
							</div>

						</div>

					</div>
				
				</div>
	<!-- end latest news -->





	<!-- featured section -->

	<!-- end featured section -->

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