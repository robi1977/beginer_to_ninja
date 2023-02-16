<?php

try {
    
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../includes/DatabaseTable.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $results = $jokesTable->findAll(); //wczytanie wszystkich dowcipow z zastosowaniem metody "findAll" klasy "DatabaseTable" ustawionej na tabele 'joke'

    $jokes = [];
    foreach($results as $joke) {
        $author = $authorsTable->find('id', $joke['authorid'])[0];

        $jokes[] = [
            'id' => $joke['id'],
            'joketext' => $joke['joketext'],
            'jokedate' => $joke['jokedate'],
            'name' => $author['name'],
            'email' => $author['email']
        ];
    }
    
    $title = 'Lista dowcipów';
    $totalJokes = $jokesTable->total();

    ob_start(); //otwarcie bufora
    include __DIR__.'/../templates/jokes.html.php'; //wczytanie konstrukcji html z pliku tworzącego listę dowcipów
    $output = ob_get_clean(); //przeniesienie bufora do zmiennej i wyczyszczenie go

} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';