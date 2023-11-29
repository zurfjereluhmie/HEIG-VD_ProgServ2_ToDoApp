<?php
session_start();

require_once "../app/autoload.php";

require_once "locale/locale-conf.php";

use ch\comem\todoapp\flash\Flash;

if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

define("FLASH_NAME", pathinfo(basename($_SERVER["PHP_SELF"]), PATHINFO_FILENAME));

if (isset($_POST["submit"])) require_once "../controllers/validate-login.php";

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['login-title'], ["login.css"]);
?>


<body class="d-flex justify-content-center align-items-center">

    <form class="form-signin" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off">

        <?= Flash::displayFlashMessage("global") ?>
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center loginCard">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">
            <label for="inputEmail" class="sr-only"><?= TEXT["email-placeholder"]; ?></label>
            <input type="email" id="inputEmail" class="formInput" placeholder="<?= TEXT["email-placeholder"]; ?>" required autofocus name="email" autocomplete="new-password">
            <label for="inputPassword" class="sr-only"><?= TEXT['password-placeholder']; ?></label>
            <input type="password" id="inputPassword" class="formInput" placeholder="<?= TEXT['password-placeholder']; ?>" required name="password" autocomplete="new-password">
            <button class="btn-lgb btn-block" type="submit" name="submit"><?= TEXT['login-btn']; ?></button>
            <p><?= TEXT['register-cta']; ?> <a href="register.php"><?= TEXT['register-link']; ?></a></p>

            <p class="small"><a href="reset-password.php"><?= TEXT['forgot-password']; ?></a></p>
        </div>
    </form>

    <?php
    include_once './components/script.php';
    loadScript();
    ?>
</body>

</html>