<?php

$url = "localhost";
$user = "root";
$pass = "";
$db = "ridb";

$conn = mysqli_connect($url, $user, $pass, $db);

if (!$conn) {

    die("The connection is not established" . mysqli_connect_error());
}
