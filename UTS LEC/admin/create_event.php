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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $event_name = htmlspecialchars($_POST['event_name']);
    $event_date = htmlspecialchars($_POST['event_date']);
    $event_location = htmlspecialchars($_POST['event_location']);
    $event_description = htmlspecialchars($_POST['event_description']);
    $max_participants = intval($_POST['max_participants']);
    
    // File upload for event image
    $event_image = $_FILES['event_image']['name'];
    $target = "../images/" . basename($event_image);
    
    if (move_uploaded_file($_FILES['event_image']['tmp_name'], $target)) {
        // Insert event into the database
        $sql = "INSERT INTO events (event_name, event_date, event_location, event_description, event_image, max_participants) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $event_name, $event_date, $event_location, $event_description, $event_image, $max_participants);
        
        if ($stmt->execute()) {
            // Redirect to the dashboard if the event is created successfully
            header('Location: ../dashboard.php');
            exit;
        } else {
            echo "Error creating event.";
        }
    } else {
        echo "Failed to upload image.";
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
        <h2 class="mt-4 mb-1 p-0">Create New Event</h2>
    </div>

    <!--content of the page-->
    <div id="content" class="mx-auto my-4 p-2 bg-secondary bg-opacity-10 d-flex justify-content-center">
        <!-- HTML Form for creating an event -->
        <div class="bg-white p-3 d-flex flex-column">
            <form action="create_event.php" method="POST" enctype="multipart/form-data">
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label>Event Name:</label>
                    <input type="text" name="event_name" placeholder="Event Name" required>
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label>Event Date:</label>
                    <input type="date" name="event_date" required>
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label>Event Location:</label>
                    <input type="text" name="event_location" placeholder="Event Location" required>
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label>Description:</label>
                    <textarea name="event_description" placeholder="Event Description" required></textarea>
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label>Max Participants:</label>
                    <input type="number" name="max_participants" placeholder="Max Participants" required>
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label>Event Banner/Image:</label>
                    <input type="file" name="event_image" required>
                </div>
                <button class="btn btn-primary" type="submit">Create Event</button>
            </form>
        </div>
    </div>

    <hr>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>