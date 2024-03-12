<?php
include "config/databaseconfig.php";
session_start();
$idNumber = $_SESSION['idNumber'];

// Initialize validation errors array
$validationErrors = [];
$enteredValues = [];


// Function to sanitize input
function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate input data
        $enteredValues['nidNumber'] = isset($_POST['nidNumber']) ? sanitizeInput($_POST['nidNumber']) : null;
        $enteredValues['fname'] = isset($_POST['nfirstname']) ? sanitizeInput($_POST['nfirstname']) : null;
        $enteredValues['lname'] = isset($_POST['nsecondname']) ? sanitizeInput($_POST['nsecondname']) : null;
        $enteredValues['phoneNumber'] = isset($_POST['nphone']) ? sanitizeInput($_POST['nphone']) : null;
        $enteredValues['email'] = isset($_POST['nemail']) ? sanitizeInput($_POST['nemail']) : null;
        $enteredValues['county'] = isset($_POST['ncounty']) ? sanitizeInput($_POST['ncounty']) : null;
        $enteredValues['gender'] = isset($_POST['ngender']) ? sanitizeInput($_POST['ngender']) : null;
        $enteredValues['maritalstatus'] = isset($_POST['nmaritalstatus']) ? sanitizeInput($_POST['nmaritalstatus']) : null;
        $enteredValues['dependents'] = isset($_POST['ndependents']) ? sanitizeInput($_POST['ndependents']) : null;
        $enteredValues['educationlevel'] = isset($_POST['neducationlevel']) ? sanitizeInput($_POST['neducationlevel']) : null;
        $enteredValues['employment'] = isset($_POST['nemployment']) ? sanitizeInput($_POST['nemployment']) : null;
        $enteredValues['income'] = isset($_POST['nincome']) ? sanitizeInput($_POST['nincome']) : null;

        // Validate National ID (8 digits only)
        if (!preg_match('/^\d{8}$/', $enteredValues['nidNumber'])) {
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

        // If there are validation errors, display them
        if (!empty($validationErrors)) {
            // Store entered values and errors in $_SESSION
            $_SESSION['enteredValues'] = $enteredValues;
            $_SESSION['validationErrors'] = $validationErrors;
        } else {
            // No validation errors, proceed with the form processing

            // Update data in the database using prepared statement

            $sql = "UPDATE farmers
                SET 
                    `idNumber` = ?, `fname` = ?, `lname` = ?, `phoneNumber` = ?, `email` = ?, `county` = ?, `gender` = ?, `maritalstatus` = ?,  
                    `dependents` = ?,  
                    `educationlevel` = ?,  
                    `employment` = ?, 
                    `income` = ? 
                WHERE 
                    `idNumber` = $idNumber";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                'ssssssssissi',
                $enteredValues['nidNumber'],
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
            );
            
            if ($stmt->execute()) {
                // Success
                echo "<script>
                        alert('Profile updated successfully!');
                        window.location.href = 'greentemplate/profile.php';
                    </script>";

               
                // echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                // <script>
                //     document.addEventListener('DOMContentLoaded', function() {
                //         Swal.fire({
                //             icon: 'success',
                //             title: 'Profile Updated Successfully!',
                //             showConfirmButton: false,
                //             timer: 2000
                //         }).then((result) => {
                //             window.location.href = 'greentemplate/profile.php';
                //         });
                //     });
                // </script>";
                

                exit();
            } else {
                echo "Error updating data in the database.";
            }
            // Clear entered values from $_SESSION after processing
            unset($_SESSION['enteredValues']);
        }
    }
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

        .details-container {
            display: flex;
            flex-direction: column;
            max-width: 600px;
            margin: 5% auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            width: 60%;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .text-area {
            flex-grow: 1;
        }

        /* .separator {
            width: 1px;
            background-color: #ddd;
            margin: 0 10px; /* Adjust the margin as needed }*/
         */

        .details-container form input,
        .details-container form select {
            /* width: 100%; */
            padding: 8px;
            border: none;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .btn {
            width: 48%; /* Adjust width for buttons */
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 4%;
            background-color: #0d6efd;
            color: #fff;
        
        }
        .btnc {
            width: 48%;
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            margin-right: 4%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .details-container form select {
            border: none;
            border-bottom: 1px solid #ddd; /* Add a bottom border to separate fields */
            margin-bottom: 10px; /* Add margin between fields */
        }

        /* Add this style to remove the border for the last input/select in each row */
        .details-container form .detail-row:last-child input,
        .details-container form .detail-row:last-child select {
            border-bottom: none;
            margin-bottom: 0;
        }
        /* Style for labels */




        /* Remove default select arrow */
        .details-container form select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23555555" width="18px" height="18px"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 100%;
            background-position-y: center;
        }



        /* Style for error messages */
        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px; /* Adjust the margin as needed */
        }

        /* Style for the cancel button */

        .details-container form .btnc:hover  {
                    background-color: black;
                }

                


        /* Optional: Add hover effect for buttons */
        .details-container form .btn:hover {
            background-color: black;
            color: #fff;
        }/* Style for labels and inputs in a grid */

        .details-container form {
            display: grid;
            gap: 10px;
        }

        /* Style for labels */
        label {
            color: #2c5e3f;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

    </style>
    <script>
        function cancel() {
            window.location.href = "greentemplate/profile.php";
        }

        function updatesuccessful() {
            alert("Your profile has been updated successfully");
            window.location.href = "greentemplate/profile.php";
        }
    </script>
</head>
<body>
    
        <?php
            $sql = "SELECT * FROM farmers WHERE idNumber = $idNumber";
            $select = mysqli_query($conn, $sql);
            if(mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
            
            // Display validation errors at the top of the form
            if (!empty($validationErrors)) {
                foreach ($validationErrors as $error) {
                    echo '<p class="error">' . $error . '</p>';
                }
            }
        ?>
    <div class="container">
        <div class="details-container">
      
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" id="updateProfileForm">

            <label for="idNumber">IDNumber</label>
            <input type="text" id="nidNumber" name="nidNumber" value="<?php echo $fetch['idNumber']; ?>" oninput="restrictInputToNumbers(this);">
            <?php if(in_array('National ID must be 8 digits.', $validationErrors)): ?>
                <span class="error"><?php echo 'National ID must be 8 digits.'; ?></span>
            <?php endif; ?><br>

            <label for="firstname">First Name:</label>
            <input type="text" id="nfirstname" name="nfirstname" value="<?php echo $fetch['fname']; ?>" required>
            <?php if(in_array('Name should contain only letters.', $validationErrors)): ?>
                <span class="error"><?php echo 'Name should contain only letters.'; ?></span>
            <?php endif; ?><br>

            <label for="nsecondname">Second Name:</label>
            <input type="text" id="nsecondname" name="nsecondname" value="<?php echo $fetch['lname']; ?>" required>
            <?php if (in_array('Name should contain only letters.', $validationErrors)): ?>
                <span class="error"><?php echo 'Name should contain only letters.'; ?></span>
            <?php endif; ?><br>

            <label for="nphone">Phone Number:</label>
            <input type="tel" id="nphone" name="nphone" value="<?php echo $fetch['phoneNumber']; ?>" oninput="phoneNumbers(this)" required>
            <?php if (in_array('Phone number must start with 254 and be 12 digits.', $validationErrors)): ?>
                <span class="error"><?php echo 'Phone number must start with 254 and be 12 digits.'; ?></span>
            <?php endif; ?><br>

            <label for="nemail">Email Address:</label>
            <input type="email" id="nemail" name="nemail" value="<?php echo $fetch['email']; ?>" required>
            <?php if (in_array('Invalid email address.', $validationErrors)): ?>
                <span class="error"><?php echo 'Invalid email address.'; ?></span>
            <?php endif; ?><br>

            <label for="ncounty">County:</label>
            <select id="ncounty" name="ncounty" required>
                <option value="UasinGishu" <?php echo ($fetch['county'] == 'UasinGishu') ? 'selected' : ''; ?>>UasinGishu</option>
                <option value="TransNzoia" <?php echo ($fetch['county'] == 'TransNzoia') ? 'selected' : ''; ?>>TransNzoia</option>
                <!-- Add more options for other counties as needed -->
            </select>
            

            <label for="ngender">Gender:</label>
            <select id="ngender" name="ngender" required>
                <option value="male" <?php echo ($fetch['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($fetch['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                <!-- Add more options for other genders as needed -->
            </select>
            

                <label for="nmaritalstatus">Marital Status:</label>
                <select id="nmaritalstatus" name="nmaritalstatus" required>
                    <option value="single" <?php echo ($fetch['maritalstatus'] == 'single') ? 'selected' : ''; ?>>Single</option>
                    <option value="married" <?php echo ($fetch['maritalstatus'] == 'married') ? 'selected' : ''; ?>>Married</option>
                </select>
                

                <label for="ndependents">Number of Dependents:</label>
                <input type="number" id="ndependents" name="ndependents" value="<?php echo $fetch['dependents']; ?>" required>

                <label for="neducationlevel">Education Level:</label>
                <select id="neducationlevel" name="neducationlevel" required>
                    <option value="graduate">Graduate</option>
                    <option value="notgraduate">Not a Graduate</option>
                </select>

                <label for="nemployment">Employment:</label>
                <select id="nemployment" name="nemployment" required>
                <option value="self-employed">Self-employed</option>
                <option value="employed">Employed</option>
                </select>

                <label for="nincome">Monthly Income:</label>
                <input type="text" id="nincome" name="nincome" value="<?php echo $fetch['income']; ?>" required>
                <?php if (in_array('Invalid monthly income.', $validationErrors)): ?>
                    <span class="error"><?php echo 'Invalid monthly income.'; ?></span>
                <?php endif; ?>
                <div class="button-container">
                    <input type="submit" value="submit" name="submit" class="btn" >
                    <button id="cancel" onclick="cancel()" class="btnc">Cancel</button>
                </div>
            </form>
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
</body>
</html>
