<?php include "config/databaseconfig.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title> FarmerLogin </title>
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

<script>
    function restrictInputToNumbers(inputElement) {
        // Remove non-numeric characters
        inputElement.value = inputElement.value.replace(/\D/g, '');

        // Restrict input to 8 characters
        if (inputElement.value.length > 8) {
        inputElement.value = inputElement.value.slice(0, 8);
        }
    }



</script>
</head>
<body>
<div class="date-time">

<?php
    echo"Today's date:",date("i-m-y, h:i:s")

?>

</div>
    <center>
        <h1> Agriloan </h1>
        <p><b><i> Welcome to Agriloan where we make farmers' dreams come true!
        <br>Join us today to get the support you need for a wonderful harvest!
    </i></b></p>
    </center>
    
<div class="login-box">
    <h2>Farmer Login</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        
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
    <div style="text-align: center;">
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</div>
<?php
// Process login form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idNumber = $_POST["idNumber"];
    $password = $_POST["password"];

    // Query to check if the provided credentials are valid
    $sql = "SELECT * FROM farmers WHERE idNumber = '$idNumber' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = mysqli_fetch_assoc($result); 
        $_SESSION['idNumber'] = $row['idNumber'];
    
        // Redirect to the success page
        header("Location: home.php");
        exit();
    } else {
        $message[]= 'Incorrect email or password!';
        
    }
}

?>


</body>
</html>

