<!--page init-->
<?php
session_start();
require_once('database/config.php');
//check session
if (isset($_SESSION['id'])) {
    header('location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <!--content of the page-->
    <div class="d-flex flex-column justify-content-center align-items-center">
        
        <!--Form for Login-->
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            
            <form action="account_login_process.php" method="post" class="was-validated">
                <div class="mb-3 ms-2">
                    <div id="error_status"></div>
                    <h1>User Log in</h1>
                    <input type="text" class="form-control" name="email" placeholder="Email Address" required />
                    <div class="invalid-feedback">
                        Please provide an email address.
                    </div><br />
                    <input type="password" class="form-control" name="password" placeholder="Password" required />
                    <div class="invalid-feedback">
                        Please provide a password.
                    </div><br />
                    <button type="submit" name="submitform" class="btn btn-dark" data-mdb-ripple-init>Submit</button><br /><br />
                    <a class="btn btn-dark" data-mdb-ripple-init href="account_register.php">Don't have account? Register here</a>
                </div>
            </form>

        </div>

    </div> <!--End of Page-->



    <!--bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--alert box-->
    <script>
        error_status = <?php
            //parse the $_GET variable
            $error_status = $_GET['error'];
            if ($error_status == 1) {
                echo '1';
            } else if ($error_status == 2) {
                echo '2';
            }
            else {
                echo '0';
            }
        ?>;

        if (error_status == 1) {
            document.getElementById("error_status").innerHTML = '<div class="alert alert-danger" role="alert"><b>User Not Found</b></div>';
        }
        else if (error_status == 2) {
            document.getElementById("error_status").innerHTML = '<div class="alert alert-danger" role="alert"><b>Password Does Not Match</b></div>';
        }
    </script>
</body>
</html>

