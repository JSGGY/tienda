<?php

$nombre = $clave = "";
$preferenciaIdioma = "";
$usuarioAnterior = "";
$claveAnterior = "";

if (isset($_COOKIE['preferenciaIdioma'])) {
    $preferenciaIdioma = $_COOKIE['preferenciaIdioma'];
} else {
    $preferenciaIdioma = "es";
}

if (isset($_COOKIE['c_recordar'])) {
    $nombre = $_COOKIE['c_nombre'];
    $clave = $_COOKIE['c_clave'];
    $usuarioAnterior = $nombre;
    $claveAnterior = $clave;
}

// Si vienen datos de cerrarsesion.php
if (isset($_POST['usuarioAnterior'])) {
    $usuarioAnterior = $_POST['usuarioAnterior'];
    $claveAnterior = $_POST['claveAnterior'];
}
?>
<html>
    <head>
        <meta charset="UTF-8">
    </head> 
    <body>
        <form action="panel.php" method="POST">
            <fieldset>
                <h1>Login</h1>
                <br>
                Usuario
                <input type="text" name="usuario"<?php echo ' value ="' . htmlspecialchars($nombre) . '"' ?> required>
                <br>
                Clave
                <input type="password" name="clave" <?php echo ' value ="' . htmlspecialchars($clave) . '"' ?> required>
                <br>
                <input type="checkbox" name="recordar" <?php echo isset($_COOKIE['c_recordar']) ? 'checked' : '' ?>> Recordar mis datos
                <br>
                
                <!-- Campos ocultos para enviar datos User y Clave al panel  -->
                <input type="hidden" name="usuarioAnterior" value="<?php echo htmlspecialchars($usuarioAnterior); ?>">
                <input type="hidden" name="claveAnterior" value="<?php echo htmlspecialchars($claveAnterior); ?>">

                <input type="submit" value="Enviar">
            </fieldset>
        </form>
    </body>
</html>