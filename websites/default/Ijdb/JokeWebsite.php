<?php
namespace Ijdb;
use \Ninja\DatabaseTable;

class JokeWebsite 
{
    public function getDefaultRoute()
    {
        return 'joke/home';
    }

    public function getController(string $controllerName)
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=ijdb;charset=utf8mb4','ijdbuser', 'tajemnica');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        if($controllerName == 'joke') {
            $controller = new \Ijdb\Controllers\JokeController($jokesTable, $authorsTable);
        } else if ($controllerName == 'author') {
            $controller = new \Ijdb\Controllers\AuthorController($authorsTable);
        }

        return $controller;
    }
}