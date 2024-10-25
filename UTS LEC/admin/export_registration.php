<?php
session_start();
require_once '../database/config.php'; // Database connection

//admin verification
if (!isset($_SESSION['is_admin'])) {
    header('Location: ../account_login.php');
    exit;
}
if ($_SESSION['is_admin'] !== 1) {
    header('Location: ../account_login.php');
    exit;
}

// Set header for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="event_registrations.csv"');

// Output column headers
$output = fopen('php://output', 'w');
fputcsv($output, array('User Name', 'Email', 'Event Name', 'Event Date'));

// Fetch registrations
$sql = "SELECT users.name as user_name, users.email, events.event_name, events.event_date 
        FROM registrations
        JOIN users ON registrations.user_id = users.id
        JOIN events ON registrations.event_id = events.id";
$result = $conn->query($sql);

// Output each registration row
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
