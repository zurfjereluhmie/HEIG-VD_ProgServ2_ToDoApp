<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;

if (isset($_POST["login"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST["password"]);

    $errorCode = 0;
    if (!$email && !$password) {
        $errorCode = 1;
        header("Location: " . $_SERVER["PHP_SELF"] . "?error=" . $errorCode);
    }

    require_once("../app/autoload.php");
    $user = DbManagerCRUD_User::getInstance()->readUsingEmail($email);

    if (!$user) {
        $errorCode = 2;
        header("Location: " . $_SERVER["PHP_SELF"] . "?error=" . $errorCode);
    }

    if (!password_verify($password, $user->getPassword())) {
        $errorCode = 3;
        header("Location: " . $_SERVER["PHP_SELF"] . "?error=" . $errorCode);
    }



    $_SESSION["user"] = [
        "id" => $user->getId(),
        "email" => $user->getEmail(),
        "firstName" => $user->getFirstName(),
        "lastName" => $user->getLastName(),
    ];
    header("Location: dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="login" value="Login">
    </form>
</body>

</html>