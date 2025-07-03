<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "admission_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $raw_password = trim($_POST['password']); // Raw password from form
    $password = password_hash($raw_password, PASSWORD_DEFAULT); // Hashed password
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validate basic fields
    if (empty($raw_password) || empty($name) || empty($email) || empty($phone)) {
        $error = "All fields are required!";
    } else {
        // ✅ Check only email for uniqueness
        $check = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            // Insert new admin with hashed password
            $stmt = $conn->prepare("INSERT INTO admin (password, name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $password, $name, $email, $phone);

            if ($stmt->execute()) {
                $success = "Admin registered successfully!";
            } else {
                $error = "Something went wrong.";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f6fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 6px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background:  #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: green;
        }

        .error {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: red;
        }
     .login{
        margin-top:10px;
     }
            .login-box {
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
    </style>
</head>
<body>
    <div class="login-box">

<form method="POST" action="">
    <h2>Admin Registration</h2>

    <?php if (!empty($success)) echo "<div class='message'>$success</div>"; ?>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
    </div>

    <button type="submit">Register Admin</button>

    <button type="button" onclick="window.location.href='admin_login.php';" class="login">Login</button>


</form>


</div>

</body>
</html>
