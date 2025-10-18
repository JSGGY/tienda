<?php
session_start();

// Si vienen datos por POST, guardarlos en sesión
if (isset($_POST['usuario']) && isset($_POST['clave'])) {
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['clave'] = $_POST['clave'];
    
    // Comparar si usuario y clave actuales son iguales a los anteriores
    $usuarioAnterior = isset($_POST['usuarioAnterior']) && $_POST['usuarioAnterior'] !== '' ? $_POST['usuarioAnterior'] : null;
    $claveAnterior = isset($_POST['claveAnterior']) && $_POST['claveAnterior'] !== '' ? $_POST['claveAnterior'] : null;
    
    $idiomaNuevo = 'es'; // Por defecto español

    // Si NO hay datos anteriores O si los datos son iguales, mantener preferencia
    if ($usuarioAnterior === null || ($_POST['usuario'] === $usuarioAnterior && $_POST['clave'] === $claveAnterior)) {
        // Mantener la cookie de idioma actual si existe
        if (isset($_COOKIE['preferenciaIdioma'])) {
            $idiomaNuevo = $_COOKIE['preferenciaIdioma'];
        }
        setcookie("preferenciaIdioma", $idiomaNuevo, time()+3600);
    } else {
        // Son diferentes usuarios, establecer español
        setcookie("preferenciaIdioma", "es", time()+3600);
    }

    $recordar = isset($_POST['recordar']) ? $_POST['recordar'] : false;
    
    if ($recordar) {
        setcookie("c_nombre", $_POST['usuario'], time()+3600); 
        setcookie("c_clave", $_POST['clave'], time()+3600);
        setcookie("c_recordar", $recordar, time()+3600);
    } else {
        // Borrar solo las cookies de recordar (NO la de idioma)
        if (isset($_COOKIE['c_nombre'])) setcookie("c_nombre", "", time()-3600);
        if (isset($_COOKIE['c_clave'])) setcookie("c_clave", "", time()-3600);
        if (isset($_COOKIE['c_recordar'])) setcookie("c_recordar", "", time()-3600);
    }
    
    // Redirigir con el idioma correspondiente
    header("Location: panel.php?idioma=" . $idiomaNuevo);
    exit();
    
} else if (isset($_GET['idioma'])){
    if ($_GET['idioma'] == "es" || $_GET['idioma'] == "en") {
        setcookie("preferenciaIdioma", $_GET['idioma'], time()+3600);
        header("Location: panel.php");
        exit();
    }
}

//Restricción de punto de acceso 
if(!isset($_SESSION["usuario"]) && !isset($_SESSION["clave"])){
    header("Location:index.php");
    exit();
}

//lectura del .txt
$archivoIdioma = isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'en' : 'es';
$archivo = "resources/categorias_{$archivoIdioma}.txt";
if(file_exists($archivo)){
    $categorias_lineas = file($archivo);
}

// Obtener el idioma (con español como predeterminado)
$idioma = isset($_COOKIE['preferenciaIdioma']) ? $_COOKIE['preferenciaIdioma'] : 'es';
?>

<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Main Panel' : 'Panel Principal'; ?></h1>
        <br>
        <h2><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Welcome User' : 'Bienvenido Usuario'; ?>: <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
        <br>
        <a href="panel.php?idioma=es">ES(ESPAÑOL) |</a><a href="panel.php?idioma=en"> EN(ENGLISH) |</a>
        <br>
        <form id="formCerrarSesion" action="cerrarsesion.php" method="POST" style="display:inline;">
            <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>">
            <input type="hidden" name="clave" value="<?php echo htmlspecialchars($_SESSION['clave']); ?>">
            <button type="submit" style="background:none;border:none;color:blue;text-decoration:underline;cursor:pointer;">
            <?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Logout' : 'Cerrar Sesión'; ?>
            </button>
        </form>
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