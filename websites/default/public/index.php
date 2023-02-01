<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');
    $output = "Udane połaczenie z bazą danych.";
} catch (PDOException $e) {
    $output = "Nie udało się połączyć z bazą danych. <br/>";
    $output .= $e;
}

include __DIR__.'/../templates/output.html.php';