<?php
namespace app\models;

use app\core\Model;
use app\core\DataBase;

class UserModel extends Model{
    protected $table = "usuarios";
    protected $primaryKey = "id";
    protected $secundaryKey = "email";

    public $id;
    public $usuario;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $fecha_nacimiento;
    public $errores = [];

    // Buscar por email
    public static function findEmail($email)
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table . " WHERE " . $model->secundaryKey . " = :email";
        $params = ["email" => $email];
        $result = DataBase::query($sql, $params);
        return $result ? $result[0] : false;
    }

    // Buscar por nombre de usuario
    public static function findByUsername($username)
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table . " WHERE usuario = :usuario LIMIT 1";
        $params = ["usuario" => $username];
        $result = DataBase::query($sql, $params);
        return $result ? $result[0] : false;
    }

    public static function findById($id)
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table . " WHERE " . $model->primaryKey . " = :id";
        $params = ["id" => $id];
        $result = DataBase::query($sql, $params);

        if ($result) {
            foreach ($result[0] as $key => $value) {
                $model->$key = $value;
            }
            return $model;
        } else {
            return false;
        }
    }

    public function existeUsuario($usuario, $id = 0)
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE usuario = :usuario";
        $params = [':usuario' => $usuario];

        if ($id > 0) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        $result = DataBase::query($sql, $params);
        return $result[0]->total > 0;
    }

    public function existeEmail($email, $id = 0)
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE email = :email";
        $params = [':email' => $email];

        if ($id > 0) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        $result = DataBase::query($sql, $params);
        return $result[0]->total > 0;
    }

    public function registrar($data)
    {
        $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, contrasena, nombre, apellido, email, telefono, fecha_nacimiento)
                VALUES (:usuario, :contrasena, :nombre, :apellido, :email, :telefono, :fecha_nacimiento)";
        return DataBase::execute($sql, $data);
    }

    public function editar($id, $data)
    {
        $sql = "UPDATE usuarios
                SET usuario = :usuario, 
                    nombre = :nombre, 
                    apellido = :apellido, 
                    email = :email, 
                    telefono = :telefono, 
                    fecha_nacimiento = :fecha_nacimiento
                WHERE id = :id";
        $data['id'] = $id;
        return DataBase::execute($sql, $data);
    }

    public function eliminar($id)
    {
        $sql = "UPDATE usuarios SET baja = 1, fecha_baja = NOW() WHERE id = :id";
        return DataBase::execute($sql, ['id' => $id]);
    }

    public static function changePassword($newPass, $token)
    {
        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET contrasena = :contrasena WHERE token = :token";
        return DataBase::execute($sql, ['contrasena' => $hash, 'token' => $token]);
    }

    public function validar($modo = 'crear')
    {
        $errores = [];

        // Validaciones (usuario, contraseña, nombre, etc.)
        // ... (todo lo que ya tenías)
        // sin cambios en esta parte

        $this->errores = $errores;
        return empty($errores);
    }
}
