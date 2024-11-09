<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contraseña'];

$query = "SELECT * FROM usuario WHERE usuario = :usuario AND pswd = :contrasena";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':contrasena', $contrasena);
$stmt->execute();

$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if($datos){
    session_start();
    $_SESSION['usuario'] = $datos['usuario'];
    $_SESSION['tipo'] = $datos['idTipo'];
    $_SESSION['id'] = $datos['id'];
    header('Location: ../../inicio.php');
}
