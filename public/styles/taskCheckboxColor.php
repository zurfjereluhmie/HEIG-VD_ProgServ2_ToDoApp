<?php

require_once '../../app/autoload.php';
require_once "../locale/locale-conf.php";

use ch\comem\todoapp\category\CategoryManager;
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

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();

$categoriesColors = [];

foreach ($categories as $category) {
    $id = strtolower(substr($category->getColor(), 1));
    $categoriesColors[$id] = $category->getColor();
}

function generateCss($categoriesColors)
{
    $css = "";

    foreach ($categoriesColors as $id => $color) {
        $css .= <<<CSS
        
        /*{$id} Style*/

        .{$id}CheckBoxSpan {
            background-color: {$color}3b;
            border-radius: 6px;
            border: 1px solid {$color};
        }

        .containerCheckBox:hover .{$id}CheckBox~.checkmark {
            background-color: {$color}a8;
        }

        .containerCheckBox .{$id}CheckBox:checked~.checkmark {
            background-color: {$color};
        }
        CSS;
    }

    return $css;
}

$css = <<<CSS
.containerCheckBox {
    display: block;
    position: relative;
    cursor: pointer;
    margin-top: 7px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.containerCheckBox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 29px;
    width: 29px;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.containerCheckBox input:checked~.checkmark:after {
    display: block;
}

.containerCheckBox .checkmark:after {
    left: 33%;
    top: 15%;
    width: 10px;
    height: 15px;
    border: solid white;
    border-width: 0 4.5px 4.5px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

CSS;

$css .= "\n\n";
$css .= generateCss($categoriesColors);

header('Content-Type: text/css');
echo $css;
