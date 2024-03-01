


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Signup</title>
    <!-- Bootstrap CSS -->
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

  document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
      var nationalId = document.getElementById('national_id').value;
      var firstName = document.getElementById('first_name').value;
      var lastName = document.getElementById('last_name').value;
      var phoneNumber = document.getElementById('phone_number').value;
      var email = document.getElementById('email').value;
      var password = document.getElementById('password').value;
      var confirmPassword = document.getElementById('confirm_password').value;

      // Validate National ID (8 digits only)
      if (!/^\d{8}$/.test(nationalId)) {
        alert('National ID must be 8 digits.');
        event.preventDefault();
        return;
      }

      // Validate First Name and Last Name (only letters)
      if (!/^[A-Za-z]+$/.test(firstName) || !/^[A-Za-z]+$/.test(lastName)) {
        alert('Name should contain only letters.');
        event.preventDefault();
        return;
      }

      // Validate Phone Number (10 digits only)
      if (!/^\d{10}$/.test(phoneNumber)) {
        alert('Phone number must be 10 digits.');
        event.preventDefault();
        return;
      }

      // Validate Email
      if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert('Invalid email address.');
        event.preventDefault();
        return;
      }

      // Validate Password
      if (!validatePassword(password)) {
        alert('Password should be at least 8 characters and include letters, symbols, and numbers.');
        event.preventDefault();
        return;
      }

      // Validate Confirm Password
      if (password !== confirmPassword) {
        alert('Passwords do not match.');
        event.preventDefault();
        return;
      }
    });
  });
</script>


</head>
<body>
<div class="container mt-5">
    <h2>User Signup</h2>
    <form  method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="national_id">National ID:</label>
            <input type="text" class="form-control" id="national_id" name="national_id" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control-file" id="photo" name="photo" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



</body>
</html>