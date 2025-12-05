<?php
namespace app\controllers;

use \Controller;
use \app\models\UserModel;
use \Response;
use \DataBase;

class UserController extends Controller
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // --- Helpers
    private function authRequired() {
        if (!isset($_SESSION['id'])) {
            header("Location: " . self::$ruta . "user/login");
            exit;
        }
    }

    private function validarUsuario($data, $modo = 'crear') {
        $errores = [];

        if (isset($data['usuario'])) {
            if (strlen($data['usuario']) < 3 || strlen($data['usuario']) > 20)
                $errores['usuario'] = 'Ingrese un usuario entre 3 y 20 caracteres';
        }

        if (isset($data['nombre'])) {
            if(strlen($data['nombre']) < 3 || strlen($data['nombre']) > 20)
                $errores['nombre'] = 'Ingrese un nombre entre 3 y 20 caracteres';
        }

        if (isset($data['apellido'])) {
            if(strlen($data['apellido']) < 3 || strlen($data['apellido']) > 20)
                $errores['apellido'] = 'Ingrese un apellido entre 3 y 20 caracteres';
        }

        if (isset($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
                $errores['email'] = "El email no es válido.";
        }

        if (isset($data['telefono'])) {
            if (!preg_match('/^[0-9]{6,15}$/', $data['telefono']))
                $errores['telefono'] = 'Ingrese un teléfono válido (6-15 dígitos).';
        }

        if (isset($data['fecha_nacimiento'])) {
            $fechaObj = \DateTime::createFromFormat('Y-m-d', $data['fecha_nacimiento']);
            if (!$fechaObj) {
                $errores['fecha_nacimiento'] = "La fecha de nacimiento no es válida.";
            } else {
                $hoy = new \DateTime();
                $edad = $fechaObj->diff($hoy)->y;
                if ($fechaObj > $hoy) $errores['fecha_nacimiento'] = "La fecha no puede ser en el futuro";
                elseif ($edad < 13) $errores['fecha_nacimiento'] = "Debes tener al menos 13 años.";
            }
        }

        if ($modo === 'crear') {
            if (isset($data['contrasena'])) {
                if (strlen($data['contrasena']) < 8)
                    $errores['contrasena'] = "La contraseña debe tener al menos 8 caracteres.";
                if (!preg_match('/[A-Z]/', $data['contrasena']))
                    $errores['contrasena'] = "La contraseña debe incluir al menos 1 mayúscula.";
                if (!preg_match('/[0-9]/', $data['contrasena']))
                    $errores['contrasena'] = "La contraseña debe incluir al menos 1 número.";
                if (isset($data['contrasena_conf']) && $data['contrasena'] !== $data['contrasena_conf'])
                    $errores['contrasena_conf'] = "Las contraseñas no coinciden.";
            }
        }

        return $errores;
    }

    // --- Listado de usuarios
    public function actionIndex($var = null) {
        $this->authRequired();
        $sql = "SELECT id, usuario, email, baja FROM usuarios";
        $usuarios = DataBase::query($sql);

        $head = SiteController::head();
        Response::render($this->viewDir(__NAMESPACE__), "index", [
            "title" => $this->title . 'Usuarios',
            "head"  => $head,
            "usuarios" => $usuarios
        ]);
    }

    public function actionRegister() {
        $head = SiteController::head();
        $path = static::path();

        // Datos vacíos para primera carga
        $data = [
            'usuario' => '',
            'contrasena' => '',
            'contrasena_conf' => '',
            'nombre' => '',
            'apellido' => '',
            'email' => '',
            'telefono' => '',
            'fecha_nacimiento' => ''
        ];

        Response::render($this->viewDir(__NAMESPACE__), "register", [
            "title"   => "Registro",
            "head"    => $head,
            "path"    => $path,
            "data"    => $data,
            "errores" => [],
            "msg"     => ""
        ]);
    }
    public function actionStore() {
        $head = SiteController::head();
        $path = static::path();
        $errores = [];
        $msg = "";

        // CARGAR datos recibidos
        $data = [
            'usuario' => trim($_POST['usuario'] ?? ''),
            'contrasena' => trim($_POST['contrasena'] ?? ''),
            'contrasena_conf' => trim($_POST['contrasena_conf'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'fecha_nacimiento' => trim($_POST['fecha_nacimiento'] ?? '')
        ];

        $userModel = new UserModel();

        // Validaciones de existencia
        if ($userModel->existeUsuario($data['usuario'], null)) {
            $errores['usuario'] = "El nombre de usuario ya existe.";
        }

        if ($userModel->existeEmail($data['email'], null)) {
            $errores['email'] = "El email ya está registrado.";
        }

        // Validaciones de formato
        $errores = array_merge($errores, $this->validarUsuario($data, 'crear'));

        // SI NO HAY ERRORES → GUARDAR Y REDIRIGIR
        if (empty($errores)) {
            if ($userModel->registrar($data)) {

                // Redirigir al login
                header("Location: /lingua_tunes_demo/user/login");
                exit;
            } else {
                $errores['general'] = "Ocurrió un error al guardar en la base de datos.";
            }
        }

        // SI HAY ERRORES → VOLVER A MOSTRAR LA VISTA
        Response::render($this->viewDir(__NAMESPACE__), "register", [
            "title"   => "Registro",
            "head"    => $head,
            "path"    => $path,
            "data"    => $data,   // repoblar formulario
            "errores" => $errores,
            "msg"     => $msg
        ]);
    }


    // --- Login
    public function actionLogin() {
        $errores = [];
        if (isset($_SESSION['id'])) {
            header("Location: /lingua_tunes_demo/home/inicio");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['contrasena'] ?? '');
            if (!$usuario) $errores['usuario'] = 'El usuario es obligatorio';
            if (!$password) $errores['contrasena'] = 'La contraseña es obligatoria';

            if (empty($errores)) {
                $user = UserModel::findUsername($usuario);
                if ($user) {
                    if (!self::checkActivo($user->email)) {
                        $errores['general'] = 'El usuario no existe';
                    } elseif (password_verify($password, $user->contrasena)) {
                        $_SESSION['id'] = $user->id;
                        $_SESSION['usuario'] = [
                            "id" => $user->id,
                            "usuario" => $user->usuario,
                            "nombre" => $user->nombre,
                            "apellido" => $user->apellido,
                            "email" => $user->email,
                            "telefono" => $user->telefono,
                            "fecha_nacimiento" => $user->fecha_nacimiento
                        ];
                        header("Location: /lingua_tunes_demo/home/inicio");
                        exit;
                    } else {
                        $errores['general'] = 'Usuario o contraseña incorrectos';
                    }
                } else {
                    $errores['general'] = 'Usuario o contraseña incorrectos';
                }
            }
        }

        $head = SiteController::head();
        $path = static::path();
        Response::render($this->viewDir(__NAMESPACE__), 'login', [
            'title' => 'Iniciar sesión',
            'head' => $head,
            'errores' => $errores,
            'path' => $path
        ]);
    }

    public function actionLogout() {
        session_unset();
        session_destroy();
        header("Location: /lingua_tunes_demo/user/login");
        exit;
    }

    // --- Perfil y edición unificados
    private function renderUserForm($view, $data, $errores = []) {
        $id = $_SESSION['id'] ?? null;
        if (!$id) $this->action404();

        $usuarioBD = UserController::getUser($id);

        // En caso de que devuelva false
        if (!$usuarioBD) $this->action404();

        $fotoNombre = UserModel::obtenerFoto($id);
        $fotoNombre = $fotoNombre ? basename ($fotoNombre) : null;

        // Ruta base pública
        define('BASE_URL', '/lingua_tunes_demo/');

        $rutaFoto = ($fotoNombre && file_exists(__DIR__ . "/../../public/img/uploads/profile_photos/" . $fotoNombre))
            ? BASE_URL . "img/uploads/profile_photos/" . htmlspecialchars($fotoNombre)
            : BASE_URL . "img/default_profile.png";

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        $path = static::path();

        $usuarioBDArray = (array) $usuarioBD;
        $dataArray = (array) $data;
        $usuarioMerge = array_merge($usuarioBDArray, $dataArray);

        Response::render($this->viewDir(__NAMESPACE__), $view, [
            'title' => $view === 'profile' ? 'Mi Perfil' : 'Editar Perfil',
            'head' => $head,
            'header' => $header,
            'footer' => $footer,
            'usuario' => (object)$usuarioMerge,
            'rutaFoto' => $rutaFoto,
            'path' => $path,
            'errores' => $errores
        ]);
    }

    public function actionProfile() {
        $id = $_SESSION['id'] ?? null;
        $usuario = UserController::getUser($id);
        $this->renderUserForm('profile', (array)$usuario);
    }

    public function actionEdit() {
        $id = $_SESSION['id'] ?? null;
        $usuarioBD = UserController::getUser($id);
        $data = [
            'usuario' => $_POST['usuario'] ?? $usuarioBD->usuario,
            'nombre' => $_POST['nombre'] ?? $usuarioBD->nombre,
            'apellido' => $_POST['apellido'] ?? $usuarioBD->apellido,
            'email' => $_POST['email'] ?? $usuarioBD->email,
            'telefono' => $_POST['telefono'] ?? $usuarioBD->telefono,
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? $usuarioBD->fecha_nacimiento
        ];

        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new UserModel();
            $erroresFormato = $this->validarUsuario($data, 'editar');
            $erroresExistencia = [];
            if ($userModel->existeUsuario($data['usuario'], $id)) $erroresExistencia[] = "El nombre de usuario ya existe.";
            if ($userModel->existeEmail($data['email'], $id)) $erroresExistencia[] = "El email ya está registrado.";
            $errores = array_merge($erroresFormato, $erroresExistencia);

            if (empty($errores)) {
                $userModel->editar($id, $data);
                $_SESSION['usuario'] = array_merge($_SESSION['usuario'], $data);
                header("Location: /lingua_tunes_demo/user/profile");
                exit;
            }
        }
        $this->renderUserForm('edit', $data, $errores);
    }

    // --- Update photo
    public function actionUpdatePhoto() {
        $this->authRequired();
        $userId = $_SESSION['id'];

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            echo "No se subió ninguna imagen.";
            return;
        }

        $foto = $_FILES['photo'];
        $targetDir = __DIR__ . "/../../public/img/uploads/profile_photos/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $archivoFinal = $userId . "_" . time() . "_" . basename($foto['name']);
        $rutaFinal = $targetDir . $archivoFinal;
        if (!move_uploaded_file($foto["tmp_name"], $rutaFinal)) {
            echo "Hubo un error al subir la imagen.";
            return;
        }

        (new UserModel())->guardarFoto($userId, $archivoFinal);
        header("Location: /lingua_tunes_demo/user/edit");
        exit;
    }

    // --- Password recovery
    public function actionSolicitarRecuperacion() {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            if (!$email) $errores[] = "El email es obligatorio";
            $usuario = UserModel::findEmail($email);
            if (!$usuario) $errores[] = "No se encontró ningún usuario con ese email";

            if (empty($errores)) {
                $token = Controller::generarToken(16);
                UserModel::saveToken($usuario->id, $token);
                header("Location: /lingua_tunes_demo/user/resetPass&token=$token");
                exit;
            }
        }

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        Response::render($this->viewDir(__NAMESPACE__), 'solicitar_recuperacion', [
            'title' => 'Recuperar contraseña',
            'head' => $head,
            'header' => $header,
            'footer' => $footer,
            'errores' => $errores
        ]);
    }

    public function actionResetPass() {
        $token = $_GET['token'] ?? null;
        $user = UserModel::getUserByToken($token);
        if (!$user) $this->action404();

        $head = SiteController::head();
        $header = SiteController::header();
        $footer = SiteController::footer();
        Response::render($this->viewDir(__NAMESPACE__), "reset_pass", [
            'title' => "Cambiar Contraseña",
            'head' => $head,
            'header' => $header,
            'footer' => $footer,
            'token' => $token
        ]);
    }

    public function actionCambiarPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $token = $_POST['token'] ?? null;
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if ($password !== $password2) {
            echo "Las contraseñas no coinciden.";
            return;
        }

        $user = UserModel::getUserByToken($token);
        if (!$user) { echo "Token inválido."; return; }

        UserModel::changePassword($password, $token);
        session_destroy();
        echo "<script>alert('Contraseña actualizada correctamente'); window.location='/lingua_tunes_demo/user/login';</script>";
    }

    // --- Delete user (logical)
    public function actionDelete() {
        $this->authRequired();
        $userId = $_SESSION['id'] ?? null;
        if (!$userId) $this->action404();

        DataBase::query("UPDATE usuarios SET baja = 1 WHERE id = :id", [':id' => $userId]);
        session_unset();
        session_destroy();
        header("Location: /lingua_tunes_demo/user/login");
        exit;
    }

    // --- Static helpers
    public static function getUser($emailOrId) {
        return filter_var($emailOrId, FILTER_VALIDATE_EMAIL)
            ? UserModel::findEmail($emailOrId)
            : UserModel::findId($emailOrId);
    }

    public static function getUserByToken($token) {
        return UserModel::getUserByToken($token);
    }

    public static function checkActivo($userEmail) {
        $datos = UserModel::findEmail($userEmail);
        return $datos && $datos->baja == 0;
    }
}
