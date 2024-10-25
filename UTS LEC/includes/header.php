<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard: <?php
    //name of dashboard change depending on the user type
    $is_admin = $_SESSION['is_admin'];
    if ($is_admin) {
        echo 'Admin';
    }
    else {
        echo 'User';
    }
    ?></title>
    <style>
    /* Custom CSS for dropdown */
    .dropdown-menu {
      display: none;
      position: absolute;
      z-index: 1000;
    }

    .nav-item:hover .dropdown-menu {
      display: block;
    }

    /* grid */
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        gap: 5px;
        padding: 2%;
    }

    @media only screen and (max-width: 900px) {
      .grid-container {
        display: grid;
        grid-template-columns: auto auto;
        gap: 5px;
        padding: 2%;
      }
    }

    @media only screen and (max-width: 600px) {
      .grid-container {
        display: grid;
        grid-template-columns: auto;
        gap: 5px;
        padding: 2%;
      }
    }

    .grid-item {
      min-width: 200px;
    }

    /* Daniel's alertbox */
    .alertCover {
      position: fixed;
      padding: 0;
      margin: 0;

      top: 0;
      left: 0;

      width: 100%;
      height: 100%;
    }

    .alertBox {
      width: 75%;
      max-width: 500px;
      height: auto;
      max-height: 300px;
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>