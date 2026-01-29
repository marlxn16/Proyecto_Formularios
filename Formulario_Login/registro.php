<?php
// registro.php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: index.php?msg=" . urlencode("Acceso invalido"));
  exit;
}

$username  = trim($_POST["username"] ?? "");
$email     = trim($_POST["email"] ?? "");
$password  = $_POST["password"] ?? "";
$password2 = $_POST["password2"] ?? "";

if ($username === "" || $email === "" || $password === "" || $password2 === "") {
  header("Location: index.php?msg=" . urlencode("Campos vacios. Complete todo."));
  exit;
}

if ($password !== $password2) {
  header("Location: index.php?msg=" . urlencode("Las contraseñas no coinciden."));
  exit;
}

// Ruta al archivo de guardado de los registro el TXT 
$archivo = _DIR_ . "/usuarios.txt";

if (!file_exists($archivo)) {
  file_put_contents($archivo, "");
}

$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lineas as $linea) {
  $p = explode("|", $linea);
  if (count($p) >= 1) {
    if (strtolower($p[0]) === strtolower($username)) {
      header("Location: index.php?msg=" . urlencode("Ese usuario ya existe."));
      exit;
    }
  }
}

// Guardar en el TXT 
$registro = $username . "|" . $email . "|" . $password . PHP_EOL;
file_put_contents($archivo, $registro, FILE_APPEND);

header("Location: index.php?msg=" . urlencode("Registro exitoso. Ya puede iniciar sesión."));
exit;