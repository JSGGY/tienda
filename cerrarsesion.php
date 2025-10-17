<?php
session_start();
// AQUI TU CODIGO

session_destroy();
header("Location:index.php");
?>