<?php
namespace app\controllers;

use app\core\Response;
use app\core\DataBase;

class UserController {

    // Mostrar lista de usuarios
    public function actionIndex() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Solo usuarios logueados pueden acceder
        if (!isset($_SESSION['id'])) {
            Response::redirect('index.php?url=sesion/login');
            return;
        }

        $sql = "SELECT id, usuario, email, baja FROM usuarios";
        $usuarios = DataBase::query($sql);

        Response::render('user', 'index', ['usuarios' => $usuarios]);
    }

    // Mostrar formulario para crear usuario
    public function actionCreate() {
        Response::render('user', 'create');
    }

    // Guardar nuevo usuario
    public function actionStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';
            $confirmar = $_POST['contrasena_conf'] ?? '';
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

            $errores = [];

            // --- Campos obligatorios
            if (empty($usuario) || empty($email) || empty($contrasena) || empty($confirmar) ||
                empty($nombre) || empty($apellido) || empty($telefono) || empty($fecha_nacimiento)) {
                $errores[] = "Todos los campos son obligatorios.";
            }

            // --- Contraseña
            if (strlen($contrasena) < 8) {
                $errores[] = "La contraseña debe tener al menos 8 caracteres.";
            }
            if (!preg_match('/[A-Z]/', $contrasena)) {
                $errores[] = "La contraseña debe incluir al menos una letra mayúscula.";
            }
            if (!preg_match('/[0-9]/', $contrasena)) {
                $errores[] = "La contraseña debe incluir al menos un número.";
            }
            if ($contrasena !== $confirmar) {
                $errores[] = "Las contraseñas no coinciden.";
            }

            // --- Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El email no tiene un formato válido.";
            }

            // --- Fecha de nacimiento
            $fechaObj = \DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
            if (!$fechaObj) {
                $errores[] = "La fecha de nacimiento no es válida.";
            } else {
                $edad = (new \DateTime())->diff($fechaObj)->y;
                if ($edad < 13) {
                    $errores[] = "El usuario debe tener al menos 13 años.";
                }
            }

            // --- Verificar usuario único
            $sql = "SELECT id FROM usuarios WHERE usuario = :usuario";
            if (DataBase::query($sql, [':usuario' => $usuario])) {
                $errores[] = "El usuario ya existe.";
            }

            // --- Insertar o mostrar errores
            if (empty($errores)) {
                $hash = password_hash($contrasena, PASSWORD_DEFAULT);

                $sql = "INSERT INTO usuarios (usuario, email, contrasena, nombre, apellido, telefono, fecha_nacimiento, baja)
                        VALUES (:usuario, :email, :contrasena, :nombre, :apellido, :telefono, :fecha_nacimiento, 0)";
                DataBase::execute($sql, [
                    ':usuario' => $usuario,
                    ':email' => $email,
                    ':contrasena' => $hash,
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':telefono' => $telefono,
                    ':fecha_nacimiento' => $fecha_nacimiento
                ]);

                Response::redirect('index.php?url=user/index');
                exit();
            } else {
                Response::render('user', 'create', ['errores' => $errores]);
            }
        }
    }

    // Editar usuario
    public function actionEdit($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $usuario = DataBase::query($sql, [':id' => $id])[0] ?? null;

        if (!$usuario) {
            Response::redirect('index.php?url=user/index');
            return;
        }

        Response::render('user', 'edit', ['usuario' => $usuario]);
    }

    // Actualizar usuario
    public function actionUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

            $errores = [];

            // Campos obligatorios
            if (empty($usuario) || empty($email) || empty($nombre) || empty($apellido) || empty($telefono) || empty($fecha_nacimiento)) {
                $errores[] = "Todos los campos son obligatorios.";
            }

            // Email válido
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El email no es válido.";
            }

            // Fecha de nacimiento
            $fechaObj = \DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
            if (!$fechaObj) {
                $errores[] = "La fecha de nacimiento no es válida.";
            } else {
                $edad = (new \DateTime())->diff($fechaObj)->y;
                if ($edad < 13) {
                    $errores[] = "El usuario debe tener al menos 13 años.";
                }
            }

            // Usuario único (excepto el actual)
            $sql = "SELECT id FROM usuarios WHERE usuario = :usuario AND id != :id";
            if (DataBase::query($sql, [':usuario' => $usuario, ':id' => $id])) {
                $errores[] = "El usuario ya existe.";
            }

            // Actualizar o mostrar errores
            if (empty($errores)) {
                $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, nombre = :nombre, apellido = :apellido, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento WHERE id = :id";
                DataBase::execute($sql, [
                    ':usuario' => $usuario,
                    ':email' => $email,
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':telefono' => $telefono,
                    ':fecha_nacimiento' => $fecha_nacimiento,
                    ':id' => $id
                ]);

                Response::redirect('index.php?url=user/index');
                exit();
            } else {
                $sql = "SELECT * FROM usuarios WHERE id = :id";
                $usuarioActual = DataBase::query($sql, [':id' => $id])[0];
                Response::render('user', 'edit', ['usuario' => $usuarioActual, 'errores' => $errores]);
            }
        }
    }


    // Dar de baja / eliminar usuario
    public function actionDelete($id) {
        $sql = "UPDATE usuarios SET baja = 1 WHERE id = :id";
        DataBase::query($sql, [':id' => $id]);

        Response::redirect('index.php?url=user/index');
    }
}
