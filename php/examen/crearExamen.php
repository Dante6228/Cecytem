<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];
$parcial = $_POST['parcial'];
$maestro = $_POST['maestro'];
$materia = $_POST['materia'];

$titulo = $materia . " " . $parcial;

$query = "INSERT INTO examen (titulo) VALUES (:titulo)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':titulo', $titulo);
$stmt->execute();

$idExamen = $pdo->lastInsertId();

$query2 = "SELECT r.id, r.pregunta, r.idTema
        FROM reactivos r
        JOIN materia_maestro mm ON r.materia_maestro_id = mm.id
        JOIN semestre_grupo_parcial sgp ON sgp.idParcial = :parcial_id
        WHERE sgp.idSG = mm.idMateria
        AND mm.idMateria = :materia_id
        ORDER BY RAND()
        LIMIT 5;
";

$stmt2 = $pdo->prepare($query2);
$stmt2->bindParam(':parcial_id', $parcial);
$stmt2->bindParam(':materia_id', $materia);
$stmt2->execute();

$result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
if ($result) {
    // Procesar resultados, por ejemplo:
    foreach ($result as $row) {
        echo "ID: " . $row['id'] . " - Pregunta: " . $row['pregunta'] . " - Tema ID: " . $row['idTema'] . "<br>";
    }
} else {
    echo "No se encontraron reactivos.";
}
