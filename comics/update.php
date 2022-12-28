<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом comics
include_once "../config/database.php";
include_once "../objects/comics.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

$comics = new Comics($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));


$comics->id = $data->id;
$comics->name = $data->name;
$comics->price = $data->price;
$comics->description = $data->description;
$comics->type_id = $data->type_id;

// обновление товара
if ($comics->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Комикс был обновлён"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить товар, сообщим пользователю
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить комикс"), JSON_UNESCAPED_UNICODE);
}