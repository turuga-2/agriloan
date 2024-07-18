<?php
include "config/databaseconfig.php";
session_start();

$validationErrors = [];
$enteredValues = [];

// Function to sanitize input
function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $enteredValues['idNumber'] = sanitizeInput($_POST['idNumber']);
    $enteredValues['fname'] = sanitizeInput($_POST['firstname']);
    $enteredValues['lname'] = sanitizeInput($_POST['lastname']);
    $enteredValues['phoneNumber'] = sanitizeInput($_POST['phone']);
    $enteredValues['email'] = sanitizeInput($_POST['email']);
    $enteredValues['county'] = sanitizeInput($_POST['county']);
    $enteredValues['gender'] = isset($_POST['gender']) ? sanitizeInput($_POST['gender']) : null;
    $enteredValues['maritalstatus'] = isset($_POST['maritalStatus']) ? sanitizeInput($_POST['maritalStatus']) : null;
    $enteredValues['dependents'] = sanitizeInput($_POST['dependents']);
    $enteredValues['educationlevel'] = isset($_POST['educationlevel']) ? sanitizeInput($_POST['educationlevel']) : null;
    $enteredValues['employment'] = isset($_POST['employment']) ? sanitizeInput($_POST['employment']) : null;
    $enteredValues['income'] = sanitizeInput($_POST['income']);
    $enteredValues['password'] = sanitizeInput($_POST['password']);
    $enteredValues['confirmpassword'] = sanitizeInput($_POST['confirmpassword']);

    // Validate National ID (8 digits only)
    if (!preg_match('/^\d{8}$/', $enteredValues['idNumber'])) {
        $validationErrors[] = 'National ID must be 8 digits.';
    }

    // Validate First Name and Last Name (only letters)
    if (!preg_match('/^[A-Za-z]+$/', $enteredValues['fname']) || !preg_match('/^[A-Za-z]+$/', $enteredValues['lname'])) {
        $validationErrors[] = 'Name should contain only letters.';
    }

    // Validate Phone Number (starts with 254 and followed by 9 digits)
    if (!preg_match('/^254\d{9}$/', $enteredValues['phoneNumber'])) {
        $validationErrors[] = 'Phone number must start with 254 and be 12 digits.';
    }

    // Validate Email
    if (!filter_var($enteredValues['email'], FILTER_VALIDATE_EMAIL)) {
        $validationErrors[] = 'Invalid email address.';
    }

    // Validate Password
    if (strlen($enteredValues['password']) < 8 || !preg_match('/[a-zA-Z]/', $enteredValues['password']) || !preg_match('/\d/', $enteredValues['password']) || !preg_match('/[~`!@#$%\^&*+=\-\[\]\\\';,\/{}|\\":<>\?]/', $enteredValues['password'])) {
        $validationErrors[] = 'Password should be at least 8 characters and include letters, symbols, and numbers.';
    }

    // Validate Confirm Password
    if ($enteredValues['password'] !== $enteredValues['confirmpassword']) {
        $validationErrors[] = 'Passwords do not match.';
    }

    // If there are validation errors, display them
    if (!empty($validationErrors)) {
        // Store entered values in $_SESSION
        $_SESSION['enteredValues'] = $enteredValues;
    } else {
        // No validation errors, proceed with the form processing

        // Hash the password
        $hashedPassword = password_hash($enteredValues['password'], PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO `farmers` (`idNumber`, `fname`, `lname`, `phoneNumber`, `email`, `county`, `gender`, `maritalstatus`, `dependents`, `educationlevel`, `employment`, `income`, `password`) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'sssssssssssss',
            $enteredValues['idNumber'],
            $enteredValues['fname'],
            $enteredValues['lname'],
            $enteredValues['phoneNumber'],
            $enteredValues['email'],
            $enteredValues['county'],
            $enteredValues['gender'],
            $enteredValues['maritalstatus'],
            $enteredValues['dependents'],
            $enteredValues['educationlevel'],
            $enteredValues['employment'],
            $enteredValues['income'],
            $hashedPassword
        );

        if ($stmt->execute()) {
            // Success
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Created Successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        window.location.href = 'farmerlogin.php';
                    });
                });
            </script>";

    exit();
        } else {
            echo "Error inserting data into the database.";
        }
    }
}

// Clear entered values from $_SESSION after processing
unset($_SESSION['enteredValues']);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #0e301d6c;
        margin: 0; /* Remove default margin to ensure full-width background */
    }

        .container {
            max-width: 70%; /* Adjust the maximum width as needed */
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.2);
        }
        /* Add media queries for responsiveness */
    @media only screen and (max-width: 600px) {
        .container {
            max-width: 90%; /* Adjust the maximum width for smaller screens */
        }
    }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4caf50;
        }
        h4 {
            text-align: left;
            margin-bottom: 20px;
            color: #4caf50;
        }

        form {
            margin-left: 30px;
            max-width: 90%;
            display: flex;
            flex-direction: column;
        }

        label {
            display: inline-block;
            margin-bottom: 8px;
            color: #4caf50;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="password"],
        input[type="checkbox"] {
            margin-bottom: 25px;
            padding: 5px;
            border: 1px solid #4caf50;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 60%;
            align-items: center;
            margin-left: 20%;
            padding: 10px;
            background: linear-gradient(to right, #4caf50, black);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container.btn {
            width: 100%;
            padding: 10px;
        }

        .container .dropdown {
            width: 100%;
            padding: 5px;
            margin-bottom: 20px;
        }

        #rbtn {
            display: flexbox;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <script>
        // Function to validate password
        function validatePassword(password) {
            // Validate length
            if (password.length < 8) {
                return false;
            }

            // Regex to check for letter, number, and symbol
            var hasLetter = /[a-zA-Z]/.test(password);
            var hasNumber = /\d/.test(password);
            var hasSymbol = /[~`!@#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/.test(password);

            // Return validation result
            return hasLetter && hasNumber && hasSymbol;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Sign up process</h1>
        <h4>Please enter your details to Sign-up</h4>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" autocomplete="on" id="accountForm">

            <!-- IDNumber Input -->
            <label for="idNumber">IDNumber</label>
            <input type="text" id="idNumber" name="idNumber" placeholder="IDNumber" oninput="restrictInputToNumbers(this);" value="<?php echo isset($enteredValues['idNumber']) ? htmlspecialchars($enteredValues['idNumber']) : ''; ?>" required>
            <?php if(in_array('National ID must be 8 digits.', $validationErrors)): ?>
                <span class="error"><?php echo 'National ID must be 8 digits.'; ?></span>
            <?php endif; ?>

            <!-- FirstName Input -->
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="FirstName" value="<?php echo isset($enteredValues['fname']) ? htmlspecialchars($enteredValues['fname']) : ''; ?>" required>
            <?php if(in_array('Name should contain only letters.', $validationErrors)): ?>
                <span class="error"><?php echo 'Name should contain only letters.'; ?></span>
            <?php endif; ?>

                        <!-- LastName Input -->
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="lastName" value="<?php echo isset($enteredValues['lname']) ? htmlspecialchars($enteredValues['lname']) : ''; ?>" required>
            <?php if(in_array('Name should contain only letters.', $validationErrors)): ?>
                <span class="error"><?php echo 'Name should contain only letters.'; ?></span>
            <?php endif; ?>

            <!-- PhoneNumber Input -->
            <p>This number will be used in payment use mode: e.g., 254712345678</p>
            <label for="phone">Phone Number: </label>
            <input type="tel" id="phone" name="phone" placeholder="PhoneNumber" oninput="phoneNumbers(this)" value="<?php echo isset($enteredValues['phoneNumber']) ? htmlspecialchars($enteredValues['phoneNumber']) : ''; ?>" required>
            <?php if(in_array('Phone number must start with 254 and be 12 digits.', $validationErrors)): ?>
                <span class="error"><?php echo 'Phone number must start with 254 and be 12 digits.'; ?></span>
            <?php endif; ?>

            <!-- Email Input -->
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($enteredValues['email']) ? htmlspecialchars($enteredValues['email']) : ''; ?>" required>
            <?php if(in_array('Invalid email address.', $validationErrors)): ?>
                <span class="error"><?php echo 'Invalid email address.'; ?></span>
            <?php endif; ?>

            <!-- County Input -->
            <label for="county">County:</label>
            <select id="county" name="county" required class="dropdown">
                <option value="UasinGishu" <?php echo (isset($enteredValues['county']) && $enteredValues['county'] === 'UasinGishu') ? 'selected' : ''; ?>>UasinGishu</option>
                <option value="TransNzoia" <?php echo (isset($enteredValues['county']) && $enteredValues['county'] === 'TransNzoia') ? 'selected' : ''; ?>>TransNzoia</option>
                <!-- Add more county options as needed -->
            </select>

            <!-- Gender Input -->
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male" <?php echo (isset($enteredValues['gender']) && $enteredValues['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo (isset($enteredValues['gender']) && $enteredValues['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
            </select>

            <!-- Marital Status Input -->
            <label for="maritalStatus">Marital Status:</label>
            <select id="maritalStatus" name="maritalStatus" required>
                <option value="single" <?php echo (isset($enteredValues['maritalstatus']) && $enteredValues['maritalstatus'] === 'single') ? 'selected' : ''; ?>>Single</option>
                <option value="married" <?php echo (isset($enteredValues['maritalstatus']) && $enteredValues['maritalstatus'] === 'married') ? 'selected' : ''; ?>>Married</option>
            </select>

            <!-- Dependents Input -->
            <label>Number of dependents: </label>
            <input type="number" id="dependents" name="dependents" step="1" min="0" max="30" placeholder="0" value="<?php echo isset($enteredValues['dependents']) ? htmlspecialchars($enteredValues['dependents']) : ''; ?>" required>
            <?php if(in_array('Invalid number of dependents.', $validationErrors)): ?>
                <span class="error"><?php echo 'Invalid number of dependents.'; ?></span>
            <?php endif; ?>

            <!-- Education Level Input -->
            <label for="educationlevel">Education Level:</label>
            <select id="educationlevel" name="educationlevel" required>
                <option value="graduate" <?php echo (isset($enteredValues['educationlevel']) && $enteredValues['educationlevel'] === 'graduate') ? 'selected' : ''; ?>>graduate</option>
                <option value="notgraduate" <?php echo (isset($enteredValues['educationlevel']) && $enteredValues['educationlevel'] === 'notgraduate') ? 'selected' : ''; ?>>notgraduate</option>
            </select>

            <!-- Employment Input -->
            <label for="employment">Employment:</label>
            <select id="employment" name="employment" required>
                <option value="self-employed" <?php echo (isset($enteredValues['employment']) && $enteredValues['employment'] === 'self-employed') ? 'selected' : ''; ?>>self-employed</option>
                <option value="employed" <?php echo (isset($enteredValues['employment']) && $enteredValues['employment'] === 'employed') ? 'selected' : ''; ?>>employed</option>
            </select>

            <!-- Income Input -->
            <label>Monthly Income: </label>
            <input type="number" id="income" name="income" min="0" placeholder="0" value="<?php echo isset($enteredValues['income']) ? htmlspecialchars($enteredValues['income']) : ''; ?>" required>
            <?php if(in_array('Invalid monthly income.', $validationErrors)): ?>
                <span class="error"><?php echo 'Invalid monthly income.'; ?></span>
            <?php endif; ?>

            <!-- Password Input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <?php if(in_array('Password should be at least 8 characters and include letters, symbols, and numbers.', $validationErrors)): ?>
                <span class="error"><?php echo 'Password should be at least 8 characters and include letters, symbols, and numbers.'; ?></span>
            <?php endif; ?>

            <!-- ConfirmPassword Input -->
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
            <?php if(in_array('Passwords do not match.', $validationErrors)): ?>
                <span class="error"><?php echo 'Passwords do not match.'; ?></span>
            <?php endif; ?>
            <!-- Submit Button -->
            <input type="submit" value="Submit" name="submit" class="btn">
        </form>
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

            // Optionally, you can trim the input to only keep the first 12 characters
            inputField.value = inputField.value.slice(0, 12);
        }
    </script>
</body>
</html>
