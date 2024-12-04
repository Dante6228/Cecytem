<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

$pdo->exec("SET NAMES 'utf8'");

$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];
$parcial = $_POST['parcial'];
$maestro = $_POST['maestro'];
$materia = $_POST['materia'];

$query = "
    SELECT
        m.descripcion AS materia,
        p.descripcion AS parcial,
        s.descripcion AS semestre,
        g.descripcion AS grupo,
        ma.nombre AS maestro
    FROM
        semestre_grupo sg
    JOIN semestre s ON sg.idSemestre = s.id
    JOIN grupo g ON sg.idGrupo = g.id
    JOIN materia m ON m.id = :materia_id
    JOIN maestro ma ON ma.id = :maestro_id
    JOIN parcial p ON p.id = :parcial_id
    WHERE
        sg.idSemestre = :semestre_id
        AND sg.idGrupo = :grupo_id
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':semestre_id', $semestre);
$stmt->bindParam(':grupo_id', $grupo);
$stmt->bindParam(':parcial_id', $parcial);
$stmt->bindParam(':materia_id', $materia);
$stmt->bindParam(':maestro_id', $maestro);
$stmt->execute();
$titulo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($titulo) {
    $titulo_examen = $titulo['materia'] . " " . $titulo['parcial'] . " " . $titulo['semestre'] . " " . $titulo['grupo'] . " " . $titulo['maestro'];
} else {
    echo "No se encontró información para generar el título del examen.";
}

$query = "INSERT INTO examen (titulo) VALUES (:titulo)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':titulo', $titulo_examen);
$stmt->execute();
$idExamen = $pdo->lastInsertId();

// Obtener materia_maestro_id
$query_maestro_materia = "
    SELECT mm.id AS materia_maestro_id
    FROM materia_maestro mm
    WHERE mm.idMateria = :materia_id AND mm.idMaestro = :maestro_id
";

$stmt_maestro_materia = $pdo->prepare($query_maestro_materia);
$stmt_maestro_materia->bindParam(':materia_id', $materia);
$stmt_maestro_materia->bindParam(':maestro_id', $maestro);
$stmt_maestro_materia->execute();
$materia_maestro = $stmt_maestro_materia->fetch(PDO::FETCH_ASSOC);

if ($materia_maestro) {
    $materia_maestro_id = $materia_maestro['materia_maestro_id'];
} else {
    echo "No se encontró el ID de materia-maestro.";
    exit;
}

// Seleccionar preguntas
$query = "
    SELECT r.id AS reactivo_id, r.pregunta
    FROM reactivos r
    JOIN materia_maestro mm ON r.materia_maestro_id = mm.id
    WHERE mm.idMateria = :materia_id
    AND r.idParcial = :parcial_id
    ORDER BY RAND()
    LIMIT 10;
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':parcial_id', $parcial);
$stmt->bindParam(':materia_id', $materia);
$stmt->execute();
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($preguntas) {
    foreach ($preguntas as $pregunta) {
        $query_insert = "INSERT INTO examen_preguntas (idExamen, idPregunta) VALUES (:idExamen, :idPregunta)";
        $stmt_insert = $pdo->prepare($query_insert);
        $stmt_insert->bindParam(':idExamen', $idExamen);
        $stmt_insert->bindParam(':idPregunta', $pregunta['reactivo_id']);
        $stmt_insert->execute();
    }
}

// Redireccionar con el materia_maestro_id
header("Location: editar_examen.php?idExamen=$idExamen&idMateria=$materia&idParcial=$parcial&materiaMaestroId=$materia_maestro_id");
exit();
