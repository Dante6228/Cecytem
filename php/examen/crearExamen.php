<?php

require_once __DIR__ . "../../conexion/conexion.php";

$pdo = conn::conn();

$pdo->exec("SET NAMES 'utf8'");

// Obtención de las variables post
$semestre = $_POST['semestre'];
$grupo = $_POST['grupo'];
$parcial = $_POST['parcial'];
$maestro = $_POST['maestro'];
$materia = $_POST['materia'];

$query = "
    SELECT
        m.descripcion AS materia,
        p.descripcion AS parcial,
        s.descripcion AS semestre,
        g.descripcion AS grupo,
        ma.nombre AS maestro
    FROM
        semestre_grupo sg
    JOIN semestre s ON sg.idSemestre = s.id
    JOIN grupo g ON sg.idGrupo = g.id
    JOIN materia m ON m.id = :materia_id
    JOIN maestro ma ON ma.id = :maestro_id
    JOIN parcial p ON p.id = :parcial_id
    WHERE
        sg.idSemestre = :semestre_id
        AND sg.idGrupo = :grupo_id
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':semestre_id', $semestre);
$stmt->bindParam(':grupo_id', $grupo);
$stmt->bindParam(':parcial_id', $parcial);
$stmt->bindParam(':materia_id', $materia);
$stmt->bindParam(':maestro_id', $maestro);
$stmt->execute();
$titulo = $stmt->fetch(PDO::FETCH_ASSOC);

// Valida si se encontró información para generar el título del examen
if ($titulo) {
    $titulo_examen = $titulo['materia'] . " " . $titulo['parcial'] . " " . $titulo['semestre'] . " " . $titulo['grupo'] . " " . $titulo['maestro'];
} else {
    echo "No se encontró información para generar el título del examen.";
}

// Inserta un nuevo examen
$query = "INSERT INTO examen (titulo) VALUES (:titulo)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':titulo', $titulo_examen);
$stmt->execute();
$idExamen = $pdo->lastInsertId();

// Selecciona las preguntas (reactivos) al azar de acuerdo a la materia y el parcial
$query = "
    SELECT r.id AS reactivo_id, r.pregunta
    FROM reactivos r
    JOIN materia_maestro mm ON r.materia_maestro_id = mm.id
    WHERE mm.idMateria = :materia_id
    AND r.idParcial = :parcial_id
    ORDER BY RAND()
    LIMIT 10;
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':parcial_id', $parcial);
$stmt->bindParam(':materia_id', $materia);
$stmt->execute();
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/tcpdf/tcpdf.php';

// Crear un nuevo PDF
$pdf = new TCPDF();
$pdf->SetFont('dejavusans', '', 12);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Cecytem');
$pdf->SetTitle('Examen ' . $titulo_examen);
$pdf->SetHeaderData('', 0, 'Examen ' . $titulo['materia'], $titulo_examen);

// Configuración del PDF
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 8]);
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

// Contenido del examen
$html = "<h1 style='text-align: center;'>Examen: $titulo_examen</h1>";

$html .= "<strong>Nombre: ____________________________________________________________</strong><br><br>";
$html .= "<strong>Calificación: ________</strong>";

if ($preguntas) {
    foreach ($preguntas as $pregunta) {
        $reactivo_id = $pregunta['reactivo_id'];
        $texto_pregunta = $pregunta['pregunta'];

        $html .= "<h3>$texto_pregunta</h3>";

        // Opciones de respuesta
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

// Escribir contenido en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('examen.pdf', 'D');


