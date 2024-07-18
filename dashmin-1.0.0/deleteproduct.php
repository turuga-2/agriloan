<?php
// Include your database connection code here
include "../config/databaseconfig.php";

// Check if the idNumber is set
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    try {
        // Start a transaction
        mysqli_autocommit($conn, false);

        // Execute SQL statement to delete the row
        $sql = "UPDATE `products` SET `status`='[Inactive]' WHERE product_id = '$product_id'";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception('Error deleting : ' . mysqli_error($conn));
        }

        // Commit the transaction
        mysqli_commit($conn);

        // Return a success response
        echo 'success';
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        mysqli_rollback($conn);

        // Return an error response
        echo 'error: ' . $e->getMessage();
    } finally {
        // Close the database connection
        mysqli_close($conn);
    }
} else {
    // Return an error response if idNumber is not set
    echo 'error: product ID not set';}
?>

