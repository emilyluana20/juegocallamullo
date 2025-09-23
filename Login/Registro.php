<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Encriptar contraseña
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $password_hashed);

    if ($stmt->execute()) {
        $_SESSION['usuario'] = $nombre;
        header("Location: index.php"); // Redirigir a página principal
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Venganza Zombie</title>
  <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=Henny+Penny&family=Merienda:wght@300..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
  <div class="form-container">
    <h1 class="henny-penny-regular">Crear Cuenta</h1>
  <form>
    <form action="registro.php" method="POST">
  <div class="input-group">
    <span class="icon">👤</span>
    <input type="text" name="username" placeholder="Nombre de usuario" required>
  </div>
  <div class="input-group">
    <span class="icon">📧</span>
    <input type="email" name="email" placeholder="Correo electrónico" required>
  </div>
  <div class="input-group">
    <span class="icon">🔑</span>
    <input type="password" name="password" placeholder="Contraseña" required>
  </div>
  <button type="submit">Crear</button>
</form>
  </form>
</div>

<script>
const bando = document.getElementById('bando');
const container = document.querySelector('.form-container');
bando.addEventListener('change', () => {
  if (bando.value === 'zombie') {
    container.classList.add('zombie');
    container.classList.remove('humano');
  } else {
    container.classList.add('humano');
    container.classList.remove('zombie');
  }
});
</script>
</body>
</html>
