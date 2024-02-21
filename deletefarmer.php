<?php
// Include your database connection code here
include "config/databaseconfig.php";

// Check if the idNumber is set
if (isset($_POST['idNumber'])) {
    $idNumber = $_POST['idNumber'];

    try {
        // Start a transaction
        mysqli_autocommit($conn, false);

        // Execute SQL statement to delete the row
        $sql = "DELETE FROM farmers WHERE idNumber = '$idNumber'";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception('Error deleting farmer: ' . mysqli_error($conn));
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
    echo 'error: Farmer ID not set';}
?>

<div id="content">
        <button onclick="toggleAgrodealerForm()"> Add agrodealer </button>

        <!-- Form to add agrodealer (initially hidden) -->
        <div id="agrodealerForm" style="display: none;">
            <h2>Add Agrodealer</h2>
            <form id="agrodealerForm" action="" method="POST">
                <table>
                    <tr>
                        <td>ID:</td>
                        <td><input type="text" name="agrodealerId" required></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="agrodealerName" required></td>
                    </tr>
                    <tr>
                        <td>Region:</td>
                        <td><input type="text" name="agrodealerRegion" required></td>
                    </tr>
                </table>
                <button type="submit" name="submitAgrodealer">Submit</button>
            </form>
        </div>
