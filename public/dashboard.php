<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once "locale/locale-conf.php";

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;
use ch\comem\todoapp\task\TaskManager;


$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();

$taskManager = TaskManager::getInstance();
$tasks = $taskManager->getTasks();

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['dashboard'], ["main.css", "navBar.css", "dashboard.css", "task.css", "list.css", "taskCheckboxColor.php"]);

require_once 'components/task-container-long.php';
require_once 'components/task-long.php';
?>

<body>
    <?php include_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once './components/sidebar.php'; ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="dashboardTitle"><?= TEXT['dashboard'] ?></h1>
                </div>
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("dashboard") ?>

                <!-- Liste ToDo -->
                <div class="d-flex flex-row justify-content-center align-items-start flex-wrap dasboardMyCategories" id="myCategories">
                    <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>
                            <div class="p-3 myCategoriesItem" data-id="<?= $category->getId() ?>">
                                <div class="d-flex">
                                    <div class="colorTag" style="background: <?= $category->getColor() ?>;"></div>
                                    <h3 class="myCategoriesTitle"><?= $category->getTitle() ?></h3>
                                </div>
                                <p class="myCategoriesDate"><?= TEXT['created-on'] ?> <?= $category->getCreatedAt()->format('d.m.Y') ?></p>
                                <p class="myCategoriesDescritpion"><?= $category->getDescription() ?></p>
                            </div>
                        <?php endforeach; ?>
                        <a href="/categories.php" class="seeAllCategories"><?= TEXT['see-all'] ?> &#62;</a>
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
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['due-today'] ?> :</h3>
                            <a class="p-2" href="/calendar.html#today"><?= TEXT['see-all'] ?></a>
                        </div>
                        <div class="taskContainer">
                            
                        <!-- TODO : DELETE - Old Task Model -->
                            <!-- Task#1 -->
                            <!-- <div class="d-flex flex-row align-items-center task">
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
                            </div> -->
                            <!-- Task#1 end -->
                            
                            <!-- Tasks begin -->
                            <!-- TODO : UPDATE VIEW - Charger les tasks depuis la DB (en cas d'update/delete) -->

                            <?php if (!empty($tasks)) : ?>
                                <?php
                                // Filter task because we only need task due today
                                $dueTodayTasks = array_filter($tasks, function ($task) {
                                    return $task->isDueFor() === 0;
                                });

                                // Filter task because we only need task not done
                                $dueTodayTasks = array_filter($dueTodayTasks, function ($task) {
                                    return !$task->isDone();
                                });

                                // TODO : ORDER in SQL ? (SELECT * FROM tasks ORDER BY dueDate ASC)
                                // TODO : Idem pour les filtres au dessus
                                // Order tasks by due date : hours, minutes, seconds
                                usort($dueTodayTasks, function ($task1, $task2) {
                                    return $task1->getDueDate() <=> $task2->getDueDate();
                                });
                                ?>
                                <!-- TODO : NB DISPLAY - Stop loop ? -->
                                <!-- TODO : DATETIME - Display only "Today" date/today/tomorrow and hh:mm ? -->
                                <?php foreach ($dueTodayTasks as $task) : ?>
                                    <?php 
                                    echo task(
                                        $task->getId(),
                                        $task->getTitle(),
                                        $task->getDueDate(),
                                        $task->isFav(),
                                        $task->isDone(),
                                        $category->getColor()
                                    );
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- Tasks end -->


                        </div>
                    </div>
                    <!-- ToDO due today end -->

                    <!-- ToDO due tomorrow start -->
                    <div class="p-3 todoElt">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['due-tomorrow'] ?> :</h3>
                            <a class="p-2" href="/calendar.html#tomorrow"><?= TEXT['see-all'] ?></a>
                        </div>
                        <div class="taskContainer">

                        <!-- TODO : DELETE - Old Task Model -->
                            <!-- Task#1 -->
                            <!-- <div class="d-flex flex-row align-items-center task">
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
                            </div> -->
                            <!-- Task#1 end -->

                            <!-- Tasks due later begin -->
                            <!-- TODO : UPDATE VIEW - Charger les tasks depuis la DB (en cas d'update/delete) -->

                            <?php if (!empty($tasks)) : ?>
                                <?php
                                // Filter task because we only need task due later
                                $dueTomorrowTasks = array_filter($tasks, function ($task) {
                                    return $task->isDueFor() === 1;
                                });

                                // Filter task because we only need task not done
                                $dueTomorrowTasks = array_filter($dueTomorrowTasks, function ($task) {
                                    return !$task->isDone();
                                });

                                // TODO : ORDER in SQL ? (SELECT * FROM tasks ORDER BY dueDate ASC)
                                // TODO : Idem pour les filtres au dessus
                                // Order tasks by due date
                                usort($dueTomorrowTasks, function ($task1, $task2) {
                                    return $task1->getDueDate() <=> $task2->getDueDate();
                                });
                                ?>
                                <!-- TODO : NB DISPLAY - Stop loop ? -->
                                <!-- TODO : DATETIME - Display only "Today" date/today/tomorrow and hh:mm ? -->
                                <?php foreach ($dueTomorrowTasks as $task) : ?>
                                    <?php 
                                    echo task(
                                        $task->getId(),
                                        $task->getTitle(),
                                        $task->getDueDate(),
                                        $task->isFav(),
                                        $task->isDone(),
                                        $category->getColor()
                                    );
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- Tasks due later end -->

                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
    include_once './components/script.php';
    loadScript(["categories", "searchBar"], ["locale"]);
    ?>
</body>

</html>