<?php
session_start();
$idioma = isset($_COOKIE['parametroIdioma']) ? $_COOKIE['parametroIdioma'] : 'es';

function cargarProductos($idioma){
    $archivo = $idioma === 'en' ? 'categorias_en.txt' : 'categorias_es.txt';
    $productos = [];

    if(file_exists($archivo)){
        $lineas = file($archivo);
        foreach ($lineas as $linea) {
            $partes = explode('|', trim($linea));
            if (count($partes) === 4) {
                list($id, $nombre, $descripcion, $precio) = $partes;
                $productos[$id] = [
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => (float)$precio
                ];
            }
        }
    }

    return $productos;
}

$productos = cargarProductos($idioma);
$carrito = isset($_SESSION['paramatroCarritoenSession']) ? $_SESSION['paramatroCarritoenSession'] : [];

?>

<html>
    <head>
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
                foreach ($carrito as $id => $cantidad):
                    if(!isset($productos[$id])) continue;

                    $producto = $productos[$id];
                    $precio = $producto['precio'];
                    $nombre = $producto['nombre'];
                    $subtotal = $precio * $cantidad;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
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
             <form action="post" action="vaciar.php">
                <button type = "submit"><?php echo $idioma === 'en' ? 'Empty Cart' : 'Vaciar Carrito'; ?></button>
             </form>
        <?php endif; ?>

        <form action="">

        </form>

        <p><a href="<?php echo $idioma === 'en' ? 'panelEN.php' : 'panelES.php'; ?>"><?php echo $idioma === 'en' ? 'Back to Panel' : 'Volver al Panel'; ?></a></p>
    </body>
</html>