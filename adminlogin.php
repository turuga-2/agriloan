<?php include "config/databaseconfig.php";
session_start();?>
<!DOCTYPE html>
<html>
<head>
    <title> Admin Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
body {
    /* background-color: #22503a; */
    font-family: Arial, sans-serif;
}
header {
            background-color: #051922;
            padding: 10px;
            text-align: center;
            color: #fff;
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

.login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            background-image: url('HighTechIT-1.0.0/img/indexpage.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(0.7); /* Adjust the brightness value as needed */
        }
        .login-box {
            width: 400px;
            height: 400px;
            background-color: #fff;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #8CC084; /* Light green border color */
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body>
    <header>
            <h1>Agriloan</h1>
        </header>

    
    <div class="login-container">    
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
    </div>

<?php
// Process login form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idNumberadmin = $_POST["idNumber"];
    $password = $_POST["password"];

    // Query to check if the provided ID number exists in the database
    $checkIdNumberQuery = "SELECT * FROM admin WHERE idNumber = '$idNumberadmin'";
    $checkIdNumberResult = $conn->query($checkIdNumberQuery);

    if ($checkIdNumberResult->num_rows > 0) {
        // The ID number exists, now check if the password matches
        $checkPasswordQuery = "SELECT * FROM admin WHERE idNumber = '$idNumberadmin' AND password = '$password'";
        $checkPasswordResult = $conn->query($checkPasswordQuery);

        if ($checkPasswordResult->num_rows > 0) {
            // Both ID number and password are correct
            $row = mysqli_fetch_assoc($checkPasswordResult);
            $_SESSION['idNumberadmin'] = $row['idNumber'];
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'dashmin-1.0.0/home.php'; // Redirect to home.php after the alert
            });
          </script>";
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

