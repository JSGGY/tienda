<?php
$nombre = $clave = "";
if (isset($_COOKIE['c_recordar']) ) {
    $nombre = $_COOKIE['c_nombre'];
    $clave = $_COOKIE['c_clave'];
}
?>

<html>
    <head>
    </head> 
    <body>
        <form action="panel.php" method="POST">
            <fieldset>
                <h1>Login</h1>
                <br>
                Usuario
                <input type="text" name="usuario"<?php echo ' value ="' . $nombre . '"' ?> required>
                <br>
                Clave
                <input type="password" name="clave" <?php echo ' value ="' . $nombre . '"' ?> required>
                <br>
                <input type="checkbox" name="recordar" > Recordar mis datos
                 <br>
                <input type="submit" value="Enviar">
            </fieldset>
        </form>
    </body>
</html>