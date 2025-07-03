<?php
session_start();
include 'database/dbconnect.php';


if (!isset($_POST['user']) || !isset($_POST['pass'])) {
    header("Location: admin_login.php");
    exit();
}


$name = htmlspecialchars(trim($_POST['user']));
$password = trim($_POST['pass']);


$sql = "SELECT * FROM admin WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows >= 1) {
    $row = $result->fetch_assoc();


    if (password_verify($password, $row['password'])) {

        session_regenerate_id(true);
        $_SESSION['admin'] = $name;
        $_SESSION['admin_name'] = $row['name'];


        header("Location: admin_dashboard.php");
        exit();
    } else {
        
        echo "<div style='
            padding: 15px;
            margin: 20px auto;
            max-width: 400px;
            background-color: #ffe6e6;
            color: #cc0000;
            border: 1px solid #cc0000;
            border-radius: 6px;
            text-align: center;
            font-family: Arial;
        '>
            Invalid password. <a href='admin_login.php' style='color: #cc0000; text-decoration: underline;'>Try again</a>
        </div>";
    }
} else {
   
    echo "<div style='
        padding: 15px;
        margin: 20px auto;
        max-width: 400px;
        background-color: #ffe6e6;
        color: #cc0000;
        border: 1px solid #cc0000;
        border-radius: 6px;
        text-align: center;
        font-family: Arial;
    '>
        Admin name not found. <a href='admin_login.php' style='color: #cc0000; text-decoration: underline;'>Try again</a>
    </div>";
}


$conn->close();
?>
