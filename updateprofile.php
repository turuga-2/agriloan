<?php
include "config/databaseconfig.php";
session_start();
$idNumber = $_SESSION['idNumber'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container{
        width: 600px;
        height: 640px;
        margin: 5% auto;
        padding: 20px;
        background-color: #6d947cd2;
        border-radius: 5px;
        box-sizing: border-box;
        }

        .edit-profile-card {
            
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #4b704e; /* Darker green color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        
        }

        

    .edit-profile-card label,
    .edit-profile-card input,
    .edit-profile-card select {
      width: 100%;
      margin-bottom: 10px;
      box-sizing: border-box;
      padding: 8px;
      border-radius: 3px;
    }

    .edit-profile-card button {
      background-color: #2c5e3f;
      color: #ffffff;
      padding: 10px 15px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    .edit-profile-card .btn {
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
    function cancel(){
        window.location.href = "profile.php";
      
    }
    function updatesuccessful(){
        window.location.href = "profile.php";
        alert("Your profile has been updated successfully");
    
}
      
    // }setTimeout(function() {
    //     alert("Your profile has been updated successfully");
    // }, 100);
    
    </script>
    
</head>
<body>
    <div class="container">
    <?php
      $sql = "SELECT * FROM farmers WHERE idNumber = $idNumber";
      $select = mysqli_query($conn, $sql);
       if(mysqli_num_rows($select)> 0){
        $fetch = mysqli_fetch_assoc($select);
       }
      ?>

<div class="edit-profile-card" id="editProfileCard">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" id="updateProfileForm">

        <label for="idNumber">IDNumber</label>
        <input type="text" id="nidNumber" name="nidNumber" value="<?php echo $fetch['idNumber']; ?>" oninput="restrictInputToNumbers(this);">
        
        <label for="firstname">First Name:</label>
        <input type="text" id="nfirstname" name="nfirstname" value="<?php echo $fetch['fname']; ?>" required>
        
        <label for="nsecondname">Second Name:</label>
        <input type="text" id="nsecondname" name="nsecondname" value="<?php echo $fetch['lname']; ?>" required>
        
        <label for="nphone">Phone Number:</label>
        <input type="tel" id="nphone" name="nphone" value="<?php echo $fetch['phoneNumber']; ?>" oninput= "phoneNumbers()"required>
        
        <label for="nemail">Email Address:</label>
        <input type="email" id="nemail" name="nemail" value="<?php echo $fetch['email']; ?>" required>
        
        <label for="ncounty">County:</label>
        <select id="ncounty" name="ncounty" required>

            <option value="using">UasinGishu</option>

            <option value="trans">Transnzoia</option>
        </select>

          

        <input type="submit"  value="submit" name="submit" class="btn" onclick="updatesuccessful()" >
        <button id="cancel"  onclick="cancel()">Cancel</button>
    </div>
  </div>
  <script>
    function restrictInputToNumbers(inputField) {
            // Remove non-numeric characters using a regular expression
            inputField.value = inputField.value.replace(/[^0-9]/g, '');

            // Optionally, you can trim the input to only keep the first 8 characters
            inputField.value = inputField.value.slice(0, 8);
        }
    function phoneNumbers(inputField) {
            // Remove non-numeric characters using a regular expression
            inputField.value = inputField.value.replace(/[^0-9]/g, '');

            // Optionally, you can trim the input to only keep the first 8 characters
            inputField.value = inputField.value.slice(0, 10);
        }
  </script>
 


  <?php
        // Function to sanitize input
        function sanitizeInput($data) {
            global $conn;
            return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input data
            $nidNumber = sanitizeInput($_POST['nidNumber']);
            $fname = sanitizeInput($_POST['nfirstname']);
            $lname = sanitizeInput($_POST['nsecondname']);
            $phoneNumber = sanitizeInput($_POST['nphone']);
            $email = sanitizeInput($_POST['nemail']);
            $county = sanitizeInput($_POST['ncounty']);
           
        }

    //Insert data into the database
    $sql = "UPDATE `farmers` 
    SET 
        `idNumber` = '$nidNumber', 
        `fname` =  '$fname', 
        `lname` = '$lname', 
        `phoneNumber` = '$phoneNumber', 
        `email` = '$email' 
    WHERE 
        `farmers`.`idNumber` = '$idNumber'";    


    if ($conn->query($sql) === TRUE) {

        header("location:profile.php");

        echo "Data saved successfully.";

        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    };
    
  
?>
    
    
</body>
</html>