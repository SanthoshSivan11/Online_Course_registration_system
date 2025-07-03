<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    if (isset($_POST['id']) && isset($_POST['status'])) {


        $id = $_POST['id'];
        $status = $_POST['status'];

     $conn = new mysqli("localhost", "root", "", "admission_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if (!in_array($status, ['accepted', 'rejected'])) {
            die("Invalid status");
        }

        $sql = "UPDATE students SET status = '$status' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "❌ Error: " . $conn->error;
        }

        $conn->close();
    } else {
        die("Missing form data.");
    }
}
?>
