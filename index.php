<?php
$nombre = $clave = "";
$preferenciaIdioma = "es";
if (isset($_COOKIE['c_recordar']) ) {
    $nombre = $_COOKIE['c_nombre'];
    $clave = $_COOKIE['c_clave'];
    if (isset($_COOKIE['preferenciaIdioma'])) {
        $preferenciaIdioma = $_COOKIE['preferenciaIdioma'];
    }else{
        $preferenciaIdioma = "es";
    }
}
?>
<html>
    <head>
    </head> 
    <body>
        <form action=<?php  echo $preferenciaIdioma === 'en'  ? 'panelEN.php' : 'panelES.php'; ?> method="POST">
            <fieldset>
                <h1>Login</h1>
                <br>
                Usuario
                <input type="text" name="usuario"<?php echo ' value ="' . $nombre . '"' ?> required>
                <br>
                Clave
                <input type="password" name="clave" <?php echo ' value ="' . $clave . '"' ?> required>
                <br>
                <input type="checkbox" name="recordar" <?php echo isset($_COOKIE['c_recordar']) ? 'checked' : '' ?>> Recordar mis datos
                 <br>
                <input type="submit" value="Enviar">
            </fieldset>
        </form>
    </body>
</html>