<?php
session_start();

// Si vienen datos por POST, guardarlos en sesión
if (isset($_POST['usuario']) && isset($_POST['clave'])) {
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['clave'] = $_POST['clave'];
    
    $recordar = isset($_POST['recordar']) ? $_POST['recordar'] : false;
    
    if ($recordar) {
        setcookie("c_nombre", $_POST['usuario'], time()+60); 
        setcookie("c_clave", $_POST['clave'], time()+60);
        setcookie("c_recordar", $recordar, time()+60);
    } else {
        // Borrar solo las cookies de usuario
        if (isset($_COOKIE)){    
            foreach ($_COOKIE as $name => $value) {
            setcookie($name, "", 1);
        }
        }
    }
}

//lectura del .txt
$archivo = "resources\categorias_es.txt";
if(file_exists($archivo)){
    $categorias_lineas = file($archivo);
}
?>

<html>
    <head>
    </head>
    <body>
            <h1>Panel Principal </h1>
            <br>
            <h2>Bienvenido Usuario : <?php echo $_SESSION['usuario']; ?></h2>
            <br>
            <a href="acceso.php?idioma=es">ES(ESPAÑOL) |</a><a href="acceso.php?idioma=en"> EN(ENGLISH) |</a>
            <br>
            <a href="cerrarsesion.php">Cerrar Sesion</a>
            <br>
            <h1>Lista de Productos</h1>
            <!-- Aqui sigo yo -->
             <?php 
             foreach($categorias_lineas as $lineas){
                echo "<a href='' >". trim($lineas) ."</a><br>";
             }?>

        </form>
    </body>
</html>