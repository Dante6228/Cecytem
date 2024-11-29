<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

session_start();

$id = $_GET['id'];

$query = "SELECT * FROM materia WHERE id = :id";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':id', $id);

$stmt->execute();

$materia = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $materia = $_POST['materia'];
    $id = $_POST['id'];

    $query = "UPDATE materia SET descripcion = :descripcion WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':descripcion', $materia);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location:../../maestros.php?msj=actualizacion3");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/crearCuenta.css">
    <title>Actualizar materia</title>
</head>
<body>
    <header>
        <h1>Actualizar materia</h1>
    </header>
    <main>
        <form action="?" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']) ?>">
            <div class="input">
                <label for="materia">Nuevo nombre de la materia</label>
                <input type="text" id="materia" name="materia" value="<?php echo htmlspecialchars($materia['descripcion']) ?>" required>
            </div>
            <div class="input">
                <button value="submit">Actualizar materia</button>
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
