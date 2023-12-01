<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\task\TaskManager;

if (isset($_POST['submit-update-task'])) {
    require_once "../controllers/task-update.php";
} elseif (isset($_POST['submit-delete-task'])) {
    require_once "../controllers/task-delete.php";
} else {
    $taskId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!$taskId) {
        new Flash("task-update", TEXT['error-task-not-found'], "danger");
        header("Location: /categories.php");
        exit();
    }

    $taskManager = TaskManager::getInstance();
    $task = $taskManager->getTask($taskId);

    if (!$task) {
        new Flash("task-update", TEXT['error-task-not-found'], "danger");
        header("Location: /categories.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
loadHead(TEXT['task-title'], ["main.css", "navBar.css"]);
?>

<body>
    <?php include_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once './components/sidebar.php'; ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="taskUpdateTitle"><?= TEXT['task-update-title'] ?></h1>
                </div>
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("task-update") ?>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <label><?= TEXT['task-title-placeholder']; ?>*</label>
                            <input type="text" class="form-control" name="task-title" placeholder="<?= TEXT['task-title-placeholder']; ?>" value="<?= $task->getTitle() ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><?= TEXT['task-due-date-placeholder']; ?>*</label>
                            <input type="datetime-local" class="form-control" name="task-due-date" value="<?= $task->getDueDate()->format("Y-m-d\TH:i") ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?= TEXT['task-category-select-placeholder']; ?>*</label>
                            <select class="form-control form-select" name="task-category-id">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category->getId() ?>" <?= $category->getId() == $task->getCategoryId() ? "selected" : "" ?>><?= $category->getTitle() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?= TEXT['task-description-placeholder']; ?></label>
                        <textarea class="form-control" rows="3" name="task-description" placeholder="<?= TEXT['task-description-placeholder']; ?>"><?= $task->getDescription() ?></textarea>
                    </div>

                    <input type="hidden" name="taskId" value="<?= $taskId ?>">
                    <button type="submit" name="submit-update-task" class="btn btn-primary"><?= TEXT['update-task']; ?></button>
                </form>

                <hr class="mt-2">
                <h3><?= TEXT['danger-zone']; ?></h3>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <input type="hidden" name="taskId" value="<?= $taskId ?>">
                    <button type="submit" name="submit-delete-task" class="btn btn-danger"><?= TEXT['delete-task']; ?></button>
                </form>
            </main>
        </div>
    </div>

    <?php
    include_once './components/script.php';
    loadScript(["searchBar"], ["locale"]);
    ?>
</body>

</html>