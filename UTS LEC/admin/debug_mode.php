<!--page init-->
<?php
session_start();
require_once('../database/config.php');
//check session
if (!isset($_SESSION['id'])) {
    header('location: ../account_login.php');
    exit();
}

//check access
if (!$_SESSION['is_admin']) {
    header('location: ../dashboard.php');
    exit();
}

if (!isset($_SESSION['debug_mode'])) {
    $_SESSION['debug_mode'] = 1;
    header('location: ../dashboard.php');
    exit();
}
else if ($_SESSION['debug_mode'] == 1) {
    $_SESSION['debug_mode'] = 0;
    header('location: ../dashboard.php');
    exit();
}
else {
    $_SESSION['debug_mode'] = 1;
    header('location: ../dashboard.php');
    exit();
}