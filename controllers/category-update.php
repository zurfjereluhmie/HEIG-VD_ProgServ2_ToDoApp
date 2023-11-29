<?php

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

$catId = filter_input(INPUT_POST, 'catId', FILTER_SANITIZE_NUMBER_INT);
$catTitle = htmlspecialchars($_POST['cat-title']);
$catColor = htmlspecialchars($_POST['cat-color']);
$catDescription = htmlspecialchars($_POST['cat-description']) ?? "";

if (!$catId || !$catTitle || !$catColor) {
    new Flash("category-update", TEXT['must-fill-all-fields'], "danger");
    header("Location: /category-update.php?id=$catId");
    die();
}

$categoryManager = CategoryManager::getInstance();
$category = $categoryManager->getCategory($catId);

if (!$category) {
    new Flash("category-update", TEXT['error-category-not-found'], "danger");
    header("Location: /category-update.php?id=$catId");
    die();
}

$category->setTitle($catTitle);
$category->setColor($catColor);
$category->setDescription($catDescription);

if ($categoryManager->updateCategory($category)) {
    new Flash("global", TEXT['category-update'], "success");
    header("Location: /category.php?id=$catId");
    die();
} else {
    new Flash("category-update", TEXT['error-category-update'], "danger");
    header("Location: /category-update.php?id=$catId");
    die();
}
