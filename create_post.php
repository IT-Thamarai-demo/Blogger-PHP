<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare and execute the SQL statement to insert the post
    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        header("Location: http://localhost/blog/");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        #editor {
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #editor {
            height: 300px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            input[type="text"],
            #editor {
                font-size: 14px;
            }

            input[type="submit"] {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create a New Post</h1>
        <form action="create_post.php" method="POST" id="createPostForm">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Content:</label>
            <div id="editor"></div>
            <input type="hidden" name="content" required>

            <input type="submit" value="Create Post">
        </form>
    </div>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    ['clean']  // Remove formatting button
                ]
            }
        });

        // Set content into hidden input before submitting form
        document.getElementById('createPostForm').onsubmit = function() {
            var content = quill.root.innerHTML;
            document.querySelector('input[name=content]').value = content;
        };
    </script>
</body>
</html>
