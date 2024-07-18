<?php
include "../config/databaseconfig.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = $search ? " AND (productName LIKE '%$search%' OR category LIKE '%$search%')" : '';

$select = "SELECT * FROM products WHERE status ='Active' $whereClause";
$selectresult = mysqli_query($conn, $select);
echo"<thead>
<tr>
    <th>Product ID</th>
    <th>Product Name</th>
    <th>Image Path</th>
    <th>Category</th>
    <th>Price</th>
</tr>
</thead>
<tbody>";

if (mysqli_num_rows($selectresult) > 0) {
    while ($row = mysqli_fetch_assoc($selectresult)) {
        echo "<tr>";
        echo "<td>" . $row['product_id']. "</td>";
        echo "<td>" . $row['productName']. "</td>";
        echo "<td>" . $row['image_path'] . "</td>";
        echo "<td>" . $row['category']. "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No data found</td></tr>";
}
echo "</tbody>";
echo "</table>";
mysqli_close($conn);
?>
