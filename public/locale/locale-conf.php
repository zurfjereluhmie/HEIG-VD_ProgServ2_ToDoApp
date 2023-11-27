<?php

$langs = glob("locale/*", GLOB_ONLYDIR);

foreach ($langs as $key => $value) {
    $langs[$key] = basename($value);
}

define("AVAILABLE_LANGS", $langs);

$lang = $_COOKIE["locale"] ?? "en";

if (!in_array($lang, AVAILABLE_LANGS)) throw new Exception("Invalid language option");

define("TEXT", require_once "$lang/locale.php");
