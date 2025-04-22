<?php
require_once('../Libreria/bd/conexion.php'); // Ajusta la ruta si es necesario
session_start();

// Aquí asumimos que la empresa está autenticada y su ID está en la sesión
if (!isset($_SESSION['id_empresa'])) {
    $id_empresa = $_SESSION['id_empresa'] ?? 2; // Simulación para pruebas
} else {
    $id_empresa = $_SESSION['id_empresa'];
}

$candidatos = conexion::consulta("
    SELECT u.nombre, u.apellido, u.correo, c.profesion, c.cv_pdf
    FROM Aplicaciones a
    INNER JOIN Candidatos c ON a.id_candidato = c.id_candidato
    INNER JOIN Usuarios u ON c.id_usuario = u.id_usuario
    INNER JOIN Ofertas o ON a.id_oferta = o.id_oferta
    WHERE o.id_empresa = $id_empresa
");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect RD - Lista de Candidatos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Libreria/style_empresas.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="../Libreria/logo.png" alt="JobConnect RD Logo">
                <h1>Job<span>Connect RD</span></h1>
            </div>
            <div class="mobile-menu-toggle" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="user-menu">
                <div class="user-avatar">TS</div>
                <span class="user-name">Tech Solutions</span>
                <div class="dropdown-toggle">
                    <i class="fas fa-chevron-down"></i>
                </div>
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
                    <li class="menu-item active">
                        <a href="empresa_panel.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="ofertas/crear_oferta.php"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="candidatos.php"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="perfil_empresa.html"><i class="fas fa-building"></i> <span>Perfil de la Empresa</span></a>
                    </li>
                    <li class="menu-item" style="color: var(--danger);">
                        <a href="../general/index_empresas.html" style="color: var(--danger);"><i
                                class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
                                Sesión</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">
                <h1>Candidatos</h1>
            </div>

            <!-- Candidates List -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Candidatos Recientes</h2>
                    <select class="form-control filter-select">
                        <option>Filtrar por oferta</option>
                        <?php
                        // Obtener solo las ofertas únicas para el filtro
                        $ofertas = conexion::consulta("SELECT DISTINCT puesto FROM aplicaciones ORDER BY puesto");
                        foreach ($ofertas as $oferta) {
                            echo "<option>{$oferta['puesto']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="section-body">
                    <?php if (!empty($candidatos)): ?>
                        <?php foreach ($candidatos as $c): ?>
                            <div class="job-offer">
                                <div class="offer-icon"><?php echo strtoupper(substr($c['nombre'], 0, 1)); ?></div>
                                <div class="offer-info">
                                    <div class="offer-title"><?php echo htmlspecialchars($c['nombre']); ?></div>
                                    <div class="offer-description">
                                        <p><strong>Profesión:</strong> <?php echo htmlspecialchars($c['profesion']); ?></p>
                                        <div class="offer-meta">
                                            <span><i class="fas fa-calendar-alt"></i> <?php echo $c['fecha']; ?></span>
                                        </div>
                                    </div>
                                    <div class="offer-actions">
                                        <button class="btn btn-outline btn-sm" href="<?php echo htmlspecialchars($c['cv_pdf']); ?>">Ver CV</button>
                                        <button class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($c['correo']); ?>">Contactar</button>
                                        <button class="btn btn-secondary btn-sm">Programar Entrevista</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay candidatos registrados aún.</p>
                        <?php endif; ?>
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
                            <li><a href="empresa_panel.php">Inicio</a></li>
                            <li><a href="ofertas/crear_oferta.php">Ofertas de Empleo</a></li>
                            <li><a href="candidatos.php">Candidatos</a></li>
                            <li><a href="perfil_empresa.html">Sobre Nosotros</a></li>
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
            </div>
        </footer>

        <script src="script.js"></script>
</body>

</html>