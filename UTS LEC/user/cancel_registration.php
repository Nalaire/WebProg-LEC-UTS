<?php
session_start();

//check session
if (!isset($_SESSION['id'])) {
  header('location: ../account_login.php');
  exit();
}
//check role
if ($_SESSION['is_admin'] && !$_SESSION['debug_mode']) {
  header('location: ../dashboard.php');
  exit();
}

include '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = $_SESSION['id'];
  $event_id = $_POST['event_id'];

  // Batalkan pendaftaran user
  $sql = "DELETE FROM registrations WHERE user_id = ? AND event_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $user_id, $event_id);
  if ($stmt->execute()) {
    $_SESSION['err_reg_cancel'] = 0;
  } else {
    $_SESSION['err_reg_cancel'] = 1;
  }
  header('location: event_registered.php');
}
?>
