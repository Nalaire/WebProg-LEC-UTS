<?php
session_start();

//check session
if (!isset($_SESSION['id'])) {
  header('location: account_login.php');
  exit();
}
//check role
if ($_SESSION['is_admin'] && !$_SESSION['debug_mode']) {
  header('location: account_login.php');
  exit();
}

require '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = $_SESSION['id'];
  $event_id = $_POST['event_id'];

  // Cek apakah user sudah terdaftar
  $sql = "SELECT * FROM registrations WHERE user_id = ? AND event_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $user_id, $event_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 0) {
    // Daftar user ke event
    $sql = "INSERT INTO registrations (user_id, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    if($stmt->execute()){
      $_SESSION['err_register'] = 0;
    }else{
      $_SESSION['err_register'] = 1;
    }
  } else {
    $_SESSION['err_register'] = 2;
  }
}
header('location: event_detail.php?id='. $_POST['event_id']);
?>
