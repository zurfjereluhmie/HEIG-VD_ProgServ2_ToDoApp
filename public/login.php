<?php
session_start();

require_once("../app/autoload.php");

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use ch\comem\todoapp\flash\Flash;

if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

define("FLASH_NAME", pathinfo(basename($_SERVER["PHP_SELF"]), PATHINFO_FILENAME));

if (isset($_POST["submit"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST["password"]);


    if (!$email || !$password) {
        new Flash(constant("FLASH_NAME"), "Fill all the forms fields", "warning");
        header("Location: " . $_SERVER["PHP_SELF"]);
        die();
    }

    $user = DbManagerCRUD_User::getInstance()->readUsingEmail($email);

    if (!$user) {
        new Flash(constant("FLASH_NAME"), "Wrong email or password", "danger");
        header("Location: " . $_SERVER["PHP_SELF"]);
        die();
    }

    if (!password_verify($password, $user->getPassword())) {
        new Flash(constant("FLASH_NAME"), "Wrong email or password", "danger");
        header("Location: " . $_SERVER["PHP_SELF"]);
        die();
    }

    $_SESSION["user"] = [
        "id" => $user->getId(),
        "email" => $user->getEmail(),
        "firstName" => $user->getFirstName(),
        "lastName" => $user->getLastName(),
    ];

    new Flash(constant("FLASH_NAME"), "Welcome back " . $user->getFirstName() . " " . $user->getLastName(), "success");
    header("Location: dashboard.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="fr" data-lt-installed="true">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ToDoApp - Login</title>

    <!-- CSS Lib -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- CSS Custom -->
    <link href="styles/login.css" rel="stylesheet">

    <!-- icon -->
    <link rel="icon" href="assets/icons/logo.svg">


</head>

<body class="d-flex justify-content-center align-items-center">

    <form class="form-signin" method="post" action="<?= $_SERVER["PHP_SELF"] ?>" autocomplete="off">

        <?= Flash::displayFlashMessage("global") ?>
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center loginCard">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" class="formInput" placeholder="Email address" required autofocus name="email" autocomplete="new-password">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="formInput" placeholder="Password" required name="password" autocomplete="new-password">
            <button class="btn-lgb btn-block" type="submit" name="submit">Sign in</button>
            <p>Don't have an account ? <a href="register.php">Register here</a></p>

            <p class="small"><a href="reset-password.php">Forgot password ?</a></p>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>