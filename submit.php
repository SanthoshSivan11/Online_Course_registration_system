<?php

$conn = new mysqli("localhost", "root", "", "admission_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$marksheet = uniqid("marksheet_") . "_" . basename($_FILES['marksheet']['name']);
$photo = uniqid("photo_") . "_" . basename($_FILES['photo']['name']);

$marksheet_tmp = $_FILES['marksheet']['tmp_name'];
$photo_tmp = $_FILES['photo']['tmp_name'];


$marksheet_path = "uploads/" . $marksheet;
$photo_path = "uploads/" . $photo;

move_uploaded_file($marksheet_tmp, $marksheet_path);
move_uploaded_file($photo_tmp, $photo_path);


$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$group = $_POST['group'];
$total_marks = $_POST['total_marks'];
$course = $_POST['course'];


$sql = "INSERT INTO students 
    (first_name, last_name, gender, email, phone, dob, address, student_group, total_marks, course, marksheet, photo)
    VALUES 
    ('$first_name', '$last_name', '$gender', '$email', '$phone', '$dob', '$address', '$group', '$total_marks', '$course', '$marksheet_path', '$photo_path')";

if ($conn->query($sql) === TRUE) {
    header("Location: formsubmitted.html");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
