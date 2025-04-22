<?php
require_once 'ofertas/crud_ofertas.php';
require_once '../Libreria/bd/conexion.php';
session_start();

// Aquí asumimos que la empresa está autenticada y su ID está en la sesión
if (!isset($_SESSION['id_empresa'])) {
    $id_empresa = $_SESSION['id_empresa'] ?? 2; // Simulación para pruebas
} else {
    $id_empresa = $_SESSION['id_empresa'];
}

$totalCandidatos = conexion::consulta("
    SELECT a.id_candidato
        FROM Aplicaciones a
    INNER JOIN Ofertas o ON a.id_oferta = o.id_oferta
    WHERE o.id_empresa = $id_empresa
");
$totalCandidatos = count($totalCandidatos); // 👈 Esto actualiza la tarjeta de candidatos

$ofertas = listarOfertas($id_empresa);
$totalOfertas = count($ofertas); // 👈 Esto actualiza la tarjeta

$candidatos = conexion::consulta("
    SELECT u.nombre, u.apellido, u.correo, c.profesion, c.cv_pdf, a.fecha_aplicacion
    FROM Aplicaciones a
    INNER JOIN Candidatos c ON a.id_candidato = c.id_candidato
    INNER JOIN Usuarios u ON c.id_usuario = u.id_usuario
    INNER JOIN Ofertas o ON a.id_oferta = o.id_oferta
    WHERE o.id_empresa = $id_empresa
    ORDER BY a.fecha_aplicacion DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect RD - Panel de Empresa</title>
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
                <h1>Dashboard</h1>
                <div>
                    <button class="btn btn-primary">
                        <i class="fas fa-bell" style="margin-right: 0.5rem;"></i>
                        <span class="badge">2</span>
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $totalOfertas; ?></h3>
                        <p>Ofertas Activas</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(46, 204, 113, 0.1); color: var(--secondary);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $totalCandidatos; ?></h3>
                        <p>Candidatos Totales</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(243, 156, 18, 0.1); color: var(--warning);">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-info">
                        <h3>150</h3>
                        <p>Vistas de Ofertas</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(231, 76, 60, 0.1); color: var(--danger);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Entrevistas Programadas</p>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <div class="section-header">
                    <h2>Ofertas de Empleo Activas</h2>
                </div>
                <div class="section-body">
                    <?php if (count($ofertas) > 0): ?>
                        <?php foreach ($ofertas as $oferta): ?>
                            <div class="job-offer">
                                <div class="offer-info">
                                    <div class="offer-title"><?php echo htmlspecialchars($oferta['titulo']); ?></div>
                                    <div class="offer-meta">
                                        <span><i class="fas fa-calendar-alt"></i> <?php echo date('d M Y', strtotime($oferta['fecha_publicacion'])); ?></span>
                                    </div>
                                </div>
                                <div class="offer-actions">
                                    <a href="ofertas/ver_oferta.php?id_oferta=<?php echo $oferta['id_oferta']; ?>" class="btn btn-outline btn-sm">Ver Oferta</a>
                                    <a href="ofertas/editar_oferta.php?id_oferta=<?php echo $oferta['id_oferta']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="ofertas/eliminar_oferta.php?id_oferta=<?= $oferta['id_oferta'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?');">
                                        Eliminar
                                    </a>
                                </div><br>
                                <hr><br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info">No hay ofertas registradas aún.</div>
                        <?php endif; ?>
                            </div>
                </div>

                <!-- Recent Applicants -->
                <div class="section-header">
                    <h2>Candidatos Recientes</h2>
                    <a href="candidatos.php" class="btn-link">Ver todos</a>
                </div>
                <div class="section-body">
                    <?php foreach ($candidatos as $candidato): ?>
                        <div class="job-offer">
                            <div class="offer-icon">
                                <?= strtoupper(substr($candidato['nombre'], 0, 1) . substr($candidato['apellido'], 0, 1)) ?>
                            </div>
                            <div class="offer-info">
                                <div class="offer-title">
                                    <?= htmlspecialchars($candidato['nombre'] . ' ' . $candidato['apellido']) ?>
                                </div>
                                <div class="offer-meta">
                                    <span><i class="fas fa-briefcase"></i> Aplicó a: <?= htmlspecialchars($candidato['titulo']) ?></span>
                                    <span><i class="fas fa-calendar-alt"></i> <?= date("d M Y", strtotime($candidato['fecha_aplicacion'])) ?></span>
                                </div>
                            </div>
                            <div class="offer-actions">
                                <a href="<?= htmlspecialchars($candidato['cv_pdf']) ?>" target="_blank" class="btn btn-outline btn-sm">Ver CV</a>
                                <a href="mailto:<?= htmlspecialchars($candidato['correo']) ?>" class="btn btn-primary btn-sm">Contactar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-section">
                </div>
            </div>
        </div>
    </footer>
    </div>
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobile-toggle');
            const sidebar = document.getElementById('sidebar');

            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>