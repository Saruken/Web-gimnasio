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

                echo "<h1>SOCIOS</h1>
                <div class='funcionalidades'>
                    <a href='insertar_socios.php'>Añadir socio</a>
                    <form  action='#' method='post' enctype='multipart/form-data'>
                        <input id='buscar' type='text' name='buscar' maxlength='50' placeholder='Nombre o teléfono'>
                        <input type='submit' name='enviar' value='Buscar'>
                    </form>
                </div>";

                $conexion=conectarServidor();

                echo "<table id='tabla_socios' class='con_mod'>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Usuario</th>
                            <th>Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>";
                
                if(isset($_POST['enviar'])){
                    $busqueda="%".$_POST['buscar']."%";
                    $consulta=$conexion->prepare("select * from socio where id!=0 and nombre like ? or telefono like ?");
                    $consulta->bind_param("ss",$busqueda,$busqueda);
                    $consulta->bind_result($id,$nombre,$edad,$usuario,$pass,$telefono,$foto);
                    $consulta->execute();        
                    $consulta->store_result();
                    if($consulta->num_rows>0){
                        while($consulta->fetch()){
                            echo "<tr>
                                <td>
                                    <img src='../../$foto' alt='$nombre'>
                                </td>
                                <td>$nombre</td>
                                <td>$edad</td>
                                <td>$usuario</td>
                                <td>$telefono</td>
                                <td>
                                    <a href='modificar_socios.php?id=$id' class='mod'>Modificar</a>
                                </td>
                            </tr>";
                        }
                    }else{
                        echo "<tr>
                            <td colspan=5 class='tabla_vacia'>No hay coincidencias</td>
                        </tr>";
                    }
                    $consulta->close();
                }else{
                    $consulta=$conexion->query("select * from socio where id!=0");
                    while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                        echo "<tr>
                            <td>
                                <img src='../../$fila[foto]' alt='$fila[nombre]'>
                            </td>
                            <td>$fila[nombre]</td>
                            <td>$fila[edad]</td>
                            <td>$fila[usuario]</td>
                            <td>$fila[telefono]</td>
                            <td>
                                <a href='modificar_socios.php?id=$fila[id]' class='mod'>Modificar</a>
                            </td>
                        </tr>";
                    }
                }

                echo "</tbody>
                </table>";

                $conexion->close();
                footer();
            }
        }
    ?>
</body>
</html>