<?php
ob_start();
require('bd/conexion.php');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido']; // Opcional, no usado en la base de datos
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha']; // Opcional
    $tipo_usuario = $_POST['tipo_usuario'];
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar'];

    if (!str_contains($correo, '@')) {
        $mensaje = "⚠️ El correo debe contener @";
    } elseif ($contrasena !== $confirmar) {
        $mensaje = "⚠️ Las contraseñas no coinciden";
    } elseif (empty($tipo_usuario)) {
        $mensaje = "⚠️ Debe seleccionar un tipo de usuario";
    } else {
        try {
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $conn = Conexion::obtener();
            $conn->beginTransaction();

            // Insertar en Usuarios
            $sqlUsuarios = "INSERT INTO Usuarios (nombre, correo, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlUsuarios);
            $stmt->execute([$nombre, $correo, $contrasena_hash, $tipo_usuario]);
            $id_usuario = $conn->lastInsertId();

            if ($tipo_usuario === 'candidato') {
                $sqlCandidato = "INSERT INTO Candidatos (id_usuario, telefono) VALUES (?, ?)";
                $stmt = $conn->prepare($sqlCandidato);
                $stmt->execute([$id_usuario, $telefono]);
            } elseif ($tipo_usuario === 'empresa') {
                $sqlEmpresa = "INSERT INTO Empresas (id_usuario, direccion) VALUES (?, ?)";
                $stmt = $conn->prepare($sqlEmpresa);
                $stmt->execute([$id_usuario, '']);
            }

            $conn->commit();
            ob_end_clean();
            header("Location: Login.php");
            exit;
        } catch (Exception $e) {
            if (isset($conn)) $conn->rollBack();
            $mensaje = "❌ Error al registrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .campo-password {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 16px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        label, input, select, button {
            display: block;
            width: 100%;
            margin-bottom: 12px;
        }
        .mensaje {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1 class="title">Registro de Usuario</h1>
    <p>Complete sus datos para crear una cuenta.</p>

    <?php if (!empty($mensaje)) echo "<div class='mensaje'>$mensaje</div>"; ?>

    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Apellido:</label>
        <input type="text" name="apellido" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono" required>

        <label>Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha" required>

        <label>Tipo de Usuario:</label>
        <select name="tipo_usuario" required>
            <option value="">Seleccione una opción</option>
            <option value="candidato">Candidato</option>
            <option value="empresa">Empresa</option>
        </select>

        <label>Contraseña:</label>
        <div class="campo-password">
            <input type="password" name="contrasena" id="contrasena" required>
            <button type="button" class="toggle-password" onclick="togglePassword('contrasena')">👁</button>
        </div>

        <label>Confirmar Contraseña:</label>
        <div class="campo-password">
            <input type="password" name="confirmar" id="confirmar" required>
            <button type="button" class="toggle-password" onclick="togglePassword('confirmar')">👁</button>
        </div>

        <button type="submit">Registrarse</button>
    </form>

    <script>
        function togglePassword(id) {
            const campo = document.getElementById(id);
            campo.type = campo.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
