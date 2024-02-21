<?php
include "config/databaseconfig.php";
session_start();
$idNumber = $_SESSION['idNumber'];

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
    $gender = isset($_POST['ngender']) ? sanitizeInput($_POST['ngender']) : null;
    $maritalstatus = isset($_POST['nmaritalstatus']) ? sanitizeInput($_POST['nmaritalstatus']) : null;
    $dependents = sanitizeInput($_POST['ndependents']);
    $educationlevel = isset($_POST['neducationlevel']) ? sanitizeInput($_POST['neducationlevel']) : null;
    $employment = isset($_POST['nemployment']) ? sanitizeInput($_POST['nemployment']) : null;
    $income = sanitizeInput($_POST['nincome']);

    // Update data in the database
    $sql = "UPDATE `farmers` 
        SET 
            `idNumber` = '$nidNumber', 
            `fname` = '$fname', 
            `lname` = '$lname', 
            `phoneNumber` = '$phoneNumber', 
            `email` = '$email',
            `gender` = '$gender',  
            `maritalstatus` = '$maritalstatus',  
            `dependents` = '$dependents',  
            `educationlevel` = '$educationlevel',  
            `employment` = '$employment', 
            `income` = '$income' 
        WHERE 
            `farmers`.`idNumber` = '$idNumber'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to profile.php after successful update
        header("location: profile.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
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
        function cancel() {
            window.location.href = "profile.php";
        }

        function updatesuccessful() {
            alert("Your profile has been updated successfully");
            window.location.href = "profile.php";
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

                <label for="ngender">Gender:</label>
                <select id="ngender" name="ngender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label for="nmaritalstatus">Marital Status:</label>
                <select id="nmaritalstatus" name="nmaritalstatus" required>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
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
                <label for="nincome">Income:</label>
                <input type="text" id="nincome" name="nincome" value="<?php echo $fetch['income']; ?>" required>

                <input type="submit" value="submit" name="submit" class="btn" onclick="updatesuccessful()">
                <button id="cancel" onclick="cancel()">Cancel</button>
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

            // Optionally, you can trim the input to only keep the first 8 characters
            inputField.value = inputField.value.slice(0, 10);
        }
    </script>
</body>
</html>
