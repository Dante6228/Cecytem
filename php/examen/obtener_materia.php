<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

// Obtención de las variables tipo post
$maestro = $_POST['maestro'];

// Consulta para obtener las materias del maestro seleccionado
$query = "
    SELECT ma.*
    FROM materia_maestro mm
    INNER JOIN materia ma ON mm.idMateria = ma.id
    WHERE mm.idMaestro = :maestro";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':maestro', $maestro);

$stmt->execute();

$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$options = "<option value=''>Selecciona una materia</option>";

// Generación de las opciones para las materias
foreach ($materias as $row) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['descripcion'] . "</option>";
}

echo $options;


