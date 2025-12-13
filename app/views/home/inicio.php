<!DOCTYPE html>
<html lang="es">
<head>
    <?=$head?>
    <title>Lingua Tunes</title>
</head>
<body>
    <header>
        <?=$header?>
    </header>
    <main>
     
        <div class="container mt-4 col-12 m-0">
            <div class="row">           
                <div class="col-md-8 d-flex flex-column align-items-center">
                    <?php foreach($canciones as $musica): ?>
                    <div class="contenedor-video">
                        <div class="box-video">
                            <iframe width="560" height="315" 
                                src="https://www.youtube.com/embed/<?= htmlspecialchars($musica->youtube_id) ?>" 
                                title="YouTube video player" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                loading="lazy" allowfullscreen>
                            </iframe>

                            <div class="texto-video d-flex flex-column gap-2">
                                <h2 class="fs-1"><?= htmlspecialchars($musica->cancion) ?></h2>
                                <a href="<?= $path ?>artist/show/<?= $musica->artista_id ?>" class="boton-artista fs-4">
                                    <?= htmlspecialchars($musica->artista) ?>
                                </a>
                                <a href="<?= $path ?>album/show/<?= $musica->album_id ?>" class="boton-album fs-6">
                                    <?= htmlspecialchars($musica->album) ?>
                                </a>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>


            </div>
            <!-- Puedes añadir más filas y columnas aquí -->
        </div>
    </main>
    <footer>
        <?= $footer?>
    </footer>
    

</body>
</html>
