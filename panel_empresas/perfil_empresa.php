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
                        <a href="perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de la Empresa</span></a>
                    </li>
                    <li class="menu-item" style="color: var(--danger);">
                        <a href="../general/index_empresas.php" style="color: var(--danger);"><i
                                class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
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
                    <button class="btn btn-primary btn-sm">Guardar Cambios</button>
                </div>
                <div class="section-body">
                    <form action="procesar_perfil.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label" for="nombre_empresa">Nombre de la Empresa</label>
                            <input type="text" id="nombre_empresa" name="nombre_empresa" class="form-control" placeholder="Tech Solutions" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Somos una empresa líder en tecnología..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="industria">Industria</label>
                            <select id="industria" name="industria" class="form-control">
                                <option>Tecnología</option>
                                <option>Finanzas</option>
                                <option>Salud</option>
                                <option>Otros</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ubicacion">Ubicación</label>
                            <input type="text" id="ubicacion" name="ubicacion" class="form-control" placeholder="Santo Domingo">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="sitio_web">Sitio Web</label>
                            <input type="url" id="sitio_web" name="sitio_web" class="form-control" placeholder="https://techsolutions.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="correo_contacto">Correo de Contacto</label>
                            <input type="email" id="correo_contacto" name="correo_contacto" class="form-control" placeholder="contacto@techsolutions.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="+1 809-555-1234">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
