<?php
session_start();
//Restricción de punto de acceso 
if(!isset($_SESSION["nombre"])&& !isset($_SESSION["clave"])){
    header("Location:index.php");
}
?>

<html>
    <head>

    </head>
    <body>
        <h2>Usuario: <?php echo $_SESSION['nombre']; ?></h2>
    </body>

</html>