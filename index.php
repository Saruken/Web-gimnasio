<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Deportivo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        require_once "php/funciones.php";
        inicio_sesion();
        crear_menu();
    ?>
        <div id="foto_inicio">
            <div>
                <h1><cite>La excelencia no es un acto de un día, sino un hábito. Tú eres lo que repites en muchas ocasiones.</cite></h1>
                <p>Shaquille O’Neal</p>
            </div>
            <a href="html/landing.html">La mejor calidad <i class='fa-solid fa-arrow-right'></i></a>
        </div>
        <section id="noti">
            <h2>Últimas Noticias</h2>
            <?php
                require_once "php/funciones.php";
                $conexion=conectarServidor("club");
                $hoy=getdate()['year']."-".getdate()['mon']."-".getdate()['mday'];
                $consulta=$conexion->query("select * from noticia where fecha_publicacion<='$hoy' order by fecha_publicacion desc limit 3 ");
                while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                    echo "<div class='ultima_noti'>
                        <div>
                            <img src='$fila[imagen]' alt=''>
                            <h3>$fila[titulo]</h3>
                        </div>
                        <p>".substr($fila['contenido'],0,500)."
                            <a href='php/noticias/mostrar_noticia.php?id=$fila[id]'>Mas info...</a>
                        </p>
                    </div>";
                }
            ?>
        </section>
        <section id="testi">
            <h2>Testimonios</h2>
            <?php
                require_once "php/funciones.php";
                $conexion=conectarServidor("club");
                $consulta=$conexion->query("select count(*) cantidad from testimonio");
                $cantidad=$consulta->fetch_array(MYSQLI_ASSOC);
                $fila=mt_rand(0,$cantidad['cantidad']-1);
                $consulta=$conexion->query("select nombre,contenido from testimonio,socio where autor=socio.id limit $fila,1");

                $testimonio=$consulta->fetch_array(MYSQLI_ASSOC);
                echo "<div>
                    <p>$testimonio[nombre]</p>
                    <p>\"$testimonio[contenido]\"</p>
                </div>";
            ?>
        </section>
        <section id="contacto">
            <h2>Contacto</h2>
            <form action="">
                <div>
                    <label for="">Nombre</label>
                    <br>
                    <input type="text">
                    <br>
                    <label for="">Correo</label>
                    <br>
                    <input type="email">
                </div>
                <br>
                <label for="">Mensaje</label>
                <br>
                <textarea name="" id="" cols="30" rows="10"></textarea>
                <input type="button" value="Enviar" name="enviar">
            </form>
        </section>
    </main>
    <footer>
        <div id="redes">
            <a href="">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div>
        <div>
            <p>Info - Support - Marketing</p>
            <p>Term of Use - Privacy Policy</p>
            <p>Ⓒ 2022 nombre</p>
        </div>
    </footer>
</body>
</html>