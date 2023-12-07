<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

if (isset($_POST['submit-update-category'])) {
    require_once "../controllers/category-update.php";
} elseif (isset($_POST['submit-delete-category'])) {
    require_once "../controllers/category-delete.php";
} else {
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
}


?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
loadHead(TEXT['category-title'], ["main.css", "navBar.css"]);
?>

<body>
    <?php require_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once './components/sidebar.php'; ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="categoryUpdateTitle"><?= TEXT['category-update-title'] ?></h1>
                </div>
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("category-update") ?>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <label><?= TEXT['category-title-placeholder']; ?>*</label>
                            <input type="text" class="form-control" name="cat-title" placeholder="<?= TEXT['category-title-placeholder']; ?>" value="<?= $category->getTitle() ?>" required>
                        </div>
                        <div class="form-group col-md-1">
                            <label><?= TEXT['category-color-placeholder']; ?>*</label>
                            <input type="color" class="form-control form-control-color" name="cat-color" placeholder="<?= TEXT['category-color-placeholder']; ?>" value="<?= $category->getColor() ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= TEXT['category-description-placeholder']; ?></label>
                        <textarea class="form-control" rows="3" name="cat-description" placeholder="<?= TEXT['category-description-placeholder']; ?>"><?= $category->getDescription() ?></textarea>
                    </div>

                    <input type="hidden" name="catId" value="<?= $catId ?>">
                    <button type="submit" name="submit-update-category" class="btn btn-primary"><?= TEXT['update-category']; ?></button>
                </form>

                <hr class="mt-2">
                <h3><?= TEXT['danger-zone']; ?></h3>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <input type="hidden" name="catId" value="<?= $catId ?>">
                    <button type="submit" name="submit-delete-category" class="btn btn-danger"><?= TEXT['delete-category']; ?></button>
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