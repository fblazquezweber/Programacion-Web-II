<?php
session_start(); // Asegura que la sesión esté iniciada
session_destroy(); // Destruye la sesión
header("Location: ../home.html"); // Redirige a la página de inicio (home.html)
exit();
?>