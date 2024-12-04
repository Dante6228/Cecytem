<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pregunta = $_POST['pregunta'];
    $tema_id = $_POST['tema'];
    $opciones = $_POST['opciones'];
    $respuesta_correcta = $_POST['correcta'];
    $parcial = $_POST['parcial'];
    $materia = $_POST['materia'];
    $maestro = $_POST['maestro'];

    $query = "SELECT id FROM materia_maestro WHERE idMateria = '$materia' AND idMaestro = '$maestro'";

    $stmt = $pdo->prepare($query);

    $stmt->execute();
    
    $materiaMaestro = $stmt->fetch(PDO::FETCH_ASSOC);

    try {

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO reactivos (pregunta, idTema, materia_maestro_id, idParcial) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pregunta, $tema_id, $materiaMaestro['id'], $parcial]);

        $reactivo_id = $pdo->lastInsertId();

        foreach ($opciones as $index => $opcion) {
            $es_correcta = ($index + 1 == $respuesta_correcta) ? true : false;

            $stmt = $pdo->prepare("INSERT INTO opciones (reactivo_id, descripcion, es_correcta) VALUES (?, ?, ?)");
            $stmt->execute([$reactivo_id, $opcion, $es_correcta]);
        }

        $pdo->commit();
        echo "Pregunta y opciones añadidas correctamente.";

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/crearCuenta.css">
    <title>Crear pregunta</title>
</head>
<body>

    <header>
        <h1>Crear pregunta</h1>
    </header>

    <main>
        <h3>Añadir nueva pregunta</h3>
        <form action="?" method="POST">
            <div class="input">
                <label for="pregunta">Pregunta:</label>
                <textarea name="pregunta" id="pregunta" required></textarea>
            </div>
            <div class="input">
                <label for="tema">Tema:</label>
                <select name="tema" id="tema" required>
                    <?php
                    $stmt = $pdo->prepare("SELECT id, descripcion FROM tema");
                    $stmt->execute();
                    $temas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($temas as $tema) {
                        echo "<option value='{$tema['id']}'>{$tema['descripcion']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="input">
                <label for="parcial">Parcial:</label>
                <select name="parcial" id="parcial" required>
                    <?php
                    $stmt = $pdo->prepare("SELECT id, descripcion FROM parcial");
                    $stmt->execute();
                    $parciales = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($parciales as $parcial) {
                        echo "<option value='{$parcial['id']}'>{$parcial['descripcion']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="input">
                <label for="materia">Materia:</label>
                <select name="materia" id="materia" required>
                    <?php
                    $stmt = $pdo->prepare("SELECT id, descripcion FROM materia");
                    $stmt->execute();
                    $parciales = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($parciales as $parcial) {
                        echo "<option value='{$parcial['id']}'>{$parcial['descripcion']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="input">
                <label for="maestro">Maestro:</label>
                <select name="maestro" id="maestro" required>
                    <?php
                    $stmt = $pdo->prepare("SELECT id, nombre FROM maestro");
                    $stmt->execute();
                    $parciales = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($parciales as $parcial) {
                        echo "<option value='{$parcial['id']}'>{$parcial['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
    
            <label for="opciones">Opciones:</label>
            <div id="opciones-container">
                <div class="opcion">
                    <input type="text" name="opciones[]" placeholder="Opción 1" required>
                    <input type="radio" name="correcta" value="1" required> Correcta
                </div>
                <div class="opcion">
                    <input type="text" name="opciones[]" placeholder="Opción 2" required>
                    <input type="radio" name="correcta" value="2" required> Correcta
                </div>
                <div class="opcion">
                    <input type="text" name="opciones[]" placeholder="Opción 3" required>
                    <input type="radio" name="correcta" value="3" required> Correcta
                </div>
                <div class="opcion">
                    <input type="text" name="opciones[]" placeholder="Opción 4" required>
                    <input type="radio" name="correcta" value="4" required> Correcta
                </div>
            </div>
    
            <button type="submit">Agregar Pregunta</button>
        </form>
    </main>
    
    <a href="inicio.php">Regresar</a>
</body>
</html>
