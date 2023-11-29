<?php
session_start();

require_once '../app/autoload.php';

require_once "locale/locale-conf.php";

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

define("FLASH_NAME", pathinfo(basename($_SERVER["PHP_SELF"]), PATHINFO_FILENAME));


$token = htmlspecialchars($_GET['token'] ?? '');

$formToDisplay = ($token) ? 'PW' : 'email';

if (isset($_POST['submit-PW'])) {

    $tokenTroughPOST = htmlspecialchars($_POST['token'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $password2 = htmlspecialchars($_POST['password2'] ?? '');

    if (!$tokenTroughPOST) {
        new Flash(constant("FLASH_NAME"), TEXT['no-token'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $token);
        exit();
    }

    if (!$password || !$password2) {
        new Flash(constant("FLASH_NAME"), TEXT['must-fill-both-password'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        exit();
    }

    if ($password !== $password2) {
        new Flash(constant("FLASH_NAME"), TEXT['must-fill-both-password'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        exit();
    }

    $dbManagerUser = DbManagerCRUD_User::getInstance();

    $user = $dbManagerUser->readUsingPWToken($tokenTroughPOST);

    if (!$user) {
        new Flash(constant("FLASH_NAME"), TEXT['invalid-token'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    unset($password);
    unset($password2);

    $user->setPassword($hashedPassword);

    $newUser = $dbManagerUser->update($user->getId(), $user);

    if (!$newUser) {
        new Flash(constant("FLASH_NAME"), TEXT['error-while-updating-password'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        exit();
    }

    new Flash("global", TEXT['password-updated'], 'success');
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit-email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!$email) {
        new Flash(constant("FLASH_NAME"), TEXT['must-fill-all-fields'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $dbManagerUser = DbManagerCRUD_User::getInstance();
    $user = $dbManagerUser->readUsingEmail($email);

    if (!$user) {
        new Flash(constant("FLASH_NAME"), TEXT['email-not-registered'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $res = $user->resetPassword();

    if (!$res) {
        new Flash(constant("FLASH_NAME"), TEXT['error-while-reseting-password'], 'danger');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    new Flash("global", TEXT['email-sent'], 'success');
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead(TEXT['reset-password-title'], ["password-reset.css"]);
?>

<body class="d-flex justify-content-center align-items-center">

    <form class="form-PW-reset" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off">
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center PW-reset-card">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">

            <?php
            if ($formToDisplay === 'PW') :
            ?>

                <label for="password" class="sr-only"><?= TEXT['new-password-placeholder']; ?></label>
                <input type="password" name="password" class="formInput" id="password" placeholder="<?= TEXT['new-password-placeholder']; ?>" autofocus required autocomplete="new-password">

                <label for="password2" class="sr-only"><?= TEXT['confirm-password-placeholder']; ?></label>
                <input type="password" name="password2" class="formInput" id="password2" placeholder="<?= TEXT['confirm-password-placeholder']; ?>" required autocomplete="new-password">

                <input type="hidden" name="token" value="<?= $token ?>">

                <button class="btn-lgb btn-block" type="submit" name="submit-PW"><?= TEXT['reset-password-btn']; ?></button>
            <?php
            else :
            ?>
                <p><?= TEXT['email-hint']; ?></p>
                <label for="inputEmail" class="sr-only"><?= TEXT['email-placeholder']; ?></label>
                <input type="email" id="inputEmail" class="formInput" placeholder="<?= TEXT['email-placeholder']; ?>" required autofocus name="email" autocomplete="new-password">
                <button class="btn-lgb btn-block" type="submit" name="submit-email"><?= TEXT['reset-password-btn']; ?></button>
            <?php
            endif;
            ?>
        </div>
    </form>

    <?php
    include_once './components/script.php';
    loadScript();
    ?>
</body>

</html>