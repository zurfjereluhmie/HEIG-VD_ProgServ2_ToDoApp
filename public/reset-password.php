<?php

require_once '../app/autoload.php';

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

session_start();

$token = htmlspecialchars($_GET['token'] ?? '');

if (isset($_POST['submit'])) {

    $tokenTroughPOST = htmlspecialchars($_POST['token'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $password2 = htmlspecialchars($_POST['password2'] ?? '');

    if (!$tokenTroughPOST) {
        new Flash('reset-password', 'No token provided', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $token);
        die();
    }

    if (!$password || !$password2) {
        new Flash('reset-password', 'Fill all the forms fields', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        die();
    }

    if ($password !== $password2) {
        new Flash('reset-password', 'Passwords do not match', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        die();
    }

    $dbManagerUser = DbManagerCRUD_User::getInstance();

    $user = $dbManagerUser->readUsingPWToken($tokenTroughPOST);

    if (!$user) {
        new Flash('reset-password', 'Token invalid', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    unset($password);
    unset($password2);

    $user->setPassword($hashedPassword);

    $newUser = $dbManagerUser->update($user->getId(), $user);

    if (!$newUser) {
        new Flash('reset-password', 'Error while updating the password', 'danger');
        header('Location: ' . $_SERVER['PHP_SELF'] . '?token=' . $tokenTroughPOST);
        die();
    }

    $_SESSION['user'] = [
        'id' => $newUser->getId(),
        'email' => $newUser->getEmail(),
        'firstname' => $newUser->getFirstname(),
        'lastname' => $newUser->getLastname()
    ];

    new Flash('reset-password', 'Password updated', 'success');
    header('Location: dashboard.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="fr" data-lt-installed="true">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ToDoApp - Reset Password</title>

    <!-- CSS Lib -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- CSS Custom -->
    <link href="styles/password-reset.css" rel="stylesheet">

    <!-- icon -->
    <link rel="icon" href="assets/icons/logo.svg">


</head>

<body class="d-flex justify-content-center align-items-center">

    <form class="form-PW-reset" method="post" action="<?= $_SERVER["PHP_SELF"] ?>">
        <?= Flash::displayFlashMessage('reset-password') ?>
        <div class="d-flex flex-column justify-content-center align-items-center PW-reset-card">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">

            <label for="password">New password</label>
            <input type="password" name="password" class="formInput" id="password" autofocus required>

            <label for="password2">Confirm</label>
            <input type="password" name="password2" class="formInput" id="password2" required>

            <input type="hidden" name="token" value="<?= $token ?>">

            <button class="btn-lgb btn-block" type="submit" name="submit">Submit</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>