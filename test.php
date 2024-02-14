<?php
include "config/databaseconfig.php";
session_start();
$nameErr = $emailErr = $passwordErr = $passlenErr = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your head section here -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
    font-family: Arial, sans-serif;
    
    background-color: #0e301d6c;
    /* background-color: rgba(255, 255, 255, 0.5); */
}

.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #4caf50;
}

h2 {
    margin-top: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    display: inline-block;
    margin-bottom: 8px;
    color: #4caf50;
}

input[type="text"], input[type="tel"], input[type="email"], input[type="password"]  input[type="checkbox"] {
    margin-bottom: 25px;
    padding: 5px;
    border: 1px solid #4caf50;
    border-radius: 3px;
}
input[type="submit"]{
    width: 60%;
    align-items: center;
    margin-left: 20%;
    padding: 10px;
    background:linear-gradient(to right, #4caf50, black) ;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}


.container.btn{
    width: 100%;
    padding: 10px;

} 
.container .dropdown{
    width: 100%;
    padding: 5px;
    margin-bottom: 20px;
}
#rbtn {
            display: flexbox;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        /* Add a new CSS class for highlighting */
        .error {color: #FF0000;}

   
    </style>
</head>

<body>
    <div class="container">
        <!-- Display the error message at the top of the form if passwords don't match -->
        

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"
        method="post"  autocomplete="on" id="accountForm">
        <label for="idNumber">IDNumber</label>
            <input type="text" id="idNumber" name="idNumber" placeholder="IDNumber" oninput="restrictInputToNumbers(this);" required>
            
            <span class="error"> <?php echo $nameErr;?></span>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="FirstName" required> 
            
            
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="lastName" required>
            
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" placeholder="PhoneNumber" oninput="phoneNumbers(this)" required>
            
            <span class="error">* <?php echo $emailErr;?></span>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            

            <label for="county">County:</label>
            <select id="county" name="county" required class="dropdown">

                <option value="UasinGishu" name= "UasinGishu">UasinGishu</option>

                <option value="TransNzoia" name = "TransNzoia">Transnzoia</option>
            </select> 

                <label for="gender">Gender: </label>
                <select id="gender" name="gender" required class="dropdown" required>
                   
                <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label for="maritalStatus">Marital Status: </label>
                <select id="maritalStatus" name="maritalStatus" required class="dropdown">
                    <option value="married">Married</option>
                    <option value="single">Single</option>
                </select>
                <label>Number of dependents: </label>
                <input type="number" id="dependents" name="dependents" step="1" min="0" max="30" placeholder="0" required>

                <label for="educationlevel">Education Level: </label>
                <select id="educationlevel" name="educationlevel" required class="dropdown">
                    <option value="graduate">Graduate</option>
                    <option value="notgraduate">Not a Graduate</option>
                </select>

                <label for="employment">Employment: </label>
                <select id="employment" name="employment" required class="dropdown">
                    <option value="self-employed">Self-employed</option>
                    <option value="employed">Employed</option>
                </select>



        
        <label>Monthly Income: </label>
        <input type="number" id="income" name="income"  min="0" placeholder="0" required>

            <span class="error">* <?php echo $passwordErr;?></span>
            <span class="error"> <?php echo $passlenErr;?></span>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            

            <span class="error">* <?php echo $passwordErr;?></span>
            <span class="error"> <?php echo $passlenErr;?></span>
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password"
                        required >
            
            
            

            
            <input type="submit"  value="submit" name="submit" class="btn">
        </form>

    </div>
        <!-- Your HTML form here -->


    <script>
        // Your existing JavaScript code here
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

        function highlightPasswordFields() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirmpassword');
            const passwordError = document.getElementById('passwordError');

            if (passwordField.value !== confirmPasswordField.value) {
                passwordField.classList.add('password-mismatch');
                confirmPasswordField.classList.add('password-mismatch');
                passwordError.textContent = "Passwords don't match.";
                passwordError.style.display = 'block';
            } else {
                passwordField.classList.remove('password-mismatch');
                confirmPasswordField.classList.remove('password-mismatch');
                passwordError.textContent = '';
                passwordError.style.display = 'none';
            }
        }

        document.getElementById('accountForm').addEventListener('submit', function (event) {
            highlightPasswordFields();
            if (document.getElementById('password').classList.contains('password-mismatch')) {
                event.preventDefault();
            }
        });

        
    </script>
</body>

</html>

<?php
// Function to sanitize input
function sanitizeInput($data)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $idNumber = sanitizeInput($_POST['idNumber']);
    $fname = sanitizeInput($_POST['firstname']);
    $lname = sanitizeInput($_POST['lastname']);
    $phoneNumber = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);
    $county = sanitizeInput($_POST['county']);
    $gender = isset($_POST['gender']) ? sanitizeInput($_POST['gender']) : null;
    $maritalstatus = isset($_POST['maritalStatus']) ? sanitizeInput($_POST['maritalStatus']) : null;
    $dependents = sanitizeInput($_POST['dependents']);
    $educationlevel = isset($_POST['educationlevel']) ? sanitizeInput($_POST['educationlevel']) : null;
    $employment = isset($_POST['employment']) ? sanitizeInput($_POST['employment']) : null;
    $income = sanitizeInput($_POST['income']);
    $password = sanitizeInput($_POST['password']);
    $confirmpassword = sanitizeInput($_POST['confirmpassword']);
    
    
    if (empty($_POST["firstname"])) {

        $nameErr = "Please enter a valid name";

    } else {

        // check if name only contains letters and whitespace

        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {

        $nameErr = "Only letters and white space allowed";

        }

    }

    if (empty($_POST["email"])) {

        $emailErr = "Invalid Email address";

    } 
        
    // Check if the email already exists
    $checkIdSql = "SELECT COUNT(*) AS count FROM farmers WHERE idNumber = '$idNumber'";
    $checkIdResult = $conn->query($checkIdSql);

    if ($checkIdResult) {
        $checkIdRow = $checkIdResult->fetch_assoc();
        $IdCount = $checkIdRow['count'];

        if ($IdCount > 0) {

            echo '
            <script>
            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: "error",
                    title: "ID Number Exists",
                    text: "An account with this ID number already exists. Please choose an option:",
                    showConfirmButton: true,
                    showCloseButton: false, // Hide the close button, as we have custom buttons
                    showCancelButton: true,
                    cancelButtonText: "Use a Different ID Number",
                    confirmButtonText: "Login",
                    confirmButtonColor: "#4caaaf", // Set a custom color for the Login button
                    cancelButtonColor: "#4caaaf", // Set a custom color for the Cancel button
                    reverseButtons: true,
                    //timer: 2500,
                    preConfirm: () => {
                        window.location.href = "farmerlogin.php"; // Redirect to the login page
                    }
                });
            } else {
                console.error("SweetAlert (Swal) is not defined. Make sure the script is properly included.");
                window.location.href = "farmerlogin.php";
            }
        </script>';
        exit(); // Stop further processing

            
        }
        elseif ($password !== $confirmpassword) {
            $passwordErr = "The passwords do not match";
            exit(); // Stop further processing
        }

        // Check for password strength
        if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
            $passlenerr="Password must be at least 8 characters long and contain at least one uppercase letter and one symbol or number.";

            exit(); // Stop further processing
        }
         else {
            // Insert data into the database
            $sql = "INSERT INTO `farmers` (`idNumber`, `fname`, `lname`, `phoneNumber`, `email`, `county`, `gender`, `maritalstatus`, `dependents`, `educationlevel`, `employment`, `income`, `password`) 
        VALUES ('$idNumber', '$fname', '$lname', '$phoneNumber', '$email', '$county', '$gender', '$maritalstatus', '$dependents', '$educationlevel', '$employment', '$income', '$password')";

            if ($conn->query($sql) === TRUE) {

                echo "<script>
                if (typeof Swal !== 'undefined') {
                    // Assuming the form submission was successful, show the success popup
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Created Successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = 'farmerlogin.php';
                    });
                } else {
                    // Log an error if Swal is not defined
                    console.error('SweetAlert (Swal) is not defined. Make sure the script is properly included.');
                    window.location.href = 'farmerlogin.php';
                }
            </script>";
            exit(); // Stop further processing
            } else {
                $msg = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        $msg = "Error checking email: " . $conn->error;
    }


}
?>