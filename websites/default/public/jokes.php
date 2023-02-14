<?php

try {
    
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../includes/DatabaseFunctions.php';

    
    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email` FROM `joke` INNER JOIN `author` ON `authorid` = `author`.`id`';
    
    $jokes = $pdo->query($sql);

    
    $title = 'Lista dowcipów';
    $totalJokes = totalJokes($pdo);

    
    ob_start(); //otwarcie bufora
    include __DIR__.'/../templates/jokes.html.php'; //wczytanie konstrukcji html z pliku tworzącego listę dowcipów
    $output = ob_get_clean(); //przeniesienie bufora do zmiennej i wyczyszczenie go

} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';