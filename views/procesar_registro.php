<?php
require_once '../includes/_db.php';

// Procesar el registro del cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['name']);
    $mail = mysqli_real_escape_string($conexion, $_POST['mail']);
    $genero = mysqli_real_escape_string($conexion, $_POST['genero']);
    
    // Validaciones
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre es requerido";
    }
    
    if (empty($mail)) {
        $errores[] = "El correo electrónico es requerido";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido";
    }
    
    if (empty($genero)) {
        $errores[] = "El género es requerido";
    }
    
    if (empty($errores)) {
        $query = "INSERT INTO clientes (nombre, mail, genero) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        
        mysqli_stmt_bind_param($stmt, "sss", $nombre, $mail, $genero);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['genero'] = $genero;
            $_SESSION['mail'] = $mail;
            header("Location: catalogo.php");
            exit();
        } else {
            $errores[] = "Error al registrar el cliente: " . mysqli_error($conexion);
        }
        
        mysqli_stmt_close($stmt);
    }
    
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header("Location: registro.php");
        exit();
    }
}