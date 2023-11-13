<html>

<head>
</head>

<body>
    <h1>Index.php</h1>
    <a href="testMail.php">Test Mail</a>
    <a href="testInsert.php">Test Insert</a>
    <br>
    <?php

    use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;

    include_once "../app/autoload.php";

    $dbManagerUser = DbManagerCRUD_User::getInstance();
    $u1 = $dbManagerUser->read(1);

    echo "<pre>";
    print_r($u1);
    echo "</pre>";



    // Check if the correct php.ini file is loaded
    echo ini_get('upload_max_filesize') . '<br>';
    echo php_ini_loaded_file();
    echo phpinfo();
    ?>
</body>

</html>