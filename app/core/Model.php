<?php
namespace app\core;

class Model {
    // Nombre de la tabla en la base de datos
    protected $table = "users";

    // Clave primaria (si tu tabla la llama distinto, cámbiala)
    protected $primaryKey = "id";

    // Ejemplo de método personalizado (opcional)
    public static function findByUsername($username)
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table . " WHERE username = :username LIMIT 1";
        $params = ["username" => $username];
        $result = \app\core\DataBase::query($sql, $params);

        if ($result) {
            foreach ($result as $key => $value) {
                $model->$key = $value;
            }
            return $model;
        }

        return null;
    }
}
