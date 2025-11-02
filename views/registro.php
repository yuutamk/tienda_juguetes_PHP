<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <link href="css/styles.css" rel="stylesheet">
    
</head>

<body>
    <div class="container">
        <h1>Registro de Cliente</h1>
    <form action="views/procesar_registro.php" method="post" class="form-registro">
            <div class="form-group">
                <label for="name">Nombre completo:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="mail">Correo electrónico:</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            
            <div class="form-group">
                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="">Seleccione una opción</option>
                    <option value="boy">Niño</option>
                    <option value="girl">Niña</option>
                </select>
            </div>
            
            <button type="submit">Registrar</button>
            
            <?php
            if (isset($_SESSION['errores'])) {
                foreach ($_SESSION['errores'] as $error) {
                    echo '<p class="error">' . htmlspecialchars($error) . '</p>';
                }
                unset($_SESSION['errores']);
            }
            ?>
        </form>
    </div>
</body>
</html>