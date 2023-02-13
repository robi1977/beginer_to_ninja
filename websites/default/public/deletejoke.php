<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');

    $sql = 'DELETE FROM `joke` WHERE `id` = :id';
    $stsm = $pdo->prepare($sql);

    $stsm->bindValue(':id', $_POST['id']);
    $stsm->execute();

    header('location: jokes.php');
} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';