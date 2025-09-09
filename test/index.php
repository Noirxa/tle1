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

<!---->
<?php
//include 'includes/database.php';
//
//// Query om posts op te halen
//$sql = "SELECT posts.content, posts.media_url, posts.created_at, users.username
//        FROM posts
//        JOIN users ON posts.user_id = users.id
//        ORDER BY posts.created_at DESC";
//
//$result = mysqli_query($db, $sql);
//
//if (!$result) {
//    die("Fout bij ophalen posts: " . mysqli_error($db));
//}
//?>
<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Feed</title>-->
<!--    <link rel="stylesheet" href="CSS/home.css">-->
<!--</head>-->
<!--<body>-->
<!---->
<!--<!-- Sidebar -->-->
<!--<div class="sidebar">-->
<!--    <h2>MadeByMe</h2>-->
<!--    <a href="index.php" class="active">🏠 Home</a>-->
<!--    <a href="create.php">➕ Create</a>-->
<!--    <a href="#">✔ Verify</a>-->
<!--    <a href="#">👤 Profile</a>-->
<!--</div>-->
<!---->
<!--<!-- Hoofdcontent -->-->
<!--<div class="container">-->
<!--    <h1>Human Feed</h1>-->
<!--    <a class="button" href="create.php">+ New Post</a>-->
<!---->
<!--    <div class="feed">-->
<!--        --><?php //while ($row = mysqli_fetch_assoc($result)) { ?>
<!--            <div class="post">-->
<!--                <h3>--><?php //echo $row['username']; ?><!--</h3>-->
<!--                <p>--><?php //echo nl2br($row['content']); ?><!--</p>-->
<!---->
<!--                --><?php //if (!empty($row['media_url'])) {
//                    $file = $row['media_url'];
//
//                    // Check of het een video is
//                    if (
//                        str_ends_with($file, '.mp4') ||
//                        str_ends_with($file, '.webm') ||
//                        str_ends_with($file, '.ogg')
//                    ) { ?>
<!--                        <video controls>-->
<!--                            <source src="--><?php //echo $file; ?><!--" type="video/mp4">-->
<!--                        </video>-->
<!--                    --><?php //} else { ?>
<!--                        <img src="--><?php //echo $file; ?><!--" alt="Post media"/>-->
<!--                    --><?php //}
//                } ?>
<!---->
<!--                <small>Posted on --><?php //echo $row['created_at']; ?><!--</small>-->
<!--            </div>-->
<!--        --><?php //} ?>
<!--    </div>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->


<?php
// Verbind met de database
include 'includes/database.php';

// SQL query om alle posts + gebruikersnaam op te halen
$sql = "SELECT posts.content, posts.media_url, posts.created_at, users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";

// Voer de query uit
$result = mysqli_query($db, $sql);

// Check of query gelukt is
if (!$result) {
    die("Fout bij ophalen posts: " . mysqli_error($db));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feed</title>
    <!-- Link naar je externe CSS bestand -->
    <link rel="stylesheet" href="CSS/home.css">
</head>
<body>

<!-- Sidebar (menu links of boven bij mobiel) -->
<div class="sidebar">
    <h2>MadeByMe</h2>
    <a href="index.php" class="active">🏠 Home</a>
    <a href="create.php">➕ Create</a>
    <a href="#">✔ Verify</a>
    <a href="#">👤 Profile</a>
</div>

<!-- Hoofdcontent -->
<div class="container">
    <h1>Human Feed</h1>
    <a class="button" href="create.php">+ New Post</a>

    <!-- Hier komen de posts -->
    <div class="feed">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="post">
                <!-- Gebruikersnaam -->
                <h3><?php echo $row['username']; ?></h3>

                <!-- Tekst van de post -->
                <p><?php echo nl2br($row['content']); ?></p>

                <!-- Media (foto of video) -->
                <?php if (!empty($row['media_url'])) {
                    $file = $row['media_url'];

                    // Check of het een video is
                    if (
                        str_ends_with($file, '.mp4') ||
                        str_ends_with($file, '.webm') ||
                        str_ends_with($file, '.ogg')
                    ) { ?>
                        <div class="media">
                            <video controls>
                                <source src="<?php echo $file; ?>" type="video/mp4">
                            </video>
                        </div>
                    <?php } else { ?>
                        <div class="media">
                            <img src="<?php echo $file; ?>" alt="Post media"/>
                        </div>
                    <?php }
                } ?>

                <!-- Datum -->
                <small>Posted on <?php echo $row['created_at']; ?></small>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
