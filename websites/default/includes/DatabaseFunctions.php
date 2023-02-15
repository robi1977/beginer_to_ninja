<?php

function totalJokes($pdo)
{
    $stsm = $pdo->prepare('SELECT COUNT(*) FROM `joke`');
    $stsm->execute();

    $row = $stsm->fetch();

    return $row[0];
}

function getJoke($pdo, $id) {
    $stsm = $pdo->prepare('SELECT * FROM `joke` WHERE `id` = :id');

    $values = [
        'id' => $id
    ];

    $stsm->execute($values);
    return $stsm->fetch();
}

function insertJoke($pdo, $joketext, $authorId)
{
    $stsm = $pdo->prepare('INSERT INTO `joke` (`joketext`,`jokedate`,`authorId`) 
        VALUES (:joketext, :jokedate, :authorId)');
    
    $values = [
        ':joketext'=> $joketext,
        ':authorId' => $authorId,
        ':jokedate' => date('Y-m-d'),
    ];

    $stsm->execute($values);
}

function updateJoke($pdo, $values)
{
    //tworzenie treści zapytania
    $query = 'UPDATE `joke` SET ';
    $updateFields = [];
    foreach($values as $key => $value) {
        $updateFields[] = '`'.$key.'` = :'.$key;
    }

    $query .= implode(', ', $updateFields);
    $query .= ' WHERE `id` = :primaryKey';
    //dopisanie primaryKey do tablicy. Zastosowano zmienną primaryKey ponieważ w zapytaniu nie może być użyte 2 raz odwołanie do zmiennej id
    $values['primaryKey'] = $values['id'];

    $stsm = $pdo->prepare($query);
    $stsm->execute($values);
}

function deleteJoke($pdo, $id)    
{
    $stsm = $pdo->prepare('DELETE FROM `joke` WHERE `id` = :id');
    $values = [
        'id' => $id
    ];

    $stsm->execute($values);
}

function allJokes($pdo)
{
    $stsm = $pdo->prepare('SELECT `joke`.`id`, `joketext`, `name`, `email` FROM `joke` 
        INNER JOIN `author` ON `authorid` = `author`.`id`');
    $stsm->execute();

    return $stsm->fetchAll();
}