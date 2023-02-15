<?php

try {
    
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../includes/DatabaseFunctions.php';

    $results = findAll($pdo, 'joke'); //wczytanie wszystkich dowcipow
    $jokes = [];
    foreach($results as $joke) {
        $author = find($pdo, 'author', 'id', $joke['authorid'])[0];

        $jokes[] = [
            'id' => $joke['id'],
            'joketext' => $joke['joketext'],
            'jokedate' => $joke['jokedate'],
            'name' => $author['name'],
            'email' => $author['email']
        ];
    }
    
    $title = 'Lista dowcipów';
    $totalJokes = total($pdo, 'joke');

    ob_start(); //otwarcie bufora
    include __DIR__.'/../templates/jokes.html.php'; //wczytanie konstrukcji html z pliku tworzącego listę dowcipów
    $output = ob_get_clean(); //przeniesienie bufora do zmiennej i wyczyszczenie go

} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';