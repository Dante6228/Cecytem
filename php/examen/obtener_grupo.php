<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$semestre = $_POST['semestre'];

$query = "
    SELECT g.*
    FROM semestre_grupo sg
    INNER JOIN grupo g ON sg.idGrupo = g.id
    WHERE sg.idSemestre = :semestre";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':semestre', $semestre);

$stmt->execute();

$grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$options = "<option value=''>Selecciona un grupo</option>";

foreach ($grupos as $row) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
}

echo $options;


