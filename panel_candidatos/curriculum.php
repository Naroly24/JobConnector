<?php
session_start();
$ocultar_footer = true;
require('../libreria/motor.php');
require('../libreria/plantilla.php');

plantilla::aplicar();
if ($ocultar_footer)
    echo '<style>footer { display: none !important; }</style>';
plantilla::navbar();

$idUsuario = $_SESSION['id_usuario'] ?? null;
if (!$idUsuario) {
    echo "<div class='alert alert-danger'>Debes iniciar sesión.</div>";
    exit;
}

// Datos de Usuarios
$sqlUsuario = "SELECT nombre, apellido, correo FROM usuarios WHERE id_usuario = ?";
$datos_usuario = Conexion::select($sqlUsuario, [$idUsuario]);
$nombre = $datos_usuario['nombre'] ?? '';
$apellido = $datos_usuario['apellido'] ?? '';
$correo = $datos_usuario['correo'] ?? '';

// Datos de Usuarios
$sqlUsuario = "SELECT nombre, apellido, correo FROM usuarios WHERE id_usuario = ?";
$datos_usuario = Conexion::select($sqlUsuario, [$idUsuario]);
$nombre = $datos_usuario['nombre'] ?? '';
$apellido = $datos_usuario['apellido'] ?? '';
$correo = $datos_usuario['correo'] ?? '';

// Datos de Candidato
$sqlCandidato = "SELECT telefono, direccion, ciudad, profesion, resumen_profesional, disponibilidad, redes_profesionales, cv_pdf, foto 
                FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1";
$datos_candidato = Conexion::select($sqlCandidato, [$idUsuario]);

$telefono = $datos_candidato['telefono'] ?? '';
$direccion = $datos_candidato['direccion'] ?? '';
$ciudad = $datos_candidato['ciudad'] ?? '';
$profesion = $datos_candidato['profesion'] ?? '';
$resumen = $datos_candidato['resumen_profesional'] ?? '';
$disponibilidad = $datos_candidato['disponibilidad'] ?? '';
$redes = $datos_candidato['redes_profesionales'] ?? '';
$cv_pdf = $datos_candidato['cv_pdf'] ?? null;
$foto = $datos_candidato['foto'] ?? null;

$cv_display = $cv_pdf ? "<a href='data:application/pdf;base64," . base64_encode($cv_pdf) . "' download='curriculum.pdf' class='btn btn-primary mt-2'>Descargar CV</a>" : "No se cargó ningún CV.";
$foto_display = $foto ? "<img src='data:image/jpeg;base64," . base64_encode($foto) . "' alt='Foto del candidato' style='max-width: 200px; border-radius: 8px; margin-top: 1rem;'>" : "No se cargó ninguna foto.";

// Consultas de tablas relacionadas
$sqlFormacion = "SELECT institucion, titulo, fecha_inicio, fecha_fin FROM formaciones_academicas WHERE id_candidato = (SELECT id_candidato FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1)";
$formacion = Conexion::select($sqlFormacion, [$idUsuario]) ?: [];

$sqlExperiencia = "SELECT empresa, puesto, fecha_inicio, fecha_fin FROM experiencias_laborales WHERE id_candidato = (SELECT id_candidato FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1)";
$experiencia = Conexion::select($sqlExperiencia, [$idUsuario]) ?: [];

$sqlHabilidades = "SELECT habilidad FROM habilidades WHERE id_candidato = (SELECT id_candidato FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1)";
$habilidades = Conexion::select($sqlHabilidades, [$idUsuario]) ?: [];

$sqlIdiomas = "SELECT idioma, nivel FROM idiomas WHERE id_candidato = (SELECT id_candidato FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1)";
$idiomas = Conexion::select($sqlIdiomas, [$idUsuario]) ?: [];

$sqlLogros = "SELECT descripcion FROM logros_proyectos WHERE id_candidato = (SELECT id_candidato FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1)";
$logros = Conexion::select($sqlLogros, [$idUsuario]) ?: [];

$sqlReferencias = "SELECT nombre_contacto, descripcion_contacto FROM referencias WHERE id_candidato = (SELECT id_candidato FROM candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1)";
$referencias = Conexion::select($sqlReferencias, [$idUsuario]) ?: [];
?>

<di class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Panel de Empresa</h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="menu-item"><a href="candidato_panel.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="menu-item"><a href="buscar_empleos.php"><i class="fas fa-search"></i> Buscar Empleos</a></li>
                <li class="menu-item"><a href="postulaciones.php"><i class="fas fa-file-alt"></i> Mis Aplicaciones</a>
                </li>
                <li class="menu-item active"><a href="curriculum.php"><i class="fas fa-building"></i> <span>Curriculum
                            Digital</span></a></li>
                <li class="menu-item"><a href="perfil_candidato.php"><i class="fas fa-user"></i> Mi Perfil</a>
                </li>
                <li class="menu-item" style="color: var(--danger);">
                    <a href="../general/Login_y_Registro/Logout.php" style="color: var(--danger);"><i
                            class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
                            Sesión</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="main-content">
        <div class="page-title">
            <h1>Editar Currículum</h1>
        </div>
        <div class="content-section">
            <div class="section-body">
                <form method="post" action="procesar_curriculum.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            value="<?= htmlspecialchars($nombre) ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido(s)</label>
                        <input type="text" id="apellido" name="apellido" class="form-control"
                            value="<?= htmlspecialchars($apellido) ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" class="form-control"
                            value="<?= htmlspecialchars($correo) ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control"
                            value="<?= htmlspecialchars($telefono) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="form-control"
                            value="<?= htmlspecialchars($direccion) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" class="form-control"
                            value="<?= htmlspecialchars($ciudad) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profesion">Profesión</label>
                        <input type="text" id="profesion" name="profesion" class="form-control"
                            value="<?= htmlspecialchars($profesion) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="resumen">Resumen Profesional</label>
                        <textarea id="resumen" name="resumen" class="form-control"
                            required><?= htmlspecialchars($resumen) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="disponibilidad">Disponibilidad</label>
                        <input type="text" id="disponibilidad" name="disponibilidad" class="form-control"
                            value="<?= htmlspecialchars($disponibilidad) ?>">
                    </div>
                    <div class="form-group">
                        <label for="redes">Redes Profesionales</label>
                        <input type="text" id="redes" name="redes" class="form-control"
                            value="<?= htmlspecialchars($redes) ?>">
                    </div>

                    <!-- <h3>Formación Académica</h3>
                    <div class="form-group">
                        <label>Institución</label>
                        <input type="text" name="institucion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="titulo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="date" name="fecha_inicio_formacion" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fecha de fin</label>
                        <input type="date" name="fecha_fin_formacion" class="form-control">
                    </div>

                    <h3>Experiencia Laboral</h3>
                    <div class="form-group">
                        <label>Empresa</label>
                        <input type="text" name="empresa" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Puesto</label>
                        <input type="text" name="puesto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="date" name="fecha_inicio_experiencia" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fecha de fin</label>
                        <input type="date" name="fecha_fin_experiencia" class="form-control">
                    </div>

                    <h3>Habilidades</h3>
                    <div class="form-group">
                        <label>Habilidades</label>
                        <input type="text" name="habilidades" class="form-control"
                            placeholder="Ej: Python, Gestión de proyectos">
                    </div>

                    <h3>Idiomas</h3>
                    <div class="form-group">
                        <label>Idioma</label>
                        <input type="text" name="idioma" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nivel</label>
                        <select name="nivel_idioma" class="form-control">
                            <option value="">Seleccione nivel</option>
                            <option value="Básico">Básico</option>
                            <option value="Intermedio">Intermedio</option>
                            <option value="Avanzado">Avanzado</option>
                        </select>
                    </div>

                    <h3>Logros / Proyectos</h3>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="logros" class="form-control"></textarea>
                    </div>

                    <h3>Referencias</h3>
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" name="referencias" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="cv_pdf">CV (PDF)</label>
                        <input type="file" id="cv_pdf" name="cv_pdf" class="form-control" accept="application/pdf">
                    </div>
                    <p><?= $cv_display ?></p>

                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                    </div>
                    <p><?= $foto_display ?></p> -->

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</di>