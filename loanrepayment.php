<?php 
session_start();
//include "processloan.php";
include "config/databaseconfig.php";
$grandtotal = $_SESSION['grandtotal'];
$interest = $_SESSION['interest'];
include "processloan.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Loan Repayment- Agriloan</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    header {
      background-color: #287247; /* Green header color */
      padding: 15px;
      text-align: center;
    }
    .date-time {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 17px;
        
    }

    .navbar {
    background-color: rgb(71, 160, 118);
    overflow: hidden;
    }

 /* Style the navigation bar links */
    .navbar a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        margin-left: 20px;
        margin-right: 20px;
    }
    /* Change the color of links on hover */
    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    .navbar a:active,
        .navbar a.active {
            background-color: #2c5e3f;
            color: black;
        }
        .container{
            margin-left: 30%;
            align-items: center;
            justify-content: space-between;
            display: flexbox;
        }
    .choices{
        margin-top: 10px;
        width: fit-content;
        display: flex;
        
        }
        .weekly button, .monthly button{
            width: 80px;
            padding: 8px;
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;

        }
        .weekly, .monthly{
            padding: 20px;
            width: 30%;
            margin-left: 30px;
            margin-bottom: 20px;
            margin-right: 30px;
            height: fit-content;
            background-color: #579670;
            box-sizing: border-box;
            border-radius: 5px;
            border: 2px solid transparent;
            transition: border 0.3s, box-shadow 0.3s;
        }
        
        .weekly.selected,
        .monthly.selected {
            box-shadow: 0 0 10px #f39c12;
        }
        

    
        </style>
        
        
    </head>
    <body>
        <header>
            <h1>Loan Repayment </h1>
          </header>
          <div class="date-time">
            <?php
                echo"Today's date:",date("d-m-y, h:m:s")

            ?>

    </div>
       
        
        <div class="navbar">

        <a href="home.php"> Home </a>
        <a href="profile.php"> My profile</a>
        <a href="loanapplication.php">Loan Application</a>
        <a href="loanrepayment.php" class="active">Loan Repayment</a>
        <a href="logout.php">Logout </a>
            
          </div>
          <div class="container">
          <h4> Please select the payment plan you would like to use </h4>
          <div class="choices">
           
           <div class="weekly">
            In this bundle you get to repay your loan weekly
            <p>Your loan amount is <?php echo $grandtotal;?></p>
            <p>Your interest is <?php echo $interest;?></p>
            Weekly amount payable is 

            <button onclick="selectBundle('weekly')" >Weekly </button>
           </div>
           <div class="monthly">
            In this bundle you get to repay your loan monthly
            <p>Your loan amount is <?php echo $grandtotal;?></p>
            Your interest is 
            Monthly amount payable is 

            <button onclick="selectBundle('monthly')">Monthly</button>
           </div>
            
        </div>
          </div>

          <script>
    function selectBundle(bundle) {
    event.preventDefault();
    const selectedBundle = document.querySelector(`.${bundle}`);
    const otherBundle = bundle === 'weekly' ? document.querySelector('.monthly') : document.querySelector('.weekly');

    if (!selectedBundle.classList.contains('selected')) {
      // If the selected bundle is not already selected, deselect the other bundle
      otherBundle.classList.remove('selected');
    }

    // Toggle the selected state for the clicked bundle
    selectedBundle.classList.toggle('selected');
  }
</script>
        
          

    </body>
</html>