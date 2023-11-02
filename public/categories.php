<?php

require_once '../app/autoload.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

session_start();

if (!isset($_SESSION["user"])) {
    new Flash("global", "You must be logged in to access this page", "danger");
    header("Location: login.php");
    exit();
}

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();
?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead("Categories", ["dashboard", "task", "list", "taskCheckboxColor"]);
?>

<body>
    <?php include_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once './components/sidebar.php'; ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="listsTitle">My ToDo Categories</h1>
                </div>

                <!-- Liste ToDo -->
                <div class="d-flex flex-row justify-content-center align-items-start flex-wrap myListsDisplay">
                    <?php foreach ($categories as $category) : ?>
                        <div class="p-3 myListsItem" data-id="<?= $category->getId() ?>">
                            <div class="d-flex">
                                <div class="colorTag" style="background: <?= $category->getColor() ?>;"></div>
                                <h3 class="myListsTitle"><?= $category->getTitle() ?></h3>
                            </div>
                            <p class="myListsDate">Created on 19.08.2020 // WARN NOT FROM DB</p>
                            <p class="myListsDescritpion"><?= $category->getDescription() ?></p>
                        </div>
                    <?php endforeach; ?>

                    <div class="p-3 addListsItem" id="addListTrigger">
                        <img src="assets/icons/bigAdd.svg" alt="Add a list icon" class="addListsImg">
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once './components/script.php';
    loadScript(["categories"]);
    ?>
</body>

</html>