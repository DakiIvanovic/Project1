<?php

spl_autoload_register('classAutoLoad');

function classAutoLoad($className) {

    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if(strpos($url, 'includes')) {
        $path = '../classes/';
    }
    else {
        $path = 'classes/';
    }

    $extension = '.class.php';

    require_once $path . $className . $extension;
}