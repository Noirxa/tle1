<?php
require_once 'includes/database.php'; // connectie met database

$user_id = 1;

$content = $media_url = "";
$errors = [];

if (isset($_POST['submit'])) {
    $content = $_POST['content'] ?? '';
    $media_url = $_POST['media_url'] ?? '';

    // Validatie
    if (empty($content)) {
        $errors['content'] = 'Content cannot be empty';
    }

    if (empty($errors)) {
        // Query voorbereiden
        $query = "INSERT INTO posts (user_id, content, media_url) 
                  VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $content, $media_url);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<p class='notification is-success'>Post successfully added!</p>";
            $content = $media_url = "";
        } else {
            echo "<p class='notification is-danger'>Error: " . mysqli_error($db) . "</p>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
<!--    <link rel="stylesheet" href="CSS/form.css">-->
</head>
<body>
<div class="container">
    <h2>Create a new post</h2>
    <form action="" method="post">

        <!-- Content -->
        <div class="field">
            <label for="content">Post Content</label>
            <textarea id="content" name="content" rows="4"><?= htmlspecialchars($content) ?></textarea>
            <p class="help is-danger"><?= $errors['content']?></p>
        </div>

        <div class="field">
            <label for="media_url">Media URL (optional)</label>
            <input id="media_url" type="text" name="media_url" value="<?= htmlspecialchars($media_url) ?>"/>
        </div>

        <div class="field">
            <button class="button is-link" type="submit" name="submit">Save Post</button>
        </div>
    </form>

    <a class="button" href="index.php">Back to feed</a>
</div>
</body>
</html>
