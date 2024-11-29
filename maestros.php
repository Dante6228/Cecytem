<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "
    SELECT mm.id AS id_materia_maestro, m.nombre AS maestro, mt.descripcion AS materia
    FROM maestro m
    INNER JOIN materia_maestro mm ON m.id = mm.idMaestro
    INNER JOIN materia mt ON mm.idMateria = mt.id
";


$stmt = $pdo->prepare($query);
$stmt->execute();

$maestros = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM maestro";

$stmt = $pdo->prepare($query);
$stmt->execute();

$maestros2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM materia";

$stmt = $pdo->prepare($query);
$stmt->execute();

$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/maestros.css">
    <title>Maestros y materias</title>
</head>
<body>
    <header>
        <h1>Maestros y materias</h1>
    </header>
    <main>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "exito"){
                echo "<p class='exito'>El maestro y su materia se ha eliminado correctamente</p>";
            }
        ?>
        <div class="contenedor">
            <div>
                <h2>Lista de Maestros y sus Materias</h2>
                <?php if (!empty($maestros)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Maestro</th>
                                <th>Materia</th>
                                <th>Borrar/actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($maestros as $maestro): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($maestro['maestro']); ?></td>
                                    <td><?php echo htmlspecialchars($maestro['materia']); ?></td>
                                    <td>
                                        <?php echo "<a href='php/maestro/borrar.php?id=" . urlencode($maestro['id_materia_maestro']) . "'>Borrar</a>"; ?>
                                        <?php echo "<a href='php/maestro/actualizar.php?id=" . urlencode($maestro['id_materia_maestro']) . "'>Actualizar</a>"; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay maestros o materias disponibles.</p>
                <?php endif; ?>
            </div>
            <div>
                <h2>Maestros</h2>
                <?php if (!empty($maestros2)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Maestro</th>
                                <th>Borrar/actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($maestros2 as $maestro): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($maestro['nombre']); ?></td>
                                    <td>
                                        <?php echo "<a href='php/maestro/borrarMaestro.php?id=" . urlencode($maestro['id']) . "'>Borrar</a>"; ?>
                                        <?php echo "<a href='php/maestro/actualizarMaestro.php?id=" . urlencode($maestro['id']) . "'>Actualizar</a>"; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay maestros disponibles.</p>
                <?php endif; ?>
            </div>
            <div>
                <h2>Materias</h2>
                <?php if (!empty($materias)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Borrar/actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $materia): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($materia['descripcion']); ?></td>
                                    <td>
                                        <?php echo "<a href='php/maestro/borrarMateria.php?id=" . urlencode($materia['id']) . "'>Borrar</a>"; ?>
                                        <?php echo "<a href='php/maestro/actualizarMaeteria.php?id=" . urlencode($materia['id']) . "'>Actualizar</a>"; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay materias disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <a href="crearMaestro.php">Asignar nueva materia al docente</a>
        <a href="crearMateria.php">Crear nueva materia</a>
        <a href="crearDocente.php">Crear nuevo maestro</a>
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
