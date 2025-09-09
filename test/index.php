<?php
// Database connectie
$host       = '127.0.0.1';
$username   = 'root';
$password   = '';
$database   = 'games';

session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
//if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
//    header('Location: login.php');
//    exit;
//}

// connectie met de database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error: '.mysqli_connect_error());

// Query om alle games te laten zien
$query = "SELECT * FROM ";
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

// Een array waarin alle games komen te staan.
$albums = [];
while($row = mysqli_fetch_assoc($result))
{
    $[] = $row;
}

mysqli_close($db);
?>


<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MadeByMe</title>
    <link rel="stylesheet" href="CSS/home.css">
</head>
<body>
<header class="hero is-info">
    <div class="hero-body">
        <p class="title">MadeByMe</p>
        <p class="subtitle">Home</p>
        <a href="logout.php">Log out</a>
    </div>
</header>

<main class="container">
    <section class="section">
        <table class="table mx-auto">
            <thead>
            </thead>
            <tfoot>
            <tr>
                <td colspan="6">&copy; MadeByMe</td>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach($ as $index => $) { ?>
                <tr>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>