<?php
include "config/databaseconfig.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

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

        #farmerTable {
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

        #farmerTable th,
        #farmerTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #farmerTable th {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <header>
        <h1>Dashboard</h1>
    </header>

    <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="registeration.php">Register agrodealer</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Loan Approval</a>
        <a href="logoutadmin.php">Logout</a>
    </div>

    <div id="top">
        <!-- Your main content goes here -->
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Select an option from the sidebar to navigate to different pages.</p>
        <h3>Quick actions</h3>
    </div>

    <div id="content">
        <button onclick="toggleFarmerTable()">Delete farmer record</button>
        <div id="farmerTable">
            <table>
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>phoneNumber</th>
                        <th>Email</th>
                        <th>County</th>
                        <!-- Add more table headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Fetch data from the farmers table
                        $sql = "SELECT * FROM farmers";
                        $result = mysqli_query($conn, $sql);

                        if ($result === false) {
                            throw new Exception("Error executing the query: " . mysqli_error($conn));
                        }

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr id='row_" . $row['idNumber'] . "'>";
                                echo "<td>" . $row['idNumber'] . "</td>";
                                echo "<td>" . $row['fname'] . "</td>";
                                echo "<td>" . $row['lname'] . "</td>";
                                echo "<td>" . $row['phoneNumber'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['county'] . "</td>";
                                // Add the delete button with onclick event passing idNumber
                                echo "<td><button class='deleteBtn' onclick='deleteFarmer(\"" . $row['idNumber'] . "\")'>Delete Record</button></td>";
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
                    echo "<td><button onclick='closeFarmerTable()'>Close Farmer Table</button></td>";
                    echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agrodealerModal">
        Add agrodealer
        </button>
        <!-- Modal -->
        <button onclick="openAgrodealerModal()"> Add agrodealer </button>

<!-- Form to add agrodealer (initially hidden) -->
<div id="agrodealerForm" style="display: none;">
    <h2>Add Agrodealer</h2>
    <form id="agrodealerForm" action="" method="POST">
        
            
            <tr>
                <td>Name:</td>
                <td><input type="text" name="agrodealerName" required></td>
            </tr>
            <tr>
                <td>Region:</td>
                <td><input type="text" name="agrodealerRegion" required></td>
            </tr>
        </table>
        <button onclick="addAgrodealer()" name="submitAgrodealer">Submit</button>
    </form>
</div>


        <button> Remove agrodealer </button>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Function to open the Agrodealer Modal
    function openAgrodealerModal() {
            var agrodealerModal = document.getElementById('agrodealerForm');
            agrodealerModal.style.display = 'block';
        }// Function to add an agrodealer using AJAX
    function addAgrodealer() {
        // Retrieve agrodealer name and region
        var agrodealerName = document.getElementById('agrodealerName').value;
        var agrodealerRegion = document.getElementById('agrodealerRegion').value;

        // AJAX request to the PHP script
        $.ajax({
            type: 'POST',
            url: 'registeration.php', // Change this to the actual PHP script file
            data: { agrodealerName: agrodealerName, 
            agrodealerRegion: agrodealerRegion },
            success: function (response) {
                // Handle the response (e.g., show a success message)
                Swal.fire({
                    icon: 'success',
                    title: 'Agrodealer added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                });

                // You can also close the modal if needed
                $("#agrodealerModal").modal("hide");
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    }

        // Perform AJAX request or form submission to delete record
        function toggleFarmerTable() {
            var farmerTable = document.getElementById('farmerTable');
            farmerTable.style.display = (farmerTable.style.display === 'none' || farmerTable.style.display === '') ? 'block' : 'none';
        }

        // Function to delete a farmer record
        function deleteFarmer(idNumber) {
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
                    url: 'deletefarmer.php', // Adjust the file name accordingly
                    data: { idNumber: idNumber },
                    success: function (response) {
                        // Handle the response (e.g., show a success message)
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The farmer has been deleted.',
                            icon: 'success'
                        });
                        //reloadFarmerTable();
                        // Optionally, you can also remove the row from the HTML table
                        $(`#row_${idNumber}`).remove();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }
    function closeFarmerTable() {
        var farmerTable = document.getElementById('farmerTable');
        farmerTable.style.display = 'none';
    }

    </script>

</body>

</html>
