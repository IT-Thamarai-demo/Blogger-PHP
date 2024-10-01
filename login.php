<?php
session_start();
$servername = "localhost";
$username = "root"; // change as necessary
$password = "Yasar@123!"; // change as necessary
$dbname = "blog_db"; // change as necessary

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: create_post.php"); // Redirect to create post page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0072ff, #00c6ff);
            margin: 0;
            display: flex;
            flex-direction: column; /* Changed to column for intro and form */
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        
        .intro {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em; /* Intro font size */
            color: #ffffff;
            max-width: 90%; /* Responsive max width */
            padding: 0 10px; /* Padding for small screens */
        }

        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            max-width: 90%; /* Responsive width */
            box-sizing: border-box; /* Ensure padding is included in total width */
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
            box-sizing: border-box; /* Ensure padding is included in total width */
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

        /* Mobile responsive styles */
        @media (max-width: 600px) {
            form {
                width: 90%; /* Ensure form takes up most of the screen width */
                padding: 15px; /* Adjust padding for mobile */
            }

            h2 {
                font-size: 1.5em; /* Responsive font size */
            }

            input, button {
                padding: 8px; /* Adjust input and button padding */
            }

            .intro {
                font-size: 1em; /* Smaller font size for mobile */
            }
        }
    </style>
</head>
<body>
    <div class="intro">
        <h1>Welcome Back!</h1>
        <p>Please log in to continue to your dashboard.</p>
    </div>
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <a href="signup.php">Don't have an account? Signup</a>
</body>
</html>
