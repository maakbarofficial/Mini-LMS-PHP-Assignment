<?php
$host = 'localhost';
$dbname = 'lms';
$user = 'root'; // Update with your database username
$pass = 'root';     // Update with your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
