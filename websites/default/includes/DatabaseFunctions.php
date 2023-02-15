<?php


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


function datesFormats($values)
{
    foreach($values as $key => $value) {
        if(is_object($value)){
            if(get_class($value) == 'DateTime'){
                $values[$key] = $value->format('Y-m-d H:i:s');
            }
        }
    } 

    return $values;
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
    $query = 'SELECT * FROM `'.$table.'` WHERE `'.$field.'` = :value';
    $values = [
        'value' => $value
    ];
    $stsm = $pdo->prepare($query);
    $stsm->execute($values);

    return $stsm->fetchAll(); //UWAGA: zwraca tablicę
}
function total($pdo, $table)
{
    $stsm = $pdo->prepare('SELECT COUNT(*) FROM `'.$table.'`');
    $stsm->execute();
    $row = $stsm->fetch();

    return $row[0]; //zwrot wartości jako skalara
}