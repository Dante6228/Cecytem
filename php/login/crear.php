<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$nombre = $_POST['nombre'];
$ap = $_POST['ap'];
$am = $_POST['am'];
$usuario = $_POST['usuario'];
$pwd = $_POST['pwd'];
$tipo = $_POST['tipo'];

$query = "INSERT INTO usuario (nombre, ap, am, usuario, pswd, idTipo) VALUES (:nombre, :ap, :am, :usuario, :pwd, :tipo)";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':ap', $ap);
$stmt->bindParam(':am', $am);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':pwd', $pwd);
$stmt->bindParam(':tipo', $tipo);

if($stmt->execute()){
    header("Location: ../../crearUsuario.php");
} else{
    echo "Error al crear el usuario";
}