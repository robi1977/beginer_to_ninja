<?php
if (isset($_POST['joketext']) && strlen($_POST['joketext'])>0) { 
    try {
        include __DIR__.'/../includes/DatabaseConnection.php';
        //przygotowania zapytania do bazy
        $sql = 'INSERT INTO `joke` SET `joketext` = :joketext, `jokedate` = CURDATE()';
        $stsm = $pdo->prepare($sql);
        //powiązanie zmiennych z zapytania ze zmiennymi z tablicy $_POST
        $stsm->bindValue(':joketext', $_POST['joketext']);
        //wykonanie zapytania
        $stsm->execute();

        //przekierowanie na stronę z listą dowcipów
        header('location: jokes.php');

    } catch (PDOException $e) {
        $title = 'Wystąpił błąd.';
        $output = "Błąd bazy danych ".$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
    }
} else {
    $title = "Dodaj nowy dowcip.";
    ob_start();
    include __DIR__.'/../templates/addjoke.html.php';
    $output = ob_get_clean();
}

include __DIR__.'/../templates/layout.html.php';