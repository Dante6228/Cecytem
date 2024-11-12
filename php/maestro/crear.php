<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$maestro = $_POST['maestro'];
$materia = $_POST['materia'];

$query = "INSERT INTO materia_maestro (idMateria, idMaestro) VALUES (:idMateria, :idMaestro)";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':idMateria', $materia);
$stmt->bindParam(':idMaestro', $maestro);

if($stmt->execute()){
    header("Location: ../../maestros.php");
} else{
    echo "Error al relacionar el maestro con la materia";
}
