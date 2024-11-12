<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

// Obtención de las variables post
$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];
$parcial = $_POST['parcial'];
$maestro = $_POST['maestro'];
$materia = $_POST['materia'];

// Consulta para obtener los datos del examen (materia, parcial, semestre, grupo, maestro)
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

// Valida si se encontró información para generar el título del examen
if ($titulo) {
    // Concatenar los datos para crear el título del examen
    $titulo_examen = $titulo['materia'] . " - " . $titulo['parcial'] . " - " . $titulo['semestre'] . " - " . $titulo['grupo'] . " - " . $titulo['maestro'];
} else {
    echo "No se encontró información para generar el título del examen.";
}

// Inserta un nuevo examen
$query = "INSERT INTO examen (titulo) VALUES (:titulo)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':titulo', $titulo_examen);
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
    LIMIT 6;
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':parcial_id', $parcial);
$stmt->bindParam(':materia_id', $materia);
$stmt->execute();
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/examen.css">
    <link rel="stylesheet" href="../../css/general.css">
    <title>Examen <?php echo $titulo['materia']?></title>
</head>
<body>
    <header>
        <h1>Examen <?php echo $titulo_examen?></h1>
    </header>
    <main>
        <div class="examen">
            <?php
            // Muestra el formulario para responder al examen
                if ($preguntas) {
                    echo "<form action='procesar_respuestas.php' method='POST'>";
                    echo "<input type='hidden' name='titulo_examen' value='$titulo_examen'>";

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
                            
                            echo "<div class='opcion'>";
                            echo "<label>";
                            echo "<input type='radio' name='respuesta_$reactivo_id' value='$opcion_id'> $descripcion";
                            echo "</label><br>";
                            echo "</div";
                        }
                        echo "<br>";
                    }

                    echo "<button type='submit' value='Enviar'>Enviar respuesta</button>";
                    echo "</form>";
                } else {
                    echo "No se encontraron reactivos.";
                }
            ?>
        </div>
    </main>
    <nav>
        <ul>
            <li>
                <a href="../../inicio.php">Regresar al menú principal</a>
            </li>
        </ul>
    </nav>
</body>
</html>

