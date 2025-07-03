<?php

include 'database/dbconnect.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = $_GET['id'];

$sql = "SELECT * FROM students WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("Application not found.");
}

$row = $result->fetch_assoc();
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
      display: flex;
      min-height: 100vh;
    }

    /*-------------------------------------------------------*/
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

    .card {
      max-width: 800px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .photo {
      text-align: center;
      margin-bottom: 20px;
    }

    .photo img {
      width: 50%;
      height: auto;
      border-radius: 10px;
    }

    .info p {
      margin: 10px 0;
    }

    .info strong {
      width: 150px;
      display: inline-block;
    }

    select,
    button {
      padding: 8px 12px;
      margin-top: 10px;
      font-size: 16px;
    }

    button {
      background-color: #2c3e50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #34495e;
    }
.download-btn {
  display: inline-block;
  padding: 8px 16px;
  background-color: #3498db; 
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.2s ease;
  font-size: 14px;
  border: none;
  cursor: pointer;
}

.download-btn:hover {
  background-color: #2980b9; 
  transform: scale(1.05);
}

  </style>
</head>
<body>

 <!------------------------------------------->

  <div class="sidebar">
    <h2>Admission</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="course_management.php">Course Management</a>
  </div>


 <!------------------------------------------->



  <div class="main">
    <div class="card">
      <h2>Student Application</h2>

      <form action="update_status.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="photo">
          <img src="<?php echo $row['photo']; ?>" style="height: 200px; width: 150px;" alt="Student Photo">
        </div>

        <div class="info">
    <p><strong>Name:</strong> <?php echo $row['first_name'] . ' ' . $row['last_name']; ?></p>
    <p><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
    <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
  <p><strong>Date of Birth:</strong> <?php echo $row['dob']; ?></p>
    <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
    <p><strong>Group:</strong> <?php echo $row['student_group']; ?></p>
    <p><strong>Total Marks:</strong> <?php echo $row['total_marks']; ?></p>
  <p><strong>Course:</strong> <?php echo $row['course']; ?></p>
    <p>
  <strong>Photo:</strong>
  <a href="<?php echo $row['photo']; ?>" download class="download-btn">Download</a>
</p>
  <p>
  <strong>Marksheet:</strong>
  <a href="<?php echo $row['marksheet']; ?>" download class="download-btn">Download</a>
</p>

          <label for="status"><strong>Update Status:</strong></label>
          <select name="status" required>
            <option value="">--Select Status--</option>
            <option value="accepted">Accepted</option>
            <option value="rejected">Rejected</option>
          </select>

          <br><br>
          <button type="submit">Update Status</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
