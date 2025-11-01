<?php
require_once '../includes/_db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre']) || !isset($_SESSION['genero'])) {
    header("Location: registro.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Juguetes</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Catálogo de Juguetes</h1>
        <h2>¡Bienvenido(a) <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
        
        <div class="catalogo">
            <?php
            // Obtener juguetes según el género
            $genero = $_SESSION['genero'];
            $query = "SELECT * FROM juguetes WHERE genero = ? OR genero = 'unisex'";
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, "s", $genero);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultado) > 0) {
                while ($juguete = mysqli_fetch_assoc($resultado)) {
                    echo '<div class="juguete-card">';
                    if (!empty($juguete['imagen'])) {
                        echo '<img src="' . htmlspecialchars($juguete['imagen']) . '" alt="' . htmlspecialchars($juguete['nombre']) . '">';
                    }
                    echo '<h3>' . htmlspecialchars($juguete['nombre']) . '</h3>';
                    echo '<p>' . htmlspecialchars($juguete['descripcion']) . '</p>';
                    echo '<p class="precio">$' . number_format($juguete['precio'], 2) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay juguetes disponibles para mostrar.</p>';
            }
            
            mysqli_stmt_close($stmt);
            ?>
        </div>
    </div>
</body>
</html>