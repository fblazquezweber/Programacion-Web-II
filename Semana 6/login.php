<?php
// Iniciar sesión
session_start();

// Procesar el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "agencia");
    
    $email = $conn->real_escape_string($_POST['email']);
    $contrasena = $_POST['contrasena'];
    
    $result = $conn->query("SELECT * FROM cliente WHERE email = '$email'");
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($contrasena, $user['contrasena'])) {
            // Almacenar el id_cliente en la sesión
            $_SESSION['id_cliente'] = $user['id_cliente']; // Almacena el ID del cliente en la sesión
            
            // Verificar si el usuario es admin y redirigir a la página correspondiente
            $es_admin = $conn->query("SELECT 1 FROM administradores WHERE id_cliente = ".$user['id_cliente'])->num_rows > 0;
            header("Location: " . ($es_admin ? "admin/gestion.php" : "user/dashboard.html"));
            exit();
        }
    }
    
    // Si no es correcto, mostrar error
    $error = true;
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
        .error {
            color: red;
            background: #FFEBEE;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            border: 1px solid #EF9A9A;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #0066cc;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0066cc;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <?php if (isset($error)): ?>
        <div class="error">
            Usuario o contraseña incorrectos
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    
    <div class="actions">
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        <a href="home.html" class="back-link">← Volver al Inicio</a>
    </div>
</body>
</html>
