<?php
// login.php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: index.html?msg=" . urlencode("Acceso inválido"));
  exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
  header("Location: index.html?msg=" . urlencode("Ingrese usuario y contraseña."));
  exit;
}

$archivo = __DIR__ . "/usuarios.txt";

// Si no existe en el registro no hay usuarios registrados
if (!file_exists($archivo)) {
  header("Location: index.html?msg=" . urlencode("No hay usuarios registrados."));
  exit;
}

$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lineas as $linea) {
  $p = explode("|", $linea);

  if (count($p) === 3) {
    $userGuardado = $p[0];
    $passGuardado = $p[2];

    if (strtolower($userGuardado) === strtolower($username)) {
      if ($passGuardado === $password) {
        $_SESSION["user"] = $userGuardado;
        header("Location: index.html?msg=" . urlencode("Acceso permitido. Bienvenido " . $userGuardado) . "&user=" . urlencode($userGuardado));
        exit;
      } else {
        header("Location: index.html?msg=" . urlencode("Contraseña incorrecta."));
        exit;
      }
    }
  }
}

header("Location: index.html?msg=" . urlencode("Usuario no existe."));
exit;
