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
$sql_formacion = "INSERT INTO Formaciones_Academicas (id_candidato, institucion, titulo, fecha_inicio, fecha_fin) 
                 VALUES (?, ?, ?, ?, ?)";
$parametros_formacion = [
    $id_candidato,
    $institucion,
    $titulo,
    $fecha_inicio_formacion ?: null,
    $fecha_fin_formacion ?: null
];
conexion::ejecutar($sql_formacion, $parametros_formacion);

// Insertar en Experiencias_Laborales
$sql_experiencia = "INSERT INTO Experiencias_Laborales (id_candidato, empresa, puesto, fecha_inicio, fecha_fin) 
                   VALUES (?, ?, ?, ?, ?)";
$parametros_experiencia = [
    $id_candidato,
    $empresa,
    $puesto,
    $fecha_inicio_experiencia ?: null,
    $fecha_fin_experiencia ?: null
];
conexion::ejecutar($sql_experiencia, $parametros_experiencia);

// Insertar en Habilidades
$sql_habilidades = "INSERT INTO Habilidades (id_candidato, habilidad) 
                   VALUES (?, ?)";
$parametros_habilidades = [
    $id_candidato,
    $habilidades
];
conexion::ejecutar($sql_habilidades, $parametros_habilidades);

// Insertar en Idiomas
$sql_idiomas = "INSERT INTO Idiomas (id_candidato, idioma, nivel) 
               VALUES (?, ?, ?)";
$parametros_idiomas = [
    $id_candidato,
    $idioma,
    $nivel_idioma
];
conexion::ejecutar($sql_idiomas, $parametros_idiomas);

// Insertar en Logros_Proyectos
$sql_logros = "INSERT INTO Logros_Proyectos (id_candidato, descripcion) 
              VALUES (?, ?)";
$parametros_logros = [
    $id_candidato,
    $logros
];
conexion::ejecutar($sql_logros, $parametros_logros);

// Insertar en Referencias
$sql_referencias = "INSERT INTO Referencias (id_candidato, nombre_contacto, descripcion_contacto) 
                   VALUES (?, ?, ?)";
$parametros_referencias = [
    $id_candidato,
    $referencias,
    $referencias
];
conexion::ejecutar($sql_referencias, $parametros_referencias);

$telefono = $candidato['telefono'] ?? '';
$direccion = $candidato['direccion'] ?? '';
$ciudad = $candidato['ciudad'] ?? '';
$profesion = $candidato['profesion'] ?? '';
$resumen = $candidato['resumen_profesional'] ?? '';
$institucion = $_POST['institucion'];
$titulo = $_POST['titulo'];
$fecha_inicio_formacion = $_POST['fecha_inicio_formacion'];
$fecha_fin_formacion = $_POST['fecha_fin_formacion'];
$empresa = $_POST['empresa'];
$puesto = $_POST['puesto'];
$fecha_inicio_experiencia = $_POST['fecha_inicio_experiencia'];
$fecha_fin_experiencia = $_POST['fecha_fin_experiencia'];
$habilidades = $_POST['habilidades'];
$idioma = $_POST['idioma'];
$nivel_idioma = $_POST['nivel_idioma'];
$objetivo = $_POST['objetivo_profesional'];
$logros = $_POST['logros'];
$disponibilidad = $candidato['disponibilidad'] ?? '';
$referencias = $_POST['referencias'];
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
        < class="content-section">
            <div class="section-header">
                <h2>Editar Perfil</h2>
            </div>
            <div class="section-body">
                <form action="procesar_perfil_candidato.php" method="POST" enctype="multipart/form-data">

                    <!-- Datos de Usuario -->
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre(s)</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>" readonly required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="apellido" class="form-label">Apellido(s)</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $apellido; ?>" readonly required>
                    </div>
                </div>

            <div class="form-group">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $correo; ?>" readonly required>
            </div>

            <div class="form-group">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>" readonly required>
            </div>

            <div class="form-group">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ciudad" class="form-label">Ciudad / Provincia</label>
                <input type="text" id="ciudad" name="ciudad" class="form-control" value="<?php echo $ciudad; ?>" readonly required>
            </div>

            <div class="form-group">
                <label for="profesion" class="form-label">Profesión</label>
                <input type="text" id="profesion" name="profesion" class="form-control" value="<?php echo $profesion; ?>" readonly required>
            </div>

            <div class="form-group">
                <label class="form-label">Formación Académica</label>
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="institucion" name="institucion" class="form-control" placeholder="Institución" required>
                    </div>
                    <div class="col-6">
                        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título" required>
                    </div>
                </div>
                <div class="row" style="margin-top: 1rem;">
                    <div class="col-6">
                        <input type="date" id="fecha_inicio_formacion" name="fecha_inicio_formacion" class="form-control" placeholder="Fecha de inicio">
                    </div>
                    <div class="col-6">
                        <input type="date" id="fecha_fin_formacion" name="fecha_fin_formacion" class="form-control" placeholder="Fecha de fin">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Experiencia Laboral</label>
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="empresa" name="empresa" class="form-control" placeholder="Empresa">
                    </div>
                    <div class="col-6">
                        <input type="text" id="puesto" name="puesto" class="form-control" placeholder="Puesto">
                    </div>
                </div>
                <div class="row" style="margin-top: 1rem;">
                    <div class="col-6">
                        <input type="date" id="fecha_inicio_experiencia" name="fecha_inicio_experiencia" class="form-control" placeholder="Fecha de inicio">
                    </div>
                    <div class="col-6">
                        <input type="date" id="fecha_fin_experiencia" name="fecha_fin_experiencia" class="form-control" placeholder="Fecha de fin">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="habilidades" class="form-label">Habilidades Clave</label>
                <input type="text" id="habilidades" name="habilidades" class="form-control" placeholder="Ej: Python, Gestión de Proyectos" required>
            </div>

            <div class="form-group">
                <label class="form-label">Idioma</label>
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="idioma" name="idioma" class="form-control" placeholder="Ej: Inglés" required>
                    </div>
                    <div class="col-6">
                        <select id="nivel_idioma" name="nivel_idioma" class="form-control" required>
                            <option value="" disabled selected>Seleccione nivel</option>
                            <option value="Básico">Básico</option>
                            <option value="Intermedio">Intermedio</option>
                            <option value="Avanzado">Avanzado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="objetivo" class="form-label">Objetivo Profesional / Resumen</label>
                <textarea id="objetivo" name="objetivo_profesional" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="logros" class="form-label">Logros o Proyectos Destacados</label>
                <textarea id="logros" name="logros" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="disponibilidad" class="form-label">Disponibilidad</label>
                <select id="disponibilidad" name="disponibilidad" class="form-control" required>
                    <option value="" disabled selected>Seleccione disponibilidad</option>
                    <option value="Medio Tiempo">Medio Tiempo</option>
                    <option value="Tiempo Completo">Tiempo Completo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="redes" class="form-label">Redes Profesionales (LinkedIn, etc.)</label>
                <input type="text" id="redes" name="redes_profesionales" class="form-control">
            </div>

            <div class="form-group">
                <label for="referencias" class="form-label">Referencias</label>
                <input type="text" id="referencias" name="referencias" class="form-control">
            </div>

            <div class="form-group">
                <label for="cv_pdf" class="form-label">Adjuntar CV (PDF)</label>
                <input type="file" id="cv_pdf" name="cv_pdf" class="form-control" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="foto" class="form-label">Foto (opcional)</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>


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