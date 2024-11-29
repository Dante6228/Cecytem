<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

session_start();

$id = $_GET['id'];

$query = "SELECT * FROM maestro WHERE id = :id";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':id', $id);

$stmt->execute();

$maestro = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $id = $_POST['id'];

    $query = "UPDATE maestro SET nombre = :nombre WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location:../../maestros.php?msj=actualizacion2");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/crearCuenta.css">
    <title>Actualizar docente</title>
</head>
<body>
    <header>
        <h1>Actualizar docente</h1>
    </header>
    <main>
        <form action="?" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']) ?>">
            <div class="input">
                <label for="nombre">Nuevo nombre del docente</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($maestro['nombre']) ?>" required>
            </div>
            <div class="input">
                <button value="submit">Actualizar docente</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="../../maestros.php">Regresar</a>
            </li>
        </ul>
    </nav>
</body>
</html>
