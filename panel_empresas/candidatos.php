<?php
session_start();
$ocultar_footer = true;
require('../libreria/motor.php');
require('../libreria/plantilla.php');

// Check if empresa is logged in
if (!isset($_SESSION['id_empresa'])) {
    header("Location: ../general/Login_y_Registro/login.php");
    exit();
}

$id_empresa = $_SESSION['id_empresa'];

// Get selected oferta filter (if any)
$id_oferta_filter = isset($_GET['id_oferta']) && is_numeric($_GET['id_oferta']) ? (int)$_GET['id_oferta'] : null;

// Query candidates with optional oferta filter
$sql = "
    SELECT u.nombre, u.apellido, u.correo, c.profesion, c.cv_pdf, a.fecha_aplicacion
    FROM Aplicaciones a
    INNER JOIN Candidatos c ON a.id_candidato = c.id_candidato
    INNER JOIN Usuarios u ON c.id_usuario = u.id_usuario
    INNER JOIN Ofertas o ON a.id_oferta = o.id_oferta
    WHERE o.id_empresa = :id_empresa
";
$params = [':id_empresa' => $id_empresa];

if ($id_oferta_filter !== null) {
    $sql .= " AND a.id_oferta = :id_oferta";
    $params[':id_oferta'] = $id_oferta_filter;
}

$sql .= " ORDER BY a.fecha_aplicacion DESC";
$candidatos = conexion::consulta($sql, $params);

// Query all ofertas for the empresa
$ofertas = conexion::consulta(
    "SELECT id_oferta, titulo FROM Ofertas WHERE id_empresa = :id_empresa ORDER BY titulo",
    [':id_empresa' => $id_empresa]
);

plantilla::aplicar();
if ($ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();
?>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Panel de Empresa</h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="menu-item">
                <li class="menu-item">
                    <a href="empresa_panel.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-item">
                    <a href="ofertas/crear_oferta.php"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                </li>
                <li class="menu-item active">
                <li class="menu-item active">
                    <a href="candidatos.php"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                </li>
                <li class="menu-item">
                    <a href="perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de la Empresa</span></a>
                </li>
                <li class="menu-item" style="color: var(--danger);">
                    <a href="../../general/Login_y_Registro/logout.php" style="color: var(--danger);"><i
                            class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar Sesión</span></a>
                    <a href="../general/Login_y_Registro/Logout.php" style="color: var(--danger);"><i class="fas fa-sign-out-alt"
                            style="color: var(--danger);"></i> <span>Cerrar
                            Sesión</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="page-title">
            <h1>Candidatos</h1>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Candidatos Recientes</h2>
                <form method="GET" class="filter-form">
                    <select name="id_oferta" class="form-control filter-select" onchange="this.form.submit()">
                        <option value="">Todas las ofertas</option>
                        <?php foreach ($ofertas as $oferta): ?>
                            <option value="<?= htmlspecialchars($oferta['id_oferta']) ?>"
                                <?= $id_oferta_filter === $oferta['id_oferta'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($oferta['titulo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <div class="section-body">
                <?php if (!empty($candidatos)): ?>
                    <?php foreach ($candidatos as $c): ?>
                        <div class="job-offer">
                            <div class="offer-icon">
                                <?= strtoupper(substr($c['nombre'], 0, 1) . substr($c['apellido'], 0, 1)) ?>
                            </div>
                            <div class="offer-info">
                                <div class="offer-title">
                                    <?= htmlspecialchars($c['nombre'] . ' ' . $c['apellido']) ?>
                                </div>
                                <div class="offer-description">
                                    <p><strong>Profesión:</strong> <?= htmlspecialchars($c['profesion'] ?: 'N/A') ?></p>
                                    <div class="offer-meta">
                                        <span><i class="fas fa-calendar-alt"></i> <?= date('d M Y', strtotime($c['fecha_aplicacion'])) ?></span>
                                    </div>
                                </div>
                                <div class="offer-actions">
                                    <?php if ($c['cv_pdf']): ?>
                                        <a class="btn btn-outline btn-sm" href="/Uploads/cvs/<?= htmlspecialchars(basename($c['cv_pdf'])) ?>" target="_blank">Ver CV</a>
                                    <?php else: ?>
                                        <span class="btn btn-outline btn-sm disabled">Ver CV</span>
                                    <?php endif; ?>
                                    <a class="btn btn-primary btn-sm" href="mailto:<?= htmlspecialchars($c['correo']) ?>">Contactar</a>
                                    <button class="btn btn-secondary btn-sm" disabled>Programar Entrevista</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay candidatos para las ofertas seleccionadas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>