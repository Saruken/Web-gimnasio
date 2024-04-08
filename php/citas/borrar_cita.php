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

                $fecha=$_GET['fecha'];
                $hora=$_GET['hora'];
                $socio=$_GET['socio'];
        
                echo "<h1>¿Deseas borrar esta cita?</h1>
                <form action='#' method='post' enctype='multipart/form-data' class='insertar'>
                    <label for='fecha'>Fecha</label>
                    <input type='date' name='fecha' value='$fecha' disabled class='numero'>
                    <label for='hora'>Hora</label>
                    <input type='time' name='hora' value='$hora' disabled class='numero'>
                    <label for='socio'>Socio</label>
                    <input type='text' name='socio' value='$socio' disabled>
                    <label for='servicio'>Servicio</label>";
        
                    $conexion=conectarServidor();
                    $consulta=$conexion->query("select id from servicio,citas where id=servicio and hora='$hora' and fecha='$fecha' and socio=$socio");
                    $fila=$consulta->fetch_array(MYSQLI_ASSOC);
                    $servicio=$fila['id'];
                    echo "<input type='text' name='servicio' value='$servicio' disabled>";
                    $conexion->close();
        
                echo "<input type='submit' name='enviar' value='Borrar' class='enviar'>
                </form>";
        
                if(isset($_POST['enviar'])){
                    $amd=explode("-",$fecha);
                    $hm=explode(":",$hora);
                    $fecha_cita=mktime($hm[0],$hm[1],0,$amd[1],$amd[2],$amd[0]);
        
                    if($fecha_cita>time()){
                        $conexion=conectarServidor();
                        $consulta=$conexion->prepare("select count(*) from citas where socio=? and fecha=? and hora=? and servicio=?");
        
                        $consulta->bind_param("issi",$socio,$fecha,$hora,$servicio);
                        $consulta->bind_result($cantidad);
                        $consulta->execute();
                        $consulta->fetch();
        
                        if($cantidad=="1"){
                            $consulta->close();
                            
                            $borrado=$conexion->prepare("delete from citas where fecha=? and hora=? and socio=?");
                            $borrado->bind_param("sss",$fecha,$hora,$socio);
                            $borrado->execute();
                            $borrado->close();
                            echo "<p class='notificacion bien'>Cita borrada con éxito</p>";
                        }else{
                            echo "<p class='notificacion mal'>ERROR - Esta cita no existe</p>";
                        }
                        $conexion->close();
                        header('Refresh: 3; URL=citas.php');
                    }else{
                        echo "<p class='notificacion mal'>Imposible borrar esta cita</p>";
                    }
                }
                footer();
            }
        }
    ?>
</body>
</html>