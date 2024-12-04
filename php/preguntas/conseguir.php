<?php
require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/conseguir.css">
    <title>Cuestionario</title>
</head>
<body>

    <header>
        <h1>Preguntas</h1>
    </header>

<?php
if (isset($_GET['materia']) && isset($_GET['parcial'])) {
    $materia_id = $_GET['materia'];
    $parcial_id = $_GET['parcial'];

    $stmt = $pdo->prepare(
        "SELECT r.id, r.pregunta, o.id AS opcion_id, o.descripcion AS opcion, o.es_correcta
        FROM reactivos r
        JOIN opciones o ON r.id = o.reactivo_id
        WHERE r.materia_maestro_id IN (SELECT id FROM materia_maestro WHERE idMateria = :materia_id)
        AND r.idParcial = :parcial_id"
    );
    $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
    $stmt->bindParam(':parcial_id', $parcial_id, PDO::PARAM_INT);
    $stmt->execute();

    $reactivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($reactivos) {
        $preguntas = [];
        foreach ($reactivos as $reactivo) {
            $preguntas[$reactivo['id']]['pregunta'] = $reactivo['pregunta'];
            $preguntas[$reactivo['id']]['opciones'][] = [
                'id' => $reactivo['opcion_id'],
                'descripcion' => $reactivo['opcion'],
                'es_correcta' => $reactivo['es_correcta']
            ];
        }
        
        echo '<div class="quiz-container">';
        foreach ($preguntas as $id => $pregunta) {
            echo "<div class='question-container'>";
            echo "<h3 class='question'>{$pregunta['pregunta']}</h3>";
            echo "<div class='options'>";
            foreach ($pregunta['opciones'] as $opcion) {
                echo "<label><input type='radio' name='pregunta_{$id}' value='{$opcion['id']}'> {$opcion['descripcion']}</label><br>";
            }
            echo "</div>";
            echo "</div>";
        }
        echo '</div>';
    } else {
        echo "<p class='no-results'>No se encontraron reactivos para la materia y el parcial seleccionados.</p>";
    }
} else {
    echo "<p class='no-selection'>Por favor, seleccione una materia y un parcial.</p>";
}
?>

<a href="../../preguntas.php">Regresar</a>

</body>
</html>