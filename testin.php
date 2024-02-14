<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags, title, and other head elements... -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

   

    <script>
        // Your JavaScript code...
        const idNumber = '123'; // Replace with your actual JavaScript variable

        // Embed the JavaScript variable in PHP
        <?php echo "var jsIdNumber = $idNumber;"; ?>

        // Now you can use jsIdNumber in your PHP code
        console.log("JavaScript variable in PHP: " + jsIdNumber);
    </script>

</body>

</html>
