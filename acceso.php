<?php
session_start();

// Si vienen datos por POST, guardarlos en sesión
if (isset($_POST['usuario']) && isset($_POST['clave'])) {
    $_SESSION['usuario'] = $_POST['usuario'];
    $_SESSION['clave'] = $_POST['clave'];
    header("Location:panelES.php");
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

// Setear cookie de idioma
if (isset($_SESSION)) {
    $nombre = $_SESSION['usuario'];
    $clave = $_SESSION['clave'];

    setcookie("c_nombre", $nombre, time()+60); 
    setcookie("c_clave", $clave, time()+60);

    // Redirigir según el idioma
    if ($_GET['idioma'] == "es" && isset($_COOKIE)) {
        setcookie("preferenciaIdioma", $_GET['idioma'], time()+60);
        header("Location: panelES.php");
    } else if ($_GET['idioma'] == "en" && isset($_COOKIE)) {
        setcookie("preferenciaIdioma", $_GET['idioma'], time()+60);
        header("Location: panelEN.php");
    } else {
        // Cerrar sesión la URI llego vacía
        header("Location: index.php");
    }
    
}
?>