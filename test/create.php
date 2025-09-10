<?php
session_start();

/** @var mysqli $db */
require_once 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$content = $media_url = "";
$errors = [];

if (isset($_POST['submit'])) {
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $media_url = isset($_POST['media_url']) ? $_POST['media_url'] : '';

    if (empty($content)) {
        $errors['content'] = 'Content cannot be empty';
    }

    if (empty($errors)) {
        $query = "INSERT INTO posts (user_id, content, media_url) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $content, $media_url);

            if (mysqli_stmt_execute($stmt)) {
                echo "<p class='notification is-success'>Post successfully added!</p>";
                $content = $media_url = "";
            } else {
                echo "<p class='notification is-danger'>Error: " . mysqli_error($db) . "</p>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p class='notification is-danger'>Prepare failed: " . mysqli_error($db) . "</p>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
</head>
<body>
<div class="container">
    <h2>Create a new post</h2>
    <form action="" method="post">

        <div class="field">
            <label for="content">Post Content</label>
            <textarea id="content" name="content" rows="4"><?php echo htmlspecialchars($content); ?></textarea>
            <p class="help is-danger"><?php echo isset($errors['content']) ? $errors['content'] : ''; ?></p>
        </div>

        <div class="field">
            <label for="media_url">Media URL (optional)</label>
            <input id="media_url" type="text" name="media_url" value="<?php echo htmlspecialchars($media_url); ?>"/>
        </div>

        <div class="field">
            <button class="button is-link" type="submit" name="submit">Save Post</button>
        </div>
    </form>

    <a class="button" href="index.php">Back to feed</a>
</div>
</body>
</html>
