<?php
session_start();
$ocultar_footer = true;
require('../../libreria/motor.php');
require('../../libreria/plantilla.php');
require_once 'crud_ofertas.php';

// Check if empresa is logged in
if (!isset($_SESSION['id_empresa'])) {
    header("Location: ../../general/Login_y_Registro/login.php");
    exit();
}

// Verificar si se pasa el ID de la oferta
if (!isset($_GET['id_oferta']) || !is_numeric($_GET['id_oferta'])) {
    header("Location: ../empresa_panel.php?error=ID de oferta inválido");
    exit();
}

$id_oferta = (int)$_GET['id_oferta'];
$id_empresa = $_SESSION['id_empresa'];

// Obtener los datos de la oferta
$oferta = verOferta($id_oferta, $id_empresa);
if (!$oferta) {
    header("Location: ../empresa_panel.php?error=Oferta no encontrada o no autorizada");
    exit();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_oferta' => (int)$_POST['id_oferta'],
        'id_empresa' => $id_empresa,
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        'requisitos' => $_POST['requisitos']
    ];

    // Llamar a la función para actualizar
    if (actualizarOferta($data)) {
        header("Location: ../empresa_panel.php?msg=Oferta actualizada");
        exit();
    } else {
        header("Location: ../empresa_panel.php?error=Error al actualizar la oferta");
        exit();
    }
}

plantilla::aplicar();
if ($ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();
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
                    <a href="../perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de Empresa</span></a>
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
            <h1>Editar Oferta</h1>
        </div>
        <form action="editar_oferta.php" method="POST" class="container mt-4">
            <input type="hidden" name="id_oferta" value="<?= htmlspecialchars($oferta['id_oferta']) ?>">
            <div class="form-group mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($oferta['titulo']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($oferta['descripcion']) ?></textarea>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Requisitos</label>
                <textarea name="requisitos" class="form-control" required><?= htmlspecialchars($oferta['requisitos']) ?></textarea>
            </div>
            <input type="hidden" name="fecha_publicacion" value="<?= htmlspecialchars($oferta['fecha_publicacion']) ?>">
            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
        </form>
    </div> <!-- Cierra .main-content -->
</div> <!-- Cierra .dashboard-container -->