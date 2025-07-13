<?php

// $url = "localhost";
// $user = "root";
// $pass = "";
// $db = "ridb";

// $conn = mysqli_connect($url, $user, $pass, $db);

// if (!$conn) {

//     die("The connection is not established" . mysqli_connect_error());
// }


require_once __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Retrieve .env values and cast to string
$name   = (string) $_ENV['DB_SERVER'];
$user   = (string) $_ENV['DB_UID'];
$pass   = (string) $_ENV['DB_PWD'];
$dbname = (string) $_ENV['DB_NAME'];



$serverName = $name;
$connectionInfo = array(
    "UID" => $user,
    "PWD" => $pass,
    "Database" => $dbname,
    "LoginTimeout" => 30,
    "Encrypt" => 1,
    "TrustServerCertificate" => 0
);

// Try connecting
$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    echo "❌ Connection failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT TOP 1 * FROM admin";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if ($row) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
} else {
    echo "No data found.";
}