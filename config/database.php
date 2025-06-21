<?php

$url = "localhost";
$user = "root";
$pass = "";
$db = "ridb";

$conn = mysqli_connect($url, $user, $pass, $db);

if (!$conn) {

    die("The connection is not established" . mysqli_connect_error());
}


// $serverName = "tcp:krissslazarte.database.windows.net,1433";
// $connectionInfo = array(
//     "UID" => "CloudSA38c8fe9d",
//     "PWD" => "B09120146995b",  // <-- Must NOT be empty!
//     "Database" => "ridb",
//     "LoginTimeout" => 30,
//     "Encrypt" => 1,
//     "TrustServerCertificate" => 0
// );

// $conn = sqlsrv_connect($serverName, $connectionInfo);

// if ($conn) {
//     echo "✅ Connection successful.";
// } else {
//     echo "❌ Connection failed.<br>";
//     die(print_r(sqlsrv_errors(), true));
// }
