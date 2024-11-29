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

$query = "SELECT * FROM tipousuario";

$stmt = $pdo->prepare($query);
$stmt->execute();

$tiposUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h1>Usuarios y tipos de usuario</h1>
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
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "creado2"){
                echo "<p class='exito'>Tipo de usuario creado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "exito2"){
                echo "<p class='exito'>Tipo de usuario eliminado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "actualizacion1"){
                echo "<p class='exito'>Tipo de usuario actualizado correctamente</p>";
            }
        ?>
        <div class="contenedor">
            <div>
                <h2>Cuentas</h2>
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
            </div>
            <div>
                <h2>Tipos de usuario</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de usuario</th>
                        <th>Borrar/actualizar</th>
                    </tr>
                    <?php foreach ($tiposUsuario as $tipo) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tipo['id']); ?></td>
                            <td><?php echo htmlspecialchars($tipo['descripcion']); ?></td>
                            <td>
                                <?php echo "<a href='php/usuario/borrarTipo.php?id=" . urlencode($tipo['id']) . "'>Borrar</a>"; ?>
                                <?php echo "<a href='php/usuario/actualizarTipo.php?id=" . urlencode($tipo['id']) . "'>Actualizar</a>"; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <a href="crearUsuario.php">Crear usuario</a>
        <a href="crearTipo.php">Crear nuevo tipo de usuario</a>
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
