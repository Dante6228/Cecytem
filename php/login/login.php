<?php

require_once __DIR__ . "/../conexion/conexion.php";

$pdo = conn::conn();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contraseña'];

$query = "SELECT * FROM usuario WHERE usuario = :usuario AND pswd = :contrasena";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':contrasena', $contrasena);

if($stmt->execute()){
    header('Location: ../../inicio.php');
}
