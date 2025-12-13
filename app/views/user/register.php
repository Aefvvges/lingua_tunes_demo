<!DOCTYPE html>
<html lang="es">
<head>
	<title>Registro</title>
    <?=$head?>
    <script src="js/usuario.js" defer></script>
</head>
<body>
    <main>
        <div class="contenedor">
            <div class="lado-1">
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul>
                            <?php foreach($errores as $key => $error): ?>
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

                <form method="POST" action="/lingua_tunes_demo/user/store" class="form-1">
                    <div class="titulo-1 text-center"><h1>Registrate</h1></div>

                    <label for="usuario">Nombre de Usuario:</label>
                    <div class="campo-entrada">
                        <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?= htmlspecialchars($data['usuario'] ?? '') ?>" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="contrasena">Contraseña:</label>
                    <div class="campo-entrada">
                        <input type="password" name="contrasena" placeholder="Contraseña" id="bloquear-1" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="contrasena_conf">Confirme su contraseña:</label>
                    <div class="campo-entrada">
                        <input type="password" name="contrasena_conf" placeholder="Contraseña" id="bloquear-2" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="nombre">Nombre:</label>
                    <div class="campo-entrada">
                        <input type="text" name="nombre" placeholder="Nombre" value="<?=htmlspecialchars($data['nombre'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="apellido">Apellido:</label>
                    <div class="campo-entrada">
                        <input type="text" name="apellido" placeholder="Apellido" value="<?=htmlspecialchars($data['apellido'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="email">Email:</label>
                    <div class="campo-entrada">
                        <input type="email" name="email" placeholder="Email" value="<?=htmlspecialchars($data['email'] ?? '') ?>" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="telefono">Teléfono:</label>
                    <div class="campo-entrada">
                        <input type="tel" name="telefono" placeholder="Teléfono" value="<?=htmlspecialchars($data['telefono'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>

                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <div class="campo-entrada">
                        <input type="date" name="fecha_nacimiento" value="<?=htmlspecialchars($data['fecha_nacimiento'] ?? '')?>" required>
                        <span class="text-danger">*</span>
                    </div>

                    <button type="submit" class="btn boton">Enviar</button>
                    <div class="text-center">¿Ya tienes cuenta? <a href="login">Inicia sesión</a></div>
                </form>
            </div>

            <div class="lado-2">
                <img src="/lingua_tunes_demo/public/img/fondo-1.png" alt="Fondo azul">
            </div>
        </div>
    </main>
</body>
</html>