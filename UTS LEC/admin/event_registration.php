<?php
session_start();
require_once '../database/config.php'; // Database connection

// Only allow access if the user is an admin
if (!isset($_SESSION['is_admin'])) {
    header('Location: ../account_login.php');
    exit;
}
if ($_SESSION['is_admin'] !== 1) {
    header('Location: ../account_login.php');
    exit;
}

// Fetch event registrations
$sql = "SELECT registrations.id, users.name AS user_name, users.email, events.event_name, events.event_date
        FROM registrations
        JOIN users ON registrations.user_id = users.id
        JOIN events ON registrations.event_id = events.id
        ORDER BY events.event_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registrations</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include '../includes/navbar2.php';
    require_once '../includes/header.php';?>
    <br>
    <br>

        <div id="page-head" class="d-flex flex-column justify-content-center align-items-center">
            <h1 class="mt-4 mb-1 p-0">Event Registrations</h1>
            <a href="export_registration.php" class="btn btn-success">Export to CSV</a>
        </div>

    <div class="d-flex justify-content-center">
        <div>
            <table class="table">
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($registration = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($registration['user_name']) ?></td>
                            <td><?= htmlspecialchars($registration['email']) ?></td>
                            <td><?= htmlspecialchars($registration['event_name']) ?></td>
                            <td><?= htmlspecialchars($registration['event_date']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No registrations found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <hr>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>
</html>
