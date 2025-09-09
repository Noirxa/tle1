<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'social';

$db = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$db) {
    die("Error: " . mysqli_connect_error());
}
?>
