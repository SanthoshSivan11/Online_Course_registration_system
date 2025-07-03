<?php
session_start();

include 'database/dbconnect.php';


if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


$status = isset($_GET['status']) ? $_GET['status'] : 'all';

if ($status === 'all') {
    $sql = "SELECT * FROM students";
} else {
    $sql = "SELECT * FROM students WHERE status = '$status' ORDER BY created_at DESC";
}
$result = $conn->query($sql);

$count_sql = "SELECT 
    SUM(status = 'accepted') AS accepted_count,
    SUM(status = 'rejected') AS rejected_count,
    SUM(status = 'pending') AS pending_count
    FROM students";

$count_result = $conn->query($count_sql);
$counts = $count_result->fetch_assoc();



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
    font-family: Arial;
  }

  body {
    display: flex;
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


  .top{
    display : flex;
    align-items:center;
    justify-content: space-between;
  }

.big-line {
  height: 3px;
  width: 100%;
  background: linear-gradient(to right, #3498db, #2ecc71); 
  border-radius: 4px;
  margin-top: 20px; 
  margin-bottom: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}

  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
  
  }

  th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
    overflow: hidden; 
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

.status-filter {
  margin: 20px 0;
  display: flex;
  gap: 10px;
  justify-content: left;
}

.status-filter a {
  padding: 8px 16px;
  background-color: #e0e0e0;
  color: #333;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s;
}

.status-filter a:hover {
  background-color:rgb(36, 231, 245);
  color: white;
}

.status-pending {
  background-color: #ffe0b2; 
  color: #e65100;            
  font-weight: bold;
  padding: 3px;
}

.status-accepted {
  background-color: #c8e6c9; 
  color: #2e7d32;            
  font-weight: bold;
  padding: 3px;
  
}

.status-rejected {
  background-color: #ffcdd2;
  color: #c62828;            
  font-weight: bold;
  padding: 3px;
}

.glow{
  padding: 10px;
  margin: 0px;
  border: 2px solid transparent;
  border-radius: 10px;

  font-weight: bold;
  text-align: center;

  animation: multiGlow 4s infinite ease-in-out;
}
@keyframes multiGlow {
  0% {
    border-color: red;
  }
  25% {
    border-color: orange;
  }
  50% {
    border-color: limegreen;
  }
  75% {
    border-color: yellow;
  }
  100% {
    border-color: red;
  }
}
.view{
  padding:5px;
  font-size:15px;
    background-color:rgb(30, 254, 79);
    transition: background-color 0.3s ease, transform 0.2s ease;
    border-radius:3px ;
/*border: 2px solid rgb(30, 254, 79);  */

}
.view:hover {
  background-color: rgb(164, 248, 182);
  transform: scale(1.05);
  border-radius: 5px;
  border: 2px solid rgb(30, 254, 79); 
}


</style>

</head>
<body>

  <div class="sidebar">
    <h2>Admission</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="course_management.php">Course Management</a>
  </div>

  <div class="main">



<div class="top">
  
<h2>Applications</h2>


<div class="glow ">
 <p><strong><?=($_SESSION['admin_name']) ?></strong> |
  <a href="admin_logout.php">Logout</a>
</p>
</div>

</div>

<div class="big-line"></div>

  <div class="status-filter">
  <a href="?status=all">All Applications</a>
  <a href="?status=pending">Pending</a>
  <a href="?status=accepted">Accepted</a>
  <a href="?status=rejected">Rejected</a>
</div>

  
  <div style="display: flex; gap: 20px; margin-bottom: 30px;">
  <div style="flex: 1; background-color: #dff0d8; padding: 20px; text-align: center; border-radius: 10px;">
    <h3>✅ Accepted</h3>
    <p style="font-size: 24px; font-weight: bold;"><?= $counts['accepted_count'] ?></p>
  </div>

  <div style="flex: 1; background-color: #f2dede; padding: 20px; text-align: center; border-radius: 10px;">
    <h3>❌ Rejected</h3>
    <p style="font-size: 24px; font-weight: bold;"><?= $counts['rejected_count'] ?></p>
  </div>

  <div style="flex: 1; background-color: #fcf8e3; padding: 20px; text-align: center; border-radius: 10px;">
    <h3>⏳ Pending</h3>
    <p style="font-size: 24px; font-weight: bold;"><?= $counts['pending_count'] ?></p>
  </div>
</div>
  
     <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                
                <th>Course</th>
                <th>Action</th>   
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>". $row['id'] ."</td>";
                    echo "<td>". $row['first_name'] . " " . $row['last_name'] ."</td>";
                    echo "<td>". $row['gender'] ."</td>";
                    echo "<td>". $row['email'] ."</td>";
                    echo "<td>". $row['phone'] ."</td>";

$status = strtolower($row['status']);
$colorClass = '';

if ($status === 'pending') {
    $colorClass = 'status-pending';
} elseif ($status === 'accepted') {
    $colorClass = 'status-accepted';
} elseif ($status === 'rejected') {
    $colorClass = 'status-rejected';
}

echo "<td class='$colorClass'>" . ucfirst($status) . "</td>";
       
                   
                    echo "<td>". $row['course'] ."</td>";

                   echo "<td><a href='application.php?id=". $row['id'] . " ' class='view'> View</a></td>";



                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No applications found.</td></tr>";
            }

            $conn->close();
            ?>
        </table>






  </div>

</body>
</html>
