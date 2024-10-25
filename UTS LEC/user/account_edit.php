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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '../database/config.php'; //init database + prep statement
    $sql_name = 'UPDATE users
            SET name = ?
            WHERE id = ?';
    $stm_name = $db->prepare($sql_name);
    
    $sql_email = 'UPDATE users
            SET email = ?
            WHERE id = ?';
    $stm_email = $db->prepare($sql_email);
    
    $sql_pass = 'UPDATE users
            SET password = ?
            WHERE id = ?';
    $stm_pass = $db->prepare($sql_pass);

    $sql_query = 'SELECT * FROM users WHERE email = ?';
    $stm_query = $db->prepare($sql_query);

    if($_POST['name'] != ''){ //processing
        if($_POST['name'] != $_SESSION['name']){
            if($stm_name->execute([$_POST['name'], $_SESSION['id']])){
                $_SESSION['name'] = $_POST['name'];
                $name_changed = 1;
            }else{
                $name_changed = 0;
            }
        }else{
            $name_changed = -1;
        }
    }

    if($_POST['email'] != ''){
        if($_POST['email'] != $_SESSION['email']){
            if($stm_query->execute([$_POST['email']])){
                if($stm_query->rowCount() == 0){
                    if($stm_email->execute([$_POST['email'], $_SESSION['id']])){
                        $_SESSION['email'] = $_POST['email'];
                        $email_changed = 1;
                    }else{
                        $email_changed = 0;
                    }
                }else{
                    $email_changed = -2;
                }
            }else{
                $email_changed = 0;
            }
        }else{
            $email_changed = -1;
        }
    }

    if($_POST['password'] != ''){
        $en_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if($stm_pass->execute([$en_pass, $_SESSION['id']])){
            $pass_changed = 1;
        }else{
            $pass_changed = 0;
        }
    }
}

include '../includes/header.php';
?>
<body>
    <?php
    require_once '../includes/header.php';
    include '../includes/navbar2.php'; ?>
    <br>
    <br>

    <div id="page-head" class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="mt-4 mb-1 p-0">Edit Account</h2>
    </div>

    <div id="content" class="mx-auto my-4 p-2 bg-secondary bg-opacity-50 d-flex justify-content-center">
        <div class="bg-white p-3 d-flex flex-column">
            <form action = './account_edit.php' method = 'post'>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label for = 'name'>Name: </label>
                    <input type='text' name='name' placeholder='<?= $_SESSION['name']?>'/>
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label for = 'email'>Email: </label>
                    <input type = 'email' name = 'email' placeholder = '<?= $_SESSION['email'] ?>' />
                </div>
                <div class="mb-1 d-flex flex-row justify-content-between">
                    <label for = 'password'>Password: </label>
                    <input type = 'password' name = 'password' placeholder = 'Password' />
                </div>
                <button type = 'submit' class = 'btn btn-primary mt-1'>Save Changes</button>
            </form>
        </div>
    </div>
    
    <!-- change reaction container -->
    <div>
    <?php
    if(isset($name_changed)){
        switch($name_changed){
            case 1:
                echo 'Name Changed Successfully';
                break;
            case 0:
                echo 'Failed to Change Name...';
                break;
            case -1:
                echo 'New Name is the Same...';
                break;
        }
    }
    if(isset($email_changed)){
        switch($email_changed){
            case 1:
                echo 'Email Changed Successfully';
                break;
            case 0:
                echo 'Failed to Change Email...';
                break;
            case -1:
                echo 'New Email is the Same...';
                break;
            case -2:
                echo 'New Email is already used...';
                break;
        }
    }
    if(isset($pass_changed)){
        switch($name_changed){
            case 1:
                echo 'Password Changed Successfully';
                break;
            case 0:
                echo 'Failed to Change Password...';
                break;
        }
    }
    ?>
    </div>

    <hr>
    <?php include '../includes/footer.php' ?>
</body>