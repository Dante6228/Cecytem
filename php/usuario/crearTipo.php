<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$nombre = $_POST['nombre'];

$query = "INSERT INTO tipousuario (descripcion) VALUES (:nombre)";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':nombre', $nombre);

if($stmt->execute()){
    header("Location: ../../cuentas.php?msj=creado2");
} else{
    echo "Error al crear el tipo de usuario";
}
