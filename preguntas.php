<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "
    SELECT t.id AS tema_id, t.descripcion AS tema_descripcion, r.id AS pregunta_id, r.pregunta
    FROM tema t
    LEFT JOIN reactivos r ON t.id = r.idTema
    ORDER BY t.id, r.id
";
$stmt = $pdo->prepare($query);
$stmt->execute();

$temasConPreguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <div class="contenedor">
            <div>
                <h2>Temas y Preguntas</h2>
                <?php if (!empty($temasConPreguntas)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tema</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $temaAnterior = null;
                            foreach ($temasConPreguntas as $item):
                                if ($temaAnterior != $item['tema_id']):
                                    if ($temaAnterior !== null): ?>
                                        </tbody>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="3"><strong><?php echo htmlspecialchars($item['tema_descripcion']); ?></strong></td>
                                    </tr>
                                    <tbody>
                                <?php endif;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['pregunta_id']); ?></td>
                                    <td><?php echo htmlspecialchars($item['pregunta']); ?></td>
                                    <td></td> <!-- O puedes agregar acciones como editar/borrar si es necesario -->
                                </tr>
                                <?php
                                $temaAnterior = $item['tema_id'];
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay temas o preguntas disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
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
