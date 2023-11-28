<html>

<head>
</head>

<body>
    <?php
    require_once '../app/autoload.php';

    use ch\comem\todoapp\category\CategoryManager;

    $categoryManager = CategoryManager::getInstance();
    $categories = $categoryManager->getCategories();
    echo "<pre>";
    print_r($categories);
    echo "</pre>";
    ?>
</body>

</html>