<?php
session_start();
require_once('database/config.php');
unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['is_admin']);
unset($_SESSION['debug_mode']);
session_destroy();
header('location: account_login.php');
exit();