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
$tasks = $taskManager->getActualTasks();

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
    <?php require_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once './components/sidebar.php'; ?>

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
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['due-today'] ?></h3>
                            <a class="p-2" href="/calendar.php#today"><?= TEXT['see-all'] ?></a>
                        </div>
                        <div class="taskContainer">

                            <!-- Tasks begin -->
                            <?php if (!empty($tasks)) :

                                $todayTasks = array_values(array_filter($tasks, function ($task) {
                                    return $task->getDueDate()->format('d.m.Y') === date('d.m.Y');
                                }));

                                foreach ($todayTasks as $task) :
                                    $categoryColor = $categoryManager->getCategory($task->getCategoryId())->getColor();

                                    echo task(
                                        $task->getId(),
                                        $task->getTitle(),
                                        $task->getDueDate(),
                                        $task->isFav(),
                                        $task->isDone(),
                                        $categoryColor
                                    );

                                endforeach;
                            endif; ?>
                            <!-- Tasks end -->


                        </div>
                    </div>
                    <!-- ToDO due today end -->

                    <!-- ToDO due tomorrow start -->
                    <div class="p-3 todoElt">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['due-tomorrow'] ?></h3>
                            <a class="p-2" href="/calendar.php#tomorrow"><?= TEXT['see-all'] ?></a>
                        </div>
                        <div class="taskContainer">

                            <!-- Tasks due later begin -->
                            <?php if (!empty($tasks)) :
                                // Filter task because we only need task due Tomorrow (DateTime + 1 day)
                                $dueTomorrowTasks = array_values(array_filter($tasks, function ($task) {
                                    return $task->getDueDate()->format('d.m.Y') === date('d.m.Y', strtotime('+1 day'));
                                }));

                                foreach ($dueTomorrowTasks as $task) :
                                    $categoryColor = $categoryManager->getCategory($task->getCategoryId())->getColor();
                                    echo task(
                                        $task->getId(),
                                        $task->getTitle(),
                                        $task->getDueDate(),
                                        $task->isFav(),
                                        $task->isDone(),
                                        $categoryColor
                                    );
                                endforeach;
                            endif; ?>
                            <!-- Tasks due later end -->

                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php
    require_once './components/script.php';
    loadScript(["categories", "searchBar"], ["locale", "dashboard"]);
    ?>
</body>

</html>