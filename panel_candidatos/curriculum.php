<?php
// Iniciar sesión para obtener id_usuario del usuario autenticado
session_start();

// Incluir archivo de conexión a la base de datos
require('../libreria/motor.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener id_usuario de la sesión o usar valor por defecto para pruebas
    $id_usuario = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_POST['id_usuario'];

    // Verificar si id_usuario existe en la tabla Usuarios
    $check_user_query = "SELECT id_usuario FROM Usuarios WHERE id_usuario = :id_usuario";
    $check_user_result = conexion::select($check_user_query, [':id_usuario' => $id_usuario]);
    if (!$check_user_result) {
        echo "<div class='alert alert-danger'>Error: El ID de usuario ($id_usuario) no existe en la base de datos. Por favor, inicie sesión o regístrese.</div>";
        exit;
    }

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $profesion = $_POST['profesion'];
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
    $referencias = $_POST['referencias'];
    $disponibilidad = $_POST['disponibilidad'];
    $redes = $_POST['redes_profesionales'];

    // Validar campos obligatorios
    if (empty($id_usuario) || empty($nombre) || empty($correo) || empty($telefono) || empty($profesion) || empty($institucion) || empty($titulo) || empty($idioma) || empty($nivel_idioma) || empty($disponibilidad)) {
        echo "<div class='alert alert-danger'>Por favor, complete todos los campos obligatorios, incluyendo profesión, formación académica, idioma, nivel y disponibilidad.</div>";
        exit;
    }

    // Validar fechas
    $date_format = '/^\d{4}-\d{2}-\d{2}$/';
    if (!empty($fecha_inicio_formacion) && !preg_match($date_format, $fecha_inicio_formacion)) {
        echo "<div class='alert alert-danger'>Fecha de inicio de formación académica inválida.</div>";
        exit;
    }
    if (!empty($fecha_fin_formacion) && !preg_match($date_format, $fecha_fin_formacion)) {
        echo "<div class='alert alert-danger'>Fecha de fin de formación académica inválida.</div>";
        exit;
    }
    if (!empty($fecha_inicio_experiencia) && !preg_match($date_format, $fecha_inicio_experiencia)) {
        echo "<div class='alert alert-danger'>Fecha de inicio de experiencia laboral inválida.</div>";
        exit;
    }
    if (!empty($fecha_fin_experiencia) && !preg_match($date_format, $fecha_fin_experiencia)) {
        echo "<div class='alert alert-danger'>Fecha de fin de experiencia laboral inválida.</div>";
        exit;
    }

    // Validar nivel de idioma
    $niveles_validos = ['Básico', 'Intermedio', 'Avanzado'];
    if (!in_array($nivel_idioma, $niveles_validos)) {
        echo "<div class='alert alert-danger'>El nivel de idioma debe ser Básico, Intermedio o Avanzado.</div>";
        exit;
    }

    // Validar disponibilidad
    $disponibilidades_validas = ['Medio Tiempo', 'Tiempo Completo'];
    if (!in_array($disponibilidad, $disponibilidades_validas)) {
        echo "<div class='alert alert-danger'>La disponibilidad debe ser Medio Tiempo o Tiempo Completo.</div>";
        exit;
    }

    // Manejar carga del CV (almacenar como BLOB)
    $cv_data = null;
    if (!empty($_FILES['cv_pdf']['name'])) {
        // Validar tipo y tamaño del archivo
        if ($_FILES['cv_pdf']['type'] != 'application/pdf') {
            echo "<div class='alert alert-danger'>El archivo CV debe ser un PDF.</div>";
            exit;
        }
        if ($_FILES['cv_pdf']['size'] > 5000000) { // Límite de 5MB
            echo "<div class='alert alert-danger'>El archivo CV es demasiado grande (máximo 5MB).</div>";
            exit;
        }

        // Leer el contenido del archivo
        $cv_tmp = $_FILES['cv_pdf']['tmp_name'];
        $cv_data = file_get_contents($cv_tmp);
        if ($cv_data === false) {
            echo "<div class='alert alert-danger'>Error al leer el archivo CV.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>El archivo CV es obligatorio.</div>";
        exit;
    }

    // Manejar carga de la foto (opcional, almacenar como BLOB)
    $foto_data = null;
    if (!empty($_FILES['foto']['name'])) {
        // Validar tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['foto']['type'], $allowed_types)) {
            echo "<div class='alert alert-danger'>La foto debe ser una imagen (JPEG, PNG o GIF).</div>";
            exit;
        }
        if ($_FILES['foto']['size'] > 2000000) { // Límite de 2MB
            echo "<div class='alert alert-danger'>La foto es demasiado grande (máximo 2MB).</div>";
            exit;
        }

        // Leer el contenido del archivo
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_data = file_get_contents($foto_tmp);
        if ($foto_data === false) {
            echo "<div class='alert alert-danger'>Error al leer la foto.</div>";
            exit;
        }
    }

    // Insertar en la tabla Candidatos
    $sql_candidato = "INSERT INTO Candidatos (
        id_usuario, telefono, direccion, ciudad, profesion, resumen_profesional, disponibilidad,
        redes_profesionales, cv_pdf, foto
    ) VALUES (
        :id_usuario, :telefono, :direccion, :ciudad, :profesion, :resumen_profesional, :disponibilidad,
        :redes_profesionales, :cv_pdf, :foto
    )";

    $parametros_candidato = [
        ':id_usuario' => $id_usuario,
        ':telefono' => $telefono,
        ':direccion' => $direccion,
        ':ciudad' => $ciudad,
        ':profesion' => $profesion,
        ':resumen_profesional' => $objetivo,
        ':disponibilidad' => $disponibilidad,
        ':redes_profesionales' => $redes,
        ':cv_pdf' => $cv_data,
        ':foto' => $foto_data ?: null // PDO maneja NULL automáticamente si no hay foto
    ];

    $id_candidato = conexion::insert($sql_candidato, $parametros_candidato);
    if ($id_candidato) {
        // Insertar formación académica
        if (!empty($institucion) && !empty($titulo)) {
            $sql_formacion = "INSERT INTO Formaciones_Academicas (
                id_candidato, institucion, titulo, fecha_inicio, fecha_fin
            ) VALUES (
                :id_candidato, :institucion, :titulo, :fecha_inicio, :fecha_fin
            )";
            $parametros_formacion = [
                ':id_candidato' => $id_candidato,
                ':institucion' => $institucion,
                ':titulo' => $titulo,
                ':fecha_inicio' => $fecha_inicio_formacion ?: null,
                ':fecha_fin' => $fecha_fin_formacion ?: null
            ];
            conexion::ejecutar($sql_formacion, $parametros_formacion);
        }

        // Insertar experiencia laboral
        if (!empty($empresa) && !empty($puesto)) {
            $sql_experiencia = "INSERT INTO Experiencias_Laborales (
                id_candidato, empresa, puesto, fecha_inicio, fecha_fin
            ) VALUES (
                :id_candidato, :empresa, :puesto, :fecha_inicio, :fecha_fin
            )";
            $parametros_experiencia = [
                ':id_candidato' => $id_candidato,
                ':empresa' => $empresa,
                ':puesto' => $puesto,
                ':fecha_inicio' => $fecha_inicio_experiencia ?: null,
                ':fecha_fin' => $fecha_fin_experiencia ?: null
            ];
            conexion::ejecutar($sql_experiencia, $parametros_experiencia);
        }

        // Insertar habilidades
        if (!empty($habilidades)) {
            $sql_habilidades = "INSERT INTO Habilidades (
                id_candidato, habilidad
            ) VALUES (:id_candidato, :habilidad)";
            $parametros_habilidades = [
                ':id_candidato' => $id_candidato,
                ':habilidad' => $habilidades
            ];
            conexion::ejecutar($sql_habilidades, $parametros_habilidades);
        }

        // Insertar idioma y nivel
        if (!empty($idioma) && !empty($nivel_idioma)) {
            $sql_idiomas = "INSERT INTO Idiomas (
                id_candidato, idioma, nivel
            ) VALUES (:id_candidato, :idioma, :nivel)";
            $parametros_idiomas = [
                ':id_candidato' => $id_candidato,
                ':idioma' => $idioma,
                ':nivel' => $nivel_idioma
            ];
            conexion::ejecutar($sql_idiomas, $parametros_idiomas);
        }

        // Insertar logros
        if (!empty($logros)) {
            $sql_logros = "INSERT INTO Logros_Proyectos (
                id_candidato, descripcion
            ) VALUES (:id_candidato, :descripcion)";
            $parametros_logros = [
                ':id_candidato' => $id_candidato,
                ':descripcion' => $logros
            ];
            conexion::ejecutar($sql_logros, $parametros_logros);
        }

        // Insertar referencias
        if (!empty($referencias)) {
            $sql_referencias = "INSERT INTO Referencias (
                id_candidato, nombre_contacto, descripcion_contacto
            ) VALUES (:id_candidato, :nombre_contacto, :descripcion_contacto)";
            $parametros_referencias = [
                ':id_candidato' => $id_candidato,
                ':nombre_contacto' => $referencias,
                ':descripcion_contacto' => $referencias
            ];
            conexion::ejecutar($sql_referencias, $parametros_referencias);
        }

        echo "<div class='alert alert-success'>✅ Currículum registrado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ Error al registrar el currículum.</div>";
        exit;
    }
}

// Mostrar los datos cargados (si existen)
$cv_display = '';
$foto_display = '';
$display_data = false;

if (isset($id_usuario)) {
    $query = "SELECT cv_pdf, foto FROM Candidatos WHERE id_usuario = :id_usuario ORDER BY id_candidato DESC LIMIT 1";
    $row = conexion::select($query, [':id_usuario' => $id_usuario]);
    if ($row) {
        $display_data = true;

        // Mostrar la foto
        if (!empty($row['foto'])) {
            $foto_mime = 'image/jpeg'; // Valor por defecto, ajusta según el tipo real
            if (isset($_FILES['foto']['type']) && !empty($_FILES['foto']['type'])) {
                $foto_mime = $_FILES['foto']['type'];
            }
            $foto_base64 = base64_encode($row['foto']);
            $foto_display = "<img src='data:$foto_mime;base64,$foto_base64' alt='Foto del candidato' style='max-width: 200px; border-radius: 8px; margin-top: 1rem;'>";
        }

        // Mostrar el CV (como enlace descargable)
        if (!empty($row['cv_pdf'])) {
            $cv_base64 = base64_encode($row['cv_pdf']);
            $cv_display = "<a href='data:application/pdf;base64,$cv_base64' download='curriculum.pdf' class='btn btn-primary' style='margin-top: 1rem;'>Descargar CV</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currículum Digital - JobConnect RD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Variables globales */
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --secondary-dark: #27ae60;
            --dark: #34495e;
            --light: #ecf0f1;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #1abc9c;
            --gray: #95a5a6;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 0.5rem;
            --transition: all 0.3s ease;
            --max-width: 1200px;
            --header-height: 70px;
            --footer-height: 60px;
            --sidebar-width: 250px;
        }

        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            color: var(--dark);
            line-height: 1.6;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }

        a:hover {
            color: var(--primary-dark);
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Contenedor principal */
        .container {
            width: 100%;
            max-width: var(--max-width);

            padding: 0 1rem;
        }

        /* Header */
        header {
            background-color: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            height: var(--header-height);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-right: 0.5rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo span {
            color: var(--secondary);
        }

        /* Navegación */
        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 1.5rem;
        }

        nav ul li a {
            color: var(--dark);
            font-weight: 500;
            position: relative;
        }

        nav ul li a:hover {
            color: var(--primary);
        }

        nav ul li a.active {
            color: var(--primary);
        }

        nav ul li a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary);
            border-radius: 3px;
        }

        .mobile-menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Main content */
        main {
            margin-top: calc(var(--header-height) + 40px);
            flex: 1;
            padding: 2rem 0;
        }

        /* Botones */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            color: var(--white);
        }

        /* Formularios */
        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 86, 112, 0.2);
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%2334495e" d="M7 10l5 5 5-5z"/></svg>') no-repeat right 0.75rem center/12px 12px;
        }

        input[type="date"].form-control {
            line-height: 1.5;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border-left: 5px solid;
        }

        .alert-success {
            background-color: rgba(0, 160, 165, 0.1);
            border-left-color: var(--secondary);
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border-left-color: var(--danger);
        }

        /* Grid System */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -1rem;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 0.5rem;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 2rem 0;
            margin-top: auto;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            margin-bottom: 1.5rem;
            padding-right: 1rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: var(--light);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: var(--light);
            opacity: 0.8;
        }

        .footer-section ul li a:hover {
            opacity: 1;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            nav {
                position: fixed;
                top: var(--header-height);
                left: -100%;
                width: 70%;
                height: calc(100vh - var(--header-height));
                background-color: var(--white);
                box-shadow: var(--shadow);
                transition: var(--transition);
                z-index: 999;
            }

            nav.active {
                left: 0;
            }

            nav ul {
                flex-direction: column;
                padding: 1rem;
            }

            nav ul li {
                margin-left: 0;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 576px) {
            .col-6 {
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0 1rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container container">
            <div class="logo">
                <h1>JobConnect <span>RD</span></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active">Inicio</a></li>
                    <li><a href="#">Ofertas</a></li>
                    <li><a href="#">Perfil</a></li>
                </ul>
            </nav>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <main class="main-content container">
        <h1>Formulario de Currículum Digital</h1>
        <form action="curriculum.php" method="post" enctype="multipart/form-data">
            <!-- Campo oculto para id_usuario (solo para pruebas, usar sesión en producción) -->
            <input type="hidden" name="id_usuario" value="1">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre(s)</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="apellido" class="form-label">Apellido(s)</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ciudad" class="form-label">Ciudad / Provincia</label>
                <input type="text" id="ciudad" name="ciudad" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="profesion" class="form-label">Profesión</label>
                <input type="text" id="profesion" name="profesion" class="form-control" placeholder="Ej: Ingeniero de Software" required>
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
        </form>

        <?php if ($display_data): ?>
            <div class="card" style="margin-top: 2rem;">
                <h2>Archivos Cargados</h2>
                <div class="row">
                    <div class="col-6">
                        <?php if (!empty($foto_display)): ?>
                            <h3>Foto:</h3>
                            <?php echo $foto_display; ?>
                        <?php else: ?>
                            <p>No se cargó ninguna foto.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <?php if (!empty($cv_display)): ?>
                            <h3>CV:</h3>
                            <?php echo $cv_display; ?>
                        <?php else: ?>
                            <p>No se cargó ningún CV.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <!-- About Section -->
                <div class="footer-section">
                    <h3>Sobre JobConnect RD</h3>
                    <p style="opacity: 0.8; margin-bottom: 1rem;">Plataforma líder en conectar talento dominicano con oportunidades profesionales en el país.</p>
                </div>

                <!-- Links Section -->
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="candidatos_index.html">Inicio para Candidatos</a></li>
                        <li><a href="#">Buscar Empleos</a></li>
                        <li><a href="empresas_index.html">Inicio para Empresas</a></li>
                        <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <ul>
                        <li><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i> info@jobconnectrd.com</li>
                        <li><i class="fas fa-phone" style="margin-right: 0.5rem;"></i> +1 809-555-1234</li>
                        <li><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i> Av. Winston Churchill, Santo Domingo</li>
                    </ul>
                </div>

                <!-- Newsletter Section -->
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p style="opacity: 0.8; margin-bottom: 1rem;">Recibe las últimas ofertas de empleo en República Dominicana.</p>
                    <form>
                        <div style="display: flex;">
                            <input type="email" class="form-control" placeholder="Tu email" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <button type="submit" class="btn btn-primary" style="border-top-left-radius: 0; border-bottom-left-radius: 0; white-space: nowrap;">Suscribir</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2025 JobConnect RD. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>
