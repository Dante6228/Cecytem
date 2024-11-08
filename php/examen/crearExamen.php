<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];
$maestro = $_POST['maestro'];
$materia = $_POST['materia'];

echo $semestre . " " . $grupo . " " . $maestro . " " . $materia;

