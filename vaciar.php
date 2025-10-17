<?php
session_start();

// Borrar el carrito
unset($_SESSION['carrito']);

// Redirigir al carrito otra vez (ya vacío)
header("Location: carrito.php");
exit;

?>