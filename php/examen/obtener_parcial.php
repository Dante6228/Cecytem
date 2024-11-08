<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];

$query = "
    SELECT sgp.idParcial, p.descripcion
    FROM semestre_grupo sg
    INNER JOIN semestre_grupo_parcial sgp ON sg.id = sgp.idSG
    INNER JOIN parcial p ON sgp.idParcial = p.id
    WHERE sg.idSemestre = :semestre AND sg.idGrupo = :grupo";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':semestre', $semestre, PDO::PARAM_INT);
$stmt->bindParam(':grupo', $grupo, PDO::PARAM_INT);

$stmt->execute();

$parciales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generar opciones HTML
$options = "<option value=''>Selecciona un parcial</option>";

foreach ($parciales as $row) {
    $options .= "<option value='" . $row['idParcial'] . "'>" . $row['descripcion'] . "</option>";
}

echo $options;
