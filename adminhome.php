<?php
include "config/databaseconfig.php";
session_start();
if (!isset($_SESSION['idNumberadmin'])) {
    // Redirect to the login page
    header("Location: adminlogin.php");
    exit(); // Ensure that no further code is executed after the redirect
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        } */

        header {
            background-color: #9da8a2; /* Green header color */
            padding: 15px;
            text-align: center;
        }

        #sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
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

        #top {
            margin-left: 250px;
            padding: 20px;
        }

        #content {
            /* display : flex; */
            margin-left: 250px;
            padding: 20px;
        }

        /* #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        } */

        /* #modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        } */

        #agrodealerTable {
            display: none;
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #agrodealerTable th,
        #agrodealerTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #agrodealerTable th {
            background-color: #333;
            color: white;
        }

        /* Style for delete button */
        .deleteBtn {
            background-color: #e44d26;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <h1>Dashboard</h1>
    </header>

    <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Approval Loans</a>
        <a href="dispatch.php">Dispatch Goods</a>
        <a href="logoutadmin.php">Logout</a>
    </div>

    <div id="top">
        <!-- Your main content goes here -->
        <h1>Welcome to the Admin Dashboard</h1>
        <h3>Quick actions</h3>
    </div>

    <div id="content">
    <button class="btn btn-primary" onclick="toggleAgrodealerTable()">Delete agrodealer record</button>
        <div id="agrodealerTable">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Agrodealer Name</th>
                        <th>Region</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Fetch data from the farmers table
                        $sql = "SELECT * FROM agrodealers";
                        $result = mysqli_query($conn, $sql);

                        if ($result === false) {
                            throw new Exception("Error executing the query: " . mysqli_error($conn));
                        }

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr id='row_" . $row['id'] . "'>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['region'] . "</td>";
                                echo "<td><button class='deleteBtn' onclick='deleteAgrodealer(\"" . $row['id'] . "\")'>Delete Record</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<p>No data found</p>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    mysqli_close($conn);
                    echo "<tr>";
                    echo "<td><button onclick='closeAgrodealerTable()'>Close Agrodealer Table</button></td>";
                    echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agrodealerModal">
            Add Agrodealer
        </button>
        <!-- Bootstrap Modal for Agrodealer Form -->
        <div class="modal" id="agrodealerModal" tabindex="-1" role="dialog" aria-labelledby="agrodealerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agrodealerModalLabel">Add Agrodealer</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Form to add agrodealer -->
                        <form id="agrodealerForm" action="" method="POST">

                        <label for="agrodealerName">Agrodeler Name:</label>
                        <input type="text" id="agrodealerName" name="agrodealerName" placeholder="agrodealerName" required>
                         
                        <label for="agrodealerRegion">Region:</label>
                        <select id="agrodealerRegion" name="agrodealerRegion" required class="dropdown">

                            <option value="UasinGishu" name= "UasinGishu">UasinGishu</option>

                            <option value="TransNzoia" name = "TransNzoia">Transnzoia</option>
                        </select> 

                                   
                            <!-- Submit button inside the modal form -->
                            <button type="button" name="submitAgrodealer" class="btn btn-primary" onclick="addAgrodealer()">Submit</button>
                        </form>
                           
                    </div>
                </div>
            </div>
        </div>

    </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Perform AJAX request or form submission to delete record
        function toggleAgrodealerTable() {
            var agrodealerTable = document.getElementById('agrodealerTable');
            agrodealerTable.style.display = (agrodealerTable.style.display === 'none' || agrodealerTable.style.display === '') ? 'block' : 'none';
        }
        function addAgrodealer() {
    // Retrieve agrodealer name and region
    var agrodealerName = document.getElementById('agrodealerName').value;
    var agrodealerRegion = document.getElementById('agrodealerRegion').value;

// Log the data to the console
console.log('Data to be sent:', { agrodealerName, agrodealerRegion });

    // AJAX request to the PHP script
    $.ajax({
        url: 'registeration.php',
        method: 'POST', // Change this to the actual PHP script file
        data: { 
            agrodealerName: agrodealerName, 
            agrodealerRegion: agrodealerRegion 
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Agrodealer added successfully!',
                showConfirmButton: false,
                timer: 1500
            });
            // You can also close the modal if needed
            $("#agrodealerModal").modal("hide");
        },
        error: function() {
            // Handle errors
            console.log(response);
            Swal.fire({
                icon: 'error',
                title: 'Error adding agrodealer',
                text: 'Please try again later.',
            });
        }
    });
    Swal.fire({
                icon: 'error',
                title: 'Error adding agrodealer',
                text: 'Please try again later.',
            });
}

        // Function to delete a farmer record
        function deleteAgrodealer(id) {
        // Use SweetAlert2 to confirm the deletion
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call a PHP script to handle the deletion
                $.ajax({
                    type: 'POST',
                    url: 'deleteagrodealer.php', // Adjust the file name accordingly
                    data: { id: id },
                    success: function (response) {
                        // Handle the response (e.g., show a success message)
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The agrodealer has been deleted.',
                            icon: 'success'
                        });
                        //reloadFarmerTable();
                        // Optionally, you can also remove the row from the HTML table
                        $(`#row_${id}`).remove();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }
    function closeAgrodealerTable() {
        var agrodealerTable = document.getElementById('agrodealerTable');
        agrodealerTable.style.display = 'none';
    }
    // Renamed function to avoid conflicts with Bootstrap modal
    function openAgrodealerForm() {
        var agrodealerModal = document.getElementById('agrodealerModal');
        agrodealerModal.style.display = 'block';
    }

    </script>

</body>

</html>
