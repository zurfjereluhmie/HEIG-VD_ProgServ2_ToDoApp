<?php

function loadHead(string $title, array $stylesheet = null): void
{
?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ToDoApp - <?= $title ?></title>

        <!-- CSS Lib -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- CSS Custom -->
        <link href="styles/main.css" rel="stylesheet">
        <link href="styles/navBar.css" rel="stylesheet">
        <?php foreach ($stylesheet as $css) : ?>
            <link href="styles/<?= $css ?>.css" rel="stylesheet">
        <?php endforeach; ?>
        <!-- <link href="css/modal.css" rel="stylesheet"> -->

        <!-- icon -->
        <link rel="icon" href="assets/icons/logo.svg">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous">


    </head>
<?php
}
