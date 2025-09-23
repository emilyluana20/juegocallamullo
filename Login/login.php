<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Buscar usuario por nombre o email
    $sql = "SELECT * FROM usuarios WHERE nombre = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $usuario['contraseña'])) {
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            header("Location: index.php"); // Redirige después del login
            exit();
        } else {
            $error = "⚠️ Contraseña incorrecta.";
        }
    } else {
        $error = "⚠️ Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Venganza Zombie</title>
  <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
  <div class="form-container">
    <h1 class="henny-penny-regular">Wedding Quest</h1>
    <?php if (!empty($error)): ?>
      <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
      <div class="input-group">
        <span class="icon">👤</span>
        <input type="text" name="username_or_email" class="merienda-uniquifier" placeholder="Usuario o correo" required>
      </div>
      <div class="input-group">
        <span class="icon">🔑</span>
        <input type="password" name="password" class="merienda-uniquifier" placeholder="Contraseña" required>
      </div>
      <button type="submit" class="merienda-uniquifier">Entrar al cementerio</button>
      <div class="extra">
        <a href="registro.php" class="merienda-uniquifier">Crear cuenta</a>
      </div>
    </form>
  </div>
</body>
</html>
