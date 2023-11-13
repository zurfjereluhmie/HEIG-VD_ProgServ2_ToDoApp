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
    ];

    new Flash("global", "Welcome back " . $user->getFirstName() . " " . $user->getLastName(), "success");
    $redirect = $_SESSION["redirect"] ?? "dashboard.php";
    unset($_SESSION["redirect"]);
    header("Location: " . $redirect);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead("Login", ["login"]);
?>


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

    <?php
    include_once './components/script.php';
    loadScript();
    ?>
</body>

</html>