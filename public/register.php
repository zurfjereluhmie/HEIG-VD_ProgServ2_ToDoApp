<?php
session_start();

require_once "../app/autoload.php";

use ch\comem\todoapp\flash\Flash;

if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

define("FLASH_NAME", pathinfo(basename($_SERVER["PHP_SELF"]), PATHINFO_FILENAME));

if (isset($_POST["submit"])) require_once("../controllers/validate-register.php");

?>

<!DOCTYPE html>
<html lang="en" data-lt-installed="true">

<?php
require_once 'components/head.php';
loadHead("Register", ["register"]);
?>


<body class="d-flex justify-content-center align-items-center">
    <form class="form-register" method="post" action="<?= $_SERVER["PHP_SELF"] ?>">

        <?= Flash::displayFlashMessage("global") ?>
        <?= Flash::displayFlashMessage(constant("FLASH_NAME")) ?>
        <div class="d-flex flex-column justify-content-center align-items-center registerCard">

            <img class="" src="assets/icons/logo.svg" alt="" width="72" height="auto">

            <div class="d-flex flex-row justify-content-center align-items-center nameInput">
                <input type="text" id="inputLastName" class="formInputSmall" placeholder="Last name" required name="lastName">
                <input type="text" id="inputFirstName" class="formInputSmall" placeholder="First name" required name="firstName">
            </div>

            <input type="email" id="inputEmail" class="formInput" placeholder="Email address" required autocomplete="off" name="email">

            <input type="password" id="inputPassword" class="formInput" placeholder="Password" required name="password">
            <input type="password" id="inputRePassword" class="formInput" placeholder="Repeat password" required name="password2">

            <button class="btn-lgb btn-block" type="submit" name="submit">Register</button>
            <p>Already have an account ? <a href="login.php">Login here</a></p>
        </div>
    </form>

    <?php
    include_once './components/script.php';
    loadScript();
    ?>
</body>

</html>