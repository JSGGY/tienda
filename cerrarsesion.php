<?php
session_start();
// Recibir los datos del usuario antes de destruir la sesión
$usuarioAnterior = $_SESSION['usuario'] ;
$claveAnterior = $_SESSION['clave'] ;

session_destroy();

// Si no le di en recordar , Borramos todas las coookies 
if (($_COOKIE['c_recordar'] == false)) {
    foreach ($_COOKIE as $name => $value) {
        setcookie($name, "", 1);
    }
}else {
    // Si sí marcó "recordar", reenviar al index con los datos
    echo "
        <form id='redirigir' action='index.php' method='POST'>
            <input type='hidden' name='usuario' value='{$usuarioAnterior}'>
            <input type='hidden' name='clave' value='{$claveAnterior}'>
            <input type='hidden' name='recordar' value='true'>
        </form>
        <script>
            document.getElementById('redirigir').submit();
        </script>
    ";
    exit;
}

// Redirección normal si no hay "recordar"
header("Location: index.php");
exit;
?>