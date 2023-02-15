<?php
try {
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../includes/DatabaseFunctions.php';

    if (isset($_POST['joketext']) && strlen($_POST['joketext'])>0) {
        updateJoke($pdo, [
            'id' => $_POST['jokeid'],
            'joketext' => $_POST['joketext'],
            'authorId' => 1
        ]);

        header('location: jokes.php');
    } else {
        $joke = getJoke($pdo, $_GET['id']);
        $title = 'Edycja dowcipu.';

        ob_start();

        include __DIR__.'/../templates/editjoke.html.php';

        $output = ob_get_clean();
    }
} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';