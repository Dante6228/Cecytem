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
    <link rel="stylesheet" href="css/cuentas.css">
    <title>Usuarios</title>
</head>
<body>
    <header>
        <h1>Lista de Usuarios</h1>
    </header>
    <main>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "exito"){
                echo "<p class='exito'>El usuario se ha eliminado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET['msj']) && $_GET["msj"] === "actualizado"){
                echo "<p class='exito'>El usuario se ha actualizado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET['msj']) && $_GET["msj"] === "creado"){
                echo "<p class='exito'>El usuario se ha creado correctamente</p>";
            }
        ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Actividad</th>
                <th>Tipo de usuario</th>
                <th>Borrar/actualizar</th>
            </tr>
            <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre'] . " " . $usuario['ap'] . " " . $usuario['am']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['usuario']);?></td>
                    <td><?php if($usuario['actividad'] === 1){
                        echo htmlspecialchars('Activo');
                    } else{
                        echo htmlspecialchars('Inactivo');
                    } ?></td>
                    <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                    <td>
                        <?php echo "<a href='php/usuario/borrar.php?id=" . urlencode($usuario['id']) . "'>Borrar</a>"; ?>
                        <?php echo "<a href='php/usuario/actualizar.php?id=" . urlencode($usuario['id']) . "'>Actualizar</a>"; ?>
                    </td>
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
