<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iniciar Sesión</title>
    <?=$head?>
</head>
<body>
<main>
    <div class="contenedor">
        <div class="lado-1">
                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            <form method="POST" action="/lingua_tunes_demo/user/login" class="form-1">
                <h1 class="titulo-1 text-center">Inicia Sesión</h1>

                <label for="usuario">Usuario:</label>
                <div class="campo-entrada">
                    <input type="text" name="usuario" placeholder="Usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                </div>

                <label for="contrasena">Contraseña:</label>
                <div class="campo-entrada">
                    <input type="password" name="contrasena" placeholder="Contraseña">
                </div>

                <button type="submit" class="btn boton">Iniciar Sesión</button>
                <div class="text-center">¿No tenés cuenta? <a href="register" >Registrate aquí</a></div>
            </form>
        </div>

        <div class="lado-2">
            <img src="/lingua_tunes_demo/public/img/fondo-2.png" alt="Fondo azul">
        </div>
    </div>
</main>
</body>
</html>
