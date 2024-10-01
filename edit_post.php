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

    // Fetch the existing post data
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found.";
        exit();
    }

    // Handle AJAX auto-save request
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['auto_save'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Update the post in the database
        $update_sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $title, $content, $post_id);

        if ($update_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Post auto-saved successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error auto-saving post.']);
        }
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0072ff, #00c6ff);
            color: white;
            text-align: center;
            padding: 20px;
        }

        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 600px; /* Set a max-width for larger screens */
            margin: auto;
            width: 90%; /* Allow it to take up more space on smaller screens */
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px; /* Increase font size for better readability */
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0072ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px; /* Increase font size for better readability */
        }

        button:hover {
            background: #005bb5;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 600px) {
            body {
                padding: 10px; /* Reduce padding for smaller screens */
            }

            form {
                padding: 15px; /* Adjust padding inside form */
            }

            input, textarea, button {
                font-size: 14px; /* Slightly smaller font size */
                padding: 8px; /* Adjust padding */
            }
        }
    </style>
    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/bzf7b1k4d8feb7oy9l4i5snkyfk0u10k86tj2dh45l8dn0vu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link charmap preview anchor textcolor',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            menubar: false,
            height: 300,
            setup: function(editor) {
                editor.on('input', function() {
                    autoSave();
                });
            }
        });
    </script>

    <script>
        // Auto-save functionality for edit post
        let autoSaveTimeout;

        function autoSave() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(function () {
                const title = document.getElementById('title').value;
                const content = tinymce.get('content').getContent(); // Use TinyMCE API to get content

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'edit_post.php?id=<?php echo $post_id; ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        const response = JSON.parse(xhr.responseText);
                        document.getElementById('status-message').innerHTML = response.message;
                    }
                };

                xhr.send(`auto_save=1&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}`);
            }, 2000); // Auto-save after 2 seconds of inactivity
        }

        document.getElementById('title').addEventListener('input', autoSave);
    </script>

</head>
<body>

    <h1>Edit Post</h1>
    <div id="status-message" style="color: yellow;"></div>

    <form method="POST" action="edit_post.php?id=<?php echo $post_id; ?>">
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        <button type="submit">Update Post</button>

    </form>

    <a class="back-link" href="previous_post.php">Go Back to Previous Post</a>

</body>
</html>
