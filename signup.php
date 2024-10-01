<?php
// signup.php
$servername = "localhost";
$username = "root"; // change as necessary
$password = "Yasar@123!"; // change as necessary
$dbname = "blog_db"; // change as necessary

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to hold feedback messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    // After successful registration
    if ($stmt->execute()) {
        $message = "Registration successful! Redirecting to login...";
        header("Refresh:2; url=login.php"); // Redirect to login page after 2 seconds
    } else {
        $message = "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0072ff, #00c6ff);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
            flex-direction: column;
        }
        
        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 90%; /* Make it responsive */
            max-width: 400px; /* Maximum width for larger screens */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0072ff;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #0072ff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0072ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #005bb5;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0072ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            color: #ff4b4b;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h1>My Blog</h1> <!-- Added a title for the website -->
    <form method="POST" action="signup.php">
        <h2>Signup</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Register</button>
    </form>
    
    <div class="message">
        <?php if (!empty($message)) echo htmlspecialchars($message); ?>
    </div>
    
    <a href="login.php">Already have an account? Login</a>
</body>
</html>
