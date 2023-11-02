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
<html lang="fr" data-lt-installed="true">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ToDoApp - Categories</title>

    <!-- CSS Lib -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS Custom -->
    <link href="styles/main.css" rel="stylesheet">
    <link href="styles/navBar.css" rel="stylesheet">
    <link href="styles/dashboard.css" rel="stylesheet">
    <link href="styles/task.css" rel="stylesheet">
    <link href="styles/list.css" rel="stylesheet">
    <link href="styles/taskCheckboxColor.css" rel="stylesheet">
    <!-- <link href="css/modal.css" rel="stylesheet"> -->

    <!-- icon -->
    <link rel="icon" href="assets/icons/logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous">


</head>

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


    <!-- Lib -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom common-->
    <!-- <script src="js/navScript.js"></script>
    <script src="js/profilePicture.js"></script>
    <script src="js/searchBar.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/taskScript.js"></script> -->

    <!-- Custom specific-->
    <script src="./scripts/categories.js"></script>
</body>

</html>