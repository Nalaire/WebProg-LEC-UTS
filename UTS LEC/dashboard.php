<!--page init-->
<?php
session_start();

// Check session
if (!isset($_SESSION['id'])) {
    header('location: account_login.php');
    exit();
}

require_once 'database/config.php';

// Fetch statistics for admin's dashboard
if($_SESSION['is_admin']){
    $sql_events = "SELECT * 
                   FROM events AS e
                   LEFT JOIN (
                       SELECT event_id, IFNULL(COUNT(*), '0') AS participant
                       FROM registrations
                       GROUP BY event_id
                   ) AS c
                   ON (e.id = c.event_id)
                   WHERE event_status = 'open'";
    $stm_display_event = $db->query($sql_events);
} else {
    $sql_events = "SELECT * FROM events WHERE event_status = 'open'";
    $stm_display_event = $db->query($sql_events);
}

require './includes/header.php';
?>

<body>

    <!--navbar-->
    <?php include './includes/navbar.php'; ?>
    <br />
    <br />

    <!--content page-->
    <div id="content" class="w-75 mx-auto my-4 p-2 bg-secondary bg-opacity-10">
        <div class="grid-container bg-success">
            <?php
            if($stm_display_event->rowCount() > 0) {
                if($_SESSION['is_admin'] && !$_SESSION['debug_mode']) {
                    while($row = $stm_display_event->fetch(PDO::FETCH_ASSOC)) {
            ?>
            
            <!-- Admin dashboard content -->
            <div class="card mx-auto my-auto grid-item" style="width: 100%; height: 100%;">
                <img class="card-img-top bg-secondary bg-opacity-50" src="images/<?= $row['event_image'] ?>" alt="<?= $row['event_name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['event_name'] ?></h5>
                    <strong>Date: </strong><br/>
                    <p class="card-text"><?= $row['event_date'] ?></p>
                    <strong>Status: </strong><br/>
                    <p class="card-text"><?= $row['event_status'] ?></p>
                    <strong>Location: </strong><br/>
                    <p class="card-text"><?= $row['event_location'] ?></p>
                    <p class="card-text"><?= $row['event_description'] ?></p>
                    <p class="card-text"><strong>Participant: </strong> <?php if (isset($row['participant'])) {
                        echo $row['participant'];
                    } else {
                        echo "No Participant";
                    } ?></p>
                </div>
            </div>
            
            <?php
                    }
                }
                if(!$_SESSION['is_admin'] || $_SESSION['debug_mode']){
                    while($row = $stm_display_event->fetch(PDO::FETCH_ASSOC)){
            ?>
            
            <!-- User dashboard content -->
            <div class="card mx-auto my-auto grid-item" style="width: 100%; height: 100%">
                <img class="card-img-top bg-secondary bg-opacity-50" src="images/<?= $row['event_image'] ?>" alt="<?= $row['event_name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['event_name'] ?></h5>
                    <p class="card-text"><?= $row['event_description'] ?></p>
                    <a href="./user/event_detail.php?id=<?= $row['id'] ?>"><strong>View More Detail</strong></a>
                </div>
            </div>

            <?php
                    }
                }
            } else {
            ?>
            <p class="text-warning">No events available at the moment. Please check back later.</p>
            <?php
            }
            ?>
        </div>
    </div>

    <hr>
    <?php include './includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
</html>
