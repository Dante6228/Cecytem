<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "SELECT * FROM materia";

$stmt = $pdo->prepare($query);
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM maestro";

$stmt = $pdo->prepare($query);
$stmt->execute();
$maestros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/crearCuenta.css">
    <title>Asignar nueva materia al docente</title>
</head>
<body>
    <header>
        <h1>Asignar nueva materia al docente</h1>
    </header>
    <main>
        <form action="php/maestro/crear.php" method="POST">
            <div class="input">
                <label for="maestro">Docente</label>
                <select name="maestro" id="maestro" onchange="limpiarSelect('maestro')">
                    <option value="">Seleccione un docente</option>
                    <?php foreach ($maestros as $maestro) {?>
                        <option value="<?php echo $maestro['id']?>"><?php echo $maestro['nombre']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="input">
                <label for="materia">Materia</label>
                <select name="materia" id="materia" onchange="limpiarSelect('materia')">
                    <option value="">Seleccione una materia</option>
                    <?php foreach ($materias as $materia) {?>
                        <option value="<?php echo $materia['id']?>"><?php echo $materia['descripcion']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="input">
                <button value="submit">Crear relación</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="maestros.php">Regresar</a>
            </li>
        </ul>
    </nav>
    <script>
        function limpiarSelect(id) {
            const select = document.getElementById(id);
            const option = select.querySelector("option[value='']");
            if (option) {
                option.disabled = true;
            }
        }
    </script>
</body>
</html>
