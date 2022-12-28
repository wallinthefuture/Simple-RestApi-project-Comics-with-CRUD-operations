<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once "../config/database.php";
include_once "../objects/comics.php";

$database = new Database();
$db = $database->getConnection();
$comics = new Comics($db);

$comics->id = isset($_GET["id"]) ? $_GET["id"] : die();

// получим детали товара
$comics->readOne();

if ($comics->name != null) {

    // создание массива
    $comics_arr = array(
        "id" => $comics->id,
        "name" => $comics->name,
        "description" => $comics->description,
        "price" => $comics->price,
        "type_id" => $comics->type_id,
        "type_name" => $comics->type_name
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($comics_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой товар не существует
    echo json_encode(array("message" => "Комикс не существует"), JSON_UNESCAPED_UNICODE);
}