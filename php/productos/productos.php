<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="../../app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        require_once "../funciones.php";
        inicio_sesion();
        crear_menu();

        echo "<h1>Productos</h1>
        <div class='funcionalidades'>";

            if(isset($_SESSION['usuario']) and $_SESSION['usuario']==="admin"){
                echo "<a href='insertar_productos.php'>Añadir producto</a>";
            }

        echo "<form action='#' method='post' enctype='multipart/form-data'>
                <input id='buscar' type='text' name='buscar' maxlength='100' placeholder='Nombre o precio'>
                <input type='submit' name='enviar' value='Buscar'>
            </form>
        </div>";
        
        $conexion=conectarServidor();

        if(isset($_SESSION['usuario']) and $_SESSION['usuario']==="admin"){
            $clase="con_mod";
        }else{
            $clase="sin_mod";
        }
        echo "<table id='tabla_productos' class='$clase'>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>";
        
        if(isset($_POST['enviar'])){
            $busqueda="%".$_POST['buscar']."%";
            $consulta=$conexion->prepare("select * from producto where nombre like ? or precio like ?");
            $consulta->bind_param("ss",$busqueda,$busqueda);
            $consulta->bind_result($id,$nombre,$precio);
            $consulta->execute();
            $consulta->store_result();
            if($consulta->num_rows>0){
                if(isset($_SESSION['usuario']) and $_SESSION['usuario']==="admin"){
                    while($consulta->fetch()){
                        echo "<tr>
                            <td>$nombre</td>
                            <td>$precio</td>
                            <td>
                                <a href='modificar_productos.php?id=$id' class='mod mod_prod'>Modificar</a>
                                <a href='modificar_productos.php?id=$id' class='mod mod_prod'>Borrar</a>
                            </td>
                        </tr>";
                    }
                }else{
                    while($consulta->fetch()){
                        echo "<tr>
                            <td>$nombre</td>
                            <td>$precio</td>
                        </tr>";
                    }
                }
            }else{
                echo "<tr>
                    <td colspan=5 class='tabla_vacia'>No hay coincidencias</td>
                </tr>";
            }
            
            $consulta->close();
        }else{
            $consulta=$conexion->query("select * from producto");
            if(isset($_SESSION['usuario']) and $_SESSION['usuario']==="admin"){
                while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                    echo "<tr>
                        <td>$fila[nombre]</td>
                        <td>$fila[precio]</td>
                        <td>
                            <a href='modificar_productos.php?id=$fila[id]' class='mod mod_prod'>Modificar</a>
                            <a href='borrar_productos.php?id=$fila[id]' class='mod mod_prod'>Borrar</a>
                        </td>
                    </tr>";
                }
            }else{
                while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                    echo "<tr>
                        <td>$fila[nombre]</td>
                        <td>$fila[precio]</td>
                    </tr>";
                }
            }
        }

        echo "</tbody>
        </table>";

        $conexion->close();
        footer();
    ?>
</body>
</html>