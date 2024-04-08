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
            if($_SESSION['usuario']=="admin"){
                denegado();
            }else{
                crear_menu();

                $usuario=$_SESSION['usuario'];
                $conexion=conectarServidor();
                $consulta=$conexion->query("select id from socio where usuario='$usuario'");
                $num=$consulta->fetch_array(MYSQLI_ASSOC);
                $id=$num['id'];

                if($id!=0){
                    echo "<h1>Datos Personales</h1>";
                    $datos=getAll("club","socio","$id");
        
                    echo "<img class='imagen_mod' src='../../$datos[foto]' alt='$datos[nombre]'>
                    <form action='#' method='post' enctype='multipart/form-data' class='modificar'>
                        <label for='nombre'>Nombre</label>
                        <input type='text' name='nombre' value='$datos[nombre]' maxlength='50' disabled>
                        <label for='edad'>Edad</label>
                        <input class='numero' type='number' name='edad' value='$datos[edad]' min='0' max='99' disabled>
                        <label for='usuario'>Usuario</label>
                        <input type='text' name='usuario' value='$datos[usuario]' maxlength='20' disabled>
                        <label for='pass'>Contraseña</label>
                        <input type='password' name='pass' value='' placeholder='Introduce una contraseña' maxlength='32'>
                        <label for='tlf'>Teléfono</label>
                        <input type='tel' name='tlf' value='$datos[telefono]' maxlength='9'>
                        <label for='foto'>Foto</label>
                        <input type='file' name='foto'>
                        <input type='submit' name='enviar' class='enviar'>
                    </form>";
                }else{
                    echo "<p class='notificacion mal'>ERROR - Socio no válido</p>";
                }
        
                if(isset($_POST['enviar'])){
                    if(trim($_POST['tlf'])!==""){
                        $tlf=$_POST['tlf'];
                        $correcto=true;
                        $nueva_img=false;
                        
                        if(!preg_match("`\d{9}`",$tlf)){
                            echo "<p class='notificacion mal'>El número de teléfono debe ser de 9 dígitos</p>";
                            $correcto=false;
                        }
                        
                        if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                            $formato=explode("/",$_FILES['foto']['type']);
                            if(!($formato[0]=="image") and $correcto){
                                echo "<p class='notificacion mal'>El archivo debe de ser una foto</p>";
                                $correcto=false;
                            }else{
                                $nueva_img=true;
                            }
                        }

                        if($correcto){
                            $conexion=conectarServidor();
                            $consulta=$conexion->prepare("select count(*) from socio where usuario=? and id!=?");
        
                            if($nueva_img){
                                $foto=$_FILES['foto']['tmp_name'];
                                $ruta="img/usuarios/$usuario.$formato[1]";
                            }
        
                            $consulta->bind_param("si",$usuario,$id);
                            $consulta->bind_result($cantidad);
                            $consulta->execute();
                            $consulta->fetch();
        
                            if($cantidad=="0"){
                                $consulta->close();
                                $pass;
                                if(trim($_POST['pass'])==""){
                                    $conexion=conectarServidor();
                                    $consulta=$conexion->prepare("select pass from socio where usuario=? and id=?");
                                    $consulta->bind_param("si",$usuario,$id);
                                    $consulta->bind_result($contra);
                                    $consulta->execute();
                                    $consulta->fetch();
                                    $pass=$contra;
                                    $consulta->close();
                                }else{
                                    $pass=md5(md5($_POST['pass']));
                                }

                                if($nueva_img){
                                    $insercion=$conexion->prepare("update socio set pass=?,telefono=?,foto=? where id=$id");
                                    $insercion->bind_param("sss",$pass,$tlf,$ruta);
                                    unlink("../../$datos[foto]");
                                    move_uploaded_file($foto,"../../$ruta");
                                }else{
                                    $formato=explode(".",$datos['foto']);
                                    $extension=$formato[count($formato)-1];
                                    $nueva_ruta="img/usuarios/$usuario.$extension";
                                    $insercion=$conexion->prepare("update socio set pass=?,telefono=?,foto=? where id=$id");
                                    $insercion->bind_param("sss",$pass,$tlf,$nueva_ruta);
                                    rename("../../$datos[foto]","../../$nueva_ruta");
                                }
                                $insercion->execute();
                                $insercion->close();
                                echo "<p class='notificacion bien'>Socio modificado con éxito</p>";
                            }else{
                                echo "<p class='notificacion mal'>ERROR - Campo usuario duplicado en la base de datos</p>";
                            }
                            $conexion->close();
                            header('Refresh: 2; URL=../../index.php');
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