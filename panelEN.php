<?php
$nombre = $_POST['usuario'];
$clave = $_POST['clave'];
$recordar = isset($_POST['recordar']) ? $_POST['recordar'] : false;
$preferenciaIdioma = "en";
if ($recordar) {
    //Setear las cookies
    setcookie("c_nombre", $nombre, time()+60); 
    setcookie("c_clave", $clave, time()+60);
    setcookie("c_recordar", $recordar, time()+60);
    setcookie("preferenciaIdioma", $preferenciaIdioma, time()+60);
}else{
    //Borrar las cookies
    if (isset($_COOKIE)){    
        foreach ($_COOKIE as $name => $value) {
            setcookie($name, "", 1);
        }
    }
}
?>

<html>
    <head>
    </head>
    <body>
            <h1>Main Panel</h1>
            <br>
            <h2>Welcome User : <?php echo $_POST['usuario']; ?></h2>
            <br>
            <a href="login.php">Logout</a>
            <br>
            <h1>Product List</h1>
        </form>
    </body>
</html>