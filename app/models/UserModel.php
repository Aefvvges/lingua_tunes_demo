<?php
namespace app\models;
use \DataBase;
use \Model;

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
    public $baja;
    public $fecha_baja;
    public $errores = [];

    // Buscar por email
public static function findEmail($email){
    $model = new static();
    $sql = "SELECT * FROM " . $model->table . " WHERE " . $model->secundaryKey . " = :email";
    $params = ["email" => $email];
    $result = DataBase::query($sql, $params);

    if ($result && count($result) > 0) {
        foreach ($result[0] as $key => $value) {
            $model->$key = $value;
        }
        return $model; // devuelve el usuario como objeto
    } else {
        return false; // si no hay usuario, devuelve false
    }
}

    // Buscar por nombre de usuario
    public static function findUsername($username)
    {
        $model = new static();
        $sql = "SELECT * FROM " . $model->table . " WHERE usuario = :usuario LIMIT 1";
        $params = ["usuario" => $username];
        $result = DataBase::query($sql, $params);
        return $result ? $result[0] : false;
    }

    public static function findId($id)
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
    public static function GetUserByToken($token)
    {
        $sql = "SELECT * FROM usuarios WHERE token = :token LIMIT 1";
        $result = DataBase::query($sql, [':token' => $token]);

        return $result ? $result[0] : null;
    }

    public static function saveToken($userId, $token)
    {
        $sql = "UPDATE usuarios SET token = :token WHERE id = :id";
        return DataBase::execute($sql, [
            'token' => $token,
            'id' => $userId
        ]);
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
        // Hashear contraseña
        $passwordHash = password_hash($data['contrasena'], PASSWORD_DEFAULT);

        // SOLO los parámetros que realmente están en el SQL
        $params = [
            ':usuario' => $data['usuario'],
            ':contrasena' => $passwordHash,
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':fecha_nacimiento' => $data['fecha_nacimiento']
        ];

        $sql = "INSERT INTO usuarios 
                (usuario, contrasena, nombre, apellido, email, telefono, fecha_nacimiento)
                VALUES 
                (:usuario, :contrasena, :nombre, :apellido, :email, :telefono, :fecha_nacimiento)";

        return DataBase::execute($sql, $params);
    }


    public function editar($id, $data)
    {
        $camposPermitidos = ['usuario', 'nombre', 'apellido', 'email', 'telefono', 'fecha_nacimiento'];
        $setParts = [];
        $params = [];

        foreach ($camposPermitidos as $campo) {
            if (isset($data[$campo])) {
                $setParts[] = "$campo = :$campo";
                $params[$campo] = $data[$campo];
            }
        }

        if (empty($setParts)) {
            return false; // no hay campos para actualizar
        }

        $sql = "UPDATE usuarios SET " . implode(', ', $setParts) . " WHERE id = :id";
        $params['id'] = $id;

        return DataBase::execute($sql, $params);
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
    public static function obtenerFoto($usuarioId) {
        $sql = "SELECT ruta FROM fotos_usuario WHERE usuario_id = :id LIMIT 1";
        $params = [':id' => $usuarioId];
        $result = DataBase::query($sql, $params);
        return $result ? $result[0]->ruta : null;
    }

    public static function guardarFoto($usuarioId, $ruta) {

        $sql = "INSERT INTO fotos_usuario (usuario_id, ruta)
                VALUES (:id, :ruta)
                ON DUPLICATE KEY UPDATE ruta = :ruta";

        return DataBase::execute($sql, [
            ':id' => $usuarioId,
            ':ruta' => $ruta
        ]);
    }

}
