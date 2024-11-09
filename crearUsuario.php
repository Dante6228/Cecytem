<?php

require_once __DIR__ . "/php/conexion/conexion.php";

$pdo = conn::conn();

session_start();

$query = "SELECT * FROM tipoUsuario";

$stmt = $pdo->prepare($query);
$stmt->execute();
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/crearCuenta.css">
    <title>Crear cuenta</title>
</head>
<body>
    <header>
        <h1>Crear usuario</h1>
    </header>
    <main>
        <form action="php/login/crear.php" method="POST">
            <div class="input">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input">
                <label for="ap">Apellido paterno</label>
                <input type="text" id="ap" name="ap" required>
            </div>
            <div class="input">
                <label for="am">Apellido materno</label>
                <input type="text" id="am" name="am" required>
            </div>
            <div class="input">
                <label for="pwd">Contraseña</label>
                <input type="password" id="pwd" name="pwd" required>
            </div>
            <div class="input">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="input">
                <label for="tipo">Permisos de usuario</label>
                <select name="tipo" id="tipo" onchange="limpiarSelect('tipo')">
                    <option value="">Seleccione un tipo de usuario</option>
                    <?php foreach ($tipos as $tipo) {?>
                        <option value="<?php echo $tipo['id']?>"><?php echo $tipo['descripcion']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="input">
                <button value="submit">Crear cuenta</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="cuentas.php">Regresar</a>
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
