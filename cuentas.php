<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "
    SELECT
        usuario.*,
        tipoUsuario.descripcion AS tipo_usuario
    FROM
        usuario
    INNER JOIN
        tipoUsuario ON usuario.idTipo = tipoUsuario.id
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/cuentas.css">
    <title>Usuarios</title>
</head>
<body>
    <header>
        <h1>Lista de Usuarios</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Tipo de usuario</th>
            </tr>
            <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre'] . " " . $usuario['ap'] . " " . $usuario['am']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['usuario']);?></td>
                    <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="crearUsuario.php">Crear usuario</a>
    </main>
    <nav>
        <ul>
            <li>
                <a href="inicio.php">Regresar</a>
            </li>
        </ul>
    </nav>
</body>
</html>
