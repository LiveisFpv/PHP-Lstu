<?php
    $host = 'mysql';
    $dbname = 'database';
    $user = 'root';
    $pass = 'root';

try{
   $pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8",
    $user,
    $pass
   );
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error while connection". $e->getMessage());
}
?>