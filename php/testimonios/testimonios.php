<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="../../app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonios</title>
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
                
                echo "<h1>TESTIMONIOS</h1>
                <div class='funcionalidades funcionalidad'>
                    <a href='insertar_testimonios.php'>Añadir testimonio</a>
                </div>";
            
                $conexion=conectarServidor();
                $consulta=$conexion->query("select nombre,contenido,fecha from testimonio,socio where autor=socio.id order by fecha desc");

                echo "<table id='tabla_testimonios' class='sin_mod'>
                    <thead>
                        <tr>
                            <th>Autor</th>
                            <th>Contenido</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>";

                while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                    $fecha=date('d-m-Y',strtotime($fila['fecha']));
                    echo "<tr>
                        <td>$fila[nombre]</td>
                        <td>$fila[contenido]</td>
                        <td>$fecha</td>
                    </tr>";
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