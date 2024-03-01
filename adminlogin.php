<?php include "config/databaseconfig.php";
session_start();?>
<!DOCTYPE html>
<html>
<head>
    <title> Admin Login </title>
<style>
body {
    background-color: #22503a;
    font-family: Arial, sans-serif;
}

body h1 {
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    align-content: center;
}

body p {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    align-self: center;
    justify-content: center;
}
.date-time {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 17px;
  
}


.login-box {
    width: 400px;
    height: 400px;
    background-color: #27704d;
    margin: 100px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.login-box h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.login-box .form-group {
    margin-bottom: 20px;
}

.login-box .form-group input {
      width: 100%;
      padding: 10px 5px ;
      margin: 5px 0 ;
      color: black;
      border: 0;
      border-bottom: 1px solid #999;
      outline: none;
      background: transparent;
    }

.login-box .form-group input::placeholder {
            color: #999; /* Change this to the desired color code */
        }

.login-box .form-group .btn {
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

.login-box .form-group .btn:hover {
    background: #555;
}
</style>
</head>
<body>

</div>
    <center>
        <h1> Agriloan </h1>
        <p><b><i> Welcome to Agriloan where we make farmers' dreams come true!
        <br>Join us today to get the support you need for a wonderful harvest!
    </i></b></p>
    </center>
    
<div class="login-box">
    <h2>Admin Login</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"method="post">
        
        <div class="form-group">
            <input type="text" id="idNumber" name="idNumber" placeholder="IDNumber" oninput="restrictInputToNumbers(this);">

        </div>
        <div class="form-group">
            
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="submit"  value="Submit" name="submit" class="btn">
        </div>
    </form>
    
</div>


<?php
// Process login form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idNumber = $_POST["idNumber"];
    $password = $_POST["password"];

    // Query to check if the provided ID number exists in the database
    $checkIdNumberQuery = "SELECT * FROM admin WHERE idNumber = '$idNumber'";
    $checkIdNumberResult = $conn->query($checkIdNumberQuery);

    if ($checkIdNumberResult->num_rows > 0) {
        // The ID number exists, now check if the password matches
        $checkPasswordQuery = "SELECT * FROM admin WHERE idNumber = '$idNumber' AND password = '$password'";
        $checkPasswordResult = $conn->query($checkPasswordQuery);

        if ($checkPasswordResult->num_rows > 0) {
            // Both ID number and password are correct
            $row = mysqli_fetch_assoc($checkPasswordResult);
            $_SESSION['idNumber'] = $row['idNumber'];
            
            header("Location: adminhome.php");
            exit();
        } else {
            // ID number is correct, but the password is wrong
            echo '<script>alert("Wrong password!");</script>';
        }
    } else {
        // ID number is not found in the database
        echo '<script>alert("Invalid login details!");</script>';
    }
}
?>
<script>
    function restrictInputToNumbers(inputField) {
        // Remove non-numeric characters using a regular expression
        inputField.value = inputField.value.replace(/[^0-9]/g, '');

        // Optionally, you can trim the input to only keep the first 8 characters
        inputField.value = inputField.value.slice(0, 8);
    }
    
</script>
</body>
</html>

