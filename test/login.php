<?php
//hello
global $db;
session_start();

require_once "includes/database.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $inputPassword = $_POST['password'] ?? '';

    if (empty($email) || empty($inputPassword)) {
        $errors[] = "Somethings is empty...";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($inputPassword, $user['password'])) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                header("Location: index.php");
                exit;
            } else {
                $errors[] = "password incorrect!";
            }
        } else {
            $errors[] = "No user or email found!";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in - MadeByMe</title>
</head>
<body>
<h1>Log in</h1>

<form method="post" action="login.php">
    <label for="email">E-mailadres</label><br>
    <input type="text" id="email" name="email" required><br><br>

    <label for="password">password</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Inloggen</button>
</form>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<p>Want to join us? <a href="register.php">Register here!</a></p>
</body>
</html>
