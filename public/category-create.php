<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

if (isset($_POST['submit-create-category'])) {
    require_once "../controllers/category-create.php";
}


?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
loadHead(TEXT['category-title'], ["main", "navBar"]);
?>

<body>
    <?php include_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include_once './components/sidebar.php'; ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">
                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("category-create") ?>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <label><?= TEXT['category-title-placeholder']; ?>*</label>
                            <input type="text" class="form-control" name="cat-title" placeholder="<?= TEXT['category-title-placeholder']; ?>" value="" required>
                        </div>
                        <div class="form-group col-md-1">
                            <label><?= TEXT['category-color-placeholder']; ?>*</label>
                            <input type="color" class="form-control" name="cat-color" placeholder="<?= TEXT['category-color-placeholder']; ?>" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= TEXT['category-description-placeholder']; ?></label>
                        <textarea class="form-control" rows="3" name="cat-description" placeholder="<?= TEXT['category-description-placeholder']; ?>"></textarea>
                    </div>

                    <button type="submit" name="submit-create-category" class="btn btn-primary"><?= TEXT['create-category']; ?></button>
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