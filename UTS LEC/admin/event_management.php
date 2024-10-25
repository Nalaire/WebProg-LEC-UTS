<?php
session_start();
require_once '../database/config.php';

//admin verification
if (!isset($_SESSION['is_admin'])) {
    header('Location: ../account_login.php');
    exit;
}
if ($_SESSION['is_admin'] !== 1) {
    header('Location: ../account_login.php');
    exit;
}

$sql = "SELECT * FROM events";
$events = $conn->query($sql);

if (isset($_GET['delete'])) {
    $event_id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $event_id);
    
    if ($stmt->execute()) {
        echo "Event successfully deleted!";
    } else {
        echo "Failed to delete event.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_event'])) {
    $event_id = intval($_POST['event_id']);
    $event_name = htmlspecialchars($_POST['event_name']);
    $event_date = htmlspecialchars($_POST['event_date']);
    $event_location = htmlspecialchars($_POST['event_location']);
    $event_description = htmlspecialchars($_POST['event_description']);
    $max_participants = intval($_POST['max_participants']);

    $sql = "UPDATE events SET event_name = ?, event_date = ?, event_location = ?, event_description = ?, max_participants = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $event_name, $event_date, $event_location, $event_description, $max_participants, $event_id);
    
    if ($stmt->execute()) {
        echo "Event successfully updated!";
    } else {
        echo "Failed to update event.";
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
        <h2 class="mt-4 mb-1 p-0">Manage Events</h2>
    </div>

    <div id="content" class="mx-auto my-4 p-2 bg-secondary bg-opacity-10">
        <table class="table">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Event Location</th>
                    <th>Event Description</th>
                    <th>Max Participants</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($event = $events->fetch_assoc()): ?>
                <tr id="row-<?= $event['id'] ?>">
                    <td id="event-name-<?= $event['id'] ?>"><?= htmlspecialchars($event['event_name']) ?></td>
                    <td id="event-date-<?= $event['id'] ?>"><?= htmlspecialchars($event['event_date']) ?></td>
                    <td id="event-location-<?= $event['id'] ?>"><?= htmlspecialchars($event['event_location']) ?></td>
                    <td id="event-description-<?= $event['id'] ?>"><?= htmlspecialchars($event['event_description']) ?></td>
                    <td id="max-participants-<?= $event['id'] ?>"><?= htmlspecialchars($event['max_participants']) ?></td>
                    <td>
                        <button class="btn btn-primary m-1" type="button" id="edit-btn-<?= $event['id'] ?>" onclick="enableEdit(<?= $event['id'] ?>)">Edit</button>
                        <div>
                            <a class="btn btn-danger m-1" href="event_management.php?delete=<?= $event['id'] ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </div>
                    </td>
                </tr>

                <!-- Hidden Edit Form Row -->
                <tr id="edit-form-<?= $event['id'] ?>" style="display: none;">
                    <td colspan="3">
                        <form action="event_management.php" method="POST">
                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                            <input type="text" name="event_name" value="<?= htmlspecialchars($event['event_name']) ?>" required>
                            <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required>
                            <input type="text" name="event_location" value="<?= htmlspecialchars($event['event_location']) ?>" required>
                            <textarea name="event_description" required><?= htmlspecialchars($event['event_description']) ?></textarea>
                            <input type="number" name="max_participants" value="<?= $event['max_participants'] ?>" required>
                            <button class="btn btn-warning" type="submit" name="edit_event">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
    function toggleEditForm(eventId) {
        var formRow = document.getElementById('edit-form-' + eventId);
        if (formRow.style.display === 'none' || formRow.style.display === '') {
            formRow.style.display = 'table-row';
        } else {
            formRow.style.display = 'none';
        }
    }

    function enableEdit(eventId) {
        var eventName = document.getElementById('event-name-' + eventId).innerText;
        var eventDate = document.getElementById('event-date-' + eventId).innerText;
        var eventLocation = document.getElementById('event-location-' + eventId).innerText;
        var eventDescription = document.getElementById('event-description-' + eventId).innerText;
        var maxParticipants = document.getElementById('max-participants-' + eventId).innerText;

        document.getElementById('event-name-' + eventId).innerHTML = 
            `<input type="text" id="edit-name-${eventId}" value="${eventName}" required>`;

        document.getElementById('event-date-' + eventId).innerHTML = 
            `<input type="date" id="edit-date-${eventId}" value="${eventDate}" required>`;

        document.getElementById('event-location-' + eventId).innerHTML = 
            `<input type="text" id="edit-location-${eventId}" value="${eventLocation}" required>`;

        document.getElementById('event-description-' + eventId).innerHTML = 
            `<textarea id="edit-description-${eventId}" required>${eventDescription}</textarea>`;

        document.getElementById('max-participants-' + eventId).innerHTML = 
            `<input type="number" id="edit-max-participants-${eventId}" value="${maxParticipants}" required>`;

        document.getElementById('edit-btn-' + eventId).outerHTML = 
            `<button class="btn btn-warning" type="button" onclick="submitEdit(${eventId})">Update</button>`;
    }

    function submitEdit(eventId) {
        var updatedName = document.getElementById('edit-name-' + eventId).value;
        var updatedDate = document.getElementById('edit-date-' + eventId).value;
        var updatedLocation = document.getElementById('edit-location-' + eventId).value;
        var updatedDescription = document.getElementById('edit-description-' + eventId).value;
        var updatedMaxParticipants = document.getElementById('edit-max-participants-' + eventId).value;

        var form = document.createElement('form');
        form.action = 'event_management.php';
        form.method = 'POST';

        form.innerHTML = `
            <input type="hidden" name="event_id" value="${eventId}">
            <input type="hidden" name="event_name" value="${updatedName}">
            <input type="hidden" name="event_date" value="${updatedDate}">
            <input type="hidden" name="event_location" value="${updatedLocation}">
            <input type="hidden" name="event_description" value="${updatedDescription}">
            <input type="hidden" name="max_participants" value="${updatedMaxParticipants}">
            <input type="hidden" name="edit_event" value="true">
        `;

        document.body.appendChild(form);
        form.submit();
    }

    </script>

    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>