<?php
session_start();
//Restricción de punto de acceso 
if(!isset($_SESSION['usuario'])&& !isset($_SESSION['clave'])){
    header("Location:index.php");
}
if(isset($_GET['producto'])){
    $nombreProducto = $_GET['producto'];

    // Buscar el producto en el arreglo de productos
    foreach ($_SESSION['productos'] as $producto) {
        if ($producto['nombre'] === $nombreProducto) {
            // Guardamos el producto completo en la sesión
            $_SESSION['productoSeleccionado'] = $producto;
            break;
        }
    }
}


?>

<html>
    <head>

    </head>
    <body>
        <h2 ><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Welcome User' : 'Bienvenido Usuario'; ?>: <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
        <h2 style="display: inline;"><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Selected Product: ' : 'Producto Seleccionado: '; ?></h2>
        <span style="font-size: 1.3em; font-weight: normal;"> <?php echo htmlspecialchars($_SESSION['productoSeleccionado']["nombre"]); ?> </span><br><br>

        <h2 style="display: inline;"><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Description: ' : 'Descripcion: '; ?></h2>
        <span style="font-size: 1.3em; font-weight: normal;"> <?php echo htmlspecialchars($_SESSION['productoSeleccionado']["descripcion"]); ?> </span><br><br>

        <h2 style="display: inline;"><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Price: ' : 'Precio: '; ?></h2>
        <span style="font-size: 1.3em; font-weight: normal;"> <?php echo htmlspecialchars($_SESSION['productoSeleccionado']["precio"]); ?> </span>

        <!-- Guardar info de la cantidad del producto -->
        <form method="post" action="carroCompra.php">
            <label for="cantidad"><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Number: ' : 'Cantidad: '; ?></label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="<?php echo $_SESSION['productoSeleccionado']['cantidad']; ?>" required>
            <button type="submit"><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Add to cart' : 'Agregar al carrito'; ?></button>
        </form><br>
        <img src="<?php echo $_SESSION['productoSeleccionado']['imagen']; ?>" alt="<?php echo $_SESSION['productoSeleccionado']['nombre']; ?>" width="200"><br><br>

        <a href="carroCompra.php"><button><?php echo isset($_COOKIE['preferenciaIdioma']) && $_COOKIE['preferenciaIdioma'] === 'en' ? 'Go to shopping cart' : 'Ir al carrito de compras'; ?></button></a>

    </body>

</html>