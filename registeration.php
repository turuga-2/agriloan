<?php
include "config/databaseconfig.php";
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $agrodealerName = $_POST['agrodealerName'];
    $agrodealerRegion = $_POST['agrodealerRegion'];

    // Echo the POST details for debugging
    echo "Agrodealer Name: " . $agrodealerName . "<br>";
    echo "Agrodealer Region: " . $agrodealerRegion . "<br>";

    // Execute SQL statement to insert into the agrodealers table
    $sql = "INSERT INTO agrodealers (`name`, `region`) VALUES ('$agrodealerName', '$agrodealerRegion')";

    // Perform the database query
    if (mysqli_query($conn, $sql)) {
        // Commit the transaction
        mysqli_commit($conn);

        // Set success response
        echo 'Agrodealer added successfully';
    } else {
        // Rollback the transaction in case of an error
        mysqli_rollback($conn);

        // Set error response
        echo 'Error adding agrodealer: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
