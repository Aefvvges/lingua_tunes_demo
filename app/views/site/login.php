<?php
// login.php
$errores = $errores ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión</title>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>/img/logo.png" type="image/x-icon">
</head>
<body>
<main>
    <div class="contenedor">
        <div class="lado-1">
            <form method="POST" action="<?= BASE_URL ?>index.php?url=sesion/login" class="form-1">
                <h1 class="titulo-1 text-center">Inicia Sesión</h1>

                <label for="usuario">Usuario:</label>
                <div class="campo-entrada">
                    <input type="text" name="usuario" placeholder="Usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                </div>
                <div class="form-error"><?= $errores['usuario'] ?? '' ?></div>

                <label for="contrasena">Contraseña:</label>
                <div class="campo-entrada">
                    <input type="password" name="contrasena" placeholder="Contraseña">
                </div>
                <div class="form-error"><?= $errores['contrasena'] ?? '' ?></div>

                <button type="submit" class="btn">Iniciar Sesión</button>
                <div class="text-center">¿No tenés cuenta? <a href="<?= BASE_URL ?>index.php?url=sesion/register" >Registrate aquí</a></div>
            </form>
        </div>

        <div class="lado-2">
            <img src="<?= BASE_URL ?>/img/fondo-2.png" alt="Fondo azul">
        </div>
    </div>
</main>
</body>
</html>
