<?php
session_start();

//check session
if (!isset($_SESSION['id'])) {
  header('location: ../account_login.php');
  exit();
}
//check role
if ($_SESSION['is_admin'] && !$_SESSION['debug_mode']) {
  header('location: ../account_login.php');
  exit();
}

require '../database/config.php';

if(isset($_GET['id'])){//check for id from get
  $event_id = $_GET['id'];
}else{
  header('location: ../dashboard.php');
}

//query for single event's row
$sql = "SELECT * FROM events WHERE id = ? AND event_status = 'open'";
$stm = $db->prepare($sql);
if($stm->execute([$event_id])){
  $event = $stm->fetch(PDO::FETCH_ASSOC);
}else{
  $err_query = 1;
}

include '../includes/header.php';
?>
<body>
  <?php include '../includes/navbar2.php'; ?>
  <br />
  <br />

  <div class = 'container'>

    <?php //query fail handler
    if(isset($err_query)){
      unset($err_query);
    ?>
    <h1>Oops, something went wrong!</h1>
    <p>page is not found...</p>

    <?php
    }else{//normal flow or the page content (which is event detail and register button)
    ?>

    <!-- details -->
    <div id="content" class="w-75 mx-auto my-4 p-2 bg-secondary bg-opacity-10">
      <div class = 'bg-white mx-auto p-4'>
        <div>
          <h2><?= htmlspecialchars($event['event_name']) ?></h2> <hr>
          <p>Date: <?= htmlspecialchars($event['event_date']) ?></p>
          <p>Creation Time: <?= htmlspecialchars($event['created_at']) ?></p>

          <?php //if check if updated
          if (!empty($event['updated_at'])){ 
          ?>
          <p>Last Update On: <?= htmlspecialchars($event['updated_at']) ?></p>
          <?php 
          } 
          ?>

          <p>Location: <?= htmlspecialchars($event['event_location']) ?></p>
          <p>Status: <?php
          $status = '<p class="text-white bg-danger p-1">';
          if ($event['event_status'] === 'open') {
            $status = '<b class="text-white bg-success p-1">';
          }
          else if ($event['event_status'] === 'closed') {
            $status = '<b class="text-white bg-secondary p-1">';
          }
          else {
            $status = '<b class="text-white bg-danger p-1">';
          }
          echo $status . htmlspecialchars($event['event_status']) . "</b>";
          ?></p>
          <p><?= htmlspecialchars($event['event_description']) ?></p>
        </div>


        <!-- register button -->
        <div>
          <form action="event_registration.php" method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>" readonly>
            <button type="submit" class = 'btn btn-primary'>Register</button>
          </form>
        </div>


        <!-- register error alert -->
        <div>
          <?php
          if(isset($_SESSION['err_register'])){
            switch($_SESSION['err_register']){
              case 0:
                echo 'Registration Success!';
                break;
              case 1:
                echo 'Registration Failed...';
                break;
              case 2:
                echo 'Already Registered. If you want to cancel registration, go to event registered tab';
                break;
              default:
            }
            unset($_SESSION['err_register']);
          }
          ?>
        </div>


      </div>
      <?php
      }
      ?>
    </div>
  </div>


  <!-- footer -->
  <hr>
    <?php include '../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>
