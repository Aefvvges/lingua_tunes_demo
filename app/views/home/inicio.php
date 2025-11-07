<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Lingua Tunes</title>
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/a5b75171a2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reset.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>/img/logo.png" type="image/x-icon">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand p-0" href="#"><img src="<?= BASE_URL ?>/img/logo.png" style="width: 50px;" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Acerca</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Artista</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Album</a>
                    </li>
                </ul>
                </div>
            </div>
            </nav>
    </header>
    <main>
        <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario'] ?? 'Invitado') ?></h1>
        
     
        <div class="container mt-4 col-12 m-0">
            <div class="row">
            <div class="col-md-4 col-2 bg-primary">
            <!-- Contenido de una columna lateral -->
               <aside>
                <p>costadito</p>
               </aside> 
            </div>               
            <div class="col-md-8 col-10 d-flex align-items-center">
                <div class="contenedor-video">
                    <div class="box-video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/fGizrX4JjPg?si=Y4-cuF__CS1s3ioL" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                        encrypted-media; gyroscope; picture-in-picture; web-share" loading="lazy" allowfullscreen></iframe>

                        <div class="texto-video d-flex flex-column gap-2">
                            <h2 class="fs-1">Binomi</h2>
                            <a href="./producer.html#maretu" class="boton-productor fs-4">Maretu</a>
                            <a href="./artist.html#miku" class="boton-artista fs-6">Hatsune Miku</a>
                        </div>
                    </div>

                    <div class="info-video">
                        <a href="https://music.youtube.com/watch?v=_2ly7nbxGlI" target="_blank"><i class="fas fa-music"></i></a>
                        <a href="https://open.spotify.com/track/03Gwcfwn1jf6odu3ZOQv1V" target="_blank"><i class="fa-brands fa-spotify"></i></a>
                        <a href="https://youtu.be/fGizrX4JjPg" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

            </div>

            </div>
            <!-- Puedes añadir más filas y columnas aquí -->
        </div>
    </main>
    <footer>
        <a href="<?= BASE_URL ?>index.php?url=sesion/logout" class="btn btn-cerrar">Cerrar sesión</a>
    </footer>
    

</body>
</html>
