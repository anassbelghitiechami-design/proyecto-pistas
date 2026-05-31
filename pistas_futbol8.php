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

// COMPROBAR DISPONIBILIDAD DE CADA PISTA
$stmt = $pdo->prepare("
    SELECT id FROM reservas 
    WHERE deporte = 'Fútbol 8' AND pista = ? AND dia = ? AND hora = ?
");

// Pista 1
$stmt->execute(["Fútbol 8 Césped Pro #1", $dia, $hora]);
$ocupada1 = $stmt->rowCount() > 0;

// Pista 2
$stmt->execute(["Fútbol 8 Césped Pro #2", $dia, $hora]);
$ocupada2 = $stmt->rowCount() > 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Campos de Fútbol 8</title>
    <link rel="stylesheet" href="reservas.css">
</head>
<body>

<form method="POST" action="procesar_reserva.php?hora=<?= urlencode($hora) ?>&dia=<?= urlencode($dia) ?>&deporte=<?= urlencode('Fútbol 8') ?>">
    <nav class="reserva">
        <div class="step-card">
            <h2>Campos de Fútbol 8 — <?= htmlspecialchars($hora) ?> — <?= htmlspecialchars($dia) ?></h2>

            <!-- PISTA 1 -->
            <label class="option" style="<?= $ocupada1 ? 'opacity:0.4; pointer-events:none;' : '' ?>">
                <input type="radio" name="pista" value="Fútbol 8 Césped Pro #1" <?= $ocupada1 ? 'disabled' : '' ?>>
                <span>
                    Fútbol 8 Césped Pro #1 
                    <?= $ocupada1 ? '<span style="color:red;"> — Ocupada</span>' : '<span style="color:green;"> — Libre</span>' ?>
                </span>
            </label>

            <!-- PISTA 2 -->
            <label class="option" style="<?= $ocupada2 ? 'opacity:0.4; pointer-events:none;' : '' ?>">
                <input type="radio" name="pista" value="Fútbol 8 Césped Pro #2" <?= $ocupada2 ? 'disabled' : '' ?>>
                <span>
                    Fútbol 8 Césped Pro #2 
                    <?= $ocupada2 ? '<span style="color:red;"> — Ocupada</span>' : '<span style="color:green;"> — Libre</span>' ?>
                </span>
            </label>

            <button type="submit" name="reservar">Reservar</button>
        </div>
    </nav>
</form>

</body>
</html>
