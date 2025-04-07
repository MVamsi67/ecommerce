<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

$host = 'xxxxxxxxxxxx'; 
$dbname = 'xxxxxxxxxxxxxx';
$username = 'xxxxxxxxxxxxxxxx';
$password = 'xxxxxxxxxxxxx';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
