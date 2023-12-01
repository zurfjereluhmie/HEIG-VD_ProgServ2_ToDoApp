<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

$catId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$catId) {
    new Flash("categories", TEXT['error-category-not-found'], "warning");
    header("Location: categories.php");
}

$categoryManager = CategoryManager::getInstance();
$category = $categoryManager->getCategory($catId);

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
loadHead(TEXT['category-title'], ["main.css", "navBar.css", "viewByDate.css", "task.css", "taskCheckboxColor.php"]);
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
                </div>
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("category") ?>

                <!-- Liste ToDo -->
                <div class="d-flex flex-column justify-content-center align-items-start flex-wrap">
                    <!-- Late task -->
                    <div class="p-3 todoElt lateTaskContainer">
                        <div class="d-flex">
                            <h3 class="toDoTitle mr-auto p-2"><?= TEXT['task-late'] ?> :</h3>
                        </div>
                        <div class="taskContainer">
                            <?php if (count($category->getLateTasks()) === 0) : ?>
                                <p class="text-center"><?= TEXT['no-task'] ?></p>
                            <?php else : ?>
                                <?php foreach ($category->getLateTasks() as $task) : ?>
                                    <?= task($task->getId(), $task->getTitle(), $task->getDueDate(), $task->isFav(), $task->isDone(), $category->getColor()) ?>
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
                            <?php if (count($category->getDoneTasks()) === 0) : ?>
                                <p class="text-center"><?= TEXT['no-task'] ?></p>
                            <?php else : ?>
                                <?php foreach ($category->getDoneTasks() as $task) : ?>
                                    <?= task($task->getId(), $task->getTitle(), $task->getDueDate(), $task->isFav(), $task->isDone(), $category->getColor()) ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- Done task end -->

                    <?php
                    $prevDate = null;
                    ?>
                    <?php for ($i = 0; $i < count($category->getActualTasks()); $i++) : ?>
                        <?php
                        $task = $category->getActualTasks()[$i];
                        $nextTask = $category->getActualTasks()[$i + 1] ?? null;

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