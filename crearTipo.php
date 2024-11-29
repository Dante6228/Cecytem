<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/crearCuenta.css">
    <title>Crear tipo de usuario</title>
</head>
<body>
    <header>
        <h1>Crear tipo de usuario</h1>
    </header>
    <main>
        <form action="php/usuario/crearTipo.php" method="POST">
            <div class="input">
                <label for="nombre">Nombre de tipo de usuario</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input">
                <button value="submit">Crear tipo de usuario</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="cuentas.php">Regresar</a>
            </li>
        </ul>
    </nav>
</body>
</html>
