<?php

// iniciar sesión
session_start();

// variables de conexión
$host = "localhost";
$user = "root";
$password = "";
$database = "juguetes";

// uso de excepciones para manejar errores de conexión
try {
    $conexion = mysqli_connect($host, $user, $password, $database);
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexion, "utf8mb4");
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>