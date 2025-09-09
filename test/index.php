<?php
require_once 'includes/database.php';

$query = "SELECT posts.id, posts.content, posts.media_url, posts.created_at, users.username 
          FROM posts
          JOIN users ON posts.user_id = users.id
          ORDER BY posts.created_at DESC";

$result = mysqli_query($db, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($db));
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="CSS/home.css">
</head>
<body>
<div class="container">
    <h1>Social Feed</h1>

    <a class="button" href="create.php">+ New Post</a>

    <div class="feed">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="post">
                <h3><?= htmlspecialchars($row['username']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                <?php if (!empty($row['media_url'])): ?>
                    <div class="media">
                        <?php if (preg_match('/\.(mp4|webm|ogg)$/i', $row['media_url'])): ?>
                            <video controls width="320">
                                <source src="<?= htmlspecialchars($row['media_url']) ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($row['media_url']) ?>" alt="Post media" width="320"/>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <small>Posted on <?= $row['created_at'] ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
