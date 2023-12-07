<?php
session_start();

require_once '../app/autoload.php';
require_once '../controllers/protect.php';
require_once 'locale/locale-conf.php';

use ch\comem\todoapp\flash\Flash;

if (isset($_POST['submit-update-user'])) {
    require_once "../controllers/user-update.php";
} elseif (isset($_POST['submit-delete-user'])) {
    require_once "../controllers/user-delete.php";
}

?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once 'components/head.php';
loadHead(TEXT['user-update-title'], ["main.css", "navBar.css"]);
?>

<body>
    <?php require_once './components/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once './components/sidebar.php'; ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light mainFullHeight">

                <?= Flash::displayFlashMessage("global") ?>
                <?= Flash::displayFlashMessage("user-update") ?>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2" id="taskCreateTitle"><?= TEXT['user-update-title'] ?></h1>
                </div>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><?= TEXT['lastname-placeholder']; ?>*</label>
                            <input type="text" name="last-name" class="form-control" placeholder="<?= TEXT['lastname-placeholder']; ?>" value="<?= $_SESSION['user']['lastName'] ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?= TEXT['firstname-placeholder']; ?>*</label>
                            <input type="text" name="first-name" class="form-control" placeholder="<?= TEXT['firstname-placeholder']; ?>" value="<?= $_SESSION['user']['firstName'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="<?= TEXT['email-placeholder']; ?>" value="<?= $_SESSION['user']['email'] ?>" required disabled>
                    </div>
                    <button type="submit" name="submit-update-user" class="btn btn-primary"><?= TEXT['user-update-btn']; ?></button>
                </form>

                <hr class="mt-2">
                <form action="reset-password.php" method="post" id="form-delete-user">
                    <input type="hidden" name="email" value="<?= $_SESSION['user']['email'] ?>">
                    <button type="submit" name="submit-email" class="btn btn-primary"><?= TEXT['user-update-password-btn']; ?></button>
                </form>

                <hr class="mt-2">
                <h3><?= TEXT['danger-zone']; ?></h3>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" id="form-delete-user">
                    <button type="submit" name="submit-delete-user" class="btn btn-danger"><?= TEXT['user-delete-btn']; ?></button>
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