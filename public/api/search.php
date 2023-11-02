<?php

// return to the API caller the body of the request
$req = file_get_contents('php://input');

// decode the JSON string into an associative array
$req = json_decode($req, true);

echo json_encode([
    ["id" => 1, "title" => "Resultat #1 " . $req["searchValue"]],
    ["id" => 2, "title" => "Resultat #2 " . $req["searchValue"]],
    ["id" => 3, "title" => "Resultat #3 " . $req["searchValue"]],
]);
