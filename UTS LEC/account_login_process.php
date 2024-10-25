<!--page init-->
<?php
session_start();
require_once('database/config.php');


$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$email]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $error_message = "<b>User not found</b>";
    header("Location: account_login.php?error=1");
    exit();
} else {
    if (!password_verify($password, $row['password'])) {
        $error_message = "<b>Wrong password</b>";
        header("Location: account_login.php?error=2");
        exit();
    } else {
        // Login success, set SESSION DATA
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['is_admin'] = $row['is_admin'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['acc_creation'] = $row['created_at'];
        $_SESSION['debug_mode'] = 0;
        header('location: dashboard.php');
        exit();
    }
}