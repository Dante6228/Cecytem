<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$nombre = $_POST['nombre'];

$query = "INSERT INTO maestro (nombre) VALUES (:maestro)";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':maestro', $nombre);

if($stmt->execute()){
    header("Location: ../../maestros.php");
} else{
    echo "Error al crear al docente";
}
