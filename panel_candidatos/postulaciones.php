<?php
session_start();
$ocultar_footer = true;

require('../libreria/motor.php');
require('../libreria/plantilla.php');
require_once('../libreria/bd/conexion.php');

plantilla::aplicar();
if ($ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();

// Verificar sesión de candidato
if (!isset($_SESSION['id_candidato'])) {
    echo "<p style='color: red;'>❌ Debes iniciar sesión como candidato para ver el panel.</p>";
    exit;
}

$id_candidato = $_SESSION['id_candidato'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect RD - Panel de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Variables globales */
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --secondary-dark: #27ae60;
            --dark: #34495e;
            --light: #ecf0f1;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #1abc9c;
            --gray: #95a5a6;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 0.5rem;
            --transition: all 0.3s ease;
            --max-width: 1200px;
            --header-height: 70px;
            --footer-height: 60px;
            --sidebar-width: 250px;
        }

        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            color: var(--dark);
            line-height: 1.6;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }

        a:hover {
            color: var(--primary-dark);
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Header */
        header {
            background-color: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            height: var(--header-height);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            padding: 0 1rem;
            max-width: var(--max-width);
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-right: 0.5rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo span {
            color: var(--secondary);
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .user-name {
            margin-right: 1rem;
            font-weight: 500;
        }

        .dropdown-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .dropdown-toggle i {
            margin-left: 0.5rem;
        }

        /* Layout principal */
        .dashboard-container {
            display: flex;
            margin-top: var(--header-height);
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--white);
            box-shadow: var(--shadow);
            height: calc(100vh - var(--header-height));
            position: fixed;
            overflow-y: auto;
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .menu-item {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .menu-item.active {
            background-color: rgba(52, 152, 219, 0.1);
            border-left: 4px solid var(--primary);
        }

        .menu-item:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        .menu-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            color: var(--primary);
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: var(--sidebar-width);
        }

        .page-title {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Cards para Dashboard */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(52, 152, 219, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-right: 1rem;
        }

        .stat-info h3 {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .stat-info p {
            color: var(--gray);
            font-size: 0.875rem;
        }

        /* Secciones de contenido */
        .content-section {
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .section-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-body {
            padding: 1.5rem;
        }

        /* Aplicaciones a trabajos */
        .job-application {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .job-application:last-child {
            border-bottom: none;
        }

        .application-company {
            width: 50px;
            height: 50px;
            background-color: rgba(52, 152, 219, 0.1);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: bold;
            margin-right: 1rem;
        }

        .application-info {
            flex: 1;
        }

        .application-title {
            font-weight: 500;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        .application-company-name {
            font-size: 0.9rem;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .application-meta {
            font-size: 0.875rem;
            color: var(--gray);
            display: flex;
            align-items: center;
        }

        .application-meta span {
            margin-right: 1rem;
            display: flex;
            align-items: center;
        }

        .application-meta i {
            margin-right: 0.25rem;
        }

        .application-status {
            min-width: 120px;
            text-align: right;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-applied {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--primary);
        }

        /* Formularios */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Botones */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: var(--white);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .stats-container {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .sidebar {
                left: -300px;
                z-index: 998;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .user-name {
                display: none;
            }

            .stats-container {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .header-container {
                padding: 0 0.5rem;
            }

            .logo h1 {
                font-size: 1.2rem;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Panel de Usuario</h3>
            </div>
            <div class="sidebar-menu">
            <ul>
                    <li class="menu-item "><a href="candidato_panel.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="menu-item"><a href="buscar_empleos.php"><i class="fas fa-search"></i> Buscar
                            Empleos</a></li>
                    <li class="menu-item active"><a href="postulaciones.php"><i class="fas fa-file-alt"></i> Mis
                            Aplicaciones</a></li>
                    <li class="menu-item">
                        <a href="curriculum.php"><i class="fas fa-building"></i> <span>Curriculum Digital</span></a>
                    </li>
                    <li class="menu-item"><a href="perfil_candidato.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                    <li class="menu-item" style="color: var(--danger);">
                        <a href="../general/Login_y_Registro/Logout.php" style="color: var(--danger);"><i
                                class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
                                Sesión</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">
                <h1>Mis Postulaciones</h1>
            </div>

            <!-- Applications List -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Tus Aplicaciones</h2>
                    <select class="form-control" style="max-width: 200px;">
                        <option>Filtrar por estado</option>
                        <option>Aplicado</option>
                        <option>En Revisión</option>
                        <option>Entrevista</option>
                        <option>Rechazado</option>
                    </select>
                </div>
                <div class="section-body">
                    <div class="job-application">
                        <div class="application-company">T</div>
                        <div class="application-info">
                            <div class="application-title">Desarrollador Frontend</div>
                            <div class="application-company-name">TechRD Solutions</div>
                            <div class="application-meta">
                                <span><i class="fas fa-calendar-alt"></i> 12 Abr 2025</span>
                                <span><i class="fas fa-map-marker-alt"></i> Santo Domingo</span>
                            </div>
                        </div>
                        <div class="application-status">
                            <span class="status-badge status-applied">Aplicado</span>
                        </div>
                    </div>
                    <div class="job-application">
                        <div class="application-company">I</div>
                        <div class="application-info">
                            <div class="application-title">Ingeniero de Software</div>
                            <div class="application-company-name">Innovatech RD</div>
                            <div class="application-meta">
                                <span><i class="fas fa-calendar-alt"></i> 10 Abr 2025</span>
                                <span><i class="fas fa-map-marker-alt"></i> Santiago</span>
                            </div>
                        </div>
                        <div class="application-status">
                            <span class="status-badge" style="background-color: rgba(46, 204, 113, 0.1); color: var(--secondary);">Entrevista</span>
                        </div>
                    </div>
                    <div class="job-application">
                        <div class="application-company">C</div>
                        <div class="application-info">
                            <div class="application-title">Diseñador UX/UI</div>
                            <div class="application-company-name">CreativeTech RD</div>
                            <div class="application-meta">
                                <span><i class="fas fa-calendar-alt"></i> 8 Abr 2025</span>
                                <span><i class="fas fa-map-marker-alt"></i> Punta Cana</span>
                            </div>
                        </div>
                        <div class="application-status">
                            <span class="status-badge" style="background-color: rgba(231, 76, 60, 0.1); color: var(--danger);">Rechazado</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Sobre JobConnect RD</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="candidato_panel.html">Inicio</a></li>
                        <li><a href="buscar_empleos.html">Buscar Empleos</a></li>
                        <li><a href="empresas.html">Empresas</a></li>
                        <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <ul>
                        <li><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i> info@jobconnectrd.com</li>
                        <li><i class="fas fa-phone" style="margin-right: 0.5rem;"></i> +1 809-555-1234</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <form>
                        <div style="display: flex;">
                            <input type="email" class="form-control" placeholder="Tu email" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>