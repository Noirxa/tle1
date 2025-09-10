<?php
session_start();
require_once 'includes/database.php';
global $db;


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$content = $media_url = "";
$errors = [];
$success = "";

if (isset($_POST['submit'])) {
    $content = trim($_POST['content'] ?? '');

    // --- standaard leeg, vullen via URL of upload ---
    $media_url = "";

    // 1. Check content
    if (empty($content)) {
        $errors['content'] = 'Content cannot be empty';
    }

    // 2. Foto upload vanaf bestanden
    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['media_file']['name']);
        $targetPath = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array($fileType, $allowed)) {
            if (move_uploaded_file($_FILES['media_file']['tmp_name'], $targetPath)) {
                $media_url = $targetPath; // dit wordt in DB opgeslagen
            } else {
                $errors['media'] = "Upload failed.";
            }
        } else {
            $errors['media'] = "Only JPG, PNG, GIF allowed.";
        }
    }

    // 3. Media URL uit tekstveld (indien ingevuld en geen upload)
    if (empty($media_url) && !empty($_POST['media_url'])) {
        $media_url = trim($_POST['media_url']);
    }

    // 4. Opslaan in DB
    if (empty($errors)) {
        $query = "INSERT INTO posts (user_id, content, media_url) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $content, $media_url);
            if (mysqli_stmt_execute($stmt)) {
                $content = $media_url = "";
                $success = "Post successfully added!";
            } else {
                $errors['db'] = "Database error: " . mysqli_error($db);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<!-- Sidebar direct in create.php -->
<div class="sidebar">
    <h2>MadeByMe</h2>
    <a href="index.php">🏠 Home</a>
    <a href="create.php" class="active">➕ Create</a>
    <a href="verify.php">✔ Verify</a>
    <a href="profile.php">👤 Profile</a>
</div>

<!-- Content -->
<div class="container">
    <div class="create-card">
        <h2>Create Something Human</h2>
        <p>Share your authentic creativity with the world. Embrace imperfection, celebrate humanity.</p>

        <?php if (!empty($success)) echo "<p style='color: lightgreen;'>$success</p>"; ?>
        <?php if (!empty($errors['db'])) echo "<p style='color: red;'>{$errors['db']}</p>"; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="content">Post Content</label>
            <textarea name="content" rows="4"
                      placeholder="Share your thoughts..."><?php echo htmlspecialchars($content); ?></textarea>
            <small style="color: red;"><?php echo $errors['content'] ?? ''; ?></small>

            <label for="media_file">Upload a photo (optional)</label>
            <input type="file" name="media_file" id="media_file" accept="image/*">
            <small style="color: red;"><?php echo $errors['media'] ?? ''; ?></small>

            <label for="media_url">Or paste image URL (optional)</label>
            <input type="text" name="media_url" placeholder="Media URL"
                   value="<?php echo htmlspecialchars($media_url); ?>">

            <button class="button" type="submit" name="submit">Share with Humans</button>
        </form>
    </div>

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
