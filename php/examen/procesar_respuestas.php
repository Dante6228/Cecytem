<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

// Variables para llevar la cuenta de respuestas correctas e incorrectas
$total_preguntas = 0;
$respuestas_correctas = 0;

// Recorre todas las respuestas enviadas
foreach ($_POST as $clave => $valor) {
    // Verifica que el nombre del campo corresponda a una respuesta (empieza con "respuesta_")
    if (strpos($clave, 'respuesta_') === 0) {
        // Extrae el reactivo_id de la clave, que tiene el formato "respuesta_{reactivo_id}"
        $reactivo_id = str_replace('respuesta_', '', $clave);
        $opcion_id_seleccionada = $valor;  // ID de la opción seleccionada por el usuario

        // Consulta para obtener la pregunta y las opciones para este reactivo
        $query = "SELECT r.pregunta, o.id AS opcion_id, o.descripcion, o.es_correcta
                FROM reactivos r
                JOIN opciones o ON r.id = o.reactivo_id
                WHERE r.id = :reactivo_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':reactivo_id', $reactivo_id);
        $stmt->execute();
        
        $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pregunta) {
            $total_preguntas++;

            // Verifica si la opción seleccionada es correcta
            if ($pregunta['opcion_id'] == $opcion_id_seleccionada && $pregunta['es_correcta']) {
                $respuestas_correctas++;
                $respuesta_correcta = true;
            } else {
                $respuesta_correcta = false;
            }

            // Imprime la pregunta y las opciones
            echo "<h3>" . $pregunta['pregunta'] . "</h3>";

            // Mostrar opciones y marcar la correcta
            $opciones_query = "SELECT id, descripcion, es_correcta FROM opciones WHERE reactivo_id = :reactivo_id";
            $stmt_opciones = $pdo->prepare($opciones_query);
            $stmt_opciones->bindParam(':reactivo_id', $reactivo_id);
            $stmt_opciones->execute();
            $opciones = $stmt_opciones->fetchAll(PDO::FETCH_ASSOC);

            foreach ($opciones as $opcion) {
                $opcion_id = $opcion['id'];
                $descripcion = $opcion['descripcion'];
                $es_correcta = $opcion['es_correcta'];

                // Marca la opción seleccionada y si es correcta
                $correcto = ($opcion_id == $opcion_id_seleccionada) ? ($es_correcta ? " - Correcta" : " - Incorrecta") : "";

                echo "<label>";
                echo "<input type='radio' name='respuesta_$reactivo_id' value='$opcion_id' disabled" .
                    (($opcion_id == $opcion_id_seleccionada) ? " checked" : "") . "> $descripcion$correcto";
                echo "</label><br>";
            }
            echo "<br>";
        }
    }
}

// Calcula el porcentaje de respuestas correctas
$porcentaje_correctas = ($total_preguntas > 0) ? ($respuestas_correctas / $total_preguntas) * 100 : 0;

// Muestra el resultado
echo "<h2>Resultado del Examen</h2>";
echo "<p>Respuestas correctas: $respuestas_correctas de $total_preguntas</p>";
echo "<p>Porcentaje de aciertos: " . round($porcentaje_correctas, 2) . "%</p>";

// Mensaje final en función del puntaje
if ($porcentaje_correctas >= 80) {
    echo "<p>¡Excelente trabajo! Aprobaste con éxito.</p>";
} elseif ($porcentaje_correctas >= 60) {
    echo "<p>Buen intento, pero puedes mejorar.</p>";
} else {
    echo "<p>Necesitas estudiar más. ¡No te desanimes!</p>";
}

