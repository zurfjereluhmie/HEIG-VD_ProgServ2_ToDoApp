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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <?= Flash::displayFlashMessage('reset-password') ?>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" name="password" id="password">
        <label for="password2">Confirmer le nouveau mot de passe</label>
        <input type="password" name="password2" id="password2">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="submit" value="Envoyer" name="submit">
    </form>
</body>

</html>