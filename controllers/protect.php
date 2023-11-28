<?php

require_once "./locale/locale-conf.php";

use ch\comem\todoapp\flash\Flash;

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    new Flash("global", TEXT['must-be-logged-in'], "danger");
    $_SESSION["redirect"] = $_SERVER["REQUEST_URI"];
    header("Location: login.php");
    exit();
}

if (!$_SESSION['user']['isValid']) {
    new Flash("global", TEXT['must-validate-account'], "danger");
    header("Location: validate-account.php");
    exit();
}
