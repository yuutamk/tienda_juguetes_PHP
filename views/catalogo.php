<?php
require_once '../includes/_db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre']) || !isset($_SESSION['genero'])) {
    header("Location: registro.php");
    exit();
}

// para cerrar sesión y redirigir al index
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

// vista previa y envío simulado
$mensaje_envio = '';
$preview = false;
$preview_toy = null;
$preview_to = '';

// generando vista previa del correo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send']) && isset($_POST['juguete_id'])) {
        if (!isset($_SESSION['mail']) || empty($_SESSION['mail'])) {
            $mensaje_envio = 'No se encontró el correo del cliente en la sesión.';
        } else {
            $preview_to = $_SESSION['mail'];
            $juguete_id = intval($_POST['juguete_id']);

            $q = "SELECT id, nombre, descripcion, precio, imagen FROM juguetes WHERE id = ? LIMIT 1";
            $stmt2 = mysqli_prepare($conexion, $q);
            mysqli_stmt_bind_param($stmt2, "i", $juguete_id);
            mysqli_stmt_execute($stmt2);
            $res2 = mysqli_stmt_get_result($stmt2);

            if ($res2 && mysqli_num_rows($res2) > 0) {
                $preview_toy = mysqli_fetch_assoc($res2);
                $preview = true;
            } else {
                $mensaje_envio = 'No se encontró el juguete especificado.';
            }

            if (isset($stmt2) && $stmt2) {
                mysqli_stmt_close($stmt2);
            }
        }
    }

    // simular confirmación de envío sin usar mail()
    if (isset($_POST['confirm_send']) && isset($_POST['juguete_id'])) {
        if (!isset($_SESSION['mail']) || empty($_SESSION['mail'])) {
            $mensaje_envio = 'No se encontró el correo del cliente en la sesión.';
        } else {
            $to = $_SESSION['mail'];
            $juguete_id = intval($_POST['juguete_id']);

            
            $q = "SELECT nombre, descripcion, precio, imagen FROM juguetes WHERE id = ? LIMIT 1";
            $stmt3 = mysqli_prepare($conexion, $q);
            mysqli_stmt_bind_param($stmt3, "i", $juguete_id);
            mysqli_stmt_execute($stmt3);
            $res3 = mysqli_stmt_get_result($stmt3);

            if ($res3 && mysqli_num_rows($res3) > 0) {
                $j = mysqli_fetch_assoc($res3);
                // aqui usaríamos enviar el correo con la función mail()
                
                // $subject = "Información del juguete: " . $j['nombre'];
                // $body = "Detalles...";
                // mail(
                //     $to,
                //     $subject,
                //     $body,
                //     "From: no-reply@yourdomain.com\r\nReply-To: no-reply@yourdomain.com"
                // );

                $mensaje_envio = 'Simulación: correo enviado correctamente a ' . htmlspecialchars($to) . '.';
            } else {
                $mensaje_envio = 'No se encontró el juguete especificado.';
            }

            if (isset($stmt3) && $stmt3) {
                mysqli_stmt_close($stmt3);
            }
        }
    }
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
        <div class="header-row">
            <h2>¡Bienvenido(a) <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
            <!-- Botón para cerrar sesión -->
            <form method="post" style="display:inline; margin-left:20px;">
                <button type="submit" name="logout" class="logout-button">Cerrar sesión</button>
            </form>
        </div>
        <?php if (!empty($mensaje_envio) && !$preview): ?>
            <p class="info-message"><?php echo htmlspecialchars($mensaje_envio); ?></p>
        <?php endif; ?>
        
        <?php if ($preview && $preview_toy): ?>
            <div class="preview-card">
                <h3>Vista previa del correo</h3>
                <p><strong>Destinatario:</strong> <?php echo htmlspecialchars($preview_to); ?></p>
                <p><strong>Asunto:</strong> Información del juguete: <?php echo htmlspecialchars($preview_toy['nombre']); ?></p>
                <div class="preview-body">
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($preview_toy['nombre']); ?></p>
                    <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($preview_toy['descripcion'])); ?></p>
                    <p><strong>Precio:</strong> $<?php echo number_format($preview_toy['precio'], 2); ?></p>
                    <?php if (!empty($preview_toy['imagen'])): ?>
                        <p><strong>Imagen:</strong> <a href="<?php echo htmlspecialchars($preview_toy['imagen']); ?>" target="_blank">Ver imagen</a></p>
                    <?php endif; ?>
                </div>

                <form method="post" style="margin-top:1rem;">
                    <input type="hidden" name="juguete_id" value="<?php echo intval($preview_toy['id']); ?>">
                    <button type="submit" name="confirm_send" class="confirm-button">Confirmar envío (simular)</button>
                    <a href="catalogo.php" class="cancel-link">Cancelar</a>
                </form>
            </div>
        <?php endif; ?>
        
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
                    
                    echo '<form method="post" class="send-form">';
                    echo '<input type="hidden" name="juguete_id" value="' . intval($juguete['id']) . '">';
                    echo '<button type="submit" name="send" class="send-button">Enviar por correo</button>';
                    echo '</form>';
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