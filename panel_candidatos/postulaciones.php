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
    <link rel="stylesheet" href="../assets/style.css">
    </style>
</head>
<<<<<<< HEAD:panel_candidatos/postulaciones.html
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>JobConnect RD - Mis Postulaciones</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../assets/styles.css">
    </head>

    <body>
        <!-- Header -->
        <header>
            <div class="header-container">
                <div class="logo">
                    <assets src="../assets/logo.png" alt="JobConnect RD Logo">
                        <h1>Job<span>Connect RD</span></h1>
                </div>
                <div class="mobile-menu-toggle" id="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-menu">
                    <div class="user-avatar">MC</div>
                    <span class="user-name">María Castillo</span>
                    <div class="dropdown-toggle">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </header>
        =======

        <body>
            >>>>>>> arreglando_bd:panel_candidatos/postulaciones.php

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
                                <<<<<<< HEAD:panel_candidatos/postulaciones.html
                                    <a href="candidato_panel.html"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li class="menu-item">
                                <a href="buscar_empleos.html"><i class="fas fa-search"></i> <span>Buscar Empleos</span></a>
                            </li>
                            <li class="menu-item active">
                                <a href="postulaciones.html"><i class="fas fa-briefcase"></i> <span>Mis Postulaciones</span></a>
                                =======
                                <a href="curriculum.php"><i class="fas fa-building"></i> <span>Curriculum Digital</span></a>
                                >>>>>>> arreglando_bd:panel_candidatos/postulaciones.php
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
                                <<<<<<< HEAD:panel_candidatos/postulaciones.html
                                    <li><a href="candidato_panel.html">Candidatos</a></li>
                                    =======
                                    <li><a href="candidato_panel.html">Inicio</a></li>
                                    >>>>>>> arreglando_bd:panel_candidatos/postulaciones.php
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