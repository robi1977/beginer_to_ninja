<?php

function totalJokes($pdo)
{
    $stsm = $pdo->prepare('SELECT COUNT(*) FROM `joke`');
    $stsm->execute();

    $row = $stsm->fetch();

    return $row[0];
}