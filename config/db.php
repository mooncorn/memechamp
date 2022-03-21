<?php

//$db = mysqli_connect(constant('DB_HOST'), constant("DB_USER"), constant('DB_PASS'), constant('DB_NAME'));
//
//if (!$db) {
//    die("Connection failed: " . mysqli_connect_error());
//}

$host = 'localhost';
$db   = 'memechampdb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
