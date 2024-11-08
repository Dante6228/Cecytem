<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

$query = "SELECT * FROM maestro";

$stmt = $pdo->prepare($query);

$stmt->execute();

$maestros = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM semestre";

$stmt = $pdo->prepare($query);

$stmt->execute();

$semestres = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/examen.css">
    <link rel="stylesheet" href="css/general.css">
    <title>Crear examen</title>
</head>
<body>
    <header>
        <h1>Crear examen</h1>
    </header>
    <main>
        <div class="contenedor">
            <form action="php/examen/crearExamen.php" method="post">
                <div class="content">
                    <label for="semestre">Semestre</label>
                    <select name="semestre" id="semestre" onchange="cargarGrupos()" required>
                        <option value="">Selecciona un semestre</option>
                        <?php

                        foreach ($semestres as $semestre){
                            echo '<option value="'. $semestre['id']. '">'. $semestre['descripcion']. '</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="content">
                    <label for="grupo">Grupo</label>
                    <select name="grupo" id="grupo" onchange="cargarParciales()" required>
                        <option value="">Selecciona un grupo</option>
                    </select>
                </div>
                <div class="content">
                    <label for="parcial">Parcial</label>
                    <select name="parcial" id="parcial" required>
                        <option value="">Selecciona un parcial</option required>
                    </select>
                </div>
                <div class="content">
                    <label for="maestro">Maestro</label>
                    <select name="maestro" id="maestro" onchange="cargarMaterias()" required>
                        <option value="">Seleccione un maestro</option>
                        <?php

                        foreach ($maestros as $maestro){
                            echo '<option value="'. $maestro['id']. '">'. $maestro['nombre']. '</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="content">
                    <label for="materia">Materia</label>
                    <select name="materia" id="materia" required>
                        <option value="">Selecciona una materia</option>
                    </select>
                </div>
                <div class="content">
                    <input type="submit" value="Enviar">
                </div>
            </form>
        </div>
    </main>
        <nav>
            <ul>
                <li>
                    <a href="inicio.php">Regresar</a>
                </li>
            </ul>
        </nav>

    <script>
    async function cargarOpciones(url, parametros, selectId) {
        const selectElement = document.getElementById(selectId);

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: parametros
            });

            const data = await response.text();
            selectElement.innerHTML = data;

        } catch (error) {
            console.error('Error:', error);
        }
    }

    function cargarGrupos() {
        let semestre = document.getElementById("semestre").value;
        cargarOpciones('php/examen/obtener_grupo.php', `semestre=${semestre}`, "grupo");
        limpiarSelect('semestre');
    }

    function cargarMaterias() {
        let maestro = document.getElementById("maestro").value;
        cargarOpciones('php/examen/obtener_materia.php', `maestro=${maestro}`, "materia");
        limpiarSelect('maestro');
    }

    function cargarParciales() {
        let semestre = document.getElementById("semestre").value;
        let grupo = document.getElementById("grupo").value;
        cargarOpciones('php/examen/obtener_parcial.php', `semestre=${semestre}&grupo=${grupo}`, "parcial");
        limpiarSelect('grupo');
    }

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
