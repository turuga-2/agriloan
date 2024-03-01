<?php
include "config/databaseconfig.php";

$selectedColumns = json_decode($_POST['columns']);
$selectedColumnsString = implode(", ", $selectedColumns);

$sql = "SELECT $selectedColumnsString FROM farmers";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table>
            <thead>
                <tr>";
    foreach ($selectedColumns as $column) {
        echo "<th>$column</th>";
    }
    echo "<th>Actions</th>
            </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($selectedColumns as $column) {
            echo "<td>" . $row[$column] . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>
        </table>";
} else {
    echo "<p>No data found</p>";
}

mysqli_close($conn);
?>
