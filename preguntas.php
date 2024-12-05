<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

$stmt = $pdo->query("SELECT * FROM materia");

$materia = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM parcial");

$parcial = $stmt->fetchAll(PDO::FETCH_ASSOC);

session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/crearCuenta.css">
    <title>Reactivos</title>
</head>
<body>
    <header>
        <h1>Reactivos</h1>
    </header>
    <main>
        <form action="php/preguntas/conseguir.php">
            <div class="input">
                <label for="materia">Materia</label>
                <select name="materia" id="materia">
                    <?php
                        foreach ($materia as $materias){
                            echo '<option value="'.$materias['id'].'">'.$materias['descripcion'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="input">
                <label for="parcial">Materia</label>
                <select name="parcial" id="parcial">
                    <?php
                        foreach ($parcial as $parciales){
                            echo '<option value="'.$parciales['id'].'">'.$parciales['descripcion'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="input">
                <button type="submit">Obtener reactivos</button>
            </div>
        </form>
        
    </main>
    <nav>
        <ul>
            <li>
                <a href="crearPregunta.php">Crear pregunta</a>
                <a href="inicio.php">Regresar</a>
            </li>
        </ul>
    </nav>
</body>
</html>
