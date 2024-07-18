<?php 
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

try {
    // Check if a loan with the specified idNumber exists
    $checkLoanSql = "SELECT COUNT(*) AS loanCount FROM loans WHERE F_idNumber = '$idNumber'";
    $checkLoanResult = mysqli_query($conn, $checkLoanSql);

    if ($checkLoanResult) {
        $loanCount = mysqli_fetch_assoc($checkLoanResult)['loanCount'];

        if ($loanCount == 0) {
            // No loans found for the specified idNumber
            echo "<p>You have no loans.</p>";
        } else {
            // A loan with the specified idNumber exists, proceed with the main query
            $loansql = "SELECT * FROM loans WHERE loanid = '$dbloanid' AND F_idNumber = '$idNumber'";
            $loanresult = mysqli_query($conn, $loansql);

            if ($loanresult) {
                // Fetch the loanresult row
                $row = mysqli_fetch_assoc($loanresult);

                // Access the loantotal value
                $loantotal = $row['grandtotal'];

                // ... continue with other fields
            } else {
                // Handle the main query error
                throw new Exception("Error executing main query: " . mysqli_error($conn));
            }

            // SQL query to select the sum of payments made for the specified loanid
            $amountsql = "SELECT SUM(Amount) AS repaid_amount FROM repayment WHERE F_loanid = '$dbloanid'";
            $amountresult = mysqli_query($conn, $amountsql);

            if ($amountresult) {
                // Fetch the amountresult row
                $row = mysqli_fetch_assoc($amountresult);

                // Access the repaid_amount value
                $repaid_amount = $row['repaid_amount'];

                // Display or use the repaid_amount value
                echo "<script>console.log('Repaid Amount for loanid $dbloanid: $repaid_amount')</script>";

                $balance = $loantotal - $repaid_amount;

                // Update the loans table with the new balance
                $updateBalanceSql = "
                    UPDATE loans
                    SET balance = '$balance'
                    WHERE loanid = '$dbloanid';
                ";

                if (mysqli_query($conn, $updateBalanceSql)) {
                    echo "<script>console.log('Balance updated successfully for loanid: $dbloanid')</script>";
                } else {
                    throw new Exception("Error updating balance: " . mysqli_error($conn));
                }

                if ($balance <= 0) {
                    // Handle the case when the balance is 0
                    $updateloansql = "UPDATE loans SET loanstatus = 'Cleared' WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
                    $resultupdateloansql = mysqli_query($conn, $updateloansql);
                    if ($resultupdateloansql) {
                        echo "<script>console.log('Your balance is 0. No further actions are required. We have updated the loan status')</script>";
                    }
                } else {
                    // Continue with the rest of your code
                    // Query to select approval date and penalty from the loans table
                    $selectQuery = "SELECT approvaldate, penalty, last_penalty_update FROM loans WHERE F_idNumber = '$idNumber'";
                    $result = mysqli_query($conn, $selectQuery);

                    // Check if the query was successful
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        // Get approval date and penalty from the result
                        $ApprovalDate = strtotime($row['approvaldate']);
                        $weekselapsed = ceil((time() - $ApprovalDate) / (60 * 60 * 24 * 7)); // Calculate elapsed weeks since achukue loan

                        // Check if the difference between approval date and current week is greater than 25 weeks
                        if ($weekselapsed >= 25) {
                            $checkExistingQuery = "SELECT * FROM defaulters WHERE idNumber = '$idNumber' AND loanid = '$dbloanid'";
                            $existingResult = mysqli_query($conn, $checkExistingQuery);

                            if (!$existingResult) {
                                throw new Exception("Error checking existing row: " . mysqli_error($conn));
                            }

                            if (mysqli_num_rows($existingResult) > 0) {
                                // A row with the same idNumber and loanid already exists
                                echo "<script>console.log('Record with idNumber $idNumber and loanid $dbloanid already exists in defaulters table.')</script>";
                            } else {
                                // Insert into defaulters table
                                $insertdefaulters = "INSERT INTO defaulters (idNumber, loanid, loanedamount, balance) VALUES ('$idNumber', '$dbloanid', '$LoanTotal', '$balance')";
                                $insertResult = mysqli_query($conn, $insertdefaulters);

                                if (!$insertResult) {
                                    throw new Exception("Error inserting into defaulters table: " . mysqli_error($conn));
                                }

                                // ... (remaining code)
                            }

                            //this means amepitisha repayment period
                            // Calculate the number of weeks after the 25th week
                            $weeksAfter25Weeks = $weekselapsed - 25;
                            $daysafterdeadline = $weeksAfter25Weeks * 7;
                            // Get the last penalty update date from the database
                            $lastPenaltyUpdate = strtotime($row['last_penalty_update']);
                            // Check if a day has passed since the last penalty update
                            $daysSinceLastUpdate = floor((time() - $lastPenaltyUpdate) / (60 * 60 * 24));

                            // Check if a new day has started since the last update
                            if ($daysSinceLastUpdate > 0) {
                                // Calculate the new penalty (increased by 50 for each passing day after the 25th week)
                                $newPenalty = $row['penalty'] + ($daysafterdeadline * 50);

                                // Update the table with the new penalty and the last penalty update date
                                $updateQuery = "UPDATE loans SET penalty = $newPenalty, last_penalty_update = NOW() WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
                                $updateResult = mysqli_query($conn, $updateQuery);
                            }

                            echo '<script>console.log ("A day has not elapsed")</script>';
                        }
                    }
                }
            } else {
                // Handle the main query error
                throw new Exception("Error executing main query: " . mysqli_error($conn));
            }
        }
    } else {
        // Handle the check loan query error
        throw new Exception("Error checking for loans: " . mysqli_error($conn));
    }

    //fetch the penalty value
    $selectpena = "SELECT penalty FROM loans WHERE F_idNumber = '$idNumber' AND loanid = '$dbloanid'";
    $resultpena = mysqli_query($conn, $selectpena);

    if ($resultpena) {
        $rowpena = mysqli_fetch_assoc($resultpena);
        $penaValue = $rowpena['penalty'];
    } else {
        throw new Exception("Error executing query: " . mysqli_error($conn));
    }

                    
    
    // Fetch data from repayments table
    $repaymentsQuery = "SELECT * FROM repayment WHERE F_idNumber = '$idNumber' AND F_loanid = '$dbloanid'";
    $repaymentsResult = mysqli_query($conn, $repaymentsQuery);

    if ($repaymentsResult) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>My Bills</title>

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
		.detail{
			background-color: #ddd; 
			/* background-image: url(../Beans.jpg);  */
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
								<li><a href="home.php">Home</a></li>
								<li><a href="profile.php">My Profile</a></li>
								
								<li><a href="loanapplication.php">Loan Application</a></li>
								<li class="current-list-item"><a href="bills.php">My bills</a></li>
									
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
						<p>My bills</p>
						<!-- <h1>Single Article</h1> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	
			<!-- single article section -->
			<div class="hero-area hero-bg detail" >

			<!-- <div class="mt-150 mb-150 detail">  -->
				<div class="container">
					<div class="row"> 
						<div class="col-lg-8">
							<div class="single-article-section">
								<div class="single-article-text">
									<div class="single-artcile-bg">
										<!-- <div id="loan_amount"> -->
											<h3>Loan id: <?php echo $dbloanid ?? 0; ?></h3>
											<h3>Loan amount: <?php echo $loantotal ?? 0; ?></h3>
											<h3>Repaid amount: <?php echo $repaid_amount ?? 0; ?></h3>
											<h3>Balance: <?php echo $balance ?? 0; ?></h3>
											<h3>Penalty: <?php echo $penaValue ?? 0; ?></h3>
									
											
											<?php
												if (mysqli_num_rows($repaymentsResult) > 0) {
													?>
													<h2>Your Transactions</h2>
											
											<table border="1">
												<thead>
													<tr>
														<th>Repaymentid</th>
														<th>Mpesa_Receipt_Number</th>
														<th>PhoneNumber</th>
														<th>Transaction_date</th>
														<th>Amount</th>
														
													</tr>
												</thead>
												<tbody>
												<?php
															while ($repaymentRow = mysqli_fetch_assoc($repaymentsResult)) {
																echo "<tr>";
																echo "<td>{$repaymentRow['repaymentid']}</td>";
																echo "<td>{$repaymentRow['MpesaReceiptNumber']}</td>";
																echo "<td>{$repaymentRow['PhoneNumber']}</td>";
																echo "<td>{$repaymentRow['transactiondate']}</td>";
																echo "<td>{$repaymentRow['Amount']}</td>";
																echo "</tr>";
															}
															?>
												</tbody>
											</table>
											<?php
												} else {
													echo "<h4 class=\"orange-text\">You have no transactions.</h4>";

												}
												?>
										
								
											
												<?php
													} else {
														throw new Exception("Error executing query: " . mysqli_error($conn));
													}
												} catch (Exception $e) {
													// Handle the exception, you can log or display an error message as needed
													echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
												} finally {
													// Close the database connection
													if ($conn) {
														mysqli_close($conn);
													}
												}
												?>
									</div>			
								</div>
							</div>			
						</div>
					</div>
				</div>
			</div>
				
				<!-- </div> -->
			<!-- </div> -->
			<!-- end single article section -->
	
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