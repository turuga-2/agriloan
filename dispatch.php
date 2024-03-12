<?php
// Assuming you've already established a database connection
include "config/databaseconfig.php";
if (!isset($_SESSION['idNumberadmin'])) {
    // Redirect to the login page
    header("Location: adminlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}

// Your SQL query to select data from the "loans" table where loanstatus is "Active"
$select = "SELECT * FROM loans WHERE loanstatus = 'Active' AND dispatch_status = 'Pending'";
$result = mysqli_query($conn, $select);

// Check if the query was successful
if ($result) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dispatch</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

        <style>
        #sidebar {
            height: 100%;
            width: 250px;
            position: absolute;
            left: 0;
            background-color: #333;
            padding-top: 20px;
        }

        #sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        #sidebar a:hover {
            background-color: #555;
        }
        </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('table').dataTable();

   // $('#dispatchtable').DataTable();
}); 
</script>
    
    

</head>
<body>
<div id="sidebar">
        
    </div> 
    <!-- Create a table to display the results -->
    <table border="1">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>F_idNumber</th>
                <th>Loan Amount</th>
                <th>Loan status</th>
                <th>Application Date</th>
                <th>Approval Date</th>
                <th>Dispatch status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display them in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr id='row_" . $row['loanid'] . "'>";
                echo "<td>" . $row['loanid'] . "</td>"; 
                echo "<td>" . $row['F_idNumber'] . "</td>";
                echo "<td>" . $row['grandtotal'] . "</td>";
                echo "<td>" . $row['loanstatus'] . "</td>";
                echo "<td>" . $row['applicationdate'] . "</td>"; 
                echo "<td>" . $row['approvaldate'] . "</td>";
                echo "<td>" . $row['dispatch_status'] . "</td>";
                echo "<td><button class='Btn' onclick='dispatch(\"" . $row['loanid'] . "\")'> Dispatch </button> </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
           

    <?php
} else {
    // If the query was not successful, display an error message
    echo "Error executing query: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
<script>
    function dispatch (loanid){
    Swal.fire({
            title: 'Are you sure?',
            text: 'You want to dispatch this loan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, dispatch it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a PHP script to handle the deletion
                $.ajax({
                    type: 'POST',
                    url: 'dispatching.php', // Adjust the file name accordingly
                    data: { loanid: loanid },
                    success: function (response) {
                        // Handle the response (e.g., show a success message)
                        Swal.fire({
                            title: 'Dispatch!',
                            text: 'The goods have been dispatched to the farmer.',
                            icon: 'success'
                        });
                        
                        $(`#row_${loanid}`).remove();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
}
</script>
</body>
</html>