<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

// Obtención de las variables tipo post
$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];

// Consulta para obtener los parciales
$query = "SELECT * FROM parcial";

$stmt = $pdo->prepare($query);
$stmt->execute();

$parciales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$options = "<option value=''>Selecciona un parcial</option>";

// Generar opciones HTML
foreach ($parciales as $row) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
}

echo $options;
