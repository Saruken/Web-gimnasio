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

                echo "<h1>Insertar Citas</h1>
                <form action='#' method='post' enctype='multipart/form-data' class='insertar'>
                    <label for='fecha'>Fecha</label>
                    <input type='date' name='fecha'>
                    <label for='hora'>Hora</label>
                    <input type='time' name='hora'>
                    <label for='socio'>Socio</label>
                    <select name='socio'>
                        <option value='' hidden disabled selected>-----------------------------------</option>";
        
                        $conexion=conectarServidor();
                        $consulta=$conexion->query("select id,nombre from socio where id!=0");
                        while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='$fila[id]'>$fila[nombre]</option>";
                        }
                        $conexion->close();
        
                echo "</select>
                    <label for=servicio'>Servicio</label>
                    <select name='servicio'>
                        <option value='' hidden disabled selected>-----------------------------------</option>";
        
                        $conexion=conectarServidor();
                        $consulta=$conexion->query("select id,descripcion from servicio");
                        while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='$fila[id]'>$fila[descripcion]</option>";
                        }
                        $conexion->close();
        
                echo "</select>
                    <input type='submit' name='enviar' class='enviar'>
                </form>";
        
                if(isset($_POST['enviar'])){
                    if(!($_POST['fecha']=="" || $_POST['hora']=="" || $_POST['socio']=="" || $_POST['servicio']=="")){
                        $fecha=$_POST['fecha'];
                        $hora=$_POST['hora'];
                        $amd=explode("-",$fecha);
                        $hm=explode(":",$hora);
                        $fecha_cita=mktime($hm[0],$hm[1],0,$amd[1],$amd[2],$amd[0]);
        
                        if($fecha_cita>time()){
                            $conexion=conectarServidor();
                            $consulta=$conexion->prepare("select count(*) from citas where socio=? and fecha=? and hora=?");
        
                            $socio=$_POST['socio'];
                            $servicio=$_POST['servicio'];
        
                            $consulta->bind_param("sss",$socio,$fecha,$hora);
                            $consulta->bind_result($cantidad);
                            $consulta->execute();
                            $consulta->fetch();
        
                            if($cantidad=="0"){
                                $consulta->close();
                                
                                $insercion=$conexion->prepare("insert into citas values (?,?,?,?)");
                                $insercion->bind_param("ssss",$socio,$servicio,$fecha,$hora);
                                $insercion->execute();
                                $insercion->close();
                                echo "<p class='notificacion bien'>Cita insertada con éxito</p>";
                            }else{
                                echo "<p class='notificacion mal'>ERROR - Este usuario ya tiene una cita asignada a esa fecha y hora en la base de datos</p>";
                            }
                            $conexion->close();
                            header('Refresh: 3; URL=citas.php');
                        }else{
                            echo "<p class='notificacion mal'>La fecha y hora no pueden ser anteriores a las actuales</p>";
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