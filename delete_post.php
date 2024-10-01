<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the post ID is provided
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Check if the post exists
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Delete the post
        $delete_sql = "DELETE FROM posts WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $post_id);

        if ($delete_stmt->execute()) {
            // HTML message and auto-redirect after deletion
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Post Deleted</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f5f5f5;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .message {
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        text-align: center;
                    }
                    .message h1 {
                        color: #0072ff;
                        font-size: 24px;
                    }
                    .message p {
                        color: #333333;
                        font-size: 18px;
                    }
                </style>
                <script>
                    setTimeout(function() {
                        window.location.href = 'previous_post.php';
                    }, 3000); // Redirects in 3 seconds
                </script>
            </head>
            <body>
                <div class='message'>
                    <h1>Post Deleted Successfully</h1>
                    <p>You will be redirected to the posts list page shortly.</p>
                </div>
            </body>
            </html>";
        } else {
            echo "Error deleting post.";
        }
    } else {
        echo "Post not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
