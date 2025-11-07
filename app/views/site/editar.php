<?php
require_once '../controllers/SesionControlador.php';
require_once '../models/Usuario.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sesion = new Sesion();
$usuarioModel = new Usuario();

$token = $_GET['token'] ?? '';

if ($token !== $_SESSION['token']) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso no autorizado.");
}

if (!$sesion->estaLogueado()) {
    header("Location sesion.php");
    exit;
}

$id = $sesion->getDatosUsuario()['id'];
$usuario = $usuarioModel->obtenerPorId($id);
if (!$usuario) {
    die("Usuario no encontrado o sin permiso");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../../public/css/reset.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="shortcut icon" href="../../public/img/logo.png" type="image/x-icon">
</head>
<header>
    <div class="botones-h">
        <input type="search" name="buscar" placeholder="buscar"><button class="btn-h b-3"></button>
        <button class="btn-h b-1" onclick="window.location.href='listado.php'"></button>
        <button class="btn-h b-2" onclick="window.location.href='listado.php'"></button>
    </div>
    
</header>
<body>
    <main>
        <div class="contenedor">
            <div class="lado-1">
                <form method="POST" action="../controller/UsuarioControlador.php" class="form-1">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>">
                    <div class="form-error"><?= $errores['usuario'] ?? '' ?></div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>">
                    <div class="form-error"><?= $errores['nombre'] ?? '' ?></div>
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>">
                    <div class="form-error"><?= $errores['apellido'] ?? '' ?></div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>">
                    <div class="form-error"><?= $errores['email'] ?? '' ?></div>
                    <label for="telefono">Telefono:</label>
                    <input type="tel" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>">
                    <div class="form-error"><?= $errores['telefono'] ?? '' ?></div>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($usuario['fecha_nacimiento']) ?>">
                    <div class="form-error"><?= $errores['fecha_nacimiento'] ?? '' ?></div>
                    <button type="submit" name="accion" value="editar" class="btn">Guardar cambios</button>
                    <a href="listado.php" class="btn centrar-texto">Cancelar</a>
                </form>                
            </div>
            <div class="lado-2">
                <img src="../../public/img/fondo-2.png" alt="Fondo azul">
            </div>
        </div>

    </main>
</body>
</html>
