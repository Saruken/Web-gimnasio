<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="../../app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Deportivo</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        require_once "../funciones.php";
        inicio_sesion();
        crear_menu();
    ?>
    <main id="acceso">
        <a id="volver" href="../../index.php">
            <i class='fa-solid fa-arrow-left'></i>
        </a>
        <form action="#" method="post" enctype="multipart/form-data">
            <div>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario">
            </div>
            <div>
                <label for="pass">Contraseña:</label>
                <input type="password" name="pass">
            </div>
            <span>
                <input type="checkbox" name="abierto">
                <label for="abierto"> No cerrar sesión</label>
            </span>
            <br>
            <input type="submit" name="enviar" id="btn-entrar">
        </form>
        <?php
            if(isset($_COOKIE['sesion'])){
                session_decode($_COOKIE['sesion']);
                header('Refresh: 0; URL=../../index.php');
            }else if(isset($_POST['enviar'])){
                if(!($_POST['usuario']=="" || $_POST['pass']=="")){
                    $conexion=conectarServidor();
                    $consulta=$conexion->prepare("select count(*) from socio where usuario=? and pass=?");
                    $usuario=$_POST['usuario'];
                    $pass=md5(md5($_POST['pass']));

                    $consulta->bind_param("ss",$usuario,$pass);
                    $consulta->bind_result($cantidad);
                    $consulta->execute();
                    $consulta->fetch();

                    if($cantidad==0){
                        echo "<p class='notificacion mal'>ERROR - Usuario o contraseña incorrectos</p>";
                    }else{
                        $_SESSION['usuario']=$usuario;
                        if(isset($_POST['abierto'])){
                            $datos=session_encode();
                            setcookie('sesion',$datos,time()+(1*24*60*60),"/");
                        }
                        echo "<p class='notificacion bien'>Bienvenido $usuario</p>";
                        header('Refresh: 1.5; URL=../../index.php');
                    }
                    $conexion->close();
                }else{
                    echo "<p class='notificacion mal'>ERROR - Rellena todos los campos</p>";
                }
            }
        ?>
    </main>
</body>
</html>