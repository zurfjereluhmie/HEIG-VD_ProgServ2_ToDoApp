<html>

<head>
</head>

<body>
    <h1>Index.php</h1>
    <a href="testMail.php">Test Mail</a>
    <a href="testInsert.php">Test Insert</a>
    <br>
    <?php
    // Check if the correct php.ini file is loaded
    echo ini_get('upload_max_filesize') . '<br>';
    echo php_ini_loaded_file();
    echo phpinfo();
    ?>
</body>

</html>