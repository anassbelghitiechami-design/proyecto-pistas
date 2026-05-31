<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include "db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$hora    = $_GET["hora"] ?? "";
$dia     = $_GET["dia"] ?? "";
$deporte = $_GET["deporte"] ?? "";
$pista   = $_POST["pista"] ?? "";

if ($hora === "" || $dia === "" || $pista === "" || $deporte === "") {
    echo "Faltan datos para registrar la reserva";
    exit;
}

$usuario_id = $_SESSION["id"];
$email      = $_SESSION["email"];
$precio     = 2000;

// Comprobar si ya existe una reserva igual
$check = $pdo->prepare("
    SELECT id FROM reservas 
    WHERE deporte = ? AND pista = ? AND dia = ? AND hora = ?
");
$check->execute([$deporte, $pista, $dia, $hora]);

if ($check->rowCount() > 0) {
    echo "<h2 style='color:red; text-align:center;'>⚠ Esta pista ya está reservada a esa hora.</h2>";
    echo "<p style='text-align:center;'><a href='reservas.php'>Volver</a></p>";
    exit;
}


$stmt = $pdo->prepare("
    INSERT INTO reservas (usuario_id, email, deporte, pista, hora, dia, precio, fecha)
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
");

if (!$stmt->execute([$usuario_id, $email, $deporte, $pista, $hora, $dia, $precio])) {
    echo "<pre>";
    print_r($stmt->errorInfo());
    echo "</pre>";
    exit;
}

header("Location: pistas.php");
exit;
