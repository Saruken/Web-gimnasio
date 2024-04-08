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
                echo "<h1>Borrar Producto</h1>";

                $id=$_GET['id'];
                $datos=getAll("club","producto","$id");
        
                echo "<form action='#' method='post' enctype='multipart/form-data' class='modificar'>
                    <label for='id'>Id</label>
                    <input type='text' name='id' value='$id' disabled>
                    <label for='nombre'>Nombre</label>
                    <textarea name='nombre' maxlength='100' cols='30' rows='2' disabled>$datos[nombre]</textarea>
                    <label for='precio'>Precio</label>
                    <input class='numero' type='number' name='precio' value=$datos[precio] min='0' max='999.99' step='0.01' disabled>
                    <input type='submit' name='enviar' class='enviar' value='Borrar'>
                </form>";
        
                if(isset($_POST['enviar'])){
                    $conexion=conectarServidor();
                    $consulta=$conexion->prepare("select count(*) from producto where id=?");
        
                    $consulta->bind_param("i",$id);
                    $consulta->bind_result($cantidad);
                    $consulta->execute();
                    $consulta->fetch();
        
                    if($cantidad=="1"){
                        $consulta->close();
                        
                        $borrado=$conexion->prepare("delete from producto where id=?");
                        $borrado->bind_param("i",$id);
                        $borrado->execute();
                        $borrado->close();
                        echo "<p class='notificacion bien'>Producto borrado con éxito</p>";
                    }else{
                        echo "<p class='notificacion mal'>ERROR - Esta producto no existe</p>";
                    }
                    $conexion->close();
                    header('Refresh: 2; URL=productos.php');
                }
                footer();
            }
        }
    ?>
</body>
</html>