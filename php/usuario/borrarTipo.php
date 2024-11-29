<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$id = $_GET['id'];

$query = "DELETE FROM tipousuario WHERE id = :id";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':id', $_GET['id']);

$stmt->execute();

header("Location: ../../cuentas.php?msj=exito2");
