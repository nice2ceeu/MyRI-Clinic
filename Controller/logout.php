<?php
session_start();

if (isset($_POST["submit"])) {

    $_SESSION = [];
    session_destroy();

    header("Location: ../view/pages/index.php");
    exit();
}
