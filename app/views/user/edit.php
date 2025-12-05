<?php
$usuario = $usuario ?? null;
if (!$usuario) {
    echo "<p>No se encontró el usuario.</p>";
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?=$head?>
    <title>Editar perfil</title>
</head>
<body>
    <?=$header?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="tarjeta-perfil card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

            <?php
            // Obtener la foto si existe
            $fotoPerfil = $foto ?? $path.'img/uploads/profile_photos/default.png';
            ?>

            <div class="profile-photo mb-3 text-center">
                <div class="rounded-circle bg-primary text-white d-flex m-auto justify-content-center align-items-center"
                    style="width: 150px; height: 150px; font-size: 32px; overflow: hidden; position: relative;">
                    <img src="<?= $rutaFoto ?>" alt="Foto de perfil"
                        class="rounded-circle" style="width:100%; height:100%; object-fit:cover;">
                </div>
                
                <!-- Formulario para subir nueva foto -->
                <form action="/lingua_tunes_demo/user/updatePhoto" method="POST" enctype="multipart/form-data" class="mt-2">
                    <input type="file" name="photo" accept="image/*" required style="display:none;" id="photoInput">
                    <button type="button" class="btn boton btn-sm" onclick="document.getElementById('photoInput').click();">
                        Cambiar foto
                    </button>
                    <button type="submit" class="btn boton boton-subir btn-sm">Subir</button>
                </form>
            </div>


                    <?php if (!empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul>
                            <?php foreach($errores as $key => $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>


                    <form action="<?= $path ?>user/edit" method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Nombre de usuario</label>
                            <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($usuario->usuario) ?>" required>
                        </div>
                            
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario->nombre) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($usuario->apellido) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario->email) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($usuario->telefono) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($usuario->fecha_nacimiento) ?>" required>
                        </div>

                        <div class="mb-3">
                            <a href="SolicitarRecuperacion" class="btn boton boton-eliminar">
                                Cambiar Contraseña
                            </a>

                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn boton px-4">Guardar cambios</button>
                            <a href="profile" class="btn boton boton-cancelar px-4">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
