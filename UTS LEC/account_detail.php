<?php
session_start();

if(!isset($_SESSION['id'])){
    header('location: account_login.php');
    exit();
}


//init for user history
if (!$_SESSION['is_admin'] || $_SESSION['debug_mode']) {
    require './database/config.php';
    $user_id = $_SESSION['id'];
    $sql = 'SELECT e.event_name, e.event_date, r.event_id, r.registration_date
            FROM registrations AS r
            LEFT JOIN events AS e
            ON (r.event_id = e.id)
            WHERE user_id = ?';
    $stm = $db->prepare($sql);
    if($stm->execute([$user_id])){
        if($stm->rowCount() > 0){
            $result_exist = 1;
        }
        else{
            $result_exist = 0;
        }
    }
}


require './includes/header.php';
?>

<body>
    <?php include './includes/navbar.php'; ?>
    <br />
    <br />

    <div class="d-flex flex-column justify-content-center">
        <div id="content" class="mx-auto my-4 p-4 bg-secondary bg-opacity-10">
            <h1>
                <b><?= $_SESSION['name'] ?></b>
            </h1>
            <?= 'Email: ' . htmlspecialchars($_SESSION['email']) ?><br/>
            made at: <?= $_SESSION['acc_creation'] //account creation time?><br/>
            Role: <?php if ($_SESSION['is_admin']) { echo 'Admin';} else {echo 'User';} ?>
        </div>
        <div id='content' class='mx-auto my-4 p-4'>
            <?php //check for user only and if there is anything registered
            if(!$_SESSION['is_admin'] || $_SESSION['debug_mode']){
                if($result_exist == 1){
            ?>

            <table class = 'table table-striped table-bordered'>
                <!-- table header -->
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Registration Date</th>
                    <th>Action</th>
                </tr>
            <?php
                    while($row = $stm->fetch(PDO::FETCH_ASSOC)){
            ?>
                <!-- table content -->
                <tr>
                    <td><?= $row['event_name'] ?></td>
                    <td><?= $row['event_date'] ?></td>
                    <td><?= $row['registration_date'] ?></td>
                    <td>
                        <a class="nav-link mx-2 text-dark" href = './user/event_detail.php?id=<?= $row['event_id'] ?>'><b>View Detail</b></a>
                    </td>
                </tr>
            <?php
                    }
            ?>
            </table>
            
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!--footer-->
    <hr>
    <?php include './includes/footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>