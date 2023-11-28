<?php

$langs = glob("locale/*", GLOB_ONLYDIR);

foreach ($langs as $key => $value) {
    $langs[$key] = basename($value);
}

// get keys form en/locale.php as base file
$baseFile = require_once "en/locale.php";
$keyBase = array_keys($baseFile);

// get keys form other locales and compare them to base file
foreach ($langs as $lang) {
    if ($lang === "en") continue; // skip english (already done)

    // if locale file doesn't exist, remove it from the list
    if (!file_exists("./locale/$lang/locale.php")) {
        unset($langs[array_search($lang, $langs)]);
        continue;
    }

    $file = require "./locale/$lang/locale.php";

    $keyFile = array_keys($file);
    if ($keyBase !== $keyFile) unset($langs[array_search($lang, $langs)]);
}

define("AVAILABLE_LANGS", $langs);

$lang = $_COOKIE["locale"];

if (!in_array($lang, AVAILABLE_LANGS)) $lang = "en";

define("TEXT", require "$lang/locale.php");
