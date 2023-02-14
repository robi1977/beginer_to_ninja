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

function updateJoke($pdo, $jokeId, $joketext, $authorId)
{
    $stsm = $pdo->prepare('UPDATE `joke` SET 
        `authorId` = :authorId,
        `joketext` = :joketext 
        WHERE `id` = :id');
    
    $values = [
        'id' => $jokeId,
        'joketext' => $joketext,
        'authorId' => $authorId
    ];

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