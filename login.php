<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include "db.php";   // Conexión a la BD

$error = "";//recoge el error que se pueda producir en el proceso de login

// Si el usuario envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Buscar usuario en la BD
   $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? OR email = ?");
    $stmt->execute([$usuario, $usuario]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);//devuelve la consulta

    // Verificar contraseña
   if ($user && $password === $user["password"]) {

    $_SESSION["id"] = $user["id"];
    $_SESSION["usuario"] = $user["usuario"];
    $_SESSION["rol"] = $user["rol"];   

    header("Location: pistas.php");
    exit;
}

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>

<body>

<img src="proyectopistas imegenes/proyecto.png" alt="proyecto" class="proyecto">

<div id="login-overlay">
  <div id="login-card">

    <!-- FORMULARIO REAL QUE ENVÍA A ESTE MISMO ARCHIVO -->
    <form id="login-form" method="POST" action="login.php">
      <fieldset>
        <legend>Acceder</legend>

        <!-- Mostrar error si lo hay -->
        <?php if ($error): ?>//si
            <p style="color:red; text-align:center; font-weight:bold;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <div class="campo">
          <label for="usuario">Usuario o correo electrónico</label>
          <input type="text" id="usuario" name="usuario" placeholder="Nombre de usuario" required>
        </div>

        <div class="campo">
          <label for="password">Contraseña</label>
          <input type="password" id="password" name="password" placeholder="Contraseña" required>
        </div>

        <!-- BOTÓN REAL QUE ENVÍA EL FORMULARIO -->
        <button type="submit" class="boton-iniciar-sesion">
            INICIAR SESIÓN
        </button>

        <a href="registro.php" class="registro-link">¿Aún no te has registrado?</a>
      </fieldset>
    </form>

  </div>
</div>

</body>
</html>
