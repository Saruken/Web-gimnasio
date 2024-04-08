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

                echo "<h1>Insertar Productos</h1>
                <form action='#' method='post' enctype='multipart/form-data' class='insertar'>
                    <label for='id'>Id</label>";
        
                    $id=getId("club","producto");
                    echo "<input type='text' name='id' maxlength='20' disabled value='$id'>";
        
                echo "<label for='nombre'>Nombre</label>
                    <textarea name='nombre' maxlength='100' cols='30' rows='2'></textarea>
                    <label for='precio'>Precio</label>
                    <input class='numero' type='number' name='precio' min='0' max='999.99' step='0.01'>
                    <input type='submit' name='enviar' class='enviar'>
                </form>";
        
                if(isset($_POST['enviar'])){
                    if(!(trim($_POST['nombre'])=="" || $_POST['precio']=="")){
                        $conexion=conectarServidor();
                        $consulta=$conexion->prepare("select count(*) from producto where nombre=?");
        
                        $nombre=$_POST['nombre'];
                        $precio=$_POST['precio'];
        
                        $consulta->bind_param("s",$nombre);
                        $consulta->bind_result($cantidad);
                        $consulta->execute();
                        $consulta->fetch();
        
                        if($cantidad=="0"){
                            $consulta->close();
                            
                            $insercion=$conexion->prepare("insert into producto (nombre,precio) values (?,?)");
                            $insercion->bind_param("sd",$nombre,$precio);
                            $insercion->execute();
                            $insercion->close();
                            echo "<p class='notificacion bien'>Producto insertado con éxito</p>";
                        }else{
                            echo "<p class='notificacion mal'>ERROR - Este producto ya se encuentra en la base de datos</p>";
                        }
                        $conexion->close();
                        header('Refresh: 2; URL=productos.php');
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