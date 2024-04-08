<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="../../app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socios</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
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

                echo "<h1>Insertar Noticias</h1>
                <form action='#' method='post' enctype='multipart/form-data' class='insertar'>
                    <label for='id'>Id</label>";

                    $id=getId("club","noticia");
                    echo "<input type='text' name='id' maxlength='20' disabled value='$id'>";

                echo "<label for='titulo'>Titulo</label>
                    <input class='grande' type='text' name='titulo' maxlength='100'>
                    <label for='contenido'>Contenido</label>
                    <textarea class='grande' name='contenido' cols='80' rows='16' maxlength='2000'></textarea>
                    <label for='foto'>Foto</label>
                    <input type='file' name='foto'>
                    <label for='fecha'>Fecha</label>
                    <input type='date' name='fecha'>
                    <input type='submit' name='enviar' class='enviar'>
                </form>";

                if(isset($_POST['enviar'])){
                    if(!(trim($_POST['titulo'])=="" || trim($_POST['contenido'])=="" || $_POST['fecha']=="" || $_FILES['foto']['tmp_name']=="")){
                        $formato=explode("/",$_FILES['foto']['type']);

                        if($formato[0]!=="image"){
                            echo "<p class='notificacion mal'>El archivo debe de ser una foto</p>";
                        }else{
                            $conexion=conectarServidor();
                            $consulta=$conexion->prepare("select count(*) from noticia where titulo=? and fecha_publicacion=?");

                            $titulo=$_POST['titulo'];
                            $contenido=$_POST['contenido'];
                            $fecha=$_POST['fecha'];
                            $foto=$_FILES['foto']['tmp_name'];
                            $ruta="img/noticias/noticia$id.$formato[1]";

                            $consulta->bind_param("ss",$titulo,$fecha);
                            $consulta->bind_result($cantidad);
                            $consulta->execute();
                            $consulta->fetch();

                            if($cantidad=="0"){
                                $consulta->close();
                                
                                $insercion=$conexion->prepare("insert into noticia (titulo,contenido,imagen,fecha_publicacion) values (?,?,?,?)");
                                $insercion->bind_param("ssss",$titulo,$contenido,$ruta,$fecha);
                                $insercion->execute();
                                $insercion->close();
                                echo "<p class='notificacion bien'>Noticia insertada con éxito</p>";
                                move_uploaded_file($foto,"../../$ruta");
                            }else{
                                echo "<p class='notificacion mal'>ERROR - Esta noticia ya se encuentra en la base de datos</p>";
                            }
                            $conexion->close();
                            header('Refresh: 2; URL=noticias.php');
                        }
                    }else{
                        echo "<p class='notificacion mal'>ERROR - Se deben de rellenar todos los campos</p>";
                    }
                }
                footer();
            }
        }
    ?>
</body>
</html>