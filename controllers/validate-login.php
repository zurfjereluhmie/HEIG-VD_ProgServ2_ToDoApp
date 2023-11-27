<?php

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_POST["password"]);


if (!$email || !$password) {
    new Flash(constant("FLASH_NAME"), "Fill all the forms fields", "warning");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$user = DbManagerCRUD_User::getInstance()->readUsingEmail($email);

if (!$user) {
    new Flash(constant("FLASH_NAME"), "Wrong email or password", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

if (!password_verify($password, $user->getPassword())) {
    new Flash(constant("FLASH_NAME"), "Wrong email or password", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$_SESSION["user"] = [
    "id" => $user->getId(),
    "email" => $user->getEmail(),
    "firstName" => $user->getFirstName(),
    "lastName" => $user->getLastName(),
    "isValid" => $user->getIsValid(),
];

new Flash("global", "Welcome back " . $user->getFirstName() . " " . $user->getLastName(), "success");
$redirect = $_SESSION["redirect"] ?? "dashboard.php";
unset($_SESSION["redirect"]);
header("Location: " . $redirect);
exit();
