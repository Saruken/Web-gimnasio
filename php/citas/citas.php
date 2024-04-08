<!DOCTYPE html>
<html lang="es">
<head>
    <script type="text/javascript" defer src="../../app.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
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
            if($_SESSION['usuario']!=="admin"){
                $usuario=$_SESSION['usuario'];
                $conexion=conectarServidor();
                $consulta=$conexion->query("select id from socio where usuario='$usuario'");
                $num=$consulta->fetch_array(MYSQLI_ASSOC);
                $id=$num['id'];
            }

            setlocale(LC_ALL,"es-ES.UTF-8");
            $conexion=conectarServidor();
            
            $mes_actual=date('m',time());
            $anio_actual=date('Y');

            if(isset($_GET['mes'])){
                $mes=$_GET['mes'];
                $anio=$_GET['año'];
            }else{
                $mes=$mes_actual;
                $anio=$anio_actual;
            }

            $fecha=mktime(0,0,0,$mes,1,$anio);
            $inicio_mes=date('N',$fecha);
            $fin_mes=date('t',$fecha);
            $nombre_mes=ucfirst(strftime('%B',$fecha));
            $dia=0;

            if($_SESSION['usuario']!="admin"){
                $consulta=$conexion->query("select day(fecha) dia from citas where socio=$id and year(fecha)=$anio and month(fecha)=$mes order by fecha asc");
            }else{
                $consulta=$conexion->query("select day(fecha) dia from citas where year(fecha)=$anio and month(fecha)=$mes order by fecha asc");
            }
            $num_filas=$consulta->num_rows;
            if($num_filas>0){
                $fila=$consulta->fetch_array(MYSQLI_ASSOC);
                $dia=$fila['dia'];
            }

            $mes_siguiente = $mes + 1;
            $mes_anterior = $mes - 1;
            $año_siguiente = $anio;
            $año_anterior = $anio;

            if($mes_siguiente > 12)
            {
                $mes_siguiente = 1;
                $mes=$mes_siguiente;
                $año_siguiente++;
                $anio=$año_anterior;
            }
            if($mes_anterior<1)
            {
                $mes_anterior=12;
                $mes=$mes_anterior;
                $año_anterior--;
                $anio=$año_anterior;
            }

            echo "<table id='calendario' class='sin_mod'>
                <caption>
                    <a href='citas.php?mes=$mes_anterior&año=$año_anterior'><i class='fa-solid fa-arrow-left'></i></a>
                    $nombre_mes
                    <a href='citas.php?mes=$mes_siguiente&año=$año_siguiente'><i class='fa-solid fa-arrow-right'></i></a>
                </caption>
                <thead>
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>";

            $anio_consulta=$anio;
            if($mes==12){
                $mes_consulta=1;
                $anio_consulta++;
            }else if($mes==1){
                $mes_consulta=12;
            }else{
                $mes_consulta=$mes;
            }

            for($i=1;$i<$inicio_mes;$i++){
                echo "<td></td>";
            }

            $contador=$inicio_mes;
            for($i=1;$i<=$fin_mes;$i++){
                if($i==$dia){
                    echo "<td class='cita'><a href='?mes=$mes_consulta&año=$anio_consulta&dia=$i'>$i</a></td>";
                    $fila=$consulta->fetch_array(MYSQLI_ASSOC);
                    if($fila!=false){
                        $dia=$fila['dia'];
                    }
                }else{
                    echo "<td>$i</td>";
                }
                if($contador==7){
                    echo "</tr><tr>";
                    $contador=0;
                }
                $contador++;
            }
            for($i=$contador;$i<=7;$i++){
                echo "<td></td>";
            }

            echo "</tr>
                </tbody>
            </table>";

            $conexion->close();

            if($_SESSION['usuario']==="admin"){
            echo "<div class='funcionalidades'>";
                echo "<a href='insertar_citas.php'>Añadir cita</a>";
                echo "<form  action='#' method='post' enctype='multipart/form-data'>
                <input id='buscar' type='text' name='buscar' maxlength='50' placeholder='Nombre, fecha o servicio'>
                <input type='submit' name='enviar' value='Buscar'>
                </form>
                </div>";
            }
                
            $conexion=conectarServidor();
            
            echo "<table id='tabla_citas' class='con_mod'>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Socio</th>
                        <th>Teléfono</th>
                        <th>Servicio</th>
                    </tr>
                </thead>
                <tbody>";

            if(isset($_POST['enviar']) or isset($_GET['dia'])){
                if($_SESSION['usuario']!=="admin"){
                    $busqueda="$_GET[año]-$_GET[mes]-$_GET[dia]";
                    $consulta=$conexion->prepare("select fecha,hora,nombre,telefono,descripcion from citas,socio,servicio where citas.socio!=0 and socio.id=socio and socio=? and servicio.id=servicio and fecha=? order by fecha desc");
                    $consulta->bind_param("is",$id,$busqueda);
                    $consulta->bind_result($fecha,$hora,$nombre,$telefono,$descripcion);
                }else{
                    if(isset($_POST['enviar'])){
                        $busqueda="%".$_POST['buscar']."%";
                        $consulta=$conexion->prepare("select socio.id id,fecha,hora,nombre,telefono,descripcion from citas,socio,servicio where citas.socio!=0 and socio.id=socio and servicio.id=servicio and (fecha like ? or nombre like ? or descripcion like ?) order by fecha desc");
                        $consulta->bind_param("sss",$busqueda,$busqueda,$busqueda);
                    }else if(isset($_GET['dia'])){
                        $busqueda="$_GET[año]-$_GET[mes]-$_GET[dia]";
                        $consulta=$conexion->prepare("select socio.id id,fecha,hora,nombre,telefono,descripcion from citas,socio,servicio where citas.socio!=0 and socio.id=socio and servicio.id=servicio and fecha=? order by fecha desc");
                        $consulta->bind_param("s",$busqueda);
                    }
                    $consulta->bind_result($id,$fecha,$hora,$nombre,$telefono,$descripcion);
                }
                $consulta->execute();
                $consulta->store_result();
                if($consulta->num_rows>0){
                    while($consulta->fetch()){
                        $fecha=date('d-m-Y',strtotime($fecha));
                        echo "<tr>
                            <td>$fecha</td>
                            <td>$hora</td>
                            <td>$nombre</td>
                            <td>$telefono</td>
                            <td>$descripcion</td>";

                        $hoy=getdate()['year']."-".getdate()['mon']."-".getdate()['mday'];
                        if($fecha>$hoy){
                            if($_SESSION['usuario']!=="admin"){
                                echo "<td></td>";
                            }else{
                                echo "<td>
                                    <a href='borrar_cita.php?fecha=$fecha&hora=$hora&socio=$id' class='mod mod_prod'>Borrar</a>
                                </td>";
                            }
                        }else{
                            echo "<td></td>";
                        }
                        echo "</tr>";
                    }
                }else{
                    echo "<tr>
                        <td colspan=5 class='tabla_vacia'>No hay coincidencias</td>
                    </tr>";
                }
                
                $consulta->close();
            }else{
                $dia_actual=date('d');
                if($_SESSION['usuario']!=="admin"){
                    $consulta=$conexion->query("select fecha,hora,nombre,telefono,descripcion from citas,socio,servicio where citas.socio!=0 and socio.id=socio and socio.id=$id and servicio.id=servicio and month(fecha)=$mes_consulta and year(fecha)=$anio_consulta and day(fecha)=$dia_actual order by fecha asc");
                }else{
                    $consulta=$conexion->query("select socio.id id,fecha,hora,nombre,telefono,descripcion from citas,socio,servicio where citas.socio!=0 and socio.id=socio and servicio.id=servicio and month(fecha)=$mes_consulta and year(fecha)=$anio_consulta and day(fecha)=$dia_actual order by fecha asc");
                }
                
                if($consulta->num_rows>0){
                    while($fila=$consulta->fetch_array(MYSQLI_ASSOC)){
                        $fecha=date('d-m-Y',strtotime($fila['fecha']));
                        echo "<tr>
                            <td>$fecha</td>
                            <td>$fila[hora]</td>
                            <td>$fila[nombre]</td>
                            <td>$fila[telefono]</td>
                            <td>$fila[descripcion]</td>";
    
                            $hoy=getdate()['year']."-".getdate()['mon']."-".getdate()['mday'];
                            if($fila['fecha']>$hoy){
                                if($_SESSION['usuario']!=="admin"){
                                    echo "<td></td>";
                                }else{
                                    echo "<td>
                                        <a href='borrar_cita.php?fecha=$fila[fecha]&hora=$fila[hora]&socio=$fila[id]' class='mod mod_prod'>Borrar</a>
                                    </td>";
                                }
                            }else{
                                echo "<td></td>";
                            }
                        echo "</tr>";
                    }
                }else{
                    echo "<tr>
                        <td colspan=5 class='tabla_vacia'>No hay citas para hoy</td>
                    </tr>";
                }
            }

            echo "</tbody>
            </table>";

            $conexion->close();
            footer();
        }
    ?>
</body>
</html>