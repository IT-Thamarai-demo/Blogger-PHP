<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
           background-color:black;
        }

        header {
            background: #35424a;
            color: #ffffff;
            padding: 10px 20px;
        }

        nav {
            margin: 20px 0;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin-right: 15px;
            padding: 5px 10px;
            transition: background 0.3s;
        }

        nav a:hover {
            background: #46b3e6;
            border-radius: 5px;
        }

        .post {
            background: #ffffff;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .post h2 {
            margin: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>My Blog</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="create_post.php">Create Post</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
</nav>

<div class="container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="post">
                <h2><?php echo $post['title']; ?></h2>
                <p><?php echo $post['content']; ?></p>
                <a href="post.php?id=<?php echo $post['id']; ?>">Read More</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>

</body>
</html>
