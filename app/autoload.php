<?php

/**
 * Auto loader for the app.
 */
spl_autoload_register(function ($class) {
    $class = str_replace("\\", "/", $class);
    require_once(__DIR__ . "/../app/" . $class . ".php");
});
