<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "SELECT * FROM tema";

$stmt = $pdo->prepare($query);
$stmt->execute();

$temas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Temas y preguntas</title>
</head>
<body>
    <header>
        <h1>Temas y preguntas</h1>
    </header>
    <main>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "exito"){
                echo "<p class='exito'>Dato eliminado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "actualizacion1"){
                echo "<p class='exito'>El maestro y su materia se han actualizado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "actualizacion2"){
                echo "<p class='exito'>El maestro se ha actualizado correctamente</p>";
            }
        ?>
        <?php
            if(isset($_GET["msj"]) && $_GET["msj"] === "actualizacion3"){
                echo "<p class='exito'>La materia se ha actualizado correctamente</p>";
            }
        ?>
        <div class="contenedor">
            <div>
                <h2>Temas</h2>
                <?php if (!empty($temas)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tema</th>
                                <th>Materia</th>
                                <th>Borrar/actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($temas as $tema): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($tema['id']); ?></td>
                                    <td><?php echo htmlspecialchars($tema['descripcion']); ?></td>
                                    <td>
                                        <?php echo "<a href='php/maestro/borrar.php?id=" . urlencode($maestro['id_materia_maestro']) . "'>Borrar</a>"; ?>
                                        <?php echo "<a href='php/maestro/actualizar.php?id=" . urlencode($maestro['id_materia_maestro']) . "'>Actualizar</a>"; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay temas disponibles.</p>
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
