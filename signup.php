<?php include "config/databaseconfig.php";
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- > -->
    <title> SignUp </title>
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

   
    </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="container">
        <h1></h1>
        <p>Please enter your details to Sign-up</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"
        method="post"  autocomplete="on" id="accountForm">
            
            <label for="idNumber">IDNumber</label>
            <input type="text" id="idNumber" name="idNumber" placeholder="IDNumber" oninput="restrictInputToNumbers(this);">
            
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="FirstName" required>
            
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="lastName" required>
            
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" placeholder="PhoneNumber" oninput="phoneNumbers(this)" required>
            
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

                <p>insert a copy of your CRB clearance certificate below</p>
                <label for="crbcertpath">Choose a PDF file:</label>
                <input type="file" id="crbcertpath" name="crbcertpath" accept=".pdf">


            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password"
                        required >
            
            
 
            
            <input type="submit"  value="submit" name="submit" class="btn">
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
        <?php
        // Function to sanitize input
        function sanitizeInput($data) {
            global $conn;
            return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
        }
        try{

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

    // Check if the passwords match
    // if ($password !== $confirmPassword) {
    //     throw new Exception("Passwords do not match.");
    // }
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
       // File upload handling
       $uploadDir = "uploads/";
       $crbCertPath = $uploadDir . basename($_FILES["crbcertpath"]["name"]);

       // Upload the file
       if (move_uploaded_file($_FILES["crbcertpath"]["tmp_name"], $crbCertPath)) {
           echo "File uploaded successfully.";
       } else {
           throw new Exception("Error uploading file.");
       }

       // Insert data into the database
       $sql = "INSERT INTO `farmers` (`idNumber`, `fname`, `lname`, `phoneNumber`, `email`, `county`, `gender`, `maritalstatus`, `dependents`, `educationlevel`, `employment`, `income`, `crbcertpath`, `password`) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

       $stmt = $conn->prepare($sql);
       $stmt->bind_param(
           'ssssssssssssss',
           $idNumber,
           $fname,
           $lname,
           $phoneNumber,
           $email,
           $county,
           $gender,
           $maritalstatus,
           $dependents,
           $educationlevel,
           $employment,
           $income,
           $crbCertPath,
           $hashedPassword
       );

       if ($stmt->execute()) {
           // Success
           echo "Data saved successfully.";
           header("Location: farmerlogin.php");
           exit();
       } else {
           throw new Exception("Error inserting data into the database.");
       }
   }
} catch (Exception $e) {
   // Handle exceptions here
   echo "Error: " . $e->getMessage();
}

$conn->close();
    
    ?>

    <script>
//          document.getElementById('accountForm').addEventListener('submit', function (event) {
//             event.preventDefault();

           
//             // Assuming the form submission was successful, show the success popup
//             // Check if Swal is defined
//     if (typeof Swal !== 'undefined') {
//         // Assuming the form submission was successful, show the success popup
//         Swal.fire({
//             icon: 'success',
//             title: 'Account Created Successfully!',
//             showConfirmButton: false,
//             timer: 2000, // Automatically close after 2 seconds
            
//         }).then((result) => {
//             // Redirect to the login page after the modal is closed
//             if (result.dismiss === Swal.DismissReason.timer) {
//                 window.location.href = 'farmerlogin.php';
//             }});
//      }else {
//         // Log an error if Swal is not defined
//         console.error('SweetAlert (Swal) is not defined. Make sure the script is properly included.');
//     }
// });
        
        
    </script>