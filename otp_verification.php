<?php
session_start();

if (isset($_POST['verify'])) {
    if ($_POST['otp'] == $_SESSION['otp']) {
        header("Location: password_reset.php");
        exit();
    } else {
        echo "<script>alert('Invalid OTP');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Verify OTP</title>



<style>
    :root {
      --primary: #4CAF50;
      --primary-hover:rgb(49, 133, 52);
      --bg: #f3f4f6;
      --card-bg: #ffffff;
      --radius: 12px;
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

    input[type="text"] {
      padding: 0.85rem 1rem;
      border: 1px solid #d1d5db;
      border-radius: var(--radius);
      font-size: 1rem;
      outline: none;
      transition: all 0.25s ease;
      background: #f9fafb;
    }

    input[type="text"]:focus {
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
</style></head>


<body>

    <div class="card">
    <h2>Enter the OTP sent to your email</h2>
    <form method="POST">
      <input type="text" name="otp" required placeholder="Enter OTP" />
      <button type="submit" name="verify">Verify OTP</button>
    </form>
  </div>
</body>
</html>
