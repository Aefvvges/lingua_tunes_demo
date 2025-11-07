<?php
namespace app\controllers;
ini_set('display_errors', 1);
error_reporting(E_ALL);
use app\core\Response;
use app\core\DataBase;

class SesionController {

    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }
    public function actionRegister() {
        $this->startSession();
        $errores = [];
        $msg_correcto = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';
            $contrasena_conf = $_POST['contrasena_conf'] ?? '';
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');

            // --- Campos obligatorios
            if ($usuario === '' || $contrasena === '' || $contrasena_conf === '' || 
                $nombre === '' || $apellido === '' || $email === '' || $telefono === '' || $fecha_nacimiento === '') {
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
            if ($contrasena !== $contrasena_conf) {
                $errores[] = "Las contraseñas no coinciden.";
            }

            // --- Email válido
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El email no es válido.";
            }

            // --- Fecha de nacimiento y edad mínima (13 años)
            $fechaObj = \DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
            if (!$fechaObj) {
                $errores[] = "La fecha de nacimiento no es válida.";
            } else {
                $edad = (new \DateTime())->diff($fechaObj)->y;
                if ($edad < 13) {
                    $errores[] = "Debes tener al menos 13 años para registrarte.";
                }
            }

            // --- Usuario único
            $sql = "SELECT id FROM usuarios WHERE usuario = :usuario";
            if (DataBase::query($sql, [':usuario' => $usuario])) {
                $errores[] = "El usuario ya existe.";
            }

            // --- Insertar si no hay errores
            if (empty($errores)) {
                $hash = password_hash($contrasena, PASSWORD_DEFAULT);

                $insert = "INSERT INTO usuarios 
                    (usuario, contrasena, nombre, apellido, email, telefono, fecha_nacimiento, baja)
                    VALUES (:usuario, :contrasena, :nombre, :apellido, :email, :telefono, :fecha_nacimiento, 0)";
                
                $ok = DataBase::execute($insert, [
                    ':usuario' => $usuario,
                    ':contrasena' => $hash,
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':email' => $email,
                    ':telefono' => $telefono,
                    ':fecha_nacimiento' => $fecha_nacimiento
                ]);

                if ($ok) {
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['token'] = bin2hex(random_bytes(32));
                    $msg_correcto = "Registro exitoso.";
                    Response::redirect('index.php?url=sesion/login');
                    exit();
                } else {
                    $errores[] = "Error al registrar el usuario.";
                }
            }

            Response::render('site', 'register', ['errores' => $errores, 'msg_correcto' => $msg_correcto]);
        } else {
            Response::render('site', 'register');
        }
    }


    public function actionLogin() {
        $this->startSession();

        $errores = []; // <-- nuevo array de errores
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $contrasena = trim($_POST['contrasena'] ?? '');

            if ($usuario === '') {
                $errores['usuario'] = "El usuario es obligatorio.";
            }
            if ($contrasena === '') {
                $errores['contrasena'] = "La contraseña es obligatoria.";
            }

            if (empty($errores)) {
                $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND baja = 0";
                $resultado = DataBase::query($sql, [':usuario' => $usuario]);

                if ($resultado) {
                    $user = $resultado[0];
                    if (password_verify($contrasena, $user->contrasena)) {
                        $_SESSION['id'] = $user->id;
                        $_SESSION['usuario'] = $user->usuario;
                        $_SESSION['token'] = bin2hex(random_bytes(32));
                        Response::redirect('index.php?url=home/index');
                        exit();
                    } else {
                        $errores['contrasena'] = "Contraseña incorrecta";
                    }
                } else {
                    $errores['usuario'] = "Usuario no encontrado";
                }
            }
        }

        Response::render('site', 'login', ['errores' => $errores]);
    }


    public function actionLogout() {
        session_start();

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        // Redirigir al login pasando por el router
        header("Location: " . BASE_URL . "/index.php?url=site/login");
        exit();

    }
}
