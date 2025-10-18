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
        if (isset($_COOKIE)) {
            foreach ($_COOKIE as $name => $value) {
            setcookie($name, "", 1);
        }
        }
    }
} else if (isset($_GET['idioma'])){
    if ($_GET['idioma'] == "es") {
        setcookie("preferenciaIdioma", $_GET['idioma'], time()+60);
        header("Location: panel.php");
    } else if ($_GET['idioma'] == "en") {
        setcookie("preferenciaIdioma", $_GET['idioma'], time()+60);   
        header("Location: panel.php"); 
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
        <h1><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Main Panel' : 'Panel Principal'; ?></h1>
        <br>
        <h2><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Welcome User' : 'Bienvenido Usuario'; ?>: <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
        <br>
        <a href="panel.php?idioma=es">ES(ESPAÑOL) |</a><a href="panel.php?idioma=en"> EN(ENGLISH) |</a>
        <br>
        <a href="cerrarsesion.php"><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Logout' : 'Cerrar Sesión'; ?></a>
        <br>
        <h1><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Product List' : 'Lista de Productos'; ?></h1>
        <!-- Aqui sigo yo -->
         <?php 
         if (isset($categorias_lineas)) {
             foreach($categorias_lineas as $lineas){
                echo "<a href='' >". trim($lineas) ."</a><br>";
             }
         }
         ?>
    </body>
</html>