<?php
try {
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../classes/DatabaseTable.php';
    include __DIR__.'/../controllers/JokeController.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $jokeController = new JokeController($jokesTable, $authorsTable);

    $action = $_GET['action'] ?? 'home'; //zamiast else if skrócenie 
    $page = $jokeController->$action();

    $title = $page['title'];
    $output = $page['output'];
} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';

