<?php

use ch\comem\todoapp\category\CategoryBuilder;
use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\category\CategoryManager;

$catTitle = htmlspecialchars($_POST['cat-title']);
$catColor = htmlspecialchars($_POST['cat-color']);
$catDescription = htmlspecialchars($_POST['cat-description']) ?? "";

if (!$catTitle || !$catColor) {
    new Flash("category-update", TEXT['must-fill-all-fields'], "danger");
    header("Location: /category-update.php?id=$catId");
    exit();
}

$categoryManager = CategoryManager::getInstance();
$category = (new CategoryBuilder($catTitle, $catColor))
    ->setDescription($catDescription)
    ->build();

if ($categoryManager->addCategory($category)) {
    $id = $category->getId();
    new Flash("category", TEXT['category-create'], "success");
    header("Location: /category.php?id=$id");
} else {
    new Flash("category-create", TEXT['error-category-create'], "danger");
    header("Location: /category-create.php");
}
