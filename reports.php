<?php include "config/databaseconfig.php";
session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
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

        #content {
            margin-left: 240px;
            padding: 20px;
        }
        #card {
            display: none;
           
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        #card2 {
            display: none;
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        #card3 {
            display: none;
            width: 70%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table {
            width: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <script>
        function toggleCard() {
            var card = document.getElementById('card');
            card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        }
        function toggleCard2() {
            var card = document.getElementById('card2');
            card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        }
        function toggleCard3() {
            var card = document.getElementById('card3');
            card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        }
    </script>
</head>

<body>
      <header>
            <h1>Reports</h1>
    </header>


    <div id="sidebar">
        <a href="adminhome.php">Home</a>
        <a href="reports.php">Generate reports</a>
        <a href="loanapproval.php">Loan Approval</a>
        <a href="logoutadmin.php">Logout</a>
    </div> 

    <div id="content">

        Reports
        <button onclick="toggleCard()">Farmer Details </button>

                <div id="card">
                    <h2>Farmers Data</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>phoneNumber</th>
                                <th>Email</th>
                                <th>County</th>
                                <th>Gender</th>
                                <th>Marital Status</th>
                                <th>Dependents</th>
                                <th>Education Level</th>
                                <th>Employment</th>
                                <th>Income</th>
                                <!-- <th>Credit History</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PHP code to fetch data from the farmers table in the database -->
                            <?php

                            $sql = "SELECT * FROM farmers";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['idNumber'] . "</td>";
                                    echo "<td>" . $row['fname'] .$row['lname']. "</td>";
                                    echo "<td>" . $row['phoneNumber'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['county'] . "</td>";
                                    echo "<td>" . $row['gender'] . "</td>";
                                    echo "<td>" . $row['maritalstatus'] . "</td>";
                                    echo "<td>" . $row['dependents'] . "</td>";
                                    echo "<td>" . $row['educationlevel'] . "</td>";
                                    echo "<td>" . $row['employment'] . "</td>";
                                    echo "<td>" . $row['income'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No data found</td></tr>";
                            }

                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>

<!--  -->

    <button onclick="toggleCard3()">Pending Loans </button>
    
        <div id="card3">
                <table>
                    <thead>
                        Pending loans
                        <tr>
                            <th>Loan Id</th>
                            <th>IdNumber</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th>Dependents</th>
                            <th>Education Level</th>
                            <th>Employment</th>
                            <th>Income</th>
                            <th>Loan Amount</th>
                            <th>Loan Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        // Fetch data from the farmers table
                        $sql = "SELECT * FROM farmer_details WHERE loanstatus = 'Pending'";                        $result = mysqli_query($conn, $sql);

                        if ($result === false) {
                            throw new Exception("Error executing the query: " . mysqli_error($conn));
                        }

                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['loanid'] . "</td>";
                                echo "<td>" . $row['idNumber'] . "</td>";
                                echo "<td>" . $row['fname'] . "</td>";
                                echo "<td>" . $row['gender'] . "</td>";
                                echo "<td>" . $row['maritalstatus'] . "</td>";
                                echo "<td>" . $row['dependents'] . "</td>";
                                echo "<td>" . $row['educationlevel'] . "</td>";
                                echo "<td>" . $row['employment'] . "</td>";
                                echo "<td>" . $row['income'] . "</td>";
                                echo "<td>" . $row['loaned_amount'] . "</td>";
                                echo "<td>" . $row['loanstatus'] . "</td>";

                                


                                echo "</tr>";
                            }
                        } else {
                            echo "<p>No data found</p>";
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    mysqli_close($conn);
                    ?>
                    </tbody>
                </table>
        </div> 
        
        
    </div>
    
    

</body>

</html>
