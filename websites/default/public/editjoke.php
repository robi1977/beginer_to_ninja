<?php
try {
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../classes/DatabaseTable.php';
    
    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');

    if (isset($_POST['joke'])) {
        //utworzenie tablicy $joke z danymi z formularza oraz dodatkowymi danymi
        //$_POST['joke'] zawiera tablice wartości przesłanych z folmularza przez name="joke[id]" oraz name="joke[joketext]" 
        $joke = $_POST['joke'];
        $joke['authorId'] = 1;
        $joke['jokedate'] = new DateTime();

        $jokesTable->save($joke);

        header('location: index.php?action=list');
    } else {
        if (isset($_GET['id'])) {
            $joke = $jokesTable->find('id', $_GET['id'])[0] ?? null;
        } else {
            $joke = null;
        }
        
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