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
                    <h1 class="h2" id="dashboardTitle">Dashboard</h1>
                </div>

                <!-- Liste ToDo -->
                <div class="d-flex flex-row justify-content-center align-items-start flex-wrap dasboardMyCategories" id="myCategories">
                    <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>
                            <div class="p-3 myCategoriesItem" data-id="<?= $category->getId() ?>">
                                <div class="d-flex">
                                    <div class="colorTag" style="background: <?= $category->getColor() ?>;"></div>
                                    <h3 class="myCategoriesTitle"><?= $category->getTitle() ?></h3>
                                </div>
                                <p class="myCategoriesDate">Created on <?= $category->getCreatedAt()->format('d.m.Y') ?></p>
                                <p class="myCategoriesDescritpion"><?= $category->getDescription() ?></p>
                            </div>
                        <?php endforeach; ?>
                        <a href="/categories.php" class="seeAllCategories">See All &#62;</a>
                    <?php else : ?>
                        <div class="p-3 addCategoriesItem" id="addListTrigger">
                            <img src="assets/icons/bigAdd.svg" alt="Add a category icon" class="addListsImg">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ToDo due to today and Tomorow -->
                <div class="d-flex flex-row justify-content-center align-items-start flex-wrap dasboardTodoDisplay">

                    <!-- ToDo due today -->
                    <div class="p-3 todoElt">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2">Due today :</h3>
                            <a class="p-2" href="/calendar.html#today">See All</a>
                        </div>
                        <div class="taskContainer">

                            <!-- Task#1 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="BlueCheckBox taskIsDone" data-color="#497efe" data-taskId="1">
                                    <span class="checkmark BlueCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Acheter de la raclette</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 10h00</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#1 end -->

                            <!-- Task#2 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="BlueCheckBox taskIsDone" data-color="#497efe" data-taskId="2">
                                    <span class="checkmark BlueCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Acheter de la fondue</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 10h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#2 end -->

                            <!-- Task#3 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="3">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Ex p.134 + p.135</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 13h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#3 end -->

                            <!-- Task#4 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="4">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Rendre MCD</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Today - 16h40</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#4 end -->

                        </div>
                    </div>
                    <!-- ToDO due today end -->

                    <!-- ToDO due tomorrow start -->
                    <div class="p-3 todoElt">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2">Due tomorrow :</h3>
                            <a class="p-2" href="/calendar.html#tomorrow">See All</a>
                        </div>
                        <div class="taskContainer">

                            <!-- Task#1 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="5">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Compta - Ex 38.5</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 08h50</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#1 end -->

                            <!-- Task#2 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="6">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Test chapitre 23 economie</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 11h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#2 end -->

                            <!-- Task#3 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="7">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Ex p.134 + p.135</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 13h00</p>
                                    <a class="taskStar" href="#" data-isFav="true">
                                        <img src="assets/icons/favourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#3 end -->

                            <!-- Task#4 -->
                            <div class="d-flex flex-row align-items-center task">
                                <label class="containerCheckBox taskCheckBox">
                                    <input type="checkbox" class="RedCheckBox taskIsDone" data-color="#dc3545" data-taskId="8">
                                    <span class="checkmark RedCheckBoxSpan"></span>
                                </label>
                                <p class="taskTitle">Rendre Sujet TPI</p>
                                <div class="d-flex flexEnd">
                                    <p class="taskDelai">Tomorrow - 17h30</p>
                                    <a class="taskStar" href="#" data-isFav="false">
                                        <img src="assets/icons/notFavourite.svg" width="29" height="29" alt="star icon">
                                    </a>

                                    <a class="taskTrash" href="#">
                                        <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                                    </a>
                                </div>
                            </div>
                            <!-- Task#4 end -->

                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
    include_once './components/script.php';
    loadScript(["categories"]);
    ?>
</body>

</html>