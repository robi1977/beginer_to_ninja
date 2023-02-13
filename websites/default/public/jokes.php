<?php

try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');

    $sql = 'SELECT `id`, `joketext` FROM `joke`';
    $results = $pdo->query($sql);
    
    while ($row = $results->fetch()) {
        $jokes[] = ['id' => $row['id'], 'joketext' => $row['joketext']]; 
    }
    
    $title = 'Lista dowcipów';

    ob_start(); //otwarcie bufora
    include __DIR__.'/../templates/jokes.html.php'; //wczytanie konstrukcji html z pliku tworzącego listę dowcipów
    $output = ob_get_clean(); //przeniesienie bufora do zmiennej i wyczyszczenie go

} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';