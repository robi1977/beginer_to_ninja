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
        'id' => $is
    ];

    $stsm->execute($values);
    return $stsm->fetch();
}