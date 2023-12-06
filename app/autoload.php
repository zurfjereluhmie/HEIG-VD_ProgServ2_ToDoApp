<?php

/**
 * Auto loader for the app.
 * 
 * @package app
 */
spl_autoload_register(function ($class) {
    $class = str_replace("\\", "/", $class);
    $path = __DIR__ . "/../app/" . $class . ".php";
    if (file_exists($path)) {
        require_once($path);
    }
});
