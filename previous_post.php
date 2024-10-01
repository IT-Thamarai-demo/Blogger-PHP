<?php
include('db_connection.php');

// Fetch all posts
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #0072ff;
            margin: 20px 0;
        }

        .post-container {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .post-container:hover {
            transform: translateY(-5px);
        }

        .post-container h2 {
            color: #0072ff;
            font-size: 1.5em; /* Larger font for titles */
        }

        .button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit-button {
            background-color: #0072ff;
        }

        .edit-button:hover {
            background-color: #005bb5;
        }

        .delete-button {
            background-color: #ff4b4b;
        }

        .delete-button:hover {
            background-color: #d12f2f;
        }

        .no-posts {
            color: #ff4b4b;
            font-size: 18px;
            text-align: center;
            margin: 20px;
        }

        /* Mobile responsiveness */
        @media (max-width: 600px) {
            .post-container {
                margin: 10px; /* Reduce margin on mobile */
                padding: 15px; /* Adjust padding for smaller screens */
            }

            .post-container h2 {
                font-size: 1.2em; /* Smaller title font size */
            }

            .button {
                width: 100%; /* Buttons take full width on mobile */
                margin: 5px 0; /* Space out buttons vertically */
            }
        }
    </style>
</head>
<body>
    <h1>All Posts</h1>

    <?php if ($result->num_rows > 0) { ?>
        <?php while ($post = $result->fetch_assoc()) { ?>
            <div class="post-container">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo htmlspecialchars(strip_tags(substr($post['content'], 0, 150))) . '...'; ?></p>
                <a href="single_post.php?id=<?php echo $post['id']; ?>" class="button view-button">View Full Post</a>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="button edit-button">Edit</a>
                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="button delete-button" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="no-posts">No posts available. Please check back later!</p>
    <?php } ?>

    <div style="text-align: center; margin: 20px;">
        <p>If you want to add a new post, please <a href="create_post.php" style="color: #0072ff;">click here</a>.</p>
    </div>
</body>
</html>
