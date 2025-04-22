<?php
session_start();

require('libreria/motor.php');
require('libreria/plantilla.php');

plantilla::aplicar();
plantilla::navbar();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?error=Debes iniciar sesión primero");
    exit;
}

$nombre = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'usuario'; // 'candidato' o 'empresa'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de <?= ucfirst($tipo_usuario) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .panel-container {
            max-width: 700px;
            margin: 80px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .panel-container h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .panel-container p {
            color: #555;
            margin-bottom: 30px;
        }

        .logout-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }

        .role-badge {
            display: inline-block;
            background-color: #17a2b8;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .actions {
            margin-top: 30px;
        }

        .actions a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            border-radius: 6px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .actions a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="panel-container">
    <div class="role-badge"><?= ucfirst($tipo_usuario) ?></div>
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?> 👋</h1>
    <p>Has iniciado sesión correctamente como <?= $tipo_usuario === 'empresa' ? 'empresa' : 'candidato' ?>.</p>

    <div class="actions">
        <?php if ($tipo_usuario === 'empresa'): ?>
            <a href="publicar_oferta.php">Publicar Oferta</a>
            <a href="ver_postulaciones.php">Ver Postulaciones</a>
        <?php else: ?>
            <a href="buscar_empleo.php">Buscar Empleo</a>
            <a href="mi_cv.php">Mi CV</a>
        <?php endif; ?>
        <a href="editar_perfil.php">Editar Perfil</a>
    </div>

    <a class="logout-btn" href="index.php">Cerrar sesión</a>
</div>

</body>
</html>
