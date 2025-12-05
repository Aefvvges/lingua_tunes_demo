<!DOCTYPE html>
<html lang="en">
<head>
    <?= $head ?>
    <title>SolicitarRecuperacion</title>
</head>
<body>
    <?= $header?>
    <div class="container contenedor py-4 m-auto my-4">
        <form method="POST" class="flex">
            <label class="form-label">Email:</label>
            <input type="email" name="email" required>
            <button type="submit" class="btn boton">Enviar enlace</button>
            <a href="/lingua_tunes_demo/user/edit" class="btn boton boton-cancelar px-4">Cancelar</a>
        </form>           
    </div>
 
</body>
</html>

