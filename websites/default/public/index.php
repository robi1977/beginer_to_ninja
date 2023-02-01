<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');
    
    $sql = 'CREATE TABLE joke (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        joketext TEXT,
        jokedate DATE NOT NULL
        ) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB';
    $pdo->exec($sql);

    $output = 'Tabela "joke" została utworzona.'; 
} catch (PDOException $e) {
    $output = "Błąd bazy danych: ";
    $output .= $e->getMessage().' w pliku: '.$e->getFile().' w linii: ';
    $output .= $e->getLine();
}

include __DIR__.'/../templates/output.html.php';