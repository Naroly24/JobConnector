<?php
$ocultar_footer = true;
require('../../libreria/motor.php');
require('../../libreria/plantilla.php');

// No generamos salida HTML todavía (plantilla::aplicar() y plantilla::navbar() se llaman después)

// Check if empresa is logged in
if (!isset($_SESSION['id_empresa'])) {
    header("Location: ../../general/Login_y_Registro/login.php");
    exit();
}

plantilla::aplicar();
if (isset($ocultar_footer) && $ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();

require_once 'crud_ofertas.php';
$id_empresa = $_SESSION['id_empresa'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $datos = [
        'id_empresa' => $_SESSION['id_empresa'],
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        'requisitos' => $_POST['requisitos'],
        'fecha_publicacion' => date('Y-m-d')
    ];

    $resultado = crearOferta($datos);

    if ($resultado) {
        header("Location: ../empresa_panel.php?msg=Oferta creada");
        exit();
    } else {
        $error = "❌ No se pudo crear la oferta.";
    }
}
?>

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
                    <a href="../candidatos.php"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                </li>
                <li class="menu-item">
                    <a href="../perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de la Empresa</span></a>
                </li>
                <li class="menu-item" style="color: var(--danger);">
                    <a href="../../general/Login_y_Registro/logout.php" style="color: var(--danger);"><i
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
            <?php if (isset($error)): ?>
                <p style="color:red"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="section-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="titulo">Título de la oferta:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea><br><br>
                    </div>
                    <div class="form-group">
                        <label for="requisitos">Requisitos:</label>
                        <textarea id="requisitos" name="requisitos" class="form-control" required></textarea><br><br>
                    </div>
                    <input type="hidden" name="fecha_publicacion" value="<?= date('Y-m-d') ?>">
                    <button type="submit" class="btn btn-primary btn-sm">Publicar Oferta</button>
                </form>
            </div>
        </div>
    </div>
</div>