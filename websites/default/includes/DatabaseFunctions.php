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
    $stsm = $pdo->prepare('SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email` FROM `joke` 
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

//CRUD dla tabeli author
function allAuthors($pdo) 
{
    $stsm = $pdo->prepare('SELECT * FROM `author`');
    $stsm->execute();
    return $stsm->fetchAll();
}
function deleteAuthor($pdo, $id)
{
    $values = [':id' => $id];
    $stsm = $pdo->prepare('DELETE FROM `author` WHERE `id` = :id');
    $stsm->execute($values);
}
function insertAuthor($pdo, $values)
{
    $query = 'INSERT INTO `author` (';
    foreach($values as $key => $value){
        $query .= '`'.$key.'`,';
    }
    $query = rtrim($query, ',');
    $query .= ') VALUES (';
    foreach($values as $key => $value){
        $query .=':'.$key.',';
    }
    $query = rtrim($query, ',');
    $query .=')';
    $values = datesFormats($values);
    $stsm = $pdo->prepare($query);
    $stsm->execute($values);
}
function findAll($pdo, $table)
{
    $stsm = $pdo->prepare('SELECT * FROM `'.$table.'`');
    $stsm->execute();
    return $stsm->fetchAll();
}
function delete($pdo, $table, $field, $value)
{
    $values = [':value' => $value];
    $stsm = $pdo->prepare('DELETE FROM `'.$table.'` WHERE `'.$field.'`= :value');
    $stsm->execute($values);
}
function insert($pdo, $table, $values)
{
    $query = 'INSERT INTO `'.$table.'` (';
    foreach($values as $key=>$value) {
        $query .='`'.$key.'`,';
    }
    $query = rtrim($query, ',');
    $query .=') VALUES (';
    foreach($values as $key=>$value) {
        $query .=':'.$key.',';
    }
    $query = rtrim($query, ',');
    $query = rtrim($query, ',');
    $query .=')';
    $values = datesFormats($values);
    $stsm = $pdo->prepare($query);
    $stsm->execute($values);
}
function update($pdo, $table, $primaryKey, $values)
{
    $query = 'UPDATE `'.$table.'` SET ';
    foreach ($values as $key => $value) {
        $query .= '`'.$key.'` = :'.$key.',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `'.$primaryKey.'` = :primaryKey';
    $values['primaryKey'] = $values['id'];
    $values = datesFormats($values);

    $stsm = $pdo->prepare($query);
    $stsm->execute($values);
}
function findById($pdo, $table, $primaryKey, $value)
{
    $stsm = 'SELECT * FROM `'.$table.'` WHERE `'.$primaryKey.'` = :value';
    $values = [
        'value' => $value
    ];
    $stsm = $pdo->preprare($query);
    $stsm->execute($values);
    return $stsm->fetch(); //UWAGA: zwraca pojedyńczy wpis
}
function find($pdo, $table, $field, $value)
{
    $stsm = 'SELECT * FROM `'.$table.'` WHERE `'.$field.'` = :value';
    $values = [
        'value' => $value
    ];
    $stsm = $pdo->prepare($query);
    $stsm->execute($values);

    return $stsm->fetchAll(); //UWAGA: zwraca tablicę
}