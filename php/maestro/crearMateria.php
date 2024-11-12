<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$nombre = $_POST['nombre'];

$query = "INSERT INTO materia (descripcion) VALUES (:materia)";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':materia', $nombre);

if($stmt->execute()){
    header("Location: ../../maestros.php");
} else{
    echo "Error al crear la materia";
}
