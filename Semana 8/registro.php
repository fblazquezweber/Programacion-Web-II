<?php
// Procesar formulario si se envió
if (!empty($_POST)) {
    $conn = new mysqli("localhost", "root", "", "agencia");
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $telefono = $_POST['telefono'] ?? ''; // El teléfono es opcional
    
    $conn->query("INSERT INTO cliente (nombre, email, telefono, contrasena) 
                 VALUES ('$nombre', '$email', '$telefono', '$contrasena')");
    
    header("Location: login.php"); // Redirige siempre a login
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 0 auto; padding: 20px; }
        .card { background: #f9f9f9; padding: 20px; border-radius: 5px; }
        input { display: block; width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; }
        button { background: #0066cc; color: white; border: none; padding: 10px; width: 100%; }
        .login-link { text-align: center; margin-top: 15px; }
        .back-link { text-align: center; margin-top: 15px; }
        .back-link a { color: #0066cc; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Regístrate</h1>
        <form method="post">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="telefono" placeholder="Teléfono (opcional)">
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Crear cuenta</button>
        </form>
        
        <div class="login-link">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
        
        <!-- Nuevo enlace para volver al home -->
        <div class="back-link">
            <a href="home.html">← Volver al Inicio</a>
        </div>
    </div>
</body>
</html>