<?php

use ch\comem\todoapp\auth\User;
use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

$lastName = htmlspecialchars($_POST["lastName"]);
$firstName = htmlspecialchars($_POST["firstName"]);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_POST["password"]);
$password2 = htmlspecialchars($_POST["password2"]);

if (!$lastName) {
    new Flash(constant("FLASH_NAME"), "Please enter your last name", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

if (!$firstName) {
    new Flash(constant("FLASH_NAME"), "Please enter your first name", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

if (!$email) {
    new Flash(constant("FLASH_NAME"), "Please enter your email", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

if (!$password || !$password2 || $password !== $password2) {
    new Flash(constant("FLASH_NAME"), "Please fill both password field with same password", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$dbManagerUser = DbManagerCRUD_User::getInstance();

// Find if a user with this email already exists
if ($dbManagerUser->readUsingEmail($email)) {
    new Flash(constant("FLASH_NAME"), "This email is already used", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Create the user
$user = new User($email, password_hash($password, PASSWORD_DEFAULT), $firstName, $lastName, false);
$dbManagerUser->create($user);

$user = $dbManagerUser->readUsingEmail($email);
if (!$user) {
    new Flash(constant("FLASH_NAME"), "An error occured while creating your account", "danger");
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$user->sendValidationEmail();

new Flash("global", "Thanks for creating an account " . $user->getFirstName() . " " . $user->getLastName(), "success");
$redirect = "validate-account.php";
unset($_SESSION["redirect"]);
header("Location: " . $redirect);
exit();
