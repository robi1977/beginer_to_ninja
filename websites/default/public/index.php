<?php
include __DIR__.'/../includes/autoloader.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'),'?');

$jokeWebsite = new JokeWebsite();

$entryPoint = new EntryPoint($jokeWebsite);
$entryPoint->run($uri);