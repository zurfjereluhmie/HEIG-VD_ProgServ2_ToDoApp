<html>

<head>
</head>

<body>
    <h1>Index.php</h1>
    <a href="testMail.php">Test Mail</a>
    <a href="testInsert.php">Test Insert</a>
    <br>
    <?php
    include_once "../app/autoload.php";

    use ch\comem\todoapp\category\CategoryManager;

    $categoryManager = CategoryManager::getInstance();
    $categories = $categoryManager->getCategoriesByTitle("m");

    echo "<pre>";
    print_r($categories);
    echo "</pre>";



    // Check if the correct php.ini file is loaded
    echo ini_get('upload_max_filesize') . '<br>';
    echo php_ini_loaded_file();
    echo phpinfo();
    ?>
</body>

</html>