<?php include "config/databaseconfig.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Login</title>
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #051922;
            padding: 10px;
            text-align: center;
        }

        header h1 {
            color: #fff;
            margin: 0;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 5px;
            margin: 5px 0;
            color: black;
            border: 0;
            border-bottom: 1px solid #999;
            outline: none;
            background: transparent;
        }

        .form-group input::placeholder {
            color: #999;
        }

        .form-group .btn {
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

        .form-group .btn:hover {
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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <header>
        <h1>Agriloan</h1>
    </header>

    <div class="login-container">
    <!-- <center>
        <h1> Agriloan </h1>
        <p><b><i> Welcome to Agriloan where we make farmers' dreams come true!
        <br>Join us today to get the support you need for a wonderful harvest!
    </i></b></p>
    </center> -->
        <div class="login-box">
            <h2>Farmer Login</h2>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                
                <div class="form-group">
                    <input type="text" id="idNumber" name="idNumber" placeholder="IDNumber" oninput="restrictInputToNumbers(this);">
                </div>
                
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
                
                <p><a href="forgot_password.php">Forgot your password?</a></p> <!-- Add this line for the "Forgot Password" link -->

                <div class="form-group">
                    <input type="submit" value="Submit" name="submit" class="btn">
                </div>


            </form>
            <div style="text-align: center;">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>

    <?php
    // Process login form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idNumber = $_POST["idNumber"];
        $password = $_POST["password"];

        // Query to check if the provided ID number exists in the database
        $checkIdNumberQuery = "SELECT * FROM farmers WHERE idNumber = '$idNumber'";
        $checkIdNumberResult = $conn->query($checkIdNumberQuery);

        if ($checkIdNumberResult->num_rows > 0) {
            // The ID number exists, now check if the password matches
            $checkPasswordQuery = "SELECT * FROM farmers WHERE idNumber = '$idNumber' AND password = '$password'";
            $checkPasswordResult = $conn->query($checkPasswordQuery);

            if ($checkPasswordResult->num_rows > 0) {
                // Both ID number and password are correct
                $row = mysqli_fetch_assoc($checkPasswordResult);
                $_SESSION['idNumber'] = $row['idNumber'];
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'greentemplate/home.php'; // Redirect to home.php after the alert
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
</body>
</html>
