<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$idExamen = $_POST['idExamen'];
$idPregunta = $_POST['nuevaPregunta'];

if (!empty($idPregunta)) {
    $query = "INSERT INTO examen_preguntas (idExamen, idPregunta) VALUES (:idExamen, :idPregunta)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idExamen', $idExamen);
    $stmt->bindParam(':idPregunta', $idPregunta);
    $stmt->execute();
}

header("Location: editar_examen.php?idExamen=$idExamen");
exit();
