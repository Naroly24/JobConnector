<?php
// Iniciar sesión para obtener id_usuario del usuario autenticado
session_start();

// Incluir archivo de configuración de la base de datos
require_once 'conexion.php';

// Definir rutas absolutas para las carpetas de carga
$base_dir = __DIR__; 
$cv_upload_dir = $base_dir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'cvs' . DIRECTORY_SEPARATOR;
$photo_upload_dir = $base_dir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR;

// Verificar y crear carpetas de carga si no existen
foreach ([$cv_upload_dir, $photo_upload_dir] as $dir) {
     if (!is_dir($dir)) {
          // Intentar crear la carpeta con permisos 0755
          if (!mkdir($dir, 0755, true)) {
               echo "<div class='alert alert-danger'>Error: No se pudo crear la carpeta $dir. Por favor, cree manualmente las carpetas 'uploads/cvs' y 'uploads/fotos' en $base_dir y otorgue permisos de escritura al servidor web (e.g., IUSR o IIS_IUSRS en Windows).</div>";
               exit;
          }
     }
     // Verificar que la carpeta sea escribible
     if (!is_writable($dir)) {
          echo "<div class='alert alert-danger'>Error: La carpeta $dir no tiene permisos de escritura. Otorgue permisos de escritura al servidor web (e.g., IUSR o IIS_IUSRS) en $dir.</div>";
          exit;
     }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Obtener id_usuario de la sesión o usar valor por defecto para pruebas
     $id_usuario = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conexion, $_SESSION['user_id']) : mysqli_real_escape_string($conexion, $_POST['id_usuario']);

     // Verificar si id_usuario existe en la tabla Usuarios
     $check_user_query = "SELECT id_usuario FROM Usuarios WHERE id_usuario = '$id_usuario'";
     $check_user_result = $conexion->query($check_user_query);
     if ($check_user_result->num_rows == 0) {
          echo "<div class='alert alert-danger'>Error: El ID de usuario ($id_usuario) no existe en la base de datos. Por favor, inicie sesión o regístrese.</div>";
          exit;
     }

     // Sanitizar entradas para prevenir inyección SQL
     $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
     $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
     $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
     $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
     $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
     $ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);
     $profesion = mysqli_real_escape_string($conexion, $_POST['profesion']);
     $institucion = mysqli_real_escape_string($conexion, $_POST['institucion']);
     $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
     $fecha_inicio_formacion = mysqli_real_escape_string($conexion, $_POST['fecha_inicio_formacion']);
     $fecha_fin_formacion = mysqli_real_escape_string($conexion, $_POST['fecha_fin_formacion']);
     $empresa = mysqli_real_escape_string($conexion, $_POST['empresa']);
     $puesto = mysqli_real_escape_string($conexion, $_POST['puesto']);
     $fecha_inicio_experiencia = mysqli_real_escape_string($conexion, $_POST['fecha_inicio_experiencia']);
     $fecha_fin_experiencia = mysqli_real_escape_string($conexion, $_POST['fecha_fin_experiencia']);
     $habilidades = mysqli_real_escape_string($conexion, $_POST['habilidades']);
     $idioma = mysqli_real_escape_string($conexion, $_POST['idioma']);
     $nivel_idioma = mysqli_real_escape_string($conexion, $_POST['nivel_idioma']);
     $objetivo = mysqli_real_escape_string($conexion, $_POST['objetivo_profesional']);
     $logros = mysqli_real_escape_string($conexion, $_POST['logros']);
     $referencias = mysqli_real_escape_string($conexion, $_POST['referencias']);
     $disponibilidad = mysqli_real_escape_string($conexion, $_POST['disponibilidad']);
     $redes = mysqli_real_escape_string($conexion, $_POST['redes_profesionales']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Obtener id_usuario de la sesión o usar valor por defecto para pruebas
     $id_usuario = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conexion, $_SESSION['user_id']) : mysqli_real_escape_string($conexion, $_POST['id_usuario']);

     // Verificar si id_usuario existe en la tabla Usuarios
     $check_user_query = "SELECT id_usuario FROM Usuarios WHERE id_usuario = '$id_usuario'";
     $check_user_result = $conexion->query($check_user_query);
     if ($check_user_result->num_rows == 0) {
          echo "<div class='alert alert-danger'>Error: El ID de usuario ($id_usuario) no existe en la base de datos. Por favor, inicie sesión o regístrese.</div>";
          exit;
     }

     // Sanitizar entradas para prevenir inyección SQL
     $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
     $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
     $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
     $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
     $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
     $ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);
     $profesion = mysqli_real_escape_string($conexion, $_POST['profesion']);
     $institucion = mysqli_real_escape_string($conexion, $_POST['institucion']);
     $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
     $fecha_inicio_formacion = mysqli_real_escape_string($conexion, $_POST['fecha_inicio_formacion']);
     $fecha_fin_formacion = mysqli_real_escape_string($conexion, $_POST['fecha_fin_formacion']);
     $empresa = mysqli_real_escape_string($conexion, $_POST['empresa']);
     $puesto = mysqli_real_escape_string($conexion, $_POST['puesto']);
     $fecha_inicio_experiencia = mysqli_real_escape_string($conexion, $_POST['fecha_inicio_experiencia']);
     $fecha_fin_experiencia = mysqli_real_escape_string($conexion, $_POST['fecha_fin_experiencia']);
     $habilidades = mysqli_real_escape_string($conexion, $_POST['habilidades']);
     $idioma = mysqli_real_escape_string($conexion, $_POST['idioma']);
     $nivel_idioma = mysqli_real_escape_string($conexion, $_POST['nivel_idioma']);
     $objetivo = mysqli_real_escape_string($conexion, $_POST['objetivo_profesional']);
     $logros = mysqli_real_escape_string($conexion, $_POST['logros']);
     $referencias = mysqli_real_escape_string($conexion, $_POST['referencias']);
     $disponibilidad = mysqli_real_escape_string($conexion, $_POST['disponibilidad']);
     $redes = mysqli_real_escape_string($conexion, $_POST['redes_profesionales']);

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

     // Manejar carga del CV
     $cv_destino = "";
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

          $cv_nombre = $_FILES['cv_pdf']['name'];
          $cv_tmp = $_FILES['cv_pdf']['tmp_name'];
          $cv_destino = $cv_upload_dir . uniqid() . "_" . basename($cv_nombre);
          if (!move_uploaded_file($cv_tmp, $cv_destino)) {
               echo "<div class='alert alert-danger'>Error al subir el CV. Verifique que la carpeta $cv_upload_dir existe y tiene permisos de escritura.</div>";
               exit;
          }
     }

     // Manejar carga de la foto (opcional)
     $foto_destino = "";
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

          $foto_nombre = $_FILES['foto']['name'];
          $foto_tmp = $_FILES['foto']['tmp_name'];
          $foto_destino = $photo_upload_dir . uniqid() . "_" . basename($foto_nombre);
          if (!move_uploaded_file($foto_tmp, $foto_destino)) {
               echo "<div class='alert alert-danger'>Error al subir la foto. Verifique que la carpeta $photo_upload_dir existe y tiene permisos de escritura.</div>";
               exit;
          }
     }

     // Insertar en la tabla Candidatos
     $sql_candidato = "INSERT INTO Candidatos (
        id_usuario, telefono, direccion, ciudad, profesion, resumen_profesional, disponibilidad,
        redes_profesionales, cv_pdf, foto
    ) VALUES (
        '$id_usuario', '$telefono', '$direccion', '$ciudad', '$profesion', '$objetivo', '$disponibilidad',
        '$redes', '$cv_destino', '$foto_destino'
    )";

     if ($conexion->query($sql_candidato) === TRUE) {
          $id_candidato = $conexion->insert_id;

          // Insertar formación académica
          if (!empty($institucion) && !empty($titulo)) {
               $sql_formacion = "INSERT INTO Formaciones_Academicas (
                id_candidato, institucion, titulo, fecha_inicio, fecha_fin
            ) VALUES (
                '$id_candidato', '$institucion', '$titulo', 
                " . ($fecha_inicio_formacion ? "'$fecha_inicio_formacion'" : 'NULL') . ",
                " . ($fecha_fin_formacion ? "'$fecha_fin_formacion'" : 'NULL') . "
            )";
               $conexion->query($sql_formacion);
          }

          // Insertar experiencia laboral
          if (!empty($empresa) && !empty($puesto)) {
               $sql_experiencia = "INSERT INTO Experiencias_Laborales (
                id_candidato, empresa, puesto, fecha_inicio, fecha_fin
            ) VALUES (
                '$id_candidato', '$empresa', '$puesto', 
                " . ($fecha_inicio_experiencia ? "'$fecha_inicio_experiencia'" : 'NULL') . ",
                " . ($fecha_fin_experiencia ? "'$fecha_fin_experiencia'" : 'NULL') . "
            )";
               $conexion->query($sql_experiencia);
          }

          // Insertar habilidades
          if (!empty($habilidades)) {
               $sql_habilidades = "INSERT INTO Habilidades (
                id_candidato, habilidad
            ) VALUES ('$id_candidato', '$habilidades')";
               $conexion->query($sql_habilidades);
          }

          // Insertar idioma y nivel
          if (!empty($idioma) && !empty($nivel_idioma)) {
               $sql_idiomas = "INSERT INTO Idiomas (
                id_candidato, idioma, nivel
            ) VALUES ('$id_candidato', '$idioma', '$nivel_idioma')";
               $conexion->query($sql_idiomas);
          }

          // Insertar logros
          if (!empty($logros)) {
               $sql_logros = "INSERT INTO Logros_Proyectos (
                id_candidato, descripcion
            ) VALUES ('$id_candidato', '$logros')";
               $conexion->query($sql_logros);
          }

          // Insertar referencias
          if (!empty($referencias)) {
               $sql_referencias = "INSERT INTO Referencias (
                id_candidato, nombre_contacto, descripcion_contacto
            ) VALUES ('$id_candidato', '$referencias', '$referencias')";
               $conexion->query($sql_referencias);
          }

          echo "<div class='alert alert-success'>✅ Currículum registrado exitosamente.</div>";
     } else {
          echo "<div class='alert alert-danger'>❌ Error: " . $conexion->error . "</div>";
     }

     // Cerrar conexión a la base de datos
     $conexion->close();
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
               margin: 0 auto;
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
               /* Asegurar visibilidad */
               flex: 1;
               padding: 2rem 0;
          }

          /* Hero section */
          .hero {
               background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
               color: var(--white);
               text-align: center;
               padding: 4rem 1rem;
               border-radius: var(--radius);
               margin-bottom: 2rem;
          }

          .hero h2 {
               font-size: 2.5rem;
               margin-bottom: 1rem;
          }

          .hero p {
               font-size: 1.2rem;
               max-width: 700px;
               margin: 0 auto 2rem;
          }

          /* Cards */
          .card {
               background-color: var(--white);
               border-radius: var(--radius);
               box-shadow: var(--shadow);
               padding: 1.5rem;
               margin-bottom: 1.5rem;
               transition: var(--transition);
               height: 100%;
          }

          .card:hover {
               transform: translateY(-5px);
               box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
          }

          .card-title {
               font-size: 1.25rem;
               margin-bottom: 1rem;
               color: var(--primary);
          }

          .card-body {
               color: var(--dark);
          }

          .card-footer {
               margin-top: 1rem;
               display: flex;
               justify-content: flex-end;
          }

          /* Grid System */
          .row {
               display: flex;
               flex-wrap: wrap;
               margin: 0 -1rem;
          }

          .col {
               flex: 1;
               padding: 0 1rem;
               min-width: 0;
          }

          .col-1 {
               flex: 0 0 8.333%;
               max-width: 8.333%;
          }

          .col-2 {
               flex: 0 0 16.666%;
               max-width: 16.666%;
          }

          .col-3 {
               flex: 0 0 25%;
               max-width: 25%;
          }

          .col-4 {
               flex: 0 0 33.333%;
               max-width: 33.333%;
          }

          .col-5 {
               flex: 0 0 41.666%;
               max-width: 41.666%;
          }

          .col-6 {
               flex: 0 0 50%;
               max-width: 50%;
               padding: 0 0.5rem;
          }

          .col-7 {
               flex: 0 0 58.333%;
               max-width: 58.333%;
          }

          .col-8 {
               flex: 0 0 66.666%;
               max-width: 66.666%;
          }

          .col-9 {
               flex: 0 0 75%;
               max-width: 75%;
          }

          .col-10 {
               flex: 0 0 83.333%;
               max-width: 83.333%;
          }

          .col-11 {
               flex: 0 0 91.666%;
               max-width: 91.666%;
          }

          .col-12 {
               flex: 0 0 100%;
               max-width: 100%;
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

          .btn-secondary {
               background-color: var(--secondary);
               color: var(--white);
          }

          .btn-secondary:hover {
               background-color: var(--secondary-dark);
               color: var(--white);
          }

          .btn-outline {
               background-color: transparent;
               color: var(--primary);
               border: 2px solid var(--primary);
          }

          .btn-outline:hover {
               background-color: var(--primary);
               color: var(--white);
          }

          .btn-danger {
               background-color: var(--danger);
               color: var(--white);
          }

          .btn-sm {
               padding: 0.4rem 0.8rem;
               font-size: 0.875rem;
          }

          .btn-lg {
               padding: 1rem 2rem;
               font-size: 1.25rem;
          }

          /* Formularios */
          .form-group {
               margin-bottom: 2rem;
               /* Más separación */
          }

          .form-label {
               display: block;
               margin-bottom: 0.5rem;
               font-weight: 500;
          }

          .form-control {
               width: 100%;
               padding: 1rem;
               /* Campos más amplios */
               border: 1px solid #ddd;
               border-radius: var(--radius);
               font-size: 1rem;
               transition: var(--transition);
          }

          .form-control:focus {
               outline: none;
               border-color: var(--primary);
               box-shadow: 0 0 0 3px rgba(0, 86, 112, 0.2);
               /* Ajustado para --primary */
          }

          .form-text {
               display: block;
               margin-top: 0.25rem;
               font-size: 0.875rem;
               color: var(--gray);
          }

          /* Estilo para select */
          select.form-control {
               appearance: none;
               -webkit-appearance: none;
               -moz-appearance: none;
               background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%2334495e" d="M7 10l5 5 5-5z"/></svg>') no-repeat right 0.75rem center/12px 12px;
          }

          /* Estilo para campos de fecha */
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

          .alert-primary {
               background-color: rgba(0, 86, 112, 0.1);
               /* Ajustado para --primary */
               border-left-color: var(--primary);
          }

          .alert-success {
               background-color: rgba(0, 160, 165, 0.1);
               /* Ajustado para --secondary */
               border-left-color: var(--secondary);
          }

          .alert-danger {
               background-color: rgba(231, 76, 60, 0.1);
               border-left-color: var(--danger);
          }

          .alert-warning {
               background-color: rgba(243, 156, 18, 0.1);
               border-left-color: var(--warning);
          }

          /* Badges */
          .badge {
               display: inline-block;
               padding: 0.25rem 0.5rem;
               border-radius: 50px;
               font-size: 0.75rem;
               font-weight: 700;
          }

          .badge-primary {
               background-color: var(--primary);
               color: var(--white);
          }

          .badge-secondary {
               background-color: var(--secondary);
               color: var(--white);
          }

          .badge-danger {
               background-color: var(--danger);
               color: var(--white);
          }

          /* Tablas */
          .table {
               width: 100%;
               border-collapse: collapse;
               margin-bottom: 1.5rem;
          }

          .table th,
          .table td {
               padding: 0.75rem;
               border-bottom: 1px solid #ddd;
               text-align: left;
          }

          .table th {
               font-weight: 600;
               background-color: #f8f9fa;
          }

          .table tr:hover {
               background-color: rgba(0, 86, 112, 0.05);
               /* Ajustado para --primary */
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

          .social-links {
               margin-top: 1rem;
          }

          .social-links a {
               color: var(--white);
               font-size: 1.2rem;
               margin-right: 1rem;
               opacity: 0.8;
          }

          .social-links a:hover {
               opacity: 1;
          }

          /* Job listings */
          .job-listing {
               padding: 1.5rem;
               border-radius: var(--radius);
               background-color: var(--white);
               box-shadow: var(--shadow);
               margin-bottom: 1.5rem;
               display: flex;
               flex-wrap: wrap;
               align-items: center;
               transition: var(--transition);
          }

          .job-listing:hover {
               transform: translateY(-3px);
               box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
          }

          .job-info {
               flex: 1;
          }

          .job-title {
               font-size: 1.25rem;
               margin-bottom: 0.25rem;
               color: var(--dark);
          }

          .job-company {
               color: var(--primary);
               font-weight: 500;
               margin-bottom: 0.5rem;
          }

          .job-details {
               display: flex;
               flex-wrap: wrap;
               margin-bottom: 0.5rem;
          }

          .job-detail {
               margin-right: 1.5rem;
               display: flex;
               align-items: center;
               color: var(--gray);
               font-size: 0.875rem;
          }

          .job-detail i {
               margin-right: 0.5rem;
          }

          .job-actions {
               min-width: 120px;
               text-align: right;
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

               .job-actions {
                    margin-top: 1rem;
                    width: 100%;
                    text-align: left;
               }
          }

          @media (max-width: 576px) {
               .hero h2 {
                    font-size: 2rem;
               }

               .hero p {
                    font-size: 1rem;
               }

               .job-listing {
                    padding: 1rem;
               }

               .col-6 {
                    flex: 0 0 100%;
                    max-width: 100%;
                    padding: 0 1rem;
                    /* Restaurar padding en pantallas pequeñas */
               }

               .form-group {
                    margin-bottom: 1.5rem;
                    /* Reducir en pantallas pequeñas */
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
               <input type="hidden" name="id_usuario" value="1"> <!-- Reemplazar con ID real del usuario -->

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
     </main>

     <!-- Footer -->
     <footer>
          <div class="container">
               <div class="footer-container">
                    <!-- About Section -->
                    <div class="footer-section">
                         <h3>Sobre JobConnect RD</h3>
                         <p style="opacity: 0.8; margin-bottom: 1rem;">Plataforma líder en conectar talento dominicano con
                              oportunidades profesionales en el país.</p>
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
                              <li><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i> Av. Winston Churchill, Santo
                                   Domingo</li>
                         </ul>
                    </div>

                    <!-- Newsletter Section -->
                    <div class="footer-section">
                         <h3>Newsletter</h3>
                         <p style="opacity: 0.8; margin-bottom: 1rem;">Recibe las últimas ofertas de empleo en República
                              Dominicana.</p>
                         <form>
                              <div style="display: flex;">
                                   <input type="email" class="form-control" placeholder="Tu email"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                   <button type="submit" class="btn btn-primary"
                                        style="border-top-left-radius: 0; border-bottom-left-radius: 0; white-space: nowrap;">Suscribir</button>
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
