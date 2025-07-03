<?php
$conn = new mysqli("localhost", "root", "", "admission_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$group_result = $conn->query("SELECT group_name FROM courses");

$course_result = $conn->query("SELECT course_name FROM courses");

$course_result = $conn->query("SELECT DISTINCT course_name FROM courses WHERE is_hidden = 1");

$group_result = $conn->query("SELECT DISTINCT group_name FROM courses WHERE is_hidden = 1");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Registration Form</title>
  <style>

  
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f4f8;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

  

    .form-row {
      margin-top:10px;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 6px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    input[type="date"],
    select,
    textarea {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    textarea {
      resize: none;
    }

    

    input[type="radio"] {
      margin-right: 5px;
    }

    input[type="file"] {
      padding: 5px;
    }

    button {
      background-color:  #4CAF50;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      margin-top: 15px;
    }

    button:hover {
      background-color: #45a049;
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
      }
    }
    .sheet{
      margin-top:10px;
    }

      form {
      
      max-width: 750px;
      margin: auto;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .title {
    background-color: rgb(97, 206, 101);
    padding: 10px;
    border-radius: 5px;
    color: white;
    text-align: center;
    max-width: 750px;
    margin-top: 5px;
    margin-bottom: 20px;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: center;
    align-items: center;
}




  </style>
</head>
<body>

<div>

  <form action="submit.php" method="post" enctype="multipart/form-data">

  
<h2 class="title">UnderGraduate Application Form</h2>
  

    <!-- First & Last Name -->
    <div class="form-row">
      <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="first_name" required>
      </div>
      <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="last_name" required>
      </div>
    </div>

    <!-- Gender & DOB -->
    <div class="form-row">
      <div class="form-group">
        
        <label>Gender:</label>
        <div class="sheet">
        <div class="gender-row">
          <input type="radio" id="male" name="gender" value="Male" required>
          <label for="male">Male</label>
          <input type="radio" id="female" name="gender" value="Female">
          <label for="female">Female</label>
          </div>
        </div>
      </div>


<div class="form-group">
  <label for="dob">Date of Birth:</label>
  <input type="date" id="dob" name="dob" required>
</div>



    </div>

    <!-- Email & Phone -->
    <div class="form-row">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
      </div>
    </div>

    <!-- Address (Full width) -->
    <div class="form-group">
      <label for="address">Address:</label>
      <textarea id="address" name="address" rows="3" required></textarea>
    </div>

    <!-- Group & Course -->
    <div class="form-row">
      <div class="form-group">
        <label for="group">Group:</label>
        <select id="group" name="group" required>
          <option value="">--Select Group--</option>
          <?php while ($row = $group_result->fetch_assoc()): ?>
            <option value="<?= $row['group_name']; ?>"><?= $row['group_name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="course">Select Course:</label>
        <select id="course" name="course" required>
          <option value="">--Select Course--</option>
          <?php while ($row = $course_result->fetch_assoc()): ?>
            <option value="<?= $row['course_name']; ?>"><?= $row['course_name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>

    <!-- Marks -->
    <div class="form-group">
      <label for="totalMarks">Total Marks (12th):</label>
      <input type="number" id="totalMarks" name="total_marks" min="0" required>
    </div>

    <!-- File Uploads -->
     <div class="sheet">
    <div class="form-group">
      <label for="marksheet">Upload 12th Marksheet:</label>
      <input type="file" id="marksheet" name="marksheet" accept=".pdf,.jpg,.png" required>
    </div>
</div>
<div class="sheet">
    <div class="form-group">
      <label for="photo">Upload Photo:</label>
      <input type="file" id="photo" name="photo" accept="image/*" required>
    </div>
<div>
    <button type="submit">Submit</button>

  </form>

  </div>

</body>
</html>
