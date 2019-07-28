<?php

// Define DB Params
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "ticketing");

// Define URL
define("ROOT_PATH", "/ticketing/");
define("ROOT_URL", "http://localhost" . ROOT_PATH);
define("APP_TITLE", "App");

// TO DO: try to fix this;
function myAutoload($className) {
    echo $className . '--';
    $pos = strrpos($className, 'App');
    $className = substr($className, $pos);
    $className = ltrim($className, "\\");
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, "\\")) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    echo $fileName . '<br>';
    require $fileName;
};

//spl_autoload_unregister('myAutoload');