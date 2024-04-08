<?php
    function conectarServidor(){
        $conexion=new mysqli('localhost','root','','club');
        $conexion->set_charset("utf8");
        return $conexion;
    }

    function getId($base,$tabla){
        $conexion=conectarServidor($base);
        $consulta=$conexion->query("select auto_increment from information_schema.tables where table_schema='$base' and table_name='$tabla'");
        $id=$consulta->fetch_array(MYSQLI_NUM);
        $conexion->close();
        return $id[0];
    }

    function getAll($base,$tabla,$id){
        $conexion=conectarServidor($base);
        $consulta=$conexion->query("select * from $tabla where id=$id");
        $all=$consulta->fetch_array(MYSQLI_ASSOC);
        $conexion->close();
        return $all;
    }

    // FOOTER
    function footer(){
        echo "</main>
        <footer>
            <div id='redes'>
                <a href=''>
                    <i class='fa-brands fa-facebook-f'></i>
                </a>
                <a href=''>
                    <i class='fa-brands fa-twitter'></i>
                </a>
                <a href=''>
                    <i class='fa-brands fa-instagram'></i>
                </a>
            </div>
            <div>
                <p>Info - Support - Marketing</p>
                <p>Term of Use - Privacy Policy</p>
                <p>Ⓒ 2022 nombre</p>
            </div>
        </footer>";
    }
    // MENUS
    // sin acceder
    function menu_base(){
        $ubicacion_actual=basename($_SERVER['PHP_SELF']);
        $ruta_logo="../../";
        $ruta_ul="..";
        if($ubicacion_actual==="index.php"){
            $ruta_logo="";
            $ruta_ul="php";
        }
        echo "<header>
            <nav>
                <a href='".$ruta_logo."index.php'>
                    <img src='".$ruta_logo."img/assets/logo.png' alt='Logo'>
                </a>
                <ul>
                    <li>
                        <a href='$ruta_ul/productos/productos.php'>Productos</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/servicios/servicios.php'>Servicios</a>
                    </li>
                    <li>    
                        <a href='$ruta_ul/api/api_ext.php'>Api</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/acceso/acceso.php'>Acceder</a>
                    </li>
                    <li class='enlace_dn'>
                        <button id='dia_noche'></button>
                    </li>
                </ul>
            </nav>
        </header>";
    }
    // socio
    function menu_socio($nombre){
        $ubicacion_actual=basename($_SERVER['PHP_SELF']);
        $ruta_logo="../../";
        $ruta_ul="..";
        if($ubicacion_actual==="index.php"){
            $ruta_logo="";
            $ruta_ul="php";
        }
        echo "<header>
            <nav>
                <a href='".$ruta_logo."index.php'>
                    <img src='".$ruta_logo."img/assets/logo.png' alt='Logo'>
                </a>
                <ul>
                    <li>
                        <a href='$ruta_ul/productos/productos.php'>Productos</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/servicios/servicios.php'>Servicios</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/socios/socio_personal.php'>Datos Personales</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/citas/citas.php'>Citas</a>
                    </li>
                    <li>    
                        <a href='$ruta_ul/api/api_ext.php'>Api</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/acceso/cerrar.php'>Cerrar sesión</a>
                    </li>
                    <li class='enlace_dn'>
                        <button id='dia_noche'></button>
                    </li>
                </ul>
            </nav>
        </header>";
    }
    // admin
    function menu_admin(){
        $ubicacion_actual=basename($_SERVER['PHP_SELF']);
        $ruta_logo="../../";
        $ruta_ul="..";
        if($ubicacion_actual==="index.php"){
            $ruta_logo="";
            $ruta_ul="php";
        }
        echo "<header>
            <nav>
                <a href='".$ruta_logo."index.php'>
                    <img src='".$ruta_logo."img/assets/logo.png' alt='Logo'>
                </a>
                <ul>
                    <li>
                        <a href='$ruta_ul/socios/socios.php'>Socios</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/productos/productos.php'>Productos</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/servicios/servicios.php'>Servicios</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/testimonios/testimonios.php'>Testimonios</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/noticias/noticias.php'>Noticias</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/citas/citas.php'>Citas</a>
                    </li>
                    <li>    
                        <a href='$ruta_ul/api/api_ext.php'>Api</a>
                    </li>
                    <li>
                        <a href='$ruta_ul/acceso/cerrar.php'>Cerrar sesión</a>
                    </li>
                    <li class='enlace_dn'>
                        <button id='dia_noche'></button>
                    </li>
                </ul>
            </nav>
        </header>";
    }
    // iniciar sesion
    function inicio_sesion(){
        session_start();
        if(isset($_COOKIE['sesion'])){
            session_decode($_COOKIE['sesion']);
        }
    }
    // Crear menu
    function crear_menu(){
        if(isset($_SESSION['usuario']) and $_SESSION['usuario']!=="admin"){
            $nombre=$_SESSION['usuario'];
        }
        if(isset($_SESSION['usuario'])){
            if($_SESSION['usuario']==="admin"){
                menu_admin();
            }else if($_SESSION['usuario']!==""){
                menu_socio($nombre);
            }
        }else{
            menu_base();
        }

        $ubicacion_actual=basename($_SERVER['PHP_SELF']);
        if($ubicacion_actual==="index.php"){
            echo "<main id='inicio'>";
        }else{
            echo "<main>";
        }
    }
    // Mensaje de error
    function denegado(){
        if($_SESSION['usuario']==="admin"){
            $tipo='administradores';
        }else{
            $tipo='socios';
        }
        echo "<main id='acceso_denegado' class='mal'>
            <h1>ERROR - Ruta no accesible para $tipo</h1>
        </main>";
        
        header('Refresh: 2; URL=../../index.php');
    }
?>