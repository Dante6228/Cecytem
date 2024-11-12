<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "
    SELECT m.nombre AS maestro, mt.descripcion AS materia
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
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/maestros.css">
    <title>Maestros</title>
</head>
<body>
    <header>
        <h1>Maestros</h1>
    </header>
    <main>
        <div class="contenedor">
            <div>
                <h2>Lista de Maestros y sus Materias</h2>
                <?php if (!empty($maestros)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Maestro</th>
                                <th>Materia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($maestros as $maestro): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($maestro['maestro']); ?></td>
                                    <td><?php echo htmlspecialchars($maestro['materia']); ?></td>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($maestros2 as $maestro): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($maestro['nombre']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay maestros o materias disponibles.</p>
                <?php endif; ?>
            </div>
            <div>
                <h2>Materias</h2>
                <?php if (!empty($materias)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Maestro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $materia): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($materia['descripcion']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay maestros o materias disponibles.</p>
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
