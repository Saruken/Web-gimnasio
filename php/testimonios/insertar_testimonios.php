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
                
                echo "<h1>Insertar Testimonios</h1>
                <form action='#' method='post' enctype='multipart/form-data' class='insertar'>
                    <label for='id'>Id</label>";

                    $id=getId("club","testimonio");
                    echo "<input type='text' name='id' maxlength='20' disabled value='$id'>
                    <label for='autor'>Autor</label>
                    <select name='autor'>
                        <option value='' hidden disabled selected>-----------------------------------</option>";

                        $conexion=conectarServidor();
                        $consulta=$conexion->query("select id,nombre from socio where id!=0");
                        while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='$fila[id]'>$fila[nombre]</option>";
                        }
                        $conexion->close();

                    echo "</select>
                    <label for='contenido'>Contenido</label>
                    <textarea class='largo' name='contenido' cols='55' rows='10' maxlength='200'></textarea>
                    <input type='submit' name='enviar' class='enviar'>
                </form>";

                if(isset($_POST['enviar'])){
                    if(!($_POST['autor']=="" || trim($_POST['contenido'])=="")){
                        require_once "../funciones.php";
                        $conexion=conectarServidor();
                        $consulta=$conexion->prepare("select count(*) from testimonio where autor=? and fecha=?");

                        $autor=$_POST['autor'];
                        $contenido=$_POST['contenido'];
                        $anio=getdate()['year'];
                        $mes=getdate()['mon'];
                        $dia=getdate()['mday'];
                        $fecha="$anio-$mes-$dia";

                        $consulta->bind_param("is",$autor,$fecha);
                        $consulta->bind_result($cantidad);
                        $consulta->execute();
                        $consulta->fetch();

                        if($cantidad=="0"){
                            $consulta->close();
                            
                            $insercion=$conexion->prepare("insert into testimonio (autor,contenido,fecha) values (?,?,?)");
                            $insercion->bind_param("iss",$autor,$contenido,$fecha);
                            $insercion->execute();
                            $insercion->close();
                            echo "<p class='notificacion bien'>Testimonio insertado con éxito</p>";
                        }else{
                            echo "<p class='notificacion mal'>ERROR - Este testimonio ya se encuentra en la base de datos</p>";
                        }
                        $conexion->close();
                        header('Refresh: 2; URL=testimonios.php');
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