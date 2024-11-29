<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Iniciar sesión</title>
</head>
<body>
    <main>
        <div class="login">
            <?php
                if(isset($_GET['error']) && $_GET['error'] === 'actividad'){
                    echo '<div class="error">No puedes iniciar sesión, tu cuenta es inactiva.</div>';
                }
            ?>
            <?php
                if(isset($_GET['error']) && $_GET['error'] === 'noexiste'){
                    echo '<div class="error">No existe la cuenta.</div>';
                }
            ?>
            <div class="content">
                <h1>Iniciar sesión</h1>
            </div>
            <div class="content">
                <form action="php/login/login.php" method="post">
                    <div class="content-2">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" required>
                    </div>
                    <div class="content-2">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" id="contraseña" name="contraseña" required>
                    </div>
                    <div class="content-2">
                        <input type="submit" id="enviar" value="Iniciar sesión" required>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
