<!DOCTYPE html>
<html lang="es">
<head>
    <?= $head ?>
    <title><?= htmlspecialchars($artista->nombre) ?></title>
</head>
<body>

<?= $header ?>

<main class="container mt-4">

    <h1><?= htmlspecialchars($artista->nombre) ?></h1>
    <p class="text-muted">País: <?= htmlspecialchars($artista->pais) ?></p>

    <h3 class="mt-4">Álbumes</h3>

    <?php if (!empty($albumes)): ?>
        <ul class="list-group">
            <?php foreach($albumes as $album): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($album->titulo) ?></span>

                    <a href="<?= $path ?>album/show/<?= $album->id ?>" class="btn btn-sm boton">
                        Ver
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Este artista no tiene álbumes cargados.</p>
    <?php endif; ?>

</main>

<?= $footer ?>

</body>
</html>
