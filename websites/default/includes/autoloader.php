<?php
function autoloader($className) {
    $fileName = str_replace('\\','/',$className);

    $file = __DIR__.'/../'.$fileName.'.php';
    include $file;
}

spl_autoload_register('autoloader');