<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

if (isset($_POST['submit-create-task'])) {
    require_once "../controllers/task-create.php";
}

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategories();


?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
loadHead(TEXT['task-title'], ["main.css", "navBar.css"]);
?>

<body>
    <?php require_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once './components/sidebar.php'; ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("task-create") ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="taskCreateTitle"><?= TEXT['task-create-title'] ?></h1>
                </div>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="form-group">
                        <label><?= TEXT['task-title-placeholder']; ?>*</label>
                        <input type="text" class="form-control" name="task-title" placeholder="<?= TEXT['task-title-placeholder']; ?>" value="" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><?= TEXT['task-due-date-placeholder']; ?>*</label>
                            <input type="datetime-local" class="form-control" name="task-due-date" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?= TEXT['task-category-select-placeholder']; ?>*</label>
                            <select class="form-control form-select" name="task-category-select">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category->getId() ?>"><?= $category->getTitle() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= TEXT['task-description-placeholder']; ?></label>
                        <textarea class="form-control" rows="3" name="task-description" placeholder="<?= TEXT['task-description-placeholder']; ?>"></textarea>
                    </div>

                    <button type="submit" name="submit-create-task" class="btn btn-primary"><?= TEXT['create-task']; ?></button>
                </form>
            </main>
        </div>
    </div>

    <?php
    require_once './components/script.php';
    loadScript(["searchBar"], ["locale"]);
    ?>
</body>

</html>