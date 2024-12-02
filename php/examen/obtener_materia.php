<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$maestro = $_POST['maestro'] ?? null;

if ($maestro) {
    $query = "
        SELECT DISTINCT ma.id, ma.descripcion
        FROM materia ma
        JOIN materia_maestro mm ON ma.id = mm.idMateria
        WHERE mm.idMaestro = :maestro
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':maestro', $maestro, PDO::PARAM_INT);
    $stmt->execute();

    $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($materias as $materia) {
        echo '<option value="' . $materia['id'] . '">' . $materia['descripcion'] . '</option>';
    }
}
