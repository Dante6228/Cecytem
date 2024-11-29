<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$id = $_GET['id'];

$query = "SELECT * FROM tipousuario WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();

$tipo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $tipo = $_POST['nombre'];
    $id = $_POST['id'];

    $query = "UPDATE tipousuario SET descripcion = :descripcion WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':descripcion', $tipo);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location:../../cuentas.php?msj=actualizacion1");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/crearCuenta.css">
    <title>Actualiazar tipo de usuario</title>
</head>
<body>
    <header>
        <h1>Actualizar tipo de usuario</h1>
    </header>
    <main>
        <form action="?" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']) ?>" required>
            <div class="input">
                <label for="nombre">Nuevo nombre de tipo de usuario</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($tipo['descripcion']) ?>" required>
            </div>
            <div class="input">
                <button value="submit">Actualizar tipo de usuario</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="../../cuentas.php">Regresar</a>
            </li>
        </ul>
    </nav>
</body>
</html>
