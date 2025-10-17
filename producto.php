<?php
session_start();

?>

<html>
    <head>

    </head>
    <body>
        <h2>Usuario: <?php echo $_SESSION['nombre']; ?></h2>
    </body>

</html>