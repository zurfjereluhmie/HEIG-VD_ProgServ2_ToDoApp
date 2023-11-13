<?php
session_start();

if (!isset($_SESSION["user"])) {
    exit();
}

$req = file_get_contents('php://input');
$req = json_decode($req, true);
$search = $req["searchValue"];

if (empty($search)) {
    exit();
}

include_once "../../app/autoload.php";

use ch\comem\todoapp\category\CategoryManager;

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategoriesByTitle($search);
if (empty($categories)) {
    echo json_encode([]);
    exit();
}

$data = [];
foreach ($categories as $category) {
    $data[] = [
        "id" => $category->getId(),
        "title" => $category->getTitle()
    ];
}

echo json_encode($data);
