<?php

class DatabaseTable 
{
public $pdo;
public $table;
public $primaryKey;

private function datesFormats($values)
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
public function findAll()
{
    $stsm = $this->pdo->prepare('SELECT * FROM `'.$this->table.'`');
    $stsm->execute();
    return $stsm->fetchAll();
}
public function delete( $field, $value)
{
    $values = [':value' => $value];
    $stsm = $this->pdo->prepare('DELETE FROM `'.$this->table.'` WHERE `'.$field.'`= :value');
    $stsm->execute($values);
}
private function insert($values)
{
    $query = 'INSERT INTO `'.$this->table.'` (';
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
 
    $values = $this->datesFormats($values);

    
    $stsm = $this->pdo->prepare($query);
    $stsm->execute($values);

}
private function update($values)
{
    $query = 'UPDATE `'.$this->table.'` SET ';
    foreach ($values as $key => $value) {
        $query .= '`'.$key.'` = :'.$key.',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `'.$this->primaryKey.'` = :primaryKey';
    $values['primaryKey'] = $values['id'];
    $values = $this->datesFormats($values);

    $stsm = $this->pdo->prepare($query);
    $stsm->execute($values);
}
public function findById($pdo, $table, $primaryKey, $value)
{
    $stsm = 'SELECT * FROM `'.$this->table.'` WHERE `'.$this->primaryKey.'` = :value';
    $values = [
        'value' => $value
    ];
    $stsm = $this->pdo->preprare($query);
    $stsm->execute($values);
    return $stsm->fetch(); //UWAGA: zwraca pojedyńczy wpis
}
public function find($field, $value)
{
    $query = 'SELECT * FROM `'.$this->table.'` WHERE `'.$field.'` = :value';
    $values = [
        'value' => $value
    ];
    $stsm = $this->pdo->prepare($query);
    $stsm->execute($values);

    return $stsm->fetchAll(); //UWAGA: zwraca tablicę
}
public function total()
{
    $stsm = $this->pdo->prepare('SELECT COUNT(*) FROM `'.$this->table.'`');
    $stsm->execute();
    $row = $stsm->fetch();

    return $row[0]; //zwrot wartości jako skalara
}
function save($record)
{
    try {
        if (empty($record[$this->primaryKey])) {
            unset($record[$this->primaryKey]); //usunięcie wpisu $primaryKey jezeli jest pusty, żeby nie było próby wpisania duplikujących się wpisów
        }
        $this->insert($record);
    } catch (PDOException $e) {
        $this->update($record);
    }
}
}