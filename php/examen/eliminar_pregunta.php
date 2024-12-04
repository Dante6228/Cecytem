<?php
require_once __DIR__ . "/../conexion/conexion.php";
$pdo = conn::conn();

$idExamen = $_GET['idExamen'];
$idPregunta = $_GET['idPregunta'];
$idParcial = $_GET['idParcial'];
$idMateria = $_GET['idMateria'];

$query = "DELETE FROM examen_preguntas WHERE idExamen = :idExamen AND idPregunta = :idPregunta";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':idExamen', $idExamen);
$stmt->bindParam(':idPregunta', $idPregunta);
$stmt->execute();

header("Location: editar_examen.php?idExamen=$idExamen&idParcial=$parcial&idMateria=$idMateria");
exit();
