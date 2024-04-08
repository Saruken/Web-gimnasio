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

                echo "<h1>Insertar Socios</h1>
                <form action='#' method='post' enctype='multipart/form-data' class='insertar'>
                    <label for='id'>Id</label>";

                    $id=getId("club","socio");
                    echo "<input type='text' name='id' maxlength='20' disabled value='$id'>";

                echo "<label for='nombre'>Nombre</label>
                    <input type='text' name='nombre' maxlength='50'>
                    <label for='edad'>Edad</label>
                    <input class='numero' type='number' name='edad' min='0' max='99'>
                    <label for='usuario'>Usuario</label>
                    <input type='text' name='usuario' maxlength='20'>
                    <label for='pass'>Contraseña</label>
                    <input type='password' name='pass' maxlength='20'>
                    <label for='tlf'>Teléfono</label>
                    <input type='tel' name='tlf' maxlength='9'>
                    <label for='foto'>Foto</label>
                    <input type='file' name='foto'>
                    <input type='submit' name='enviar' class='enviar'>
                </form>";

                if(isset($_POST['enviar'])){
                    if(!(trim($_POST['nombre'])=="" || $_POST['edad']=="" || trim($_POST['usuario'])=="" || trim($_POST['pass'])=="" || trim($_POST['tlf'])=="" || $_FILES['foto']['tmp_name']=="")){
                        $tlf=$_POST['tlf'];
                        $formato=explode("/",$_FILES['foto']['type']);
                        $correcto=true;
                        
                        if(!preg_match("`\d{9}`",$tlf)){
                            echo "<p class='notificacion mal'>El número de teléfono debe ser de 9 dígitos</p>";
                            $correcto=false;
                        }

                        if(!($formato[0]=="image") and $correcto){
                            echo "<p class='notificacion mal'>El archivo debe de ser una foto</p>";
                            $correcto=false;
                        }

                        if($correcto){
                            $conexion=conectarServidor();
                            $consulta=$conexion->prepare("select count(*) from socio where usuario=?");

                            $nombre=$_POST['nombre'];
                            $edad=$_POST['edad'];
                            $usuario=$_POST['usuario'];
                            $pass=md5(md5($_POST['pass']));
                            $foto=$_FILES['foto']['tmp_name'];
                            $ruta="img/usuarios/$usuario.$formato[1]";

                            $consulta->bind_param("s",$usuario);
                            $consulta->bind_result($cantidad);
                            $consulta->execute();
                            $consulta->fetch();

                            if($cantidad=="0"){
                                $consulta->close();
                                
                                $insercion=$conexion->prepare("insert into socio (nombre,edad,usuario,pass,telefono,foto) values (?,?,?,?,?,?)");
                                $insercion->bind_param("sissss",$nombre,$edad,$usuario,$pass,$tlf,$ruta);
                                $insercion->execute();
                                $insercion->close();
                                echo "<p class='notificacion bien'>Socio insertado con éxito</p>";
                                move_uploaded_file($foto,"../../$ruta");
                            }else{
                                if($usuario=="admin"){
                                    echo "<p class='notificacion mal'>ERROR - Usuario no válido</p>";
                                }else{
                                    echo "<p class='notificacion mal'>ERROR - Este usuario ya se encuentra en la base de datos</p>";
                                }
                            }
                            $conexion->close();
                            header('Refresh: 2; URL=socios.php');
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