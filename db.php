<?php
$host = "sql307.infinityfree.com"; // Change if needed
$user = "if0_36889095"; // Default for XAMPP
$pass = "thuhina"; // Default is empty in XAMPP
$dbname = "if0_36889095_url_short"; // Database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
