<!DOCTYPE html>
<html lang="es">
<head>
    <?= $head ?>
    <title><?= htmlspecialchars($album->titulo) ?></title>
</head>
<body>
    <?= $header ?>

    <div class="container">
        <h1><?= htmlspecialchars($album->titulo) ?></h1>

        <p><strong>ID:</strong> <?= $album->id ?></p>

        <a href="<?= $path ?>/artist/show/<?= $album->artista_id ?>" class="btn boton">
            Ver Artista
        </a>

    <?= $footer ?>
</body>
</html>
