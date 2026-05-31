<?php
session_start();
include "db.php";

$deporte = $_POST["deporte"] ?? "";
$dia = $_POST["dia"] ?? "";
$hora = $_POST["hora"] ?? "";

if (isset($_POST["continuar"])) {

    if ($deporte === "Pádel") {
        header("Location: pistas_padel.php?hora=$hora&dia=$dia");
        exit;
    }

    if ($deporte === "Tenis") {
        header("Location: pistas_tenis.php?hora=$hora&dia=$dia");
        exit;
    }

    if ($deporte === "Fútbol 8") {
        header("Location: pistas_futbol8.php?hora=$hora&dia=$dia");
        exit;
    }

    if ($deporte === "Fútbol Sala") {
        header("Location: pistas_futbol11.php?hora=$hora&dia=$dia");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva - A3Pistas</title>
    <link rel="stylesheet" href="reservas.css">
</head>
<body>

<header class="efecto fondo">
    <img src="proyectopistas imegenes/pintalo-de-color-amarillo-lima.jpg" class="pintalo-de-color-amarillo-lima">
    <h1>Reserva tu pista</h1>
</header>

<img src="proyectopistas imegenes/padelfoto.png" class="padelfoto">

<form method="POST">

<nav class="reserva">

    <!-- 1. Deporte -->
    <div class="step-card">
        <h2>1. Selecciona tu deporte</h2>

        <label class="option">
            <input type="radio" name="deporte" value="Pádel" <?= $deporte=='Pádel'?'checked':'' ?>>
            Pádel
        </label>

        <label class="option">
            <input type="radio" name="deporte" value="Tenis" <?= $deporte=='Tenis'?'checked':'' ?>>
            Tenis
        </label>

        <label class="option">
            <input type="radio" name="deporte" value="Fútbol 8" <?= $deporte=='Fútbol 8'?'checked':'' ?>>
            Fútbol 8
        </label>

        <label class="option">
            <input type="radio" name="deporte" value="Fútbol Sala" <?= $deporte=='Fútbol Sala'?'checked':'' ?>>
            Fútbol Sala
        </label>
    </div>

    <!-- 2. Horarios -->
    <div class="step-card">
        <h2>2. Horarios Disponibles (Hoy)</h2>

        <?php
        $horas = ["12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00"];
        $i = 1;

        foreach ($horas as $h) {
            echo "
            <label class='Disponibles'>
                <input type='radio' name='hora' value='$h' ".($hora==$h?'checked':'').">
                $h
            </label>";
            $i++;
        }
        ?>
    </div>
    <div class="step-card">
    <h2>Selecciona la fecha</h2>
    <input type="date" name="dia" required class="option" style="padding:10px;">
</div>


    <!-- Botón -->
    <div class="step-card">
        <button type="submit" name="continuar" class="boton-iniciar-sesion" style="margin-top: 15px;">
            Continuar
        </button>
    </div>

</nav>

</form>

</body>
</html>