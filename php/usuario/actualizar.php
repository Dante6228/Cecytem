<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$id = $_GET['id'];

$query = "SELECT * FROM usuario WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="../../css/crearCuenta.css">
    <title>Actualizar cuenta</title>
</head>
<body>
    <header>
        <h1>Actualizar usuario <?php echo $usuario['usuario'] ?></h1>
    </header>
    <main>
        <form action="../login/actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
            <div class="input">
                <label for="actividad">Actividad</label>
                <select name="actividad" id="actividad">
                    <option value="1" selected>Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="input">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']) ?>" required>
            </div>
            <div class="input">
                <label for="ap">Apellido paterno</label>
                <input type="text" id="ap" name="ap" value="<?php echo htmlspecialchars($usuario['ap']) ?>" required>
            </div>
            <div class="input">
                <label for="am">Apellido materno</label>
                <input type="text" id="am" name="am" value="<?php echo htmlspecialchars($usuario['am']) ?>" required>
            </div>
            <div class="input">
                <label for="pwd">Contraseña</label>
                <input type="password" id="pwd" name="pwd" value="<?php echo htmlspecialchars($usuario['pswd']) ?>" required>
            </div>
            <div class="input">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']) ?>" required>
            </div>
            <div class="input">
                <label for="tipo">Permisos de usuario</label>
                <select name="tipo" id="tipo" required>
                    <option value="" disabled <?php echo empty($usuario['idTipo']) ? 'selected' : ''; ?>>
                        Seleccione un tipo de usuario
                    </option>
                    <?php foreach ($tipos as $tipo) { ?>
                        <option value="<?php echo $tipo['id']; ?>" <?php echo ($usuario['idTipo'] == $tipo['id']) ? 'selected' : ''; ?>>
                            <?php echo $tipo['descripcion']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="input">
                <button value="submit">Actualizar cuenta</button>
            </div>
        </form>
    </main>
    <nav>
        <ul>
            <li>
                <a href="../../cuentas.php">Regresar</a>
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

