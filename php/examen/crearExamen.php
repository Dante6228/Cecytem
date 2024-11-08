<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

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
    // Concatenar los datos para crear el título del examen
    $titulo_examen = $titulo['materia'] . " - " . $titulo['parcial'] . " - " . $titulo['semestre'] . " - " . $titulo['grupo'] . " - " . $titulo['maestro'];
    echo "Título del examen: " . $titulo_examen;
} else {
    echo "No se encontró información para generar el título del examen.";
}

// Inserta un nuevo examen
$query = "INSERT INTO examen (titulo) VALUES (:titulo)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':titulo', $titulo_examen);  // Aquí se debe pasar $titulo_examen, no $titulo
$stmt->execute();
$idExamen = $pdo->lastInsertId();

// Selecciona las preguntas (reactivos) al azar de acuerdo a la materia y el parcial
$query = "
    SELECT r.id AS reactivo_id, r.pregunta
    FROM reactivos r
    JOIN materia_maestro mm ON r.materia_maestro_id = mm.id
    WHERE mm.idMateria = :materia_id
    AND r.idParcial = :parcial_id
    ORDER BY RAND()
    LIMIT 5;
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':parcial_id', $parcial);
$stmt->bindParam(':materia_id', $materia);
$stmt->execute();
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($preguntas) {
    echo "<form action='procesar_respuestas.php' method='POST'>";

    foreach ($preguntas as $pregunta) {
        $reactivo_id = $pregunta['reactivo_id'];
        $texto_pregunta = $pregunta['pregunta'];

        // Muestra la pregunta
        echo "<h3>$texto_pregunta</h3>";

        // Inserta la pregunta en la tabla examen_reactivo para asociarla con el examen actual
        $query = "INSERT INTO examen_reactivo (examen_id, reactivo_id) VALUES (:examen_id, :reactivo_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':examen_id', $idExamen);
        $stmt->bindParam(':reactivo_id', $reactivo_id);
        $stmt->execute();

        // Selecciona las opciones de respuesta para la pregunta actual
        $query = "SELECT id, descripcion, es_correcta FROM opciones WHERE reactivo_id = :reactivo_id";
        $stmt_opciones = $pdo->prepare($query);
        $stmt_opciones->bindParam(':reactivo_id', $reactivo_id);
        $stmt_opciones->execute();
        $opciones = $stmt_opciones->fetchAll(PDO::FETCH_ASSOC);

        // Muestra las opciones como radio buttons
        foreach ($opciones as $opcion) {
            $opcion_id = $opcion['id'];
            $descripcion = $opcion['descripcion'];

            echo "<label>";
            echo "<input type='radio' name='respuesta_$reactivo_id' value='$opcion_id'> $descripcion";
            echo "</label><br>";
        }
        echo "<br>";
    }

    echo "<input type='submit' value='Enviar'>";
    echo "</form>";
} else {
    echo "No se encontraron reactivos.";
}

