<?php

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\category\CategoryManager;
use ch\comem\todoapp\flash\Flash;

$userDB = DbManagerCRUD_User::getInstance();

$user = $userDB->read($_SESSION["user"]["id"]);
$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();

if (!$user) {
    new Flash("user-update", TEXT['error-user-not-found'], "danger");
    header("Location: /user-update.php");
    exit();
}

foreach ($categories as $category) {
    $categoryManager->removeCategory($category);
}

if (!$userDB->delete($user->getId())) {
    new Flash("user-update", TEXT['error-while-deleting-user'], "danger");
    header("Location: /user-update.php");
    exit();
}

session_unset();
session_destroy();
session_start();

new Flash("global", TEXT['user-delete'], "success");
header("Location: /login.php");
exit();
