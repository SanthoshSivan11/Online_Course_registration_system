<?php

session_start();

include 'database/dbconnect.php';



$username = $_POST['user'];
$password = $_POST['pass'];



$sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);  




if ($result->num_rows >= 1) {
    $row = $result->fetch_assoc();
    


    $_SESSION['admin'] = $username;          
    $_SESSION['admin_name'] = $row['name'];  


    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Invalid username or password. <a href='admin_login.php'>Try again</a>";
}

$conn->close();
?>












<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #eef1f5;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      background-color: #fff;
      padding: 40px 30px;
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      animation: fadeIn 0.6s ease;
    }
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
    .login-box h2 {
      margin-bottom: 25px;
      color: #333;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      border: none;
      border-radius: 6px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-box button:hover {
      background-color: #45a049;
    }

    .login-box input:focus,
    .login-box button:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
    }
    .forget{
      margin-top:10px;
    }
     .login{
            margin-top:10px;
        }
  </style>
</head>
<body>
  <!-- <div class="login-box">
    <h2>Admin Login</h2>

<form action="admin_auth.php" method="post">
  <input type="text" name="user" placeholder="Username" required>
  <input type="password" name="pass" placeholder="Password" required>
  <button type="submit">Login</button>
</form>

<form action="forgot_password.php" class="forget" method="post">
  <button type="submit">Forget Password</button>
</form>

  </div> -->

  <div class="login-box">
  <h2>Admin Login</h2>

 
  <form action="admin_auth.php" method="post">
    <input type="text" name="user" placeholder="Username" required>
    <input type="password" name="pass" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>

  <form action="forgot_password.php" class="forget" method="post">
    <button type="submit">Forget Password</button>
  </form>


  <form action="admin_register.php" method="get" class="login">
    <button type="submit">Register</button>
  </form>
</div>

</body>
</html>
