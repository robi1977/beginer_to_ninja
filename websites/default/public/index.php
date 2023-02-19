<?php
function loadTemplate($templateFilename, $variables) 
{
    extract($variables);

    ob_start();
        include __DIR__.'/../templates/'.$templateFilename;
    return ob_get_clean();
}
try {
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../classes/DatabaseTable.php';
    include __DIR__.'/../controllers/JokeController.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');

    $jokeController = new JokeController($jokesTable, $authorsTable);

    $action = $_GET['action'] ?? 'home'; //zamiast else if skrócenie 

    if ($action ==strtolower($action)) {
        $jokeController->$action();
    } else {
        http_response_code(301);
        header('location: index.php?action='.strtolower($action));
        exit();
    }
    $page = $jokeController->$action();

    $title = $page['title'];
    
    $variables = $page['variables'] ?? [];

    $output = loadTemplate($page['template'], $variables);

} catch (PDOException $e) {
    $title = 'Wystąpił błąd';

    $output = 'Błąd bazy danych'.$e->getMessage().' w pliku: '.$e->getFile().' w linii: '.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';

