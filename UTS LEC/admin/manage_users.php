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

// Fetch all users
$sql = "SELECT * FROM users";
$users = $conn->query($sql);

// Handle user deletion
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo "User successfully deleted!";
    } else {
        echo "Failed to delete user.";
    }
}
?>
<body>
    <?php
    require_once '../includes/header.php';
    include '../includes/navbar2.php'; ?>
    <br>
    <br>

    <div id="page-head" class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="mt-4 mb-1 p-0">Manage Users</h2>
    </div>

    <!-- List of users -->
    <div class="d-flex justify-content-center">
        <div>
            <table class="table">
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <a href="manage_users.php?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <hr>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>