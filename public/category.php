<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

if (!isset($_GET['id'])) {
    new Flash("categories", TEXT['error-category-not-found'], "warning");
    header("Location: categories.php");
}

if (!is_numeric($_GET['id'])) {
    new Flash("categories", TEXT['error-category-not-found'], "warning");
    header("Location: categories.php");
}

$categoryManager = CategoryManager::getInstance();
$category = $categoryManager->getCategory($_GET['id']);

if (!$category) {
    new Flash("categories", TEXT['error-category-not-found'], "warning");
    header("Location: categories.php");
}

require_once 'components/task-container-long.php';
require_once 'components/task-long.php';

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['category-title'], ["main", "navBar", "viewByDate", "task", "taskCheckboxColor"]);
?>

<body>
    <?php include_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once './components/sidebar.php'; ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2"><i class="fas fa-pen fa-sm modifyPenList"></i><?= $category->getTitle() ?> :</h1>
                    <div class="filtre">
                        <input type="checkbox" name="showLateTask" data-checkbox="lateTask">
                        <label for="showLateTask"><?= TEXT['filter-show-late-tasks'] ?></label>

                        <input type="checkbox" name="showDoneTask" data-checkbox="doneTask">
                        <label for="showDoneTask"><?= TEXT['filter-show-done-tasks'] ?></label>
                    </div>
                    <?= Flash::displayFlashMessage("global") ?>
                    <?= Flash::displayFlashMessage("category") ?>
                </div>

                <!-- Liste ToDo -->
                <div class="d-flex flex-column justify-content-center align-items-start flex-wrap">
                    <!-- Late task -->
                    <div class="p-3 todoElt lateTaskContainer">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['task-late'] ?> :</h3>
                        </div>
                        <div class="taskContainer">
                            <?php if (count($category->getTasks()) === 0) : ?>
                                <p class="text-center"><?= TEXT['no-task'] ?></p>
                            <?php else : ?>
                                <?php foreach ($category->getTasks() as $task) : ?>
                                    <?= ($task->getDueDate() < new DateTime() && !$task->isDone()) ? task($task->getId(), $task->getTitle(), $task->getDueDate(), $task->isFav(), $task->isDone(), $category->getColor()) : "" ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- Late task end -->

                    <!-- Done task -->
                    <div class="p-3 todoElt doneTaskContainer">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['task-done'] ?> :</h3>
                        </div>
                        <div class="taskContainer">
                            <?php if (count($category->getTasks()) === 0) : ?>
                                <p class="text-center"><?= TEXT['no-task'] ?></p>
                            <?php else : ?>
                                <?php foreach ($category->getTasks() as $task) : ?>
                                    <?= ($task->isDone()) ? task($task->getId(), $task->getTitle(), $task->getDueDate(), $task->isFav(), $task->isDone(), $category->getColor()) : "" ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- Done task end -->

                    <?php
                    $prevDate = null;
                    ?>
                    <?php for ($i = 0; $i < count($category->getTasks()); $i++) : ?>
                        <?php
                        $task = $category->getTasks()[$i];
                        $nextTask = $category->getTasks()[$i + 1] ?? null;

                        // If task is done -> we don't want to display done task
                        if ($task->isDone()) continue;

                        // If task is late -> we don't want to display late task
                        if ($task->getDueDate() < new DateTime()) continue;

                        // Open container if needed
                        if ($prevDate === null || $prevDate !== $task->getDueDate()->format("d.m.Y")) echo openContainer($task->getDueDate());

                        // Display task
                        echo task(
                            $task->getId(),
                            $task->getTitle(),
                            $task->getDueDate(),
                            $task->isFav(),
                            $task->isDone(),
                            $category->getColor()
                        );

                        // Close container if needed
                        if ($nextTask === null || $nextTask->getDueDate()->format("d.m.Y") !== $task->getDueDate()->format("d.m.Y")) echo closeContainer();

                        $prevDate = $task->getDueDate()->format("d.m.Y");

                        ?>
                    <?php endfor; ?>
                </div>
            </main>
        </div>
    </div>

    <?php
    include_once './components/script.php';
    loadScript(["searchBar"], ["locale", "category"]);
    ?>
</body>

</html>