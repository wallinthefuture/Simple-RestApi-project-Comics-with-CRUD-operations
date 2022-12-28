<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/comics.php";

$database = new Database();
$db = $database->getConnection();
$comics = new Comics($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->type_id)
) {
    // устанавливаем значения свойств товара
    $comics->name = $data->name;
    $comics->price = $data->price;
    $comics->description = $data->description;
    $comics->type_id = $data->type_id;
    $comics->created = date("Y-m-d H:i:s");

    // создание товара
    if ($comics->create()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Комикс был создан."), JSON_UNESCAPED_UNICODE);
    }

    else {

        http_response_code(503);


        echo json_encode(array("message" => "Невозможно создать комикс."), JSON_UNESCAPED_UNICODE);
    }
}

else {

    http_response_code(400);


    echo json_encode(array("message" => "Невозможно создать комикс. Данные неполные."), JSON_UNESCAPED_UNICODE);
}