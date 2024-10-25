<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'event_registration');
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $password = $_POST['password'];

  if (!empty($password)) {
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password_hashed, $user_id);
  } else {
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $email, $user_id);
  }

  if ($stmt->execute()) {
    echo "Profil berhasil diperbarui!";
  } else {
    echo "Terjadi kesalahan saat memperbarui profil.";
  }
}
?>
