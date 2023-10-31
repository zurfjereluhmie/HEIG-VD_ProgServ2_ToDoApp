<?php

require_once '../app/autoload.php';

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;

session_start();

$token = htmlspecialchars($_GET['token'] ?? '');

if (isset($_POST['submit'])) {

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    $tokenTroughPOST = htmlspecialchars($_POST['token'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $password2 = htmlspecialchars($_POST['password2'] ?? '');

    if (!$tokenTroughPOST) {
        echo "Token invalide";
        exit();
    }

    if (!$password || !$password2) {
        echo "Veuillez remplir tous les champs";
        exit();
    }

    if ($password !== $password2) {
        echo "Les mots de passe ne correspondent pas";
        exit();
    }

    require_once '../vendor/autoload.php';
    $dbManagerUser = DbManagerCRUD_User::getInstance();

    $user = $dbManagerUser->readUsingPWToken($tokenTroughPOST);

    if (!$user) {
        echo "Token invalide";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    unset($password);
    unset($password2);

    $user->setPassword($hashedPassword);

    $newUser = $dbManagerUser->update($user->getId(), $user);

    if (!$newUser) {
        echo "Erreur lors de la mise à jour du mot de passe";
        exit();
    }

    $_SESSION['user'] = [
        'id' => $newUser->getId(),
        'email' => $newUser->getEmail(),
        'firstname' => $newUser->getFirstname(),
        'lastname' => $newUser->getLastname()
    ];

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    //header('Location: index.php');
} else {
    echo "Erreur lors de la soumission du formulaire";
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