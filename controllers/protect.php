<?php

use ch\comem\todoapp\flash\Flash;

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    new Flash("global", "You must be logged in to access this page", "danger");
    $_SESSION["redirect"] = $_SERVER["REQUEST_URI"];
    header("Location: login.php");
    exit();
}