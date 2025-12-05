<?php

class Model {
    // Nombre de la tabla en la base de datos
    protected $table;

    // Clave primaria (si tu tabla la llama distinto, cámbiala)
    protected $primaryKey = "id";

    // Ejemplo de método personalizado (opcional)
    public static function findId($id)
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table . " WHERE " . $model ->primaryKey . " = :id";
        $params = ["id" => $id];
        $results = DataBase::query($sql, $params);
        $result = $results[0];

        if ($result) {
            foreach ($result as $key => $value) {
                $model->$key = $value;
            }
        }

        return $model;
    }
        // Obtener todos los registros de la tabla
    public static function getAll()
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table;
        return DataBase::query($sql);
    }

    // Obtener nombres de las columnas de una tabla
    public static function getColumnsNames($table)
    {
        return DataBase::getColumnsNames($table);
    }
}
