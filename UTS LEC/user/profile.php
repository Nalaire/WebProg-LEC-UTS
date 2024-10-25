<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'event_registration');
$user_id = $_SESSION['user_id'];

// Ambil data user
$sql = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Ambil histori event yang sudah didaftar
$sql_events = "SELECT events.event_name, events.event_date FROM registrations 
               JOIN events ON registrations.event_id = events.id 
               WHERE registrations.user_id = ?";
$stmt_events = $conn->prepare($sql_events);
$stmt_events->bind_param("i", $user_id);
$stmt_events->execute();
$events = $stmt_events->get_result();
?>

<h2>Profil Saya</h2>
<p>Nama: <?= htmlspecialchars($user['name']) ?></p>
<p>Email: <?= htmlspecialchars($user['email']) ?></p>

<h3>Event yang Terdaftar</h3>
<table>
  <tr>
    <th>Nama Event</th>
    <th>Tanggal Event</th>
  </tr>
  <?php while ($row = $events->fetch_assoc()) : ?>
  <tr>
    <td><?= htmlspecialchars($row['event_name']) ?></td>
    <td><?= htmlspecialchars($row['event_date']) ?></td>
  </tr>
  <?php endwhile; ?>
</table>

<form action="edit_profile.php" method="POST">
  <input type="text" name="name" placeholder="Nama Baru" value="<?= htmlspecialchars($user['name']) ?>" required>
  <input type="email" name="email" placeholder="Email Baru" value="<?= htmlspecialchars($user['email']) ?>" required>
  <input type="password" name="password" placeholder="Password Baru (opsional)">
  <button type="submit">Update Profil</button>
</form>
