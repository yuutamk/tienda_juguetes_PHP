<?php
session_start();

// Redirigir al catálogo si ya está logueado
if (isset($_SESSION['nombre']) && isset($_SESSION['genero'])) {
    header("Location: views/catalogo.php");
    exit();
}

// Si no está logueado, mostrar el formulario de registro
include './views/registro.php';
?>