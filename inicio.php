<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "SELECT * FROM usuario where id = " . $_SESSION['id'];

$stmt = $pdo->prepare($query);

$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inicio.css">
    <title>Menú principal</title>
</head>
<body>
    <header>
        <h1>Menú principal</h1>
    </header>
    <main>
        <div>
            <a href="crearExamen.php">Crear examen</a>
            <?php
            
                if($usuario['idTipo'] == 1){
                    echo "<a href='cuentas.php'>Usuarios</a>";
                    echo "<a href='maestros.php'>Maestros y materias</a>";
                    echo "<a href='preguntas.php'>Temas y preguntas</a>";
                }

            ?>
            <a href="php/login/cerrarSesion.php">Cerrar sesión</a>
        </div>
    </main>
</body>
</html>
