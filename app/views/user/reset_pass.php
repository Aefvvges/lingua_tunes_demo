<!DOCTYPE html>
<html lang="en">
<head>
    <?= $head ?>
    <title>SolicitarRecuperacion</title>
</head>
<body>
    <?= $header?>
    <div class="container contenedor py-4 m-auto my-4">
        <form method="POST" action="/lingua_tunes_demo/user/cambiarPassword">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <label class="form-label">Nueva contraseña:</label>
            <input type="password" name="password" required>

            <label class="form-label">Repetir contraseña:</label>
            <input type="password" name="password2" required>

            <button type="submit" class="btn boton">Cambiar contraseña</button>
        </form>
    </div>

</body>
</html>
