<?php

use ch\comem\todoapp\category\CategoryBuilder;
use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\task\Task;
use ch\comem\todoapp\category\CategoryManager;
use ch\comem\todoapp\auth\User;
use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;

session_start();
require_once("../app/autoload.php");

$database = DbManagerCRUD_User::getInstance();

$user = $database->readUsingEmail("test1@gmail.com");

//$user->resetPassword();

echo "<pre>";
print_r($user);
echo "</pre>";



echo "<br>";
echo "<br>";
echo "<a href='logout.php'>Logout</a>";
echo "<br>";
echo "<br>";
echo "<br>";

Flash::displayAllFlashMessages();


echo "<br>";
echo "<br>";
echo "<br>";
echo "<pre>";
print_r($_SESSION);

echo "<br>";
echo "<br>";

try {

    $categoryBuilder = new CategoryBuilder("test", "#000000");
    $category = $categoryBuilder
        ->build();

    $categoryManager = CategoryManager::getInstance();

    print_r($categoryManager->getCategories());
    print_r($category);

    echo "<br>";
    echo "<br>";
    $categoryManager->addCategory($category);

    echo "<br>";
    echo "<br>";
    echo "62";
    print_r($category);

    $category->setTitle("test2");

    $categoryManager->updateCategory($category);

    echo "<br>";
    echo "<br>";
    print_r($categoryManager->getCategories());
} catch (Throwable $th) {
    echo "Erreur : " . $th->getMessage();
    echo "<br>";
    echo "On file : " . $th->getFile() . " à la ligne " . $th->getLine();
}
