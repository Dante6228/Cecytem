<?php

require_once __DIR__ . "/../conexion/conexion.php";
require_once __DIR__ . "/tcpdf/tcpdf.php";

$pdo = conn::conn();
$idExamen = $_GET['idExamen'];

$queryTitulo = "SELECT titulo FROM examen WHERE id = :idExamen";
$stmtTitulo = $pdo->prepare($queryTitulo);
$stmtTitulo->bindParam(':idExamen', $idExamen);
$stmtTitulo->execute();
$tituloExamen = $stmtTitulo->fetchColumn();

$query = "SELECT r.id AS reactivo_id, r.pregunta
        FROM examen_preguntas ep
        JOIN reactivos r ON ep.idPregunta = r.id
        WHERE ep.idExamen = :idExamen";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':idExamen', $idExamen);
$stmt->execute();
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new TCPDF();
$pdf->SetFont('dejavusans', '', 12);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Cecytem');
$pdf->SetTitle('Examen - ' . $tituloExamen);
$pdf->SetHeaderData('', 0, 'Examen: ' . $tituloExamen, 'Cecytem');

$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 8]);
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

$html = "<h1 style='text-align: center;'>$tituloExamen</h1>";
$html .= "<strong>Nombre: ____________________________________________________________</strong><br><br>";
$html .= "<strong>Calificación: ________</strong><br><br>";

if ($preguntas) {
    foreach ($preguntas as $pregunta) {
        $reactivo_id = $pregunta['reactivo_id'];
        $texto_pregunta = $pregunta['pregunta'];
    
        $html .= "<h3>$texto_pregunta</h3>";
    
        $query = "SELECT descripcion FROM opciones WHERE reactivo_id = :reactivo_id";
        $stmt_opciones = $pdo->prepare($query);
        $stmt_opciones->bindParam(':reactivo_id', $reactivo_id);
        $stmt_opciones->execute();
        $opciones = $stmt_opciones->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($opciones as $opcion) {
            $descripcion = $opcion['descripcion'];
            $html .= "<p><strong>O</strong> $descripcion</p>";
        }
        $html .= "<br>";
    }
} else {
    $html .= "<p>No se encontraron reactivos.</p>";
}

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("Examen_$idExamen.pdf", 'D');
