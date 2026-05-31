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
    WHERE deporte = 'Pádel' AND pista = ? AND dia = ? AND hora = ?
");

// Pista 1
$stmt->execute(["Pádel Court #1", $dia, $hora]);
$ocupada1 = $stmt->rowCount() > 0;

// Pista 2
$stmt->execute(["Pádel Court #2", $dia, $hora]);
$ocupada2 = $stmt->rowCount() > 0;

// Pista 3
$stmt->execute(["Pádel Court #3", $dia, $hora]);
$ocupada3 = $stmt->rowCount() > 0;

// Pista 4
$stmt->execute(["Pádel Court #4", $dia, $hora]);
$ocupada4 = $stmt->rowCount() > 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pistas de Pádel</title>
    <link rel="stylesheet" href="reservas.css">
</head>
<body>

<form method="POST" action="procesar_reserva.php?hora=<?= urlencode($hora) ?>&dia=<?= urlencode($dia) ?>&deporte=Pádel">
    <nav class="reserva">
        <div class="step-card">
            <h2>Pistas de Pádel — <?= htmlspecialchars($hora) ?> — <?= htmlspecialchars($dia) ?></h2>

            <?php
            function pista($num, $ocupada) {
                echo "
                <label class='option' style='".($ocupada ? "opacity:0.4; pointer-events:none;" : "")."'>
                    <input type='radio' name='pista' value='Pádel Court #$num' ".($ocupada ? "disabled" : "").">
                    <span>Pádel Court #$num ".($ocupada ? "<span style='color:red;'>— Ocupada</span>" : "<span style='color:green;'>— Libre</span>")."</span>
                </label>";
            }

            pista(1, $ocupada1);
            pista(2, $ocupada2);
            pista(3, $ocupada3);
            pista(4, $ocupada4);
            ?>

            <button type="submit" name="reservar">Reservar</button>
        </div>
    </nav>
</form>

</body>
</html>
