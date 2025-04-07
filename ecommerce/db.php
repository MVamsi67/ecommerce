<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

$host = 'sql310.infinityfree.com'; 
$dbname = 'if0_38445318_ecommerce';
$username = 'if0_38445318';
$password = 'N8N42gC3Wv';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
