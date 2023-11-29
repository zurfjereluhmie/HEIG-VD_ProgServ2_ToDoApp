<?php

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

require_once "../app/autoload.php";

require_once "locale/locale-conf.php";

define("FLASH_NAME", pathinfo(basename($_SERVER["PHP_SELF"]), PATHINFO_FILENAME));

if (isset($_GET["token"])) {
    $token = htmlspecialchars($_GET["token"]);
    require_once "../app/autoload.php";
    $userManager = DbManagerCRUD_User::getInstance();

    $user = $userManager->readUsingValidationToken($token);

    if (!$user) {
        new Flash("global", TEXT['invalid-token'], "danger");
        exit();
    }

    $user->setIsValid(true);

    $userManager->update($user->getId(), $user);

    new Flash("global", TEXT['account-validated'], "success");

    include_once 'logout.php';

    header("Location: login.php");
    exit();
}

if (isset($_POST["submit"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

    if (!$email) {
        new Flash(constant("FLASH_NAME"), TEXT['must-fill-email'], "danger");
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    $user = DbManagerCRUD_User::getInstance()->readUsingEmail($email);

    if (!$user) {
        new Flash(constant("FLASH_NAME"), TEXT['email-not-registered'], "danger");
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    if ($user->sendValidationEmail()) {
        new Flash(constant("FLASH_NAME"), TEXT['email-sent'], "success");
    } else {
        new Flash(constant("FLASH_NAME"), TEXT['error-while-sending-email'], "danger");
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['validate-account-title'], ["login.css"]);
?>


<body class="d-flex justify-content-center align-items-center">

    <form class="form-signin" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off">

        <?= Flash::displayFlashMessage("global") ?>
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center loginCard">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">
            <p><?= TEXT['check-mail']; ?></p>
            <br>
            <p><?= TEXT['no-mail-hint']; ?></p>
            <input class="formInput" type="email" name="email" id="inputEmail" required value="<?= $_SESSION['user']['email'] ?? '' ?>">
            <button type="submit" class="btn-lgb btn-block" name="submit"><?= TEXT['resend-mail']; ?></button>
            <br>
            <a class="small" href="login.php"><?= TEXT['login-link']; ?></a>
        </div>
    </form>

    <?php
    include_once './components/script.php';
    loadScript();
    ?>
</body>

</html>