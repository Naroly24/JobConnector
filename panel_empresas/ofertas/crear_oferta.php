<?php
require_once 'crud_ofertas.php';
session_start();

if (!isset($_SESSION['id_empresa'])) {
    $_SESSION['id_empresa'] = 2; // Simulación para pruebas
}

$conn = conectarBD(); // Asegúrate de tener esta función en config.php

$id_empresa = $_SESSION['id_empresa'];

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $requisitos = $_POST['requisitos'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $id_empresa = $_SESSION['id_empresa'];

    try {
        $stmt = $conn->prepare("INSERT INTO Ofertas (id_empresa, titulo, descripcion, requisitos, fecha_publicacion) 
                                VALUES (:id_empresa, :titulo, :descripcion, :requisitos, :fecha_publicacion)");
        $stmt->bindParam(':id_empresa', $id_empresa);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':requisitos', $requisitos);
        $stmt->bindParam(':fecha_publicacion', $fecha_publicacion);
        $stmt->execute();

        header("Location: crear_oferta.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect RD - Ofertas de Empleo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/style_empresas.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="../../assets/logo.png" alt="JobConnect RD Logo">
                <h1>Job<span>Connect RD</span></h1>
            </div>
            <div class="mobile-menu-toggle" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="user-menu">
                <div class="user-avatar">TS</div>
                <span class="user-name">Tech Solutions</span>
                <div class="dropdown-toggle"><i class="fas fa-chevron-down"></i></div>
            </div>
        </div>
    </header>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Panel de Empresa</h3>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li class="menu-item">
                        <a href="../empresa_panel.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="crear_oferta.php"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="../candidatos.html"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="../perfil_empresa.html"><i class="fas fa-building"></i> <span>Perfil de la Empresa</span></a>
                    </li>
                    <li class="menu-item" style="color: var(--danger);">
                        <a href="../../general/index_empresas.html" style="color: var(--danger);"><i
                                class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
                                Sesión</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">
                <h1>Ofertas de Empleo</h1>
            </div>

            <!-- Formulario para crear nueva oferta -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Crear Nueva Oferta</h2>
                </div>
                <div class="section-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="titulo">Título de la oferta:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="requisitos">Requisitos:</label>
                            <input type="text" name="requisitos" id="requisitos" class="form-control" required>
                        </div>
                        <input type="hidden" name="fecha_publicacion" value="<?= date('Y-m-d') ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Publicar Oferta</button>
                    </form>
                </div>
            </div>
            
            </div>
        </div>

        <script src="../../assets/script.js"></script>
</body>

</html>