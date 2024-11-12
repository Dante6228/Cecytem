<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

// Consulta con INNER JOIN para obtener los maestros y las materias que enseñan
$query = "
    SELECT m.nombre AS maestro, mt.descripcion AS materia 
    FROM maestro m
    INNER JOIN materia_maestro mm ON m.id = mm.idMaestro
    INNER JOIN materia mt ON mm.idMateria = mt.id
";

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare($query);
$stmt->execute();

// Obtener todos los resultados
$maestros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css">
    <style>
        h2{
            text-align: center;
            margin-top: 30px;
        }

        table{
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 25px auto;
        }

        th, td{
            padding: 10px;
            text-align: left;
            border: 1px solid;
        }

        nav{
            height: 100px;
            display: flex;
            align-items: center;
        }
        a{
            text-decoration: none;
        }
    </style>
    <title>Maestros</title>
</head>
<body>
    <header>
        <h1>Maestros</h1>
    </header>
    <main>
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
