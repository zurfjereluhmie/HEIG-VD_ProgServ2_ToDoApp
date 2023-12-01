<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

require_once 'components/task-container-long.php';
require_once 'components/task-long.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;
use ch\comem\todoapp\task\TaskManager;

$categoryManager = CategoryManager::getInstance();
$taskManager = TaskManager::getInstance();

$tasks = $taskManager->getActualTasks();
$tasks = array_values(array_filter($tasks, function ($task) {
    return $task->isFav();
}));

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['favourites-title'], ["main.css", "navBar.css", "viewByDate.css", "task.css", "taskCheckboxColor.php"]);
?>

<body>
    <?php include_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once './components/sidebar.php'; ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="calendarTitle"><?= TEXT['favourites-title'] ?></h1>
                </div>
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("favourites") ?>

                <!-- Liste ToDo -->
                <div class="d-flex flex-column justify-content-center align-items-start flex-wrap">
                    <?php

                    if (!count($tasks)) echo "<p class='text-center text-muted'>" . TEXT['no-favourites'] . "</p>";

                    $prevDate = null;

                    for ($i = 0; $i < count($tasks); $i++) :

                        $task = $tasks[$i];
                        $nextTask = $tasks[$i + 1] ?? null;

                        // Open container if needed
                        if ($prevDate === null || $prevDate !== $task->getDueDate()->format("d.m.Y")) echo openContainer($task->getDueDate());

                        $color = $categoryManager->getCategory($task->getCategoryId())->getColor();
                        // Display task
                        echo task(
                            $task->getId(),
                            $task->getTitle(),
                            $task->getDueDate(),
                            $task->isFav(),
                            $task->isDone(),
                            $color
                        );

                        // Close container if needed
                        if ($nextTask === null || $nextTask->getDueDate()->format("d.m.Y") !== $task->getDueDate()->format("d.m.Y")) echo closeContainer();

                        $prevDate = $task->getDueDate()->format("d.m.Y");

                    endfor; ?>
                </div>
            </main>
        </div>
    </div>

    <?php
    include_once './components/script.php';
    loadScript(["searchBar"], ["locale", "favourites"]);
    ?>
</body>

</html>