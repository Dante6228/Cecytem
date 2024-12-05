<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/editar.css">
    <title>Editar pregunta</title>
</head>
<body>

    <header>
        <h1>Editar pregunta</h1>
    </header>

    <main>
    <?php

        if (isset($_GET['editar_pregunta'])) {
            $pregunta_id = $_GET['editar_pregunta'];

            $stmt = $pdo->prepare("SELECT r.pregunta, o.id AS opcion_id, o.descripcion AS opcion, o.es_correcta
                                FROM reactivos r
                                JOIN opciones o ON r.id = o.reactivo_id
                                WHERE r.id = :pregunta_id");
            $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
            $stmt->execute();
            $editar_pregunta = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($editar_pregunta) {
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='pregunta_id' value='{$pregunta_id}'>";
                echo "<label for='pregunta'>Pregunta:</label><br>";
                echo "<input type='text' id='pregunta' name='pregunta' value='{$editar_pregunta[0]['pregunta']}' required>";

                foreach ($editar_pregunta as $opcion) {
                    echo "<label for='opcion_{$opcion['opcion_id']}'>Opción:</label>";
                    echo "<input type='text' id='opcion_{$opcion['opcion_id']}' name='opciones[{$opcion['opcion_id']}]' value='{$opcion['opcion']}' required>";

                    echo "<label for='correcta_{$opcion['opcion_id']}'>¿Es correcta?</label>";
                    echo "<input type='radio' name='correcta' value='{$opcion['opcion_id']}' " . ($opcion['es_correcta'] ? "checked" : "") . ">";
                }

                echo "<button type='submit' name='actualizar_pregunta'>Actualizar Pregunta</button>";
                echo "</form>";
            }
        }

        if (isset($_POST['actualizar_pregunta'])) {
            $pregunta_id = $_POST['pregunta_id'];
            $nueva_pregunta = $_POST['pregunta'];
            $opciones = $_POST['opciones'];
            $respuesta_correcta = $_POST['correcta'];

            $stmt = $pdo->prepare("UPDATE reactivos SET pregunta = :pregunta WHERE id = :pregunta_id");
            $stmt->bindParam(':pregunta', $nueva_pregunta, PDO::PARAM_STR);
            $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
            $stmt->execute();

            foreach ($opciones as $opcion_id => $descripcion) {
                $es_correcta = ($opcion_id == $respuesta_correcta) ? true : false;

                $stmt = $pdo->prepare("UPDATE opciones SET descripcion = :descripcion, es_correcta = :es_correcta WHERE id = :opcion_id");
                $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $stmt->bindParam(':es_correcta', $es_correcta, PDO::PARAM_BOOL);
                $stmt->bindParam(':opcion_id', $opcion_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            header("Location: ../../preguntas.php");
            exit;
        }

        ?>
    </main>

</body>
</html>

