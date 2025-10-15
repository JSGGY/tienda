<?php
session_start();

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
        header("Location: login.php");
    }
    
}
?>