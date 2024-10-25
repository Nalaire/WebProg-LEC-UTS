<?php
session_start();

//check session
if (!isset($_SESSION['id'])) {
  header('location: account_login.php');
  exit();
}
//check role
if ($_SESSION['is_admin'] && !$_SESSION['debug_mode']) {
  header('location: account_login.php');
  exit();
}

require '../database/config.php';

$user_id = $_SESSION['id'];

$sql = "SELECT * FROM registrations 
        LEFT JOIN events ON registrations.event_id = events.id 
        WHERE registrations.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

require '../includes/header.php';
?>
<body>
  <?php include '../includes/navbar2.php'; ?>
  <br />
  <br />
  <!--Alert box placement-->
  <div id="alert-box">
  </div>
  <div class = 'd-flex flex-column justify-content-center'>
    <div>
      <?php
      if(isset($_SESSION['err_reg_cancel'])){
        if($_SESSION['err_reg_cancel']){
          echo '<div class="alert alert-danger">' . '<h5>Failed to cancel registration...</h5>' . '</div>';
        }else{
          echo '<div class="alert alert-danger">' . '<h5>Register cancelation success!</h5>' . '</div>';
        }
        unset($_SESSION['err_reg_cancel']);
      }
      ?>
    </div>

    <div id="page-head" class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="mt-4 mb-1 p-0">Event Registered</h2>
    </div>

    <div class = 'd-flex justify-content-center'>
      <div>
        <!-- table to list the event registered -->
        <table class="table">
          <tr>
            <th>Nama Event</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
          </tr>
          <?php while ($row = $result->fetch_assoc()) : ?>
          <tr>
            <td><?= $row['event_name'] ?></td>
            <td><?= $row['event_date'] ?></td>
            <td><?= $row['event_location'] ?></td>
            <td>
              <button onclick="alert_box_warning(<?= $row['event_id']?>, '<?= $row['event_name'] ?>')" type='submit' class='btn btn-danger'>
                Delete
              </button>
            </td>
          </tr>
          <?php endwhile; ?>
        </table>
      </div>
    </div>
  </div>
  <hr>
  <?php include '../includes/footer.php'; ?>
  <script>
    var alert_element = document.getElementById('alert-box'); //alert box element

    //close alert box
    function close_alert_box() {
      alert_element.innerHTML = '';
    };

    //Delete warning
    function alert_box_warning(event_id, event_name) {
      var event_id_str = event_id.toString();
      var event_name_str = event_name.toString();

      alert_element.innerHTML = '<div class="bg-success alertCover">asdf</div>';

      alert_element.innerHTML = '<div class="alertCover bg-dark bg-opacity-50">' +
        '<div class="bg-white rounded position-fixed top-50 start-50 translate-middle alertBox">' +
        '<div class="w-100 h-100 p-2 d-flex flex-column">' +
        '<div class="d-flex flex-row justify-content-between m-1">' +
        "<h4>Unregister from " + event_name_str + "?</h4>" +
        '<button onclick="close_alert_box()" class="btn btn-sm btn-secondary">&times</button>' +
        '</div>' +
        '<div class="d-flex flex-row justify-content-between m-1">' +
        "<form action='cancel_registration.php' method='post'>" +
        '<input type="hidden" readonly name="event_id" value=' + event_id_str + ' />' +
        '<button type="submit" class="btn btn-danger">Yes, unregister from this event</button>' +
        '</form>' +
        "<button onclick='close_alert_box()' class='btn btn-warning'>No, don't unregister</button>" +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</body>
