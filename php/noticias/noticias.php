<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" defer src="noticias.js"></script>
    <script type="text/javascript" defer src="../../app.js"></script>
</head>
<body>
    <div id="cargando">
        <img src="https://media.tenor.com/wpSo-8CrXqUAAAAi/loading-loading-forever.gif">
        <h2>Cargando</h2>
    </div>
    <?php
        require_once "../funciones.php";
        inicio_sesion();

        if(!isset($_SESSION['usuario'])){
            header('Refresh: 0; URL=../acceso/acceso.php');
        }else{
            if($_SESSION['usuario']!=="admin"){
                denegado();
            }else{
                crear_menu();

                echo "<h1>NOTICIAS</h1>
                <div class='funcionalidades funcionalidad'>
                    <a href='insertar_noticias.php'>Añadir noticia</a>
                </div>
                <div id='noticiero'>

                </div>
                <div class='pasar_pagina'>
                    <a id='anterior' href=''><i class='fa-solid fa-arrow-left'></i> <span>Anterior</span></a>
                    <a id='siguiente' href='noticias.php?pagina='><span>Siguiente</span> <i class='fa-solid fa-arrow-right'></i></a>
                </div>";

                footer();
            }
        }
    ?>
</body>
</html>