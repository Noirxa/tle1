
<?php
session_start();

global $db;
require_once 'includes/database.php';

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? 0;

// DELETE logica: alleen eigen posts
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = mysqli_prepare($db, "DELETE FROM posts WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $delete_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: index.php");
    exit;
}

// Haal posts op
$query = "SELECT posts.id, posts.content, posts.media_url, posts.created_at, users.username, posts.user_id
          FROM posts
          JOIN users ON posts.user_id = users.id
          ORDER BY posts.created_at DESC";

$result = mysqli_query($db, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feed</title>
    <link rel="stylesheet" href="CSS/home.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>MadeByMe</h2>
    <a href="index.php" class="active">🏠 Home</a>
    <a href="create.php">➕ Create</a>
    <a href="#">✔ Verify</a>
    <a href="#">👤 Profile</a>
    <a href="logout.php">⏻ log out</a>
</div>

<!-- Hoofdcontent -->
<div class="container">
    <h1>Human Feed</h1>
    <a class="button" href="create.php">+ New Post</a>

    <div class="feed">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($row['username']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

                <!-- Media (foto of video) -->
                <?php if (!empty($row['media_url'])): ?>
                    <div class="media media-sized">
                        <?php
                        $file = $row['media_url'];
                        if (str_ends_with($file, '.mp4') || str_ends_with($file, '.webm') || str_ends_with($file, '.ogg')): ?>
                            <video controls>
                                <source src="<?php echo htmlspecialchars($file); ?>" type="video/mp4">
                            </video>
                        <?php else: ?>
                            <img src="<?php echo htmlspecialchars($file); ?>" alt="Post media"/>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <small>Posted on <?php echo htmlspecialchars($row['created_at']); ?></small>

                <!-- Delete knop voor eigen posts -->
                <?php if ($row['user_id'] == $user_id): ?>
                    <div style="margin-top:5px;">
                        <a href="index.php?delete_id=<?php echo $row['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this post?');"
                           style="color:red;text-decoration:none;">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
