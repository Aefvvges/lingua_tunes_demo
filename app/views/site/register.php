<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Registro</title>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>/img/logo.png" type="image/x-icon">
    <script src="<?= BASE_URL ?>/js/usuario.js" defer></script>
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

            <?php if (!empty($msg_correcto)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($msg_correcto) ?>
                </div>
            <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>index.php?url=sesion/register" class="form-1">
                    <div class="titulo-1 text-center"><h1>Registrate</h1></div>

                    <label for="usuario">Nombre de Usuario:</label>
                    <div class="campo-entrada">
                        <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['usuario'] ?? '' ?></div>

                    <label for="contrasena">Contraseña:</label>
                    <div class="campo-entrada">
                        <input type="password" name="contrasena" placeholder="Contraseña" id="bloquear-1" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['contrasena'] ?? '' ?></div>

                    <label for="contrasena_conf">Confirme su contraseña:</label>
                    <div class="campo-entrada">
                        <input type="password" name="contrasena_conf" placeholder="Contraseña" id="bloquear-2" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['contrasena_conf'] ?? '' ?></div>

                    <label for="nombre">Nombre:</label>
                    <div class="campo-entrada">
                        <input type="text" name="nombre" placeholder="Nombre" value="<?=htmlspecialchars($_POST['nombre'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['nombre'] ?? '' ?></div>

                    <label for="apellido">Apellido:</label>
                    <div class="campo-entrada">
                        <input type="text" name="apellido" placeholder="Apellido" value="<?=htmlspecialchars($_POST['apellido'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['apellido'] ?? '' ?></div>

                    <label for="email">Email:</label>
                    <div class="campo-entrada">
                        <input type="email" name="email" placeholder="Email" value="<?=htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['email'] ?? '' ?></div>

                    <label for="telefono">Teléfono:</label>
                    <div class="campo-entrada">
                        <input type="tel" name="telefono" placeholder="Teléfono" value="<?=htmlspecialchars($_POST['telefono'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['telefono'] ?? '' ?></div>

                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <div class="campo-entrada">
                        <input type="date" name="fecha_nacimiento" value="<?=htmlspecialchars($_POST['fecha_nacimiento'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="form-error"><?= $errores['fecha_nacimiento'] ?? ''?></div>

                    <button type="submit" class="btn">Enviar</button>
                    <div class="text-center">¿Ya tienes cuenta? <a href="<?= BASE_URL ?>index.php?url=sesion/login">Inicia sesión</a></div>
                </form>
            </div>

            <div class="lado-2">
                <img src="<?= BASE_URL ?>/img/fondo-1.png" alt="Fondo azul">
            </div>
        </div>
    </main>
</body>
</html>