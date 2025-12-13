<!DOCTYPE html>
<html lang="es">
<head>
    <?= $head ?>
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <?= $header ?>
    </header>

    <main class="container contenedor-about my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 text-center">
                <h1 class="mb-4 h1">Acerca de Lingua Tunes</h1>
                <p class="fs-5">
                    Lingua Tunes es una aplicación educativa diseñada para aprender idiomas mientras disfrutas de tu música favorita. 
                    Nuestra plataforma combina canciones clásicas y modernas con ejercicios interactivos que te permiten reforzar vocabulario, comprensión auditiva y expresión escrita.
                </p>
                <p class="fs-5">
                    Cada canción incluye información sobre el artista, el álbum y enlaces directos a YouTube y Spotify, para que puedas escuchar y aprender al mismo tiempo. 
                    Además, nuestros cuestionarios nivelatorios te ayudan a medir tu progreso de manera divertida y efectiva.
                </p>

                <h3 class="mt-5 h3 mb-3">Cómo funciona</h3>
                <ul class="list-group list-group-flush text-start mi-lista">
                    <li class="list-group-item">Elige una canción de nuestra biblioteca musical.</li>
                    <li class="list-group-item">Escucha la canción mientras lees la letra y traducciones si las hay.</li>
                    <li class="list-group-item">Responde los ejercicios nivelatorios para practicar vocabulario y comprensión.</li>
                    <li class="list-group-item">Sigue tu progreso y descubre nuevas canciones adaptadas a tu nivel de idioma.</li>
                </ul>

                <div class="mt-5">
                    <a href="<?= $path ?>home/index" class="btn boton">Volver al inicio</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-5">
        <?= $footer ?>
    </footer>
</body>
</html>
