<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include "db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$hora = $_GET["hora"] ?? "";
$dia  = $_GET["dia"] ?? "";

if ($hora === "" || $dia === "") {
    header("Location: reservas.php");
    exit;
}

// COMPROBAR DISPONIBILIDAD
$stmt = $pdo->prepare("
    SELECT id FROM reservas 
    WHERE deporte = 'Fútbol 11' AND pista = ? AND dia = ? AND hora = ?
");

$stmt->execute(["Fútbol 11 Campo Oficial", $dia, $hora]);
$ocupada = $stmt->rowCount() > 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Campo de Fútbol 11</title>
    <link rel="stylesheet" href="reservas.css">
</head>
<body>

<form method="POST" action="procesar_reserva.php?hora=<?= urlencode($hora) ?>&dia=<?= urlencode($dia) ?>&deporte=Fútbol 11">
    <nav class="reserva">
        <div class="step-card">
            <h2>Campo de Fútbol 11 — <?= htmlspecialchars($hora) ?> — <?= htmlspecialchars($dia) ?></h2>

            <label class="option" style="<?= $ocupada ? 'opacity:0.4; pointer-events:none;' : '' ?>">
                <input type="radio" name="pista" value="Fútbol 11 Campo Oficial" <?= $ocupada ? 'disabled' : '' ?>>
                <span>
                    Fútbol 11 Campo Oficial 
                    <?= $ocupada ? '<span style="color:red;">— Ocupado</span>' : '<span style="color:green;">— Libre</span>' ?>
                </span>
            </label>

            <button type="submit" name="reservar">Reservar</button>
        </div>
    </nav>
</form>

</body>
</html>
