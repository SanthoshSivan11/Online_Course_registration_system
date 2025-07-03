<?php

session_start();

require 'vendor/autoload.php';
include("database/dbconnect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__); // loads from root .env
$dotenv->load();

$error = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $check = $stmt->get_result();

        if ($check->num_rows === 1) {
            $otp = random_int(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['reset_email'] = $email;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['SMTP_USER'];
                $mail->Password   = $_ENV['SMTP_PASS'];
                $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
                $mail->Port       = $_ENV['SMTP_PORT'];

                $mail->setFrom($_ENV['SMTP_USER'], $_ENV['SMTP_FROM_NAME']);
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Admin Password Reset OTP';
                $mail->Body    = "Course Management Admin,<br><br>Your OTP is <b>{$otp}</b>";

                $mail->send();
                header('Location: otp_verification.php');
                exit();
            } catch (Exception $e) {
                $error = 'Mailer Error: ' . $mail->ErrorInfo;
            }
        } else {
            $error = 'Email not found';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password – Admin</title>

    <style>


:root {
--primary: #4CAF50;
--primary-hover:rgb(49, 133, 52);
--bg: #f9fafb;
--card-bg: #ffffff;
--radius: 16px;
--shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
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
  padding: 3rem 2.5rem;
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  animation: fadeIn 0.6s ease;
  transition: transform 0.3s;
}

.card:hover {
  transform: translateY(-5px);
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

h2 {
  font-size: 1.75rem;
  font-weight: 600;
  color: #1f2937; 
  margin-bottom: 0.75rem;
  text-align: center;
}

p.desc {
  font-size: 0.95rem;
  color: #6b7280; 
  text-align: center;
  margin-bottom: 1.75rem;
}

form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

input[type="email"] {
  padding: 0.85rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: var(--radius);
  font-size: 1rem;
  outline: none;
  transition: all 0.25s ease;
  background: #f9fafb;
}

input[type="email"]:focus {
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.3);
  border-color: var(--primary);
  background: #fff;
}

button {
  background: var(--primary);
  color: #ffffff;
  font-weight: 600;
  font-size: 1rem;
  padding: 0.85rem 1rem;
  border: none;
  border-radius: var(--radius);
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: var(--primary-hover);
}

.alert {
  background: #fef2f2;
  color: #b91c1c;
  padding: 1rem;
  border-radius: var(--radius);
  font-size: 0.9rem;
  margin-bottom: 1.25rem;
  border: 1px solid #fecaca;
}

.back-link {
  display: block;
  margin-top: 1.25rem;
  text-align: center;
  font-size: 0.9rem;
  color: var(--primary);
  text-decoration: none;
  transition: color 0.2s;
}

.back-link:hover {
  text-decoration: underline;
  color: var(--primary-hover);
}

    </style>
</head>
<body>
    <div class="card">
        <h2>Forgot Password</h2>
        <p class="desc">Enter your admin email to receive an OTP.</p>
        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <input type="email" name="email" placeholder="Admin Email" required />
            <button type="submit" name="submit">Send OTP</button>
        </form>
        <a href="admin_login.php" class="back-link">Back to Login</a>
    </div>
</body>
</html>
