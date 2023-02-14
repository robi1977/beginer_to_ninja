<?php
include __DIR__.'/../includes/DatabaseConnection.php';
include __DIR__.'/../includes/DatabaseFunctions.php';

$joke1 = getJoke($pdo, 1);

echo $joke1['joketext'];

$joke2 = getJoke($pdo, 2);

echo $joke2['joketext'];
