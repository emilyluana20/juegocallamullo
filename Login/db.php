<?php
$host = "localhost";     // Servidor (localhost si usás XAMPP/MAMP)
$user = "root";          // Usuario de MySQL
$pass = "";              // Contraseña (vacía en XAMPP por defecto)
$dbname = "weddingquest"; // Nombre de tu base de datos

$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
