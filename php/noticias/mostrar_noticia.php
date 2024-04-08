<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="../../app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        require_once "../funciones.php";
        inicio_sesion();

        $conexion=conectarServidor();
        $hoy=getdate()['year']."-".getdate()['mon']."-".getdate()['mday'];
        $consulta=$conexion->query("select id from noticia where fecha_publicacion<='$hoy' order by fecha_publicacion desc limit 3 ");
        $noticias_disponibles=[];
        while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
            $noticias_disponibles[]=$fila['id'];
        }

        $id=$_GET['id'];
        if(in_array($id,$noticias_disponibles) or (isset($_SESSION['usuario']) and $_SESSION['usuario']==="admin")){
            crear_menu();

            $conexion=conectarServidor();
            $consulta=$conexion->query("select * from noticia where id=$id"); 
            $fila=$consulta->fetch_array(MYSQLI_ASSOC);

            $fecha=date('d-m-Y',strtotime($fila['fecha_publicacion']));

            echo "<h1>$fila[titulo]</h1>
            <img class='portada' src='../../$fila[imagen]' alt=''>
            <p class='info_noticia'>$fecha</p>
            <p class='texto'>$fila[contenido]</p>";
            
            footer();
        }else{
            denegado();
        }        
    ?>
</body>
</html>