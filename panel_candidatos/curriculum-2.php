<?php
$ocultar_footer = true;
require('../libreria/motor.php');
require('../libreria/plantilla.php');

plantilla::aplicar();
if (isset($ocultar_footer) && $ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();

$idUsuario = $_SESSION['id_usuario'] ?? null;
if (!$idUsuario) {
    echo "<p style='color: red;'>Debes iniciar sesión.</p>";
    exit;
}

// Datos de Usuarios
$sqlUsuario = "SELECT nombre, apellido, correo FROM Usuarios WHERE id_usuario = ?";
$usuario = Conexion::select($sqlUsuario, [$idUsuario]);

$nombre = $usuario['nombre'] ?? '';
$apellido = $usuario['apellido'] ?? '';
$correo = $usuario['correo'] ?? '';

// Datos de Candidatos
$sqlCandidato = "SELECT telefono, direccion, ciudad, profesion, resumen_profesional, disponibilidad, redes_profesionales, cv_pdf FROM Candidatos WHERE id_usuario = ?";
$candidato = Conexion::select($sqlCandidato, [$idUsuario]);

$telefono = $candidato['telefono'] ?? '';
$direccion = $candidato['direccion'] ?? '';
$ciudad = $candidato['ciudad'] ?? '';
$profesion = $candidato['profesion'] ?? '';
$resumen = $candidato['resumen_profesional'] ?? '';
$disponibilidad = $candidato['disponibilidad'] ?? '';
$redes = $candidato['redes_profesionales'] ?? '';
$cv = $candidato['cv_pdf'] ?? '';
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
                <li class="menu-item"><a href="candidato_panel.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="menu-item"><a href="buscar_empleos.php"><i class="fas fa-search"></i> Buscar Empleos</a></li>
                <li class="menu-item"><a href="postulaciones.php"><i class="fas fa-file-alt"></i> Mis
                        Aplicaciones</a></li>
                <li class="menu-item">
                    <a href="curriculum.php"><i class="fas fa-building"></i> <span>Curriculum Digital</span></a>
                </li>
                <li class="menu-item active" ><a href="perfil_candidato.php"><i class="fas fa-user"></i> Mi Perfil</a></li>
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
            <h1>Perfil de Candidato</h1>
        </div>

        <!-- Company Profile Form -->
        <div class="content-section">
            <div class="section-header">
                <h2>Editar Perfil</h2>
            </div>
            <div class="section-body">
                <form action="procesar_perfil_candidato.php" method="POST" enctype="multipart/form-data">

                    <!-- Datos de Usuario -->
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            value="<?= htmlspecialchars($nombre) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control"
                            value="<?= htmlspecialchars($apellido) ?>">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" class="form-control"
                            value="<?= htmlspecialchars($correo) ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-outline btn-sm" onclick="togglePasswordFields()"> Cambiar
                            Contraseña</button>
                    </div>

                    <div id="password-section" style="display: none;">
                        <div class="form-group">
                            <label for="password_actual">Contraseña Actual</label>
                            <input type="password" id="password_actual" name="password_actual" class="form-control"
                                placeholder="Solo si deseas cambiarla">
                        </div>
                        <div class="form-group">
                            <label for="nueva_password">Nueva Contraseña</label>
                            <input type="password" id="nueva_password" name="nueva_password" class="form-control"
                                placeholder="Solo si deseas cambiarla">
                        </div>
                        <div class="form-group">
                            <label for="confirmar_password">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirmar_password" name="confirmar_password"
                                class="form-control">
                        </div>
                    </div>

                    <!-- Datos de Candidato -->
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control"
                            value="<?= htmlspecialchars($telefono) ?>">
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" class="form-control"
                            value="<?= htmlspecialchars($ciudad) ?>">
                    </div>
                    <div class="form-group">
                        <label for="profesion">Profesión</label>
                        <input type="text" id="profesion" name="profesion" class="form-control"
                            value="<?= htmlspecialchars($profesion) ?>">
                    </div>
                    <div class="form-group">
                        <label for="disponibilidad">Disponibilidad</label>
                        <input type="text" id="disponibilidad" name="disponibilidad" class="form-control"
                            value="<?= htmlspecialchars($disponibilidad) ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordFields() {
        const section = document.getElementById('password-section');
        section.style.display = (section.style.display === 'none') ? 'block' : 'none';
    }
</script>