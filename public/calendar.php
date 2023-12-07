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

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['calendar-title'], ["main.css", "navBar.css", "viewByDate.css", "task.css", "taskCheckboxColor.php"]);
?>

<body>
    <?php require_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once './components/sidebar.php'; ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="calendarTitle"><?= TEXT['calendar-title'] ?></h1>
                </div>
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("calendar") ?>

                <!-- Liste ToDo -->
                <div class="d-flex flex-column justify-content-center align-items-start flex-wrap">
                    <?php
                    $prevDate = null;
                    ?>
                    <?php for ($i = 0; $i < count($tasks); $i++) : ?>
                        <?php
                        $task = $tasks[$i];
                        $nextTask = $tasks[$i + 1] ?? null;

                        $isToday = $task->getDueDate()->format('d.m.Y') === date('d.m.Y');
                        $isTomorrow = $task->getDueDate()->format('d.m.Y') === date('d.m.Y', strtotime('+1 day'));
                        $specialId = $isToday ? "today" : ($isTomorrow ? "tomorrow" : "");

                        // Open container if needed
                        if ($prevDate === null || $prevDate !== $task->getDueDate()->format("d.m.Y")) echo openContainer($task->getDueDate(), "", $specialId);

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

                        ?>
                    <?php endfor; ?>
                </div>
            </main>
        </div>
    </div>

    <?php
    require_once './components/script.php';
    loadScript(["searchBar"], ["locale", "calendar"]);
    ?>
</body>

</html>