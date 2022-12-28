<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/comics.php";

$database = new Database();
$db = $database->getConnection();

$comics = new Comics($db);

$stmt = $comics->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $comicses_arr = array();
    $comicses_arr["records"] = array();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
        $comics_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "type_id" => $type_id,
            "type_name" => $type_name
        );
        array_push($comicses_arr["records"], $comics_item);
    }

    http_response_code(200);


    echo json_encode($comicses_arr);
} else {

    http_response_code(404);


    echo json_encode(array("message" => "Комиксы не найдены."), JSON_UNESCAPED_UNICODE);
}
