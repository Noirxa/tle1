<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn'] !== true) {
    // Stuur de gebruiker door naar form.php
    header("Location: index.php?error=unauthorized");
    exit;
}

// Als de gebruiker is ingelogd, toon een beveiligde pagina
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beveiligde Pagina</title>
</head>
<body>
</body>
</html>