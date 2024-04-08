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

        if(!isset($_SESSION['usuario'])){
            header('Refresh: 0; URL=../acceso/acceso.php');
        }else{
            echo "<div id='acceso'>
                <a id='volver' href='../../index.php'>
                    <i class='fa-solid fa-arrow-left'></i>
                </a>
                <form action='#' method='post' enctype='multipart/form-data'>
                    <label for='enviar'>¿Desea cerrar la sesión?</label>
                    <input type='submit' name='enviar' id='btn-entrar'>
                </form>";

                if(isset($_POST['enviar'])){
                    if(isset($_COOKIE['sesion'])){
                        setcookie('sesion',session_encode(),time()-3600,"/");
                    }
                    $_SESSION=array();
                    session_destroy();
                    echo "<p class='notificacion bien'>Sesión cerrada con éxito</p>";
                    header('Refresh: 1.5; URL=../../index.php');
                }
                
            echo '</div>';
        }
    ?>
</body>
</html>