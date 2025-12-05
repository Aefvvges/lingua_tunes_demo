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
            <div class="contenedor-video">
                <div class="box-video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/A_MjCqQoLLA" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                        encrypted-media; gyroscope; picture-in-picture; web-share" loading="lazy" allowfullscreen></iframe>

                    <div class="texto-video d-flex flex-column gap-2">
                        <h2 class="fs-1">Hey Jude</h2>
                        <a href="#" class="boton-productor fs-4">The Beatles</a>
                        <a href="#" class="boton-artista fs-6">The Beatles</a>
                    </div>
                </div>

                <div class="info-video">
                    <a href="https://youtu.be/A_MjCqQoLLA" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" target="_blank"><i class="fas fa-music"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-spotify"></i></a>
                </div>
            </div>

            <div class="contenedor-video">
                <div class="box-video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/fJ9rUzIMcZQ" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                        encrypted-media; gyroscope; picture-in-picture; web-share" loading="lazy" allowfullscreen></iframe>

                    <div class="texto-video d-flex flex-column gap-2">
                        <h2 class="fs-1">Bohemian Rhapsody</h2>
                        <a href="#" class="boton-productor fs-4">Queen</a>
                        <a href="#" class="boton-artista fs-6">Queen</a>
                    </div>
                </div>

                <div class="info-video">
                    <a href="https://youtu.be/fJ9rUzIMcZQ" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" target="_blank"><i class="fas fa-music"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-spotify"></i></a>
                </div>
            </div>

            <div class="contenedor-video">
                <div class="box-video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/6R7g5hb3KUE" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                        encrypted-media; gyroscope; picture-in-picture; web-share" loading="lazy" allowfullscreen></iframe>

                    <div class="texto-video d-flex flex-column gap-2">
                        <h2 class="fs-1">Angie</h2>
                        <a href="#" class="boton-productor fs-4">The Rolling Stones</a>
                        <a href="#" class="boton-artista fs-6">The Rolling Stones</a>
                    </div>
                </div>

                <div class="info-video">
                    <a href="https://youtu.be/6R7g5hb3KUE" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" target="_blank"><i class="fas fa-music"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-spotify"></i></a>
                </div>
            </div>


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
