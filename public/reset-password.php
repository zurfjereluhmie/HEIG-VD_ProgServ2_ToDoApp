<?php
session_start();

require_once '../app/autoload.php';

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
        new Flash(constant("FLASH_NAME"), 'No token provided', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $token);
        die();
    }

    if (!$password || !$password2) {
        new Flash(constant("FLASH_NAME"), 'Fill all the forms fields', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        die();
    }

    if ($password !== $password2) {
        new Flash(constant("FLASH_NAME"), 'Passwords do not match', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        die();
    }

    $dbManagerUser = DbManagerCRUD_User::getInstance();

    $user = $dbManagerUser->readUsingPWToken($tokenTroughPOST);

    if (!$user) {
        new Flash(constant("FLASH_NAME"), 'Token invalid', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    unset($password);
    unset($password2);

    $user->setPassword($hashedPassword);

    $newUser = $dbManagerUser->update($user->getId(), $user);

    if (!$newUser) {
        new Flash(constant("FLASH_NAME"), 'Error while updating the password', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        die();
    }

    new Flash("global", 'Password updated', 'success');
    header('Location: login.php');
    die();
}

if (isset($_POST['submit-email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!$email) {
        new Flash(constant("FLASH_NAME"), 'Fill all the forms fields', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF']);
        die();
    }

    $dbManagerUser = DbManagerCRUD_User::getInstance();
    $user = $dbManagerUser->readUsingEmail($email);

    if (!$user) {
        new Flash(constant("FLASH_NAME"), 'Email not found', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF']);
        die();
    }

    $res = $user->resetPassword();

    if (!$res) {
        new Flash(constant("FLASH_NAME"), 'Error while resetting the password', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF']);
        die();
    }

    new Flash("global", 'Email sent, check your inbox', 'success');
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead("Reset Password", ["password-reset"]);
?>

<body class="d-flex justify-content-center align-items-center">

    <form class="form-PW-reset" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off">
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center PW-reset-card">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">

            <?php
            if ($formToDisplay === 'PW') :
            ?>

                <label for="password" class="sr-only">New password</label>
                <input type="password" name="password" class="formInput" id="password" placeholder="New password" autofocus required autocomplete="new-password">

                <label for="password2" class="sr-only">Confirm</label>
                <input type="password" name="password2" class="formInput" id="password2" placeholder="Repeate" required autocomplete="new-password">

                <input type="hidden" name="token" value="<?= $token ?>">

                <button class="btn-lgb btn-block" type="submit" name="submit-PW">Submit</button>
            <?php
            else :
            ?>
                <p>Enter your email address and we will send you a link to reset your password.</p>
                <label for="inputEmail" class="sr-only">Email</label>
                <input type="email" id="inputEmail" class="formInput" placeholder="Email address" required autofocus name="email" autocomplete="new-password">
                <button class="btn-lgb btn-block" type="submit" name="submit-email">Submit</button>
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