<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$semestre = $_POST['semestre'] ?? null;
$grupo = $_POST['grupo'] ?? null;

if ($semestre && $grupo) {
    $query = "
        SELECT DISTINCT m.id, m.nombre
        FROM maestro m
        JOIN materia_maestro mm ON m.id = mm.idMaestro
        JOIN materia ma ON mm.idMateria = ma.id
        JOIN semestre_grupo sg ON sg.idSemestre = :semestre AND sg.idGrupo = :grupo
        WHERE sg.idSemestre = :semestre AND sg.idGrupo = :grupo
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':semestre', $semestre, PDO::PARAM_INT);
    $stmt->bindParam(':grupo', $grupo, PDO::PARAM_INT);
    $stmt->execute();

    $maestros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($maestros as $maestro) {
        echo '<option value="' . $maestro['id'] . '">' . $maestro['nombre'] . '</option>';
    }
}
