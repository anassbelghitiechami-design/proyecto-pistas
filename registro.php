<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include "db.php";   // Conexión PDO

$error = "";
$exito = "";

// Si el usuario envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Comprobar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? OR email = ?");
    $stmt->execute([$usuario, $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $error = "El usuario o email ya está registrado";
    } else {

        // Insertar usuario nuevo
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        $stmt->execute([$usuario, $password]);

        $exito = "Usuario registrado correctamente";

        // Redirigir después de registrar
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="registro.css">
    <title>Registro</title>
</head>

<body>

<img src="proyectopistas imegenes/proyecto.png" alt="proyecto" class="proyecto">

<div id="login-overlay">
  <div id="login-card">

    <!-- FORMULARIO REAL QUE ENVÍA A ESTE MISMO ARCHIVO -->
    <form id="login-form" method="POST" action="registro.php">
      <fieldset>
        <legend>Registro</legend>

        <!-- Mostrar error si lo hay -->
        <?php if ($error): ?>
            <p style="color:red; text-align:center; font-weight:bold;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <!-- Mostrar mensaje de éxito -->
        <?php if ($exito): ?>
            <p style="color:green; text-align:center; font-weight:bold;">
                <?php echo $exito; ?>
            </p>
        <?php endif; ?>

        <div class="campo">
          <label for="usuario">Elija usuario o correo electrónico</label>
          <input type="text" id="usuario" name="usuario" placeholder="Nombre de usuario" required>
        </div>

        <div class="campo">
          <label for="password">Elija Contraseña</label>
          <input type="password" id="password" name="password" placeholder="Contraseña" required>
        </div>

        <!-- BOTÓN REAL QUE ENVÍA EL FORMULARIO -->
        <button type="submit" class="boton-iniciar-sesion">
            REGISTRAR
        </button>

        <a href="login.php" class="registro-link">¿Ya tienes cuenta? Inicia sesión</a>
      </fieldset>
    </form>

  </div>
</div>

</body>
</html>
