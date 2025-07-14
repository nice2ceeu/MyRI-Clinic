<?php

// $url = "localhost";
// $user = "root";
// $pass = "";
// $db = "ridb";

// $conn = mysqli_connect($url, $user, $pass, $db);

// if (!$conn) {

//     die("The connection is not established" . mysqli_connect_error());
// }


//require_once __DIR__ . '/../vendor/autoload.php';

// Load .env file
//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
//$dotenv->load();

// Retrieve .env values and cast to string
//$name   = (string) $_ENV['DB_SERVER'];
//$user   = (string) $_ENV['DB_UID'];
//$pass   = (string) $_ENV['DB_PWD'];
//$dbname = (string) $_ENV['DB_NAME'];



//$serverName = $name;
//$connectionInfo = array(
///    "UID" => $user,
//    "PWD" => $pass,
//   "Database" => $dbname,
//    "LoginTimeout" => 30,
//    "Encrypt" => 1,
//    "TrustServerCertificate" => 0
//);

// Try connecting
//$conn = sqlsrv_connect($serverName, $connectionInfo);

//if (!$conn) {
 //   echo "❌ Connection failed.<br>";
//    die(print_r(sqlsrv_errors(), true));
//}



// Load .env file only if it exists (for local development)
if (file_exists(__DIR__ . '/../.env')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// Retrieve environment variables (either from .env or Azure App Settings)
$name   = getenv('DB_SERVER');
$user   = getenv('DB_UID');
$pass   = getenv('DB_PWD');
$dbname = getenv('DB_NAME');

// Optional: fallback to $_ENV if getenv() returns false (can happen in CLI mode)
$name   = $name ?: ($_ENV['DB_SERVER'] ?? null);
$user   = $user ?: ($_ENV['DB_UID'] ?? null);
$pass   = $pass ?: ($_ENV['DB_PWD'] ?? null);
$dbname = $dbname ?: ($_ENV['DB_NAME'] ?? null);

// Check if all values are set
if (!$name || !$user || !$pass || !$dbname) {
    die("❌ Missing one or more required environment variables.");
}

// SQL Server connection setup
$serverName = $name;
$connectionInfo = array(
    "UID" => $user,
    "PWD" => $pass,
    "Database" => $dbname,
    "LoginTimeout" => 30,
    "Encrypt" => 1,
    "TrustServerCertificate" => 0
);

// Attempt connection
$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    echo "❌ Connection failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}


