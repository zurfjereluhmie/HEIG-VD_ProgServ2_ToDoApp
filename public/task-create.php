<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\task\TaskManager;

if (isset($_POST['submit-create-task'])) {
    require_once "../controllers/task-create.php";
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
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("task-create") ?>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <label><?= TEXT['task-title-placeholder']; ?>*</label>
                            <input type="text" class="form-control" name="cat-title" placeholder="<?= TEXT['task-title-placeholder']; ?>" value="" required>
                        </div>
                        <div class="form-group col-md-1">
                            <label><?= TEXT['task-color-placeholder']; ?>*</label>
                            <input type="color" class="form-control" name="cat-color" placeholder="<?= TEXT['task-color-placeholder']; ?>" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= TEXT['task-description-placeholder']; ?></label>
                        <textarea class="form-control" rows="3" name="cat-description" placeholder="<?= TEXT['task-description-placeholder']; ?>"></textarea>
                    </div>

                    <button type="submit" name="submit-create-task" class="btn btn-primary"><?= TEXT['create-task']; ?></button>
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