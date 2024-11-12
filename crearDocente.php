<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/crearCuenta.css">
    <title>Crear docente</title>
</head>
<body>
    <header>
        <h1>Crear docente</h1>
    </header>
    <main>
        <form action="php/maestro/crearDocente.php" method="POST">
            <div class="input">
                <label for="nombre">Nombre del docente</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input">
                <button value="submit">Crear docente</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="maestros.php">Regresar</a>
            </li>
        </ul>
    </nav>
</body>
</html>
