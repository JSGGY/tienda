<?php
session_start();

// Restricción de acceso - solo usuarios autenticados
if(!isset($_SESSION['usuario']) && !isset($_SESSION['clave'])){
    header("Location:index.php");
    exit;
}

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ACCIÓN: Vaciar el carrito
    if (isset($_POST['vaciar'])) {
        unset($_SESSION['carrito']);
        header("Location: carroCompra.php");
        exit;
    }
    
    // ACCIÓN: Agregar producto al carrito (viene de producto.php)
    if (isset($_POST['cantidad'])) {
        $productoSeleccionado = $_SESSION['productoSeleccionado'];
        $cantidad = (int)$_POST['cantidad'];
        
        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        // Usar el nombre del producto como clave (coincide con cómo se indexa en cargarProductos)
        $idProducto = $productoSeleccionado['nombre'];
        
        // Agregar o actualizar cantidad en el carrito
        if (isset($_SESSION['carrito'][$idProducto])) {
            $_SESSION['carrito'][$idProducto] += $cantidad;
        } else {
            $_SESSION['carrito'][$idProducto] = $cantidad;
        }
    }
}

// Leer idioma desde Cookie (requisito: idioma debe estar en Cookie)
$idioma = isset($_COOKIE['preferenciaIdioma']) ? $_COOKIE['preferenciaIdioma'] : 'es';

function cargarProductos($idioma){
    $archivo = $idioma === 'en' ? 'resources/categorias_en.txt' : 'resources/categorias_es.txt';
    $productos = [];

    if(file_exists($archivo)){
        $lineas = file($archivo);
        foreach ($lineas as $linea) {
            $partes = explode(',', trim($linea));
            $partes = array_map('trim', $partes); // Limpiar espacios
            
            if (count($partes) === 5) {
                // Formato: nombre, descripcion, cantidad, precio, imagen
                list($nombre, $descripcion, $cantidad, $precio, $imagen) = $partes;
                // Usar el nombre como clave (ID) porque no hay ID numérico en el archivo
                $productos[$nombre] = [
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'cantidad' => (int)$cantidad,
                    'precio' => (float)$precio,
                    'imagen' => $imagen
                ];
            }
        }
    }

    return $productos;
}

$productos = cargarProductos($idioma);
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $idioma === 'en' ? 'Shopping Cart' : 'Carrito de Compra'; ?></title>
        <style>
            table {
                border-collapse: collapse;
                width: 60%;
            }
            th, td {
                border: 1px solid #999;
                padding: 8px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1><?php echo $idioma === 'en' ? 'Welcome user' : 'Bienvenido usuario'; ?>: <?php echo $_SESSION['usuario']; ?></h1>
        <h1><?php echo $idioma === 'en' ? 'Shopping Cart' : 'Carrito de Compra'; ?></h1>
        <?php if(empty($carrito)): ?>
            <p><?php echo $idioma === 'en' ? 'Your cart is empty.' : 'Tu carrito está vacío.'; ?></p>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th><?php echo $idioma === 'en' ? 'Product' : 'Producto';?></th>
                    <th><?php echo $idioma === 'en' ? 'Quantity' : 'Cantidad';?></th>
                    <th><?php echo $idioma === 'en' ? 'Price' : 'Precio';?></th>
                    <th><?php echo $idioma === 'en' ? 'Subtotal' : 'Subtotal';?></th>
                </tr>
                <?php
                $total = 0;
                foreach ($carrito as $nombreProducto => $cantidad):
                    if(!isset($productos[$nombreProducto])) continue;

                    $producto = $productos[$nombreProducto];
                    $precio = $producto['precio'];
                    $nombre = $producto['nombre'];
                    $subtotal = $precio * $cantidad;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $nombreProducto; ?></td>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td>$<?php echo number_format($precio, 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4"><strong><?php echo $idioma === 'en' ? 'Total' : 'Total'; ?></strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </table>

            <!-- Botón para vaciar el carrito -->
             <form method="post">
                <input type="hidden" name="vaciar" value="1">
                <button type="submit"><?php echo $idioma === 'en' ? 'Empty Cart' : 'Vaciar Carrito'; ?></button>
             </form>
        <?php endif; ?>

        <p><a href="panel.php"><?php echo $idioma === 'en' ? 'Back to Panel' : 'Volver al Panel'; ?></a></p>
    </body>
</html>