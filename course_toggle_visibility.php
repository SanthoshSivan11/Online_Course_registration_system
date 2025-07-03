<?php
session_start();
include("database/dbconnect.php");


if (isset($_POST['course_id'])) {
    $id = intval($_POST['course_id']);
    $is_hidden = isset($_POST['is_hidden']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE courses SET is_hidden = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_hidden, $id);
    $stmt->execute();

    $_SESSION['message'] = $is_hidden 
        ? '<p class="message_added" style="font-size:20px; font-weight:bold;">Course Activated.</p>'
        : '<p class="message_delete" style="font-size:20px; font-weight:bold;">Course Deactivated.</p>';
}

header("Location: course_management.php");
exit;
?>
