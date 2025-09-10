<?php
//
///** @var mysqli $db */
//require_once "includes/database.php";
//
//$username = $email = $password = "";
//$errors = [];
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $username = trim($_POST['username'] ?? '');
//    $email = trim($_POST['email'] ?? '');
//    $password = $_POST['password'] ?? '';
//
//    if (empty($username)) {
//        $errors['username'] = 'Username is required.';
//    }
//
//    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        $errors['email'] = 'A valid email address is required.';
//    }
//
//    if (empty($password) || strlen($password) < 8) {
//        $errors['password'] = 'Password must be at least 8 characters long.';
//    }
//
//    if (empty($errors)) {
//        $checkQuery = "SELECT id FROM users WHERE email = ?";
//        $checkStmt = $db->prepare($checkQuery);
//        $checkStmt->bind_param("s", $email);
//        $checkStmt->execute();
//        $checkResult = $checkStmt->get_result();
//
//        if ($checkResult->num_rows > 0) {
//            $errors['email'] = "This email is already registered.";
//        }
//    }
//
//    if (empty($errors)) {
//        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//
//        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
//        $stmt = $db->prepare($query);
//        $stmt->bind_param("sss", $username, $email, $hashedPassword);
//
//        if ($stmt->execute()) {
//            header("Location: login.php");
//            exit;
//        } else {
//            $errors['database'] = 'Something went wrong while saving the user. Please try again.';
//        }
//    }
//}
//
//
//?>
<!---->
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Register - MadeByMe</title>-->
<!--</head>-->
<!--<body>-->
<!--<h1>Register</h1>-->
<!---->
<!--<form action="" method="post">-->
<!--    <label for="username">Username</label><br>-->
<!--    <input type="text" id="username" name="username" value="--><?php //= htmlspecialchars($username) ?><!--"><br>-->
<!--    <small style="color:red;">--><?php //= $errors['username'] ?? '' ?><!--</small><br><br>-->
<!---->
<!--    <label for="email">Email</label><br>-->
<!--    <input type="text" id="email" name="email" value="--><?php //= htmlspecialchars($email) ?><!--"><br>-->
<!--    <small style="color:red;">--><?php //= $errors['email'] ?? '' ?><!--</small><br><br>-->
<!---->
<!--    <label for="password">Password</label><br>-->
<!--    <input type="password" id="password" name="password"><br>-->
<!--    <small style="color:red;">--><?php //= $errors['password'] ?? '' ?><!--</small><br><br>-->
<!---->
<!--    <button type="submit">Register</button>-->
<!--</form>-->
<!---->
<?php //if (!empty($errors['database'])): ?>
<!--    <p style="color:red;">--><?php //= $errors['database'] ?><!--</p>-->
<?php //endif; ?>
<!---->
<!--<p>Already have an account? <a href="login.php">Log in here</a></p>-->
<!--<p><a href="index.php">&laquo; Back to feed</a></p>-->
<!--</body>-->
<!--</html>-->


<?php
require_once "includes/database.php";

$username = $email = $password = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'A valid email address is required.';
    }

    if (empty($password) || strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    }

    if (empty($errors)) {
        $checkQuery = "SELECT id FROM users WHERE email = ?";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $errors['email'] = "This email is already registered.";
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $errors['database'] = 'Something went wrong while saving the user. Please try again.';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - MadeByMe</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <h1>Register</h1>

        <?php if (!empty($errors['database'])): ?>
            <div class="error-box"><?= htmlspecialchars($errors['database']) ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" placeholder="Your username">
            <?php if(!empty($errors['username'])): ?>
                <div class="error-box"><?= htmlspecialchars($errors['username']) ?></div>
            <?php endif; ?>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Your email">
            <?php if(!empty($errors['email'])): ?>
                <div class="error-box"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="At least 8 characters">
            <?php if(!empty($errors['password'])): ?>
                <div class="error-box"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Log in here</a></p>
        <p><a href="index.php">&laquo; Back to feed</a></p>
    </div>
</div>
</body>
</html>
