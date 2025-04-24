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

// Contadores
$totalOfertas = conexion::consulta("SELECT COUNT(*) as total FROM Ofertas")[0]['total'];
$totalAplicaciones = conexion::consulta("SELECT COUNT(*) as total FROM Aplicaciones WHERE id_candidato = ?", [$id_candidato])[0]['total'];

// Últimas ofertas publicadas
$ultimasOfertas = conexion::consulta("
    SELECT id_oferta, titulo, fecha_publicacion 
    FROM Ofertas 
    ORDER BY fecha_publicacion DESC 
    LIMIT 5
");

// Últimas aplicaciones
$misAplicaciones = conexion::consulta("
    SELECT o.titulo, a.fecha_aplicacion 
    FROM Aplicaciones a
    INNER JOIN Ofertas o ON a.id_oferta = o.id_oferta
    WHERE a.id_candidato = ?
    ORDER BY a.fecha_aplicacion DESC
    LIMIT 5
", [$id_candidato]);
?>

<div class="dashboard-container">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Panel de Candidato</h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="menu-item active"><a href="candidato_panel.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="menu-item"><a href="buscar_empleos.php"><i class="fas fa-search"></i> Buscar Empleos</a></li>
                <li class="menu-item"><a href="postulaciones.php"><i class="fas fa-file-alt"></i> Mis
                        Aplicaciones</a></li>
                        <li class="menu-item">
                    <a href="curriculum.php"><i class="fas fa-building"></i> <span>Curriculum Digital</span></a>
                </li>
                <li class="menu-item"><a href="perfil_candidato.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
                <li class="menu-item" style="color: var(--danger);">
                    <a href="../general/Login_y_Registro/Logout.php" style="color: var(--danger);"><i
                            class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
                            Sesión</span></a>
                </li>>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="page-title">
            <h1>Bienvenido/a</h1>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                <div class="stat-info">
                    <h3><?= $totalOfertas ?></h3>
                    <p>Ofertas Disponibles</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(46, 204, 113, 0.1); color: var(--secondary);">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $totalAplicaciones ?></h3>
                    <p>Aplicaciones Enviadas</p>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Últimas Ofertas Publicadas</h2>
            </div>
            <div class="section-body">
                <?php foreach ($ultimasOfertas as $oferta): ?>
                    <div class="job-offer">
                        <div class="offer-info">
                            <div class="offer-title"><?= htmlspecialchars($oferta['titulo']) ?></div>
                            <div class="offer-meta">
                                <span><i class="fas fa-calendar-alt"></i>
                                    <?= date('d M Y', strtotime($oferta['fecha_publicacion'])) ?></span>
                            </div>
                        </div>
                        <div class="offer-actions">
                            <a href="ver_oferta.php?id_oferta=<?= $oferta['id_oferta'] ?>"
                                class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Mis Últimas Aplicaciones</h2>
            </div>
            <div class="section-body">
                <?php if ($misAplicaciones): ?>
                    <?php foreach ($misAplicaciones as $app): ?>
                        <div class="job-offer">
                            <div class="offer-info">
                                <div class="offer-title"><?= htmlspecialchars($app['titulo']) ?></div>
                                <div class="offer-meta">
                                    <span><i class="fas fa-calendar-alt"></i>
                                        <?= date('d M Y', strtotime($app['fecha_aplicacion'])) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No has aplicado a ninguna oferta aún.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>