<!DOCTYPE html>
<html lang="en">
<head>
    <?=$head?>
    <title>Perfil</title>
</head>
<body>
    <?=$header?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Tarjeta de perfil -->
            <div class="tarjeta-perfil card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <!-- Encabezado -->
                    <div class="d-flex align-items-center mb-4">

                        <div class="text-center mb-4">
                            <img src="<?= $rutaFoto ?>" 
                                alt="Foto de perfil" 
                                class="rounded-circle border"
                                style="width: 150px; height: 150px; object-fit: cover;"
                            >
                        </div>

                        <div class="ms-3">
                            <h4 class="mb-1"><?= htmlspecialchars($usuario->nombre . " " . $usuario->apellido) ?></h4>
                            <p class="text-muted mb-0">@<?= htmlspecialchars($usuario->usuario) ?></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Información personal -->
                    <h5 class="mb-3">Información personal</h5>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Nombre:</div>
                        <div class="col-sm-8"><?= htmlspecialchars($usuario->nombre) ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Apellido:</div>
                        <div class="col-sm-8"><?= htmlspecialchars($usuario->apellido) ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Email:</div>
                        <div class="col-sm-8"><?= htmlspecialchars($usuario->email) ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Teléfono:</div>
                        <div class="col-sm-8"><?= htmlspecialchars($usuario->telefono) ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Fecha de nacimiento:</div>
                        <div class="col-sm-8">
                            <?= date('d/m/Y', strtotime($usuario->fecha_nacimiento)) ?>
                        </div>
                    </div>

                    <hr>

                    <!-- Botón Editar -->
                    <div class="text-end">
                        <a href="edit&id=<?= $usuario->id ?>" class="btn boton px-4">
                            Editar perfil
                        </a>
                        <a href="delete" 
                        onclick="return confirm('¿Estás seguro de que querés eliminar tu perfil? Esta acción no se puede deshacer.');" 
                        class="btn boton boton-eliminar">
                        Eliminar Perfil
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<footer> <?= $footer?></footer>
</body>
</html>
