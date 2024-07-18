<?php 
//include "processloan.php";
include "../config/databaseconfig.php";
// Check if idNumber is not set in the session
if (!isset($_SESSION['idNumber'])) {
    // Redirect to the login page
    header("Location: ../farmerlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}
$idNumber = $_SESSION['idNumber'];
$dbloanid = $_SESSION['dbloanid'];
//print_r($_SESSION);

try{
    $sql = "SELECT phoneNumber FROM farmers WHERE idNumber = $idNumber";
    $result=  mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    $statussql = "SELECT * FROM loans WHERE F_idNumber = '$idNumber' AND loanid ='$dbloanid'";
    $statusselect = mysqli_query($conn, $statussql);

    if (!$statusselect) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($statusselect) > 0) {
        $fetch = mysqli_fetch_assoc($statusselect);
        $interest = $fetch['interest'];
        $grandtotal = $fetch['grandtotal'];
    }
    // select the balance
    $balancesql = "SELECT balance FROM repayments_view WHERE idNumber = '$idNumber' AND loanid ='$dbloanid'";
    $balanceresult = mysqli_query($conn, $balancesql);

    if (!$balanceresult) {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($balanceresult) > 0) {
        $fetch = mysqli_fetch_assoc($balanceresult);
        $balance = $fetch['balance'];
    }


    if (mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);
        $phoneNumber = $fetch['phoneNumber'];
    }
}catch (Exception $e) {
    // Handle the exception, you can log or display an error message as needed
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    if ($conn) {
        mysqli_close($conn);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>LOAN REPAYMENT</title>

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
								<li><a href="profile.php">My Profile</a></li>
								
								<li><a href="loanapplication.php">Loan Application</a></li>
								<li><a href="bills.php">My bills</a></li>
									
								<li  class="current-list-item"><a href="loanrepayment.php">Loan Repayment</a></li>
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
						<p>Repay your loans in 6 months after approval</p>
						<!-- <p>Start by paying off your interest first</p>
                			 <p> On the 6th month you will be required to repay back 
							
							 the full loaned amount</p> -->
							
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- contact form -->
	<div class="contact-from-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
					<div class="form-title">
						<h3>Loan Details</h3>
						<h5>Your active loan is loanid number <span class="orange-text"><?php echo $dbloanid;?></span></h5>
						<h5>Your interest to be repaid is <span class="orange-text"><?php echo $interest;?></span></h5>
						<h5>Your Total loan amount to be repaid is <span class="orange-text"><?php echo $grandtotal;?></span></h5>
						<h5>Your balance is <span class="orange-text"><?php echo $balance ;?></span></h5>
						<h3>Mpesa Details</h3>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
					<form method="post" id="paymentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
					    <p>You will be prompted to make payment</p>
						<p><b>This is the Safaricom number that you provided and will be used to make payments </b></p>
						<label for="phoneNumber">Phone Number:</label>
						<div class="text-area" id="phoneNumber" name="phoneNumber"> <?php echo $fetch['phoneNumber']; ?>  </div>
						<br>
								<p><b>Please enter the Amount to pay </b></p>
								<label for="amount">Amount:</label>
								<input type="number" id="amount" name="amount" placeholder="amount" oninput="restrictInputToNumbers(this);" required>
								<br>
								<input type="submit" value="Make Payment">
					</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- end contact form -->

	

	


	
	
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
	<!-- form validation js -->
	<script src="assets/js/form-validate.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
           <script>
            function restrictInputToNumbers(inputField) {
            // Replace non-numeric characters with an empty string
            inputField.value = inputField.value.replace(/[^0-9]/g, '');
            }

            function phoneNumbers(inputField) {
            // Remove non-numeric characters using a regular expression
            inputField.value = inputField.value.replace(/[^0-9]/g, '');

            // Optionally, you can trim the input to only keep the first 8 characters
            inputField.value = inputField.value.slice(0, 12);
        }
        $(document).ready(function() {
        $('#paymentForm').submit(function(event) {
            event.preventDefault();

            // Get form data
            const phoneNumber = $('#phoneNumber').text().trim();
            //const phoneNumber = $('#phoneNumber').val();
            const amount = $('#amount').val();
            const loanid = <?php echo $dbloanid;?>;
            const idNumber = <?php echo $idNumber?>;
            console.log(loanid,idNumber);

            $.ajax({
                url: '../daraja/stkpush.php',
                method: 'POST',
                data: {
                    phoneNumber: phoneNumber,
                    amount: amount,
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                    icon: 'success',
                    title: 'Request accepted for processing',
                    text: 'Please enter your mpesa pin when prompted', // You can customize this based on your response data
                });
                },
                error: function() {
                    console.error('Error sending detailsto stkpush');
                }
            });
            processtransaction();
    
            
            
        });
    });
    function processtransaction(){
        const phoneNumber = $('#phoneNumber').text().trim();
        //const phoneNumber = $('#phoneNumber').val();
            const amount = $('#amount').val();
        $.ajax({
                url: '../transactionprocessing.php',
                method: 'POST',
                data: {
                    phoneNumber: phoneNumber,
                    amount: amount,
                },
                success: function(response) {
                    console.log(response);
                   
                },
                error: function() {
                    console.error('Error sending details to transaction');
                }
            });
    }
        </script>

	
</body>
</html>