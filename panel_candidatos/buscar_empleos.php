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

$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$iniciales = strtoupper(substr($nombreUsuario, 0, 1));

// Consulta las ofertas para el select
$ofertas = conexion::consulta("SELECT id_oferta, titulo FROM Ofertas");
?>

<body>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Panel de Candidato</h3>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li class="menu-item "><a href="candidato_panel.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="menu-item active"><a href="buscar_empleos.php"><i class="fas fa-search"></i> Buscar
                            Empleos</a></li>
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
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">
                <h1>Buscar Empleos</h1>
            </div>

            <!-- Search Filters -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Filtros de Búsqueda</h2>
                </div>
                <div class="section-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="keywords">Palabras Clave</label>
                            <input type="text" id="keywords" class="form-control"
                                placeholder="Desarrollador, Marketing...">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ubicacion">Ubicación</label>
                            <select id="ubicacion" class="form-control">
                                <option>Santo Domingo</option>
                                <option>Santiago</option>
                                <option>Punta Cana</option>
                                <option>Todas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="categoria">Categoría</label>
                            <select id="categoria" class="form-control">
                                <option>Tecnología</option>
                                <option>Marketing</option>
                                <option>Finanzas</option>
                                <option>Otros</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tipo">Tipo de Empleo</label>
                            <select id="tipo" class="form-control">
                                <option>Tiempo Completo</option>
                                <option>Medio Tiempo</option>
                                <option>Freelance</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="content-section">
                <div class="section-header">
                    <h2>Ofertas de Empleo</h2>
                    <span>Mostrando 3 resultados</span>
                </div>
                <div class="section-body">
                    <div class="job-application">
                        <div class="application-company">T</div>
                        <div class="application-info">
                            <div class="application-title">Desarrollador Frontend</div>
                            <div class="application-company-name">TechRD Solutions</div>
                            <div class="application-meta">
                                <span><i class="fas fa-map-marker-alt"></i> Santo Domingo</span>
                                <span><i class="fas fa-clock"></i> Tiempo Completo</span>
                                <span><i class="fas fa-dollar-sign"></i> RD$1,200,000</span>
                            </div>
                        </div>
                        <div class="application-status">
                            <a href="curriculum.php" class="btn btn-primary btn-sm">Aplicar</a>
                            <button class="btn btn-outline btn-sm">Guardar</button>
                        </div>
                    </div>
                    <div class="job-application">
                        <div class="application-company">I</div>
                        <div class="application-info">
                            <div class="application-title">Ingeniero de Software</div>
                            <div class="application-company-name">Innovatech RD</div>
                            <div class="application-meta">
                                <span><i class="fas fa-map-marker-alt"></i> Santiago</span>
                                <span><i class="fas fa-clock"></i> Tiempo Completo</span>
                                <span><i class="fas fa-dollar-sign"></i> RD$1,400,000</span>
                            </div>
                        </div>
                        <div class="application-status">
                            <button class="btn btn-primary btn-sm">Aplicar</button>
                            <button class="btn btn-outline btn-sm">Guardar</button>
                        </div>

                    </div>
                    <div class="job-application">
                        <div class="application-company">C</div>
                        <div class="application-info">
                            <div class="application-title">Diseñador UX/UI</div>
                            <div class="application-company-name">CreativeTech RD</div>
                            <div class="application-meta">
                                <span><i class="fas fa-map-marker-alt"></i> Punta Cana</span>
                                <span><i class="fas fa-clock"></i> Tiempo Completo</span>
                                <span><i class="fas fa-dollar-sign"></i> RD$1,000,000</span>
                            </div>
                        </div>
                        <div class="application-status">
                            <button class="btn btn-primary btn-sm">Aplicar</button>
                            <button class="btn btn-outline btn-sm">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="main-content">
        <div class="content-section">
            <div class="section-header">
                <h2>Aplicar a Oferta de Empleo</h2>
            </div>
            <div class="section-body">
                <form action="formulario-aplicacion.php" method="POST">

                    <div class="form-group">
                        <label for="id_oferta" class="form-label">Selecciona una Oferta:</label>
                        <select id="id_oferta" name="id_oferta" class="form-control" required>
                            <option value="">-- Elige una oferta --</option>
                            <?php foreach ($ofertas as $oferta): ?>

                                <option value="<?= $oferta['id_oferta'] ?>"><?= htmlspecialchars($oferta['titulo']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn"
                            style="background-color: var(--primary); color: var(--white);">
                            Enviar Aplicación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="script.js"></script>