<?php 
include "../config/databaseconfig.php";?>
<!DOCTYPE html>
<html>
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
       
        
        <div class="navbar">

            <a href="home.php"class="active"> Home </a>
            <a href="profile.php"> My profile</a>
            <a href="loanapplication.php">Loan Application</b></a>
            <a href="loanrepayment.php">Loan Repayment</a>
            <a href="logout.php">Logout </a>
            
          </div>

    </body>
