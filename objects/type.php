<?php
class Type
{
    // соединение с БД и таблицей "categories"
    private $conn;
    private $table_name = "type";

    // свойства объекта
    public $id;
    public $name;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll()
    {
        $query = "SELECT
                id, name
            FROM
                " . $this->table_name . "
            ORDER BY
                name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}