<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');
    /*
    $sql = 'CREATE TABLE joke (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        joketext TEXT,
        jokedate DATE NOT NULL
        ) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB';
    $pdo->exec($sql);
    $output = 'Tabela "joke" została utworzona.'; 

    Przyklad zapytania aktualizującego:
    $sql = 'UPDATE joke SET jokedate="2021-10-01" WHERE joketext LIKE %programmer%';
    $affectedRows - $pdo->exec($sql);
    $output = 'Zaktualizowano '.$affectedRows.' wpisów.';
    */

    //Przykład zapytania wczytującego dane:
    $sql = 'SELECT * FROM `joke`';
    $results = $pdo->query($sql);
    //przepisanie wyników odczytu z bazy do tablicy jokes[]
    // while ($row = $results->fetch()) {
    //     $jokes[] = $row['joketext'];
    // }
        $jokes=$results;
    
} catch (PDOException $e) {
    $error = "Błąd bazy danych: ";
    $error .= $e->getMessage().' w pliku: '.$e->getFile().' w linii: ';
    $error .= $e->getLine();
}

include __DIR__.'/../templates/output.html.php';