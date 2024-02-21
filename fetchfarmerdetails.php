<?php include "config/databaseconfig.php";?>
<?php
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idNumber'])) {
                $idNumber = $_POST['idNumber'];
                $_SESSION['idNumber'] = $idNumber;

                // Use prepared statements to prevent SQL injection
                $sql = "SELECT * FROM farmers WHERE idNumber = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $idNumber);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $fetch = $result->fetch_assoc();
                    echo json_encode(['success' => true, 'data' => $fetch]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No data found for the given ID number']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID number not provided']);
            }
            $stmt->close();
            $conn->close();
            exit(); // Terminate the script after sending the response
        }
?>