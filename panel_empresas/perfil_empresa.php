<?php
$ocultar_footer = true; // o false si lo quieres mostrar
require('../libreria/motor.php');
require('../libreria/plantilla.php');

plantilla::aplicar();
if (isset($ocultar_footer) && $ocultar_footer) {
    echo '<style>
    footer {
        display: none !important;
    }
</style>';
}
plantilla::navbar();

$idUsuario = $_SESSION['id_usuario'];

// Consulta para traer los datos de la empresa
$sql = "SELECT rnc, sector, direccion AS ubicacion, ciudad, telefono, sitio_web, correo_corporativo AS correo, descripcion 
        FROM Empresas WHERE id_usuario = ?";
$resultado = Conexion::select($sql, [$idUsuario]);

// Variables por defecto
$nombreEmpresa = $_SESSION['nombre'] ?? ''; // viene desde la sesión también
$descripcion = $industria = $ubicacion = $sitioWeb = $correoContacto = $telefono = '';

// Si se encontró la empresa, asigna los datos
if ($resultado) {
    $descripcion = $resultado['descripcion'] ?? '';
    $industria = $resultado['sector'] ?? '';
    $ubicacion = $resultado['ubicacion'] ?? '';
    $sitioWeb = $resultado['sitio_web'] ?? '';
    if (!empty($sitioWeb) && !preg_match('/^https?:\/\//i', $sitioWeb)) {
        $sitioWeb = 'https://' . $sitioWeb;
    }
    $correoContacto = $resultado['correo'] ?? '';
    $telefono = $resultado['telefono'] ?? '';
}

// Traer datos adicionales desde la tabla Usuarios
$sqlUsuario = "SELECT nombre, apellido, correo FROM Usuarios WHERE id_usuario = ?";
$usuario = Conexion::select($sqlUsuario, [$idUsuario]);

$nombre = $apellido = $correo = '';
if ($usuario) {
    $nombre = $usuario['nombre'] ?? '';
    $apellido = $usuario['apellido'] ?? '';
    $correo = $usuario['correo'] ?? '';
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
                    <a href="empresa_panel.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-item">
                    <a href="/ofertas/crear_oferta.php"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                </li>
                <li class="menu-item">
                    <a href="candidatos.php"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                </li>
                <li class="menu-item active">
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-title">
            <h1>Perfil de Empresa</h1>
        </div>

        <!-- Company Profile Form -->
        <div class="content-section">
            <div class="section-header">
                <h2>Editar Perfil</h2>
            </div>
            <div class="section-body">
                <form action="procesar_perfil.php" method="POST" enctype="multipart/form-data">
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            value="<?= htmlspecialchars($nombre) ?>" required>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="form-group">
                        <label class="form-label" for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" class="form-control"
                            value="<?= htmlspecialchars($correo) ?>" required>
                    </div>

                    <!-- Botón para mostrar los campos de contraseña -->
                    <div class="form-group">
                        <button type="button" class="btn btn-outline btn-sm" onclick="togglePasswordFields()">Cambiar
                            Contraseña</button>
                    </div>

                    <!-- Sección de contraseñas (oculta por defecto) -->
                    <div id="password-section" style="display: none;">
                        <div class="form-group">
                            <label class="form-label" for="password_actual">Contraseña Actual</label>
                            <input type="password" id="password_actual" name="password_actual" class="form-control"
                                placeholder="Solo si deseas cambiarla">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="nueva_password">Nueva Contraseña</label>
                            <input type="password" id="nueva_password" name="nueva_password" class="form-control"
                                placeholder="Solo si deseas cambiarla">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="confirmar_password">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirmar_password" name="confirmar_password"
                                class="form-control">
                        </div>
                    </div>


                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="form-label" for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control"
                            placeholder="Somos una empresa líder en tecnología..."><?= htmlspecialchars($descripcion) ?></textarea>
                    </div>

                    <!-- RNC -->
                    <div class="form-group">
                        <label class="form-label" for="rnc">RNC</label>
                        <input type="text" id="rnc" name="rnc" class="form-control"
                            value="<?= htmlspecialchars($resultado['rnc'] ?? '') ?>" placeholder="Ej: 131234567"
                            required>
                    </div>

                    <!-- Industria -->
                    <div class="form-group">
                        <label class="form-label" for="industria">Industria</label>
                        <input type="text" id="industria" name="industria" class="form-control"
                            value="<?= htmlspecialchars($industria) ?>"
                            placeholder="Ej: Tecnología, Finanzas, Educación...">
                    </div>


                    <!-- Ubicación -->
                    <div class="form-group">
                        <label class="form-label" for="ubicacion">Ubicación</label>
                        <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                            value="<?= htmlspecialchars($ubicacion) ?>" placeholder="Santo Domingo">
                    </div>

                    <!-- Sitio Web -->
                    <div class="form-group">
                        <label class="form-label" for="sitio_web">Sitio Web</label>
                        <input type="url" id="sitio_web" name="sitio_web" class="form-control"
                            value="<?= htmlspecialchars($sitioWeb) ?>" placeholder="https://tuejemplo.com">
                    </div>

                    <!-- Correo de Contacto -->
                    <div class="form-group">
                        <label class="form-label" for="correo_contacto">Correo de Contacto</label>
                        <input type="email" id="correo_contacto" name="correo_contacto" class="form-control"
                            value="<?= htmlspecialchars($correoContacto) ?>" placeholder="contacto@empresa.com">
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group">
                        <label class="form-label" for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control"
                            value="<?= htmlspecialchars($telefono) ?>" placeholder="+1 809-555-1234">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar Cambios</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>