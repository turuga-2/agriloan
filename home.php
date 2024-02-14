<?php 
include "config\databaseconfig.php";
session_start();
$idNumber = $_SESSION['idNumber'];
?>
<!DOCTYPE html>
<html>
<head>
        <title>Home Page</title>
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
        </style>
    </head>
    <body>

    <header>
            <h1>Home Page</h1>
    </header>

       
        
        <div class="navbar">

            <a href="home.php"class="active"> Home </a>
            <a href="profile.php"> My profile</a>
            <a href="loanapplication.php">Loan Application</b></a>
            <a href="loanrepayment.php">Loan Repayment</a>
            <a href="logout.php">Logout </a>
            
          </div>

          <?php
      $sql = "SELECT fname FROM farmers WHERE idNumber = $idNumber";
      $select = mysqli_query($conn, $sql);
       if(mysqli_num_rows($select)> 0){
        $fetch = mysqli_fetch_assoc($select);
        $fname = $fetch['fname'];
        
       }?>

  
        
          <h3>Hello <i><?php echo $fname; ?></i> Welcome to Agriloan </h3>

        


          <h4> Your loan status is (Will be gotten from the database)
          </h4>
          <p> Here we are to have the news related to their individual farming kama for example if <br>
            If ni january ni dry season advice watu wadry mahindi
            kama ni time ya kuplant advice watu wanunue fertiliser 
            kama ni weeks after planting advice fertiliser ya top dressing ama ya weeding

          </p>


    </body>
</html>