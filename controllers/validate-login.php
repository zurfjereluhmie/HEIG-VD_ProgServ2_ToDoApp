<?php

require_once "./locale/locale-conf.php";

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_POST["password"]);


if (!$email || !$password) {
    new Flash(constant("FLASH_NAME"), TEXT['must-fill-all-fields'], "warning");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$user = DbManagerCRUD_User::getInstance()->readUsingEmail($email);

if (!$user) {
    new Flash(constant("FLASH_NAME"), TEXT['wrong-email-or-password'], "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

if (!password_verify($password, $user->getPassword())) {
    new Flash(constant("FLASH_NAME"), TEXT['wrong-email-or-password'], "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}


if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
    $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
    DbManagerCRUD_User::getInstance()->update($user->getId(), $user);
}

$_SESSION["user"] = [
    "id" => $user->getId(),
    "email" => $user->getEmail(),
    "firstName" => $user->getFirstName(),
    "lastName" => $user->getLastName(),
    "isValid" => $user->getIsValid(),
];

new Flash("global", TEXT['welcome-back'] . " " . $user->getFirstName() . " " . $user->getLastName(), "success");
$redirect = $_SESSION["redirect"] ?? "dashboard.php";
unset($_SESSION["redirect"]);
header("Location: " . $redirect);
exit();
