<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css">

    <link rel="stylesheet" href="css/login.css">
    <title>Iniciar sesión</title>
</head>
<body>
    <main>
        <form action="php/login/login.php" method="post">
            <div class="content">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="content">
                <label for="contraseña">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <div class="content">
                <input type="submit" id="enviar" value="Iniciar sesión" required>
            </div>
        </form>
    </main>
</body>
</html>
