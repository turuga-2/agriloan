<?php include "config/databaseconfig.php";
session_start();
$idNumber = $_SESSION['idNumber'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
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


    /* .main {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    } */

    .profile{
    
    width: 50%; /* Adjusted width to 80% */
    margin: 20px auto;
    padding: 20px;
    background-color: #6d947cd2;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    position: relative;
}
    

    label {
      font-weight: bold;
    }

   .text-area {
    display: flex;
      width: auto;
      padding: 10px 5px ;
      margin: 5px 0 ;
      color: black;
      /* border-bottom: 1px solid #2f3d36; 
      border-top: 1px solid #2f3d36 ;
      border-left: 1px solid #2f3d36;
      border-right: 1px solid #999 ; */
      outline: none;
      /* background: transparent; */
    }

    button {
      background-color: #2c5e3f;
      color: #ffffff;
      padding: 10px 15px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    .edit-profile-card {
      display: none;
      max-width: 400px;
      margin: 20px auto;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    .edit-profile-card label,
    .edit-profile-card input,
    .edit-profile-card select {
      width: 100%;
      margin-bottom: 10px;
      box-sizing: border-box;
    }

    .edit-profile-card button {
      background-color: #2c5e3f;
      color: #ffffff;
      padding: 10px 15px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }.edit-profile-card .btn {
    width: 60%;
    align-items: center;
    margin-left: 20%;
    padding: 10px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

  </style>
  <script>
    function updateprofile(){
      window.location.href = "updateprofile.php";
      
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

  <header>
    <h1>My Profile</h1>
  </header>

<div class="navbar">

            <a href="home.php"> Home </a>
            <a href="profile.php" class="active"> My profile</a>
            <a href="loanapplication.php">Loan Application</b></a>
            <a href="loanrepayment.php">Loan Repayment</a>
            <a href="logout.php">Logout </a>
  </div>

  <div class="main">
    <div class="profile">
    <?php

$sql = "SELECT * FROM farmers WHERE idNumber = $idNumber";
$select = mysqli_query($conn, $sql);

if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}
?>

<label for="idNumber">ID Number:</label>
<div class="text-area"><?php echo $fetch['idNumber']; ?></div>

<label for="firstname">First Name:</label>
<div class="text-area"><?php echo $fetch['fname']; ?></div>

<label for="secondname">Second Name:</label>
<div class="text-area"><?php echo $fetch['lname']; ?></div>

<label for="phone">Phone Number:</label>
<div class="text-area"><?php echo $fetch['phoneNumber']; ?></div>

<label for="email">Email Address:</label>
<div class="text-area"><?php echo $fetch['email']; ?></div>

<label for="county">County:</label>
<div class="text-area"><?php echo $fetch['county']; ?></div>

<!-- Display the new fields -->
<label for="gender">Gender:</label>
<div class="text-area"><?php echo $fetch['gender']; ?></div>

<label for="maritalstatus">Marital Status:</label>
<div class="text-area"><?php echo $fetch['maritalstatus']; ?></div>

<label for="dependents">Number of Dependents:</label>
<div class="text-area"><?php echo $fetch['dependents']; ?></div>

<label for="educationlevel">Education Level:</label>
<div class="text-area"><?php echo $fetch['educationlevel']; ?></div>

<label for="employment">Employment:</label>
<div class="text-area"><?php echo $fetch['employment']; ?></div>

<label for="income">Income:</label>
<div class="text-area"><?php echo $fetch['income']; ?></div>



      <button id="editProfileBtn" onclick="updateprofile()">Update Profile</button>
      
      
      
  
    </div>
  </div>
  
  

</body>
</html>




