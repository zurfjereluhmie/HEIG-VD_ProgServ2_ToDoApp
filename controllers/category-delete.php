<?php

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

$catId = filter_input(INPUT_POST, 'catId', FILTER_SANITIZE_NUMBER_INT);

if (!$catId) {
    new Flash("category-update", TEXT['error-category-delete'], "danger");
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

if ($categoryManager->removeCategory($category)) {
    new Flash("global", TEXT['category-delete'], "success");
    header("Location: /categories.php");
    die();
} else {
    new Flash("category-update", TEXT['error-category-delete'], "danger");
    header("Location: /category-update.php?id=$catId");
    die();
}
