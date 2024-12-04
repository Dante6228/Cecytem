<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$idExamen = $_GET['idExamen'];
$idParcial = $_GET['idParcial'];
$idMateria = $_GET['idMateria'];

$query_maestro_materia = "
    SELECT mm.id AS materia_maestro_id
    FROM materia_maestro mm
    JOIN materia m ON mm.idMateria = m.id
    JOIN maestro ma ON mm.idMaestro = ma.id
    WHERE m.id = :idMateria
";
$stmt_maestro_materia = $pdo->prepare($query_maestro_materia);
$stmt_maestro_materia->bindParam(':idMateria', $idMateria);
$stmt_maestro_materia->execute();
$materia_maestro = $stmt_maestro_materia->fetch(PDO::FETCH_ASSOC);

// Verificar que se haya encontrado el materia_maestro_id
if ($materia_maestro) {
    $materiaMaestroId = $materia_maestro['materia_maestro_id'];
} else {
    echo "No se encontró la relación materia-maestro.";
    exit;
}

$query = "
    SELECT r.id AS pregunta_id, r.pregunta, o.id AS opcion_id, o.descripcion, o.es_correcta
    FROM examen_preguntas ep
    JOIN reactivos r ON ep.idPregunta = r.id
    LEFT JOIN opciones o ON r.id = o.reactivo_id
    WHERE ep.idExamen = :idExamen
    ORDER BY r.id, o.id
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':idExamen', $idExamen);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$preguntas = [];
foreach ($data as $row) {
    $preguntaId = $row['pregunta_id'];
    if (!isset($preguntas[$preguntaId])) {
        $preguntas[$preguntaId] = [
            'pregunta' => $row['pregunta'],
            'opciones' => [],
            'respuesta_correcta' => null,
        ];
    }
    $opcion = [
        'id' => $row['opcion_id'],
        'descripcion' => $row['descripcion'],
        'es_correcta' => $row['es_correcta'],
    ];
    if ($row['es_correcta'] == 1) {
        $preguntas[$preguntaId]['respuesta_correcta'] = $row['descripcion'];
    }
    $preguntas[$preguntaId]['opciones'][] = $opcion;
}

$query_todas = "SELECT id, pregunta FROM reactivos WHERE materia_maestro_id = :materiaMaestroId";
$stmt_todas = $pdo->prepare($query_todas);
$stmt_todas->bindParam(':materiaMaestroId', $materiaMaestroId, PDO::PARAM_INT);
$stmt_todas->execute();
$todas_preguntas = $stmt_todas->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/editarExamen.css">
    <title>Editar Examen</title>
</head>
<body>
    <h1>Editar Examen</h1>

    <form action="actualizar_examen.php" method="post">
        <input type="hidden" name="idExamen" value="<?= $idExamen ?>">

        <h2>Preguntas actuales</h2>
        <ul>
            <?php foreach ($preguntas as $id => $pregunta): ?>
                <li>
                    <strong><?= $pregunta['pregunta'] ?></strong>
                    <button type="button" onclick="eliminarPregunta(<?= $id ?>)">Eliminar</button>
                    <ul>
                        <?php foreach ($pregunta['opciones'] as $opcion): ?>
                            <li>
                                <?= $opcion['descripcion'] ?>
                                <?php if ($opcion['es_correcta'] == 1): ?>
                                    <strong>(Correcta)</strong>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p><em>Respuesta correcta: <?= $pregunta['respuesta_correcta'] ?></em></p>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Agregar preguntas</h2>
        <select name="nuevaPregunta">
            <option value="">Selecciona una pregunta</option>
            <?php foreach ($todas_preguntas as $pregunta): ?>
                <option value="<?= $pregunta['id'] ?>"><?= $pregunta['pregunta'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Agregar</button>
    </form>

    <a href="descargar_pdf.php?idExamen=<?= $idExamen ?>" target="_blank">
        <button type="button">Descargar PDF</button>
    </a>
    <a href="../../crearExamen.php" class="boton">Regresar</a>

    <script>
        function eliminarPregunta(idPregunta) {
            window.location.href = `eliminar_pregunta.php?idExamen=<?= $idExamen ?>&idPregunta=${idPregunta}`;
        }
    </script>
</body>
</html>
