<?php

try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');

    $sql = 'SELECT * FROM `joke`';
    $results = $pdo->query($sql);
    
    while ($row = $results->fetch()) {
        $jokes[] = $row['joketext']; 
    }
    
    $title = 'Lista dowcipów';

    $output = '';

    foreach($jokes as $joke) {
        $output.= '<blockquote>';
        $output.= '<p>';
        $output.= $joke;
        $output.= '</p>';
        $output.= '</blockquote>';
    }
} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';