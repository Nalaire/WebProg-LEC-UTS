<?php
// Database configuration
$host = 'localhost';
$dbname = 'event_registration_system';
$username = 'root';  // Use your MySQL username
$password = '';      // Use your MySQL password
$dsn = 'mysql:host=localhost;dbname=event_registration_system';
define('DBUSER', 'root');   // change this once it's final
define('DBPASS', '');       // change this once it's final

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);
$db = new PDO($dsn, DBUSER, DBPASS);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
