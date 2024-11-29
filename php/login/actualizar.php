<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$actividad = $_POST['actividad'];
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$ap = $_POST['ap'];
$am = $_POST['am'];
$usuario = $_POST['usuario'];
$pwd = $_POST['pwd'];
$tipo = $_POST['tipo'];

$query = "UPDATE usuario
        SET actividad = :actividad, nombre = :nombre, ap = :ap, am = :am, usuario = :usuario, pswd = :pwd, idTipo = :tipo
        WHERE id = :id";


$stmt = $pdo->prepare($query);

$stmt->bindParam(':actividad', $actividad);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':ap', $ap);
$stmt->bindParam(':am', $am);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':pwd', $pwd);
$stmt->bindParam(':tipo', $tipo);
$stmt->bindParam(':id', $id);

if($stmt->execute()){
    header("Location: ../../cuentas.php?msj=actualizado");
} else{
    echo "Error al actualizar el usuario";
}
