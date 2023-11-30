<?php

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

$lastName = htmlspecialchars($_POST["last-name"]);
$firstName = htmlspecialchars($_POST["first-name"]);
$id = $_SESSION["user"]["id"];

if (!$id) {
    new Flash("user-update", TEXT['error-user-not-found'], "danger");
    header("Location: /user-update.php");
    exit();
}

if (empty($lastName) || empty($firstName)) {
    new Flash("user-update", TEXT['must-fill-all-fields'], "danger");
    header("Location: /user-update.php");
    exit();
}

$userDB = DbManagerCRUD_User::getInstance();
$user = $userDB->read($id);

if (!$user) {
    new Flash("user-update", TEXT['error-user-not-found'], "danger");
    header("Location: /user-update.php");
    exit();
}

$user->setLastName($lastName);
$user->setFirstName($firstName);

if (!$userDB->update($user->getId(), $user)) {
    new Flash("user-update", TEXT['error-user-update'], "danger");
    header("Location: /user-update.php");
    exit();
}

$_SESSION["user"]["lastName"] = $user->getLastName();
$_SESSION["user"]["firstName"] = $user->getFirstName();

new Flash("user-update", TEXT['user-update'], "success");
header("Location: /user-update.php");
exit();
