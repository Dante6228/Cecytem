<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

// Obtención de las variables tipo post
$semestre = $_POST['semestre'];

// Consulta para obtener los grupos del semestre seleccionado
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

// Generar opciones HTML
foreach ($grupos as $row) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
}

echo $options;


