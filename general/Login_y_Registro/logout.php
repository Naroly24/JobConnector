<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Opcional: eliminar la cookie de sesión (por si acaso)
if (ini_get("session.use_cookies")) {
     $params = session_get_cookie_params();
     setcookie(
          session_name(),
          '',
          time() - 42000,
          $params["path"],
          $params["domain"],
          $params["secure"],
          $params["httponly"]
     );
}

header("Location: /general/index.php"); // Redirige a la página principal o donde prefieras
exit;
