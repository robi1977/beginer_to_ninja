<?php
try {
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../includes/DatabaseFunctions.php';

    if (isset($_POST['joke'])) {
        //utworzenie tablicy $joke z danymi z formularza oraz dodatkowymi danymi
        //$_POST['joke'] zawiera tablice wartości przesłanych z folmularza przez name="joke[id]" oraz name="joke[joketext]" 
        $joke = $_POST['joke'];
        $joke['authorId'] = 1;
        $joke['jokedate'] = new DateTime();

        save($pdo, 'joke', 'id', $joke);

        header('location: jokes.php');
    } else {
        if (isset($_GET['id'])) {
            $joke = find($pdo, 'joke','id', $_GET['id'])[0] ?? null;
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