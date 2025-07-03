<?php
session_start();

include 'database/dbconnect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $course_name = trim($_POST['course_name']);
    $group_name = trim($_POST['group_name']);
    $duration = trim($_POST['duration']);

    if (!empty($course_name) && !empty($group_name) && !empty($duration)) {
        $stmt = $conn->prepare("INSERT INTO courses (course_name, group_name, duration) VALUES (?, ?, ?)");

        $stmt->bind_param("sss", $course_name, $group_name, $duration); 
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = '<p class="message_added" style=" font-size:20px; font-weight: bold;">Course Added successfully!</p>';
    } else {
        $_SESSION['message'] = "All fields are required.";
    }
    header("Location: course_management.php");
    exit;
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM courses WHERE id = $id");
    $_SESSION['message'] = '<p class="message_delete" style=" font-size:20px; font-weight: bold;">Course Deleted successfully!</p>';
    header("Location: course_management.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $course_name = trim($_POST['course_name']);
    $group_name = trim($_POST['group_name']);
    $duration = trim($_POST['duration']);

    if (!empty($course_name) && !empty($group_name) && !empty($duration)) {
        $stmt = $conn->prepare("UPDATE courses SET course_name = ?, group_name = ?, duration = ? WHERE id = ?");
        $stmt->bind_param("sssi", $course_name, $group_name, $duration, $id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = '<p class="message_update" style="font-size:20px; font-weight: bold;">Course updated successfully!</p>';
    } else {
        $_SESSION['message'] = "All fields are required to update.";
    }
    header("Location: course_management.php");
    exit;
}

$course_list = $conn->query("SELECT * FROM courses");

$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admission Panel</title>

  <style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
  }



  body {
    min-height: 100vh;
  }

  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 20%;
    height: 100vh;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
  }

  .sidebar h2 {
    font-size: 24px;
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 1px solid #7f8c8d;
    padding-bottom: 10px;
  }

  .sidebar a {
    display: block;
    color: white;
    padding: 12px;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #34495e;
    transition: background 0.3s;
  }

  .sidebar a:hover {
    background-color: #3b5a72;
  }

  .main {
    margin-left: 20%; 
    width: 80%;
    padding: 30px;
    background-color: #f4f6f8;
    min-height: 100vh;
  }

  .main h1 {
    color: #333;
    margin-bottom: 20px;
  }

.input{
    
padding:10px;

}
.form{
    margin-top:10px;
    margin-bottom:20px;
}
.h2{
    margin-top:10px;
}
.update{
    padding:5px;
    background-color:rgb(210, 206, 206);
    transition: background-color 0.3s ease, transform 0.2s ease;
    border-radius:5px ;

}
.update:hover{
  background-color:rgb(125, 124, 119);
    transform: scale(1.05);
}
.delete{
    padding:5px;
    background-color:rgb(251, 94, 94);
    transition: background-color 0.3s ease, transform 0.2s ease;
    border-radius:5px ;

}
.delete:hover {
    background-color:rgb(228, 12, 33);
    transform: scale(1.05);
}

/*----------------------------------------------------*/
.message_added, 
    .message_update,
  .message_delete  {
  animation-duration: 2s;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
  margin-top: 10px;
  display: flex;
  justify-content: center;
  text-align: center;
  font-weight: bold;
  font-size: 20px;
}

.message_added {
  animation-name: glowAddedLow;
}

.message_update {
  animation-name: glowUpdateLow;
}

.message_delete {
  animation-name: glowDeleteLow;
}

@keyframes glowAddedLow {
  0% {
    color:rgb(20, 143, 48);
    text-shadow: 0 0 1px rgba(21, 87, 36, 0.4);
  }
  50% {
    color: #28a745;
    text-shadow: 0 0 4px rgba(40, 167, 69, 0.6);
  }
  100% {
    color: rgb(20, 143, 48);
    text-shadow: 0 0 1px rgba(21, 87, 36, 0.4);
  }
}


@keyframes glowUpdateLow {
  0% {
    color: rgb(255, 187, 0);
    text-shadow: 0 0 1px rgba(255, 187, 0, 0.4);
  }
  50% {
    color: rgb(255, 215, 60);
    text-shadow: 0 0 4px rgba(255, 215, 60, 0.6);
  }
  100% {
    color: rgb(255, 187, 0);
    text-shadow: 0 0 1px rgba(255, 187, 0, 0.4);
  }
}

@keyframes glowDeleteLow {
  0% {
    color: rgb(246, 4, 4);
    text-shadow: 0 0 1px rgba(246, 4, 4, 0.4);
  }
  50% {
    color: rgb(255, 80, 80);
    text-shadow: 0 0 4px rgba(255, 80, 80, 0.6);
  }
  100% {
    color: rgb(246, 4, 4);
    text-shadow: 0 0 1px rgba(246, 4, 4, 0.4);
  }
}

/*----------------------------------------------------*/

.h2_message {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 20px;
  gap: 20px;
}
  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
table-layout: fixed; 
  }
.inputbox{

  width: 100%;
  padding : 5px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
}
  th, td {
    
padding: 5px;
    border: 1px solid #ddd;
    padding:20px;
    text-align: center;
    font-size : 16px;
  }

  th {
    background-color: #333;
    color: white;
  }

  tr:hover {
    background-color: #f5f5f5;
  }

  a {
    text-decoration: none;
    color: #333;
  }

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 25px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgb(247, 44, 3); /* RED when OFF */
  transition: 0.3s ease-in-out;
  border-radius: 25px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 19px;
  width: 19px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.3s ease-in-out;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: rgb(33, 243, 79); 
}

input:checked + .slider:before {
  transform: translateX(25px);
}


</style>

</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Admission</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="course_management.php">Course Management</a>
  </div>

  <!-- Main Content -->
  <div class="main">

  
<div class="fixed">


     <h2>Add New Course</h2>
    <form method="post" class="form">
        <input type="text" class="input" name="course_name" placeholder="Course Name" required>
        <input type="text" class="input" name="group_name" placeholder="Group" required>
        <input type="text" class="input" name="duration" placeholder="Duration ( Ex: 4 Years)" required>
        <button type="submit" class="input" name="add">Add Course</button>
    </form>

    <hr>

    <div class="h2_message">

    <h2 class="h2">Existing Courses</h2>
    <?php if (isset($_SESSION['message'])): ?>

<div>
    <?= $_SESSION['message']; unset($_SESSION['message']); ?>
  </div>
<?php endif; ?>

</div>

</div>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Course Name</th>
            <th>Group</th>
            <th>Duration</th>
            <th>Update</th>
            <th>Active Status</th>
        </tr>

        <?php while ($course = $course_list->fetch_assoc()): ?>
            <?php if ($edit_id === (int)$course['id']): ?>
                
                <form method="post">
                    <tr>
                        <td><?= $course['id']; ?><input type="hidden" name="id" value="<?= $course['id']; ?>"></td>
                        <td><input type="text" class="inputbox" name="course_name" value="<?=($course['course_name']); ?>"></td>
                        <td><input type="text" class="inputbox" name="group_name" value="<?=($course['group_name']); ?>"></td>
                        <td><input type="text" class="inputbox" name="duration" value="<?=($course['duration']); ?>"></td>
                        <td>
                            <button type="submit" name="update">Save</button>
                            <a href="course_management.php">Cancel</a>
                        </td>
                    </tr>
                </form>
            <?php else: ?>
              
                <tr>
                    <td><?= $course['id']; ?></td>
                    <td><?= ($course['course_name']); ?></td>
                    <td><?= ($course['group_name']); ?></td>
                    <td><?= ($course['duration']); ?></td>
                    <td>
                        <a class="update" href="course_management.php?edit=<?= $course['id']; ?>">Update</a>
                        
<td>
    <form method="POST" action="course_toggle_visibility.php" onChange="this.submit();">
        <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
        <label class="switch">
            <input type="checkbox" name="is_hidden" <?= $course['is_hidden'] ? 'checked' : '' ?>>
            <span class="slider"></span>
        </label>
    </form>
</td>





                </tr>

            <?php endif; ?>
        <?php endwhile; ?>

    </table>

  </div>

</body>
</html>

