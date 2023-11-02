<?php

function loadHead(string $title, array $stylesheet = null): void
{
?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ToDoApp - <?= $title ?></title>

        <!-- CSS Lib -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- CSS Custom -->
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
