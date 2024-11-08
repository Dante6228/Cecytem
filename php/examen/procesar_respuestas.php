<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

// Variables para llevar la cuenta de respuestas correctas e incorrectas
$total_preguntas = 0;
$respuestas_correctas = 0;
$titulo_examen = $_POST['titulo_examen'];
$contenido = "<h2>Corrección</h2>";

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
            $contenido .= "<h3>" . $pregunta['pregunta'] . "</h3>";

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
                if ($opcion_id == $opcion_id_seleccionada) {
                    if ($es_correcta) {
                        $correcto = " - Correcta";
                    } else {
                        $correcto = " - Incorrecta";
                    }
                } else {
                    $correcto = "";
                }
                
                $contenido .= "<label>";

                $contenido .= "<input type='radio' name='respuesta_$reactivo_id' value='$opcion_id' disabled";

                if ($opcion_id == $opcion_id_seleccionada) {
                    $contenido .= " checked";
                }

                $contenido .= "> $descripcion";

                if ($opcion_id == $opcion_id_seleccionada) {
                    if ($es_correcta) {
                        $contenido .= " - Correcta";
                    } else {
                        $contenido .= " - Incorrecta";
                    }
                }

                $contenido .= "</label><br>";

            }
        }
    }
}

$contenido2 = "";

// Calcula el porcentaje de respuestas correctas
$porcentaje_correctas = ($total_preguntas > 0) ? ($respuestas_correctas / $total_preguntas) * 100 : 0;

// Muestra el resultado
$contenido2 .= "<div class='resultados'>";
$contenido2 .= "<h2>Resultado del Examen</h2>";
$contenido2 .= "<p>Respuestas correctas: $respuestas_correctas de $total_preguntas</p>";
$contenido2 .= "<p>Porcentaje de aciertos: " . round($porcentaje_correctas, 2) . "%</p>";

// Mensaje final en función del puntaje
if ($porcentaje_correctas >= 80) {
    $contenido2 .= "<p>¡Excelente trabajo! Aprobaste con éxito.</p>";
    $contenido2 .= "</div>";
} elseif ($porcentaje_correctas >= 60) {
    $contenido2 .= "<p>Buen intento, pero puedes mejorar.</p>";
    $contenido2 .= "</div>";
} else {
    $contenido2 .= "<p>Necesitas estudiar más. ¡No te desanimes!</p>";
    $contenido2 .= "</div>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/examen.css">
    <link rel="stylesheet" href="../../css/general.css">
    <title>Corrección de examen</title>
</head>
<body>
    <header>
        <h1>Examen <?php echo $titulo_examen?></h1>
    </header>
    <main>
        <div class="examen">
            <?php echo $contenido; ?>
        </div>
        <div class="correccion">
            <?php echo $contenido2;?>
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
