document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
      var idNumber = document.getElementById('idNumber').value;
      var firstName = document.getElementById('firstname').value;
      var lastName = document.getElementById('lastname').value;
      var phoneNumber = document.getElementById('phone').value;
      var email = document.getElementById('email').value;
      var password = document.getElementById('password').value;
      var confirmPassword = document.getElementById('confirmpassword').value;

      // Validate National ID (8 digits only)
      if (!/^\d{8}$/.test(idNumber)) {
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