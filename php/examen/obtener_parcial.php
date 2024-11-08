<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];

$query = "SELECT * FROM parcial";

$stmt = $pdo->prepare($query);
$stmt->execute();

$parciales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generar opciones HTML
$options = "<option value=''>Selecciona un parcial</option>";

foreach ($parciales as $row) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
}

echo $options;
