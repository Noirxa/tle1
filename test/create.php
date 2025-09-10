<?php
//global $db;
//require_once 'includes/database.php'; // connectie met database
//
//$user_id = 1;
//
//$content = $media_url = "";
//$errors = [];
//
//if (isset($_POST['submit'])) {
//    $content = $_POST['content'] ?? '';
//    $media_url = $_POST['media_url'] ?? '';
//
//    // Validatie
//    if (empty($content)) {
//        $errors['content'] = 'Content cannot be empty';
//    }
//
//    if (empty($errors)) {
//        // Query voorbereiden
//        $query = "INSERT INTO posts (user_id, content, media_url)
//                  VALUES (?, ?, ?)";
//        $stmt = mysqli_prepare($db, $query);
//        mysqli_stmt_bind_param($stmt, "iss", $user_id, $content, $media_url);
//
//        $result = mysqli_stmt_execute($stmt);
//
//        if ($result) {
//            echo "<p class='notification is-success'>Post successfully added!</p>";
//            $content = $media_url = "";
//        } else {
//            echo "<p class='notification is-danger'>Error: " . mysqli_error($db) . "</p>";
//        }
//    }
//}
//?>
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, initial-scale=1.0">-->
<!--    <title>Create Post</title>-->
<!--<!--    <link rel="stylesheet" href="CSS/form.css">-->-->
<!--    <link rel="stylesheet" href="CSS/home.css">-->
<!---->
<!--</head>-->
<!--<body>-->
<!--<div class="container">-->
<!--    <h2>Create a new post</h2>-->
<!--    <form action="" method="post">-->
<!---->
<!--        <!-- Content -->-->
<!--        <div class="field">-->
<!--            <label for="content">Post Content</label>-->
<!--            <textarea id="content" name="content" rows="4">--><?php //= htmlspecialchars($content) ?><!--</textarea>-->
<!--            <p class="help is-danger">--><?php //= $errors['content']?><!--</p>-->
<!--        </div>-->
<!---->
<!--        <div class="field">-->
<!--            <label for="media_url">Media URL (optional)</label>-->
<!--            <input id="media_url" type="text" name="media_url" value="--><?php //= htmlspecialchars($media_url) ?><!--"/>-->
<!--        </div>-->
<!---->
<!--        <div class="field">-->
<!--            <button class="button is-link" type="submit" name="submit">Save Post</button>-->
<!--        </div>-->
<!--    </form>-->
<!---->
<!--    <a class="button" href="index.php">Back to feed</a>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
<!---->
<!---->



<!--test-->

<?php
global $db;
require_once 'includes/database.php';

$user_id = 1;
$content = $media_url = "";
$errors = [];
$success_message = "";

if (isset($_POST['submit'])) {
    $content = $_POST['content'] ?? '';
    $media_url = $_POST['media_url'] ?? '';

    if (empty($content)) {
        $errors['content'] = 'Content cannot be empty';
    }

    if (empty($errors)) {
        $query = "INSERT INTO posts (user_id, content, media_url) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $content, $media_url);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Post successfully added!";
            $content = $media_url = "";
        } else {
            $errors['submit'] = "Error: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Something Human</title>
    <link rel="stylesheet" href="CSS/home.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>MadeByMe</h2>
    <a href="index.php">🏠 Home</a>
    <a href="create.php" class="active">➕ Create</a>
    <a href="#">✔ Verify</a>
    <a href="#">👤 Profile</a>
</div>

<!-- Hoofdcontainer -->
<div class="container">
    <h1>Create Something Human</h1>
    <p class="subtitle">Share your authentic creativity with the world. Embrace imperfection, celebrate humanity.</p>

    <?php if ($success_message): ?>
        <div class="notification success"><?= $success_message ?></div>
    <?php endif; ?>
    <?php if (!empty($errors['submit'])): ?>
        <div class="notification error"><?= $errors['submit'] ?></div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="create-card">
        <form action="" method="post">
            <label for="content">What's on your mind?</label>
            <textarea id="content" name="content" placeholder="Share your thoughts, your process, your story..." rows="5"><?= htmlspecialchars($content) ?></textarea>
            <?php if (!empty($errors['content'])): ?>
                <p class="help is-danger"><?= $errors['content'] ?></p>
            <?php endif; ?>

            <label>Add Media</label>
            <div class="media-buttons">
                <button type="button" class="media-btn active">Text Only</button>
                <button type="button" class="media-btn">Photo</button>
                <button type="button" class="media-btn disabled">Verified Only Video</button>
            </div>

            <small>0/500 characters</small>

            <button class="button is-link" type="submit" name="submit">Share with Humans</button>
        </form>
    </div>

    <!-- Tips Card -->
    <div class="tips-card">
        <h3>Tips for Authentic Content</h3>
        <ul>
            <li>Share your creative process, not just the final result</li>
            <li>Embrace mistakes and imperfections – they make you human</li>
            <li>Tell the story behind your creation</li>
            <li>Use natural lighting and authentic settings</li>
        </ul>
    </div>
</div>

</body>
</html>
