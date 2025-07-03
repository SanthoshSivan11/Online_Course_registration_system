<?php
session_start();
include("database/dbconnect.php");

if (isset($_POST['reset'])) {
    $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_SESSION['reset_email'];

    $update = $conn->query("UPDATE admin SET password='$new_pass' WHERE email='$email'");

    if ($update) {
        session_destroy();
        echo "<script>alert('Password reset successful'); window.location='admin_login.php';</script>";
    } else {
        echo "<script>alert('Failed to update password');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head><title>Reset Password</title>
<style>
:root { 
      --primary: #4CAF50;               
      --primary-hover:rgb(49, 133, 52);
      --bg: #f3f4f6;
      --card-bg: #ffffff;
      --radius: 12px;
/* these it is a custom CSS variable name */
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .card {
      background: var(--card-bg);
      width: 100%;
      max-width: 400px;
      padding: 2.5rem 2rem;
      border-radius: var(--radius);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }

    input[type="password"] {
      padding: 0.85rem 1rem;
      border: 1px solid #d1d5db;
      border-radius: var(--radius);
      font-size: 1rem;
      outline: none;
      transition: all 0.25s ease;
      background: #f9fafb;
    }

    input[type="password"]:focus {
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.3);
      border-color: var(--primary);
      background: #fff;
    }

    button {
      background: var(--primary);
      color: #fff;
      font-weight: 600;
      padding: 0.85rem 1rem;
      border: none;
      border-radius: var(--radius);
      cursor: pointer;
      transition: background 0.3s ease;
      font-size: 1rem;
    }

    button:hover {
      background: var(--primary-hover);
    }
    .blur-bg {
  background: url('your-background.jpg') no-repeat center center/cover;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(6px);
}


</style>
</head>
<body>
    <div class="blur-bg">
   <div class="card">
    <h2>Set New Password</h2>
    <form method="POST">
      <input type="password" name="password" required placeholder="New Password" />
      <button type="submit" name="reset">Reset Password</button>
    </form>
  </div>
   </div>
</body>
</html>
