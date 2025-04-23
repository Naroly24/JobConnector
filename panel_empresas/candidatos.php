<?php
$ocultar_footer = true;
require('../libreria/motor.php');
require_once('../libreria/plantilla.php');

plantilla::aplicar();
if (isset($ocultar_footer) && $ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();

// Check if empresa is logged in
// Aquí asumimos que la empresa está autenticada y su ID está en la sesión
if (!isset($_SESSION['id_empresa'])) {
    $id_empresa = $_SESSION['id_empresa'] ?? 2; // Simulación para pruebas
} else {
    $id_empresa = $_SESSION['id_empresa'];
}

// Corrected SQL query to get candidates
$candidatos = conexion::consulta("
    SELECT u.nombre, u.apellido, u.correo, c.profesion, c.cv_pdf, a.fecha_aplicacion
    FROM Aplicaciones a
    INNER JOIN Candidatos c ON a.id_candidato = c.id_candidato
    INNER JOIN Usuarios u ON c.id_usuario = u.id_usuario
    INNER JOIN Ofertas o ON a.id_oferta = o.id_oferta
    WHERE o.id_empresa = $id_empresa
    ORDER BY a.fecha_aplicacion DESC
");
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
                    <a href="empresa_panel.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-item">
                    <a href="ofertas/crear_oferta.php"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                </li>
                <li class="menu-item active">
                    <a href="candidatos.php"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                </li>
                <li class="menu-item">
                    <a href="perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de la Empresa</span></a>
                </li>
                <li class="menu-item" style="color: var(--danger);">
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
                <select class="form-control filter-select">
                    <option>Todas las ofertas</option>
                    <?php
                    $ofertas = conexion::consulta("
                        SELECT id_oferta, titulo 
                        FROM Ofertas 
                        WHERE id_empresa = $id_empresa
                        ORDER BY titulo
                    ");
                    foreach ($ofertas as $oferta) {
                        echo "<option value='{$oferta['id_oferta']}'>{$oferta['titulo']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="section-body">
                <?php if (!empty($candidatos)): ?>
                    <?php foreach ($candidatos as $c): ?>
                        <div class="job-offer">
                            <div class="offer-icon">
                                <?php echo strtoupper(substr($c['nombre'], 0, 1) . substr($c['apellido'], 0, 1)); ?>
                            </div>
                            <div class="offer-info">
                                <div class="offer-title">
                                    <?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido']); ?>
                                </div>
                                <div class="offer-description">
                                    <p><strong>Profesión:</strong> <?php echo htmlspecialchars($c['profesion']); ?></p>
                                    <div class="offer-meta">
                                        <span><i class="fas fa-calendar-alt"></i> <?php echo $c['fecha_aplicacion']; ?></span>
                                    </div>
                                </div>
                                <div class="offer-actions">
                                    <a class="btn btn-outline btn-sm" href="<?php echo htmlspecialchars($c['cv_pdf']); ?>" target="_blank">Ver CV</a>
                                    <a class="btn btn-primary btn-sm" href="mailto:<?php echo htmlspecialchars($c['correo']); ?>">Contactar</a>
                                    <button class="btn btn-secondary btn-sm">Programar Entrevista</button>
                                </div>
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