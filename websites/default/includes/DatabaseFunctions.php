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

function insertJoke($pdo, $values)
{
    //tworzenie zapytania do bazy danych
    $query = 'INSERT INTO `joke` (';
    foreach($values as $key => $value) {
        $query .='`'.$key.'`,';
    }
    $query = rtrim($query, ','); //usuniecie ostatniego przecinka pochodzacego z dzialania petli foreach
    $query .= ') VALUES (';
    foreach($values as $key => $value) {
        $query .= ':'.$key.',';
    }
    $query = rtrim($query, ','); //j.w.
    $query .=')'; 
    //powyższe zapytanie ma trochę inną konstrukcję niż zapytanie w updateJoke
    //sprawdzenie czy ktorys z wpisow jest typu DataTime i przeformatowanie go
    $values = datesFormats($values);
    
    $stsm = $pdo->prepare($query);
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

    $values = datesFormats($values);

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

function datesFormats($values)
{
    foreach($values as $key => $value) {
        if($value instanceof DataTime) {
            $values[$key] = $value->format('Y-m-d H:i:s');
        }
    }

    return $values;
}