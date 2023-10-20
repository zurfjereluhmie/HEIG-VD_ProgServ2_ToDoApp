<?php

require_once 'testDB.php';

$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$result = $db->prepare($sql);
$result->execute([
    'name' => 'John Doe',
    'email' => 'emial',
    'password' => 'password'
]);
$row = $result->fetch(PDO::FETCH_ASSOC);
print_r($row);


$query = $db->prepare("SELECT * FROM users");
$query->execute();
$users = $query->fetchAll();

foreach ($users as $user) {
    print_r($user) . "\n";
}
