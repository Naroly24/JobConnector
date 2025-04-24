<?php
$configFile = 'db_config.php';

// // If db_config.php exists, redirect to the main app
// if (file_exists($configFile)) {
//     header("Location: ../../general/Login_y_Registro/registro.php");
//     exit;
// }

// Default credentials for local MySQL (e.g., XAMPP)
$defaultCredentials = [
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '',
    'db_name' => 'PlataformaEmpleos'
];

// Attempt automatic installation with defaults
$autoInstallSuccess = false;
$error = null;

try {
    // Connect to MySQL server
    $pdo = new PDO(
        "mysql:host={$defaultCredentials['db_host']}",
        $defaultCredentials['db_user'],
        $defaultCredentials['db_pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$defaultCredentials['db_name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `{$defaultCredentials['db_name']}`");

    // Create tables
    $sql = <<<SQL
-- Tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    tipo_usuario ENUM('candidato', 'empresa') NOT NULL
);

-- Tabla Candidatos
CREATE TABLE IF NOT EXISTS Candidatos (
    id_candidato INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    ciudad VARCHAR(100)
    resumen_profesional TEXT,,
    profesion VARCHAR(100),
    disponibilidad VARCHAR(50),
    redes_profesionales VARCHAR(255),
    foto VARCHAR(255),
    cv_pdf VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Empresas
CREATE TABLE IF NOT EXISTS Empresas (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    rnc VARCHAR(20),
    sector VARCHAR(100),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    telefono VARCHAR(20),
    correo_corporativo VARCHAR(100),
    sitio_web VARCHAR(100),
    descripcion TEXT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Formaciones Academicas
CREATE TABLE IF NOT EXISTS Formaciones_Academicas (
    id_formacion INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    institucion VARCHAR(255),
    titulo VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);

-- Tabla Experiencias Laborales
CREATE TABLE IF NOT EXISTS Experiencias_Laborales (
    id_experiencia INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    empresa VARCHAR(255),
    puesto VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);

-- Tabla Habilidades
CREATE TABLE IF NOT EXISTS Habilidades (
    id_habilidad INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    habilidad VARCHAR(100),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);

-- Tabla Idiomas
CREATE TABLE IF NOT EXISTS Idiomas (
    id_idioma INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    idioma VARCHAR(100),
    nivel VARCHAR(100),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);

-- Tabla Logros o Proyectos
CREATE TABLE IF NOT EXISTS Logros_Proyectos (
    id_logro INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    descripcion TEXT,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);

-- Tabla Referencias
CREATE TABLE IF NOT EXISTS Referencias (
    id_referencia INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    nombre_contacto VARCHAR(255),
    descripcion_contacto TEXT,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato)
);

-- Tabla Ofertas
CREATE TABLE IF NOT EXISTS Ofertas (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT,
    titulo VARCHAR(255),
    descripcion TEXT,
    requisitos TEXT,
    fecha_publicacion DATE,
    FOREIGN KEY (id_empresa) REFERENCES Empresas(id_empresa)
);

-- Tabla Aplicaciones
CREATE TABLE IF NOT EXISTS Aplicaciones (
    id_aplicacion INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT,
    id_oferta INT,
    fecha_aplicacion DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato),
    FOREIGN KEY (id_oferta) REFERENCES Ofertas(id_oferta)
);
SQL;

    $pdo->exec($sql);

    // Save configuration
    $configContent = "<?php
define('DB_HOST', '{$defaultCredentials['db_host']}');
define('DB_USER', '{$defaultCredentials['db_user']}');
define('DB_PASS', '{$defaultCredentials['db_pass']}');
define('DB_NAME', '{$defaultCredentials['db_name']}');
?>";
    file_put_contents($configFile, $configContent);

    $autoInstallSuccess = true;
} catch (PDOException $e) {
    $error = "No se pudo conectar con las credenciales predeterminadas. Por favor, ingrese los detalles de la base de datos.";
}

// If auto-install succeeded, redirect to registro.php
if ($autoInstallSuccess) {
    header("Location: ../general/Login_y_Registro/registro.php");
    exit;
}

// Handle manual form submission if auto-install failed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbHost = trim($_POST['db_host'] ?? '');
    $dbUser = trim($_POST['db_user'] ?? '');
    $dbPass = $_POST['db_pass'] ?? '';
    $dbName = trim($_POST['db_name'] ?? '');

    if (empty($dbHost) || empty($dbUser) || empty($dbName)) {
        $error = "Por favor, complete todos los campos requeridos.";
    } else {
        try {
            // Connect to MySQL server
            $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Create database
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `$dbName`");

            // Create tables (same SQL as above)
            $pdo->exec($sql);

            // Save configuration
            $configContent = "<?php
define('DB_HOST', '$dbHost');
define('DB_USER', '$dbUser');
define('DB_PASS', '$dbPass');
define('DB_NAME', '$dbName');
?>";
            file_put_contents($configFile, $configContent);

            header("Location: ../general/Login_y_Registro/registro.php");
            exit;
        } catch (PDOException $e) {
            $error = "❌ Error en la instalación: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Instalador PlataformaEmpleos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .installer-container {
            max-width: 500px;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .installer-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="installer-container">
        <h2>🔧 Instalador PlataformaEmpleos</h2>
        <p class="text-center">Configure la base de datos para iniciar la aplicación.</p>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="db_host" class="form-label">Servidor de Base de Datos</label>
                <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
            </div>
            <div class="mb-3">
                <label for="db_user" class="form-label">Usuario de Base de Datos</label>
                <input type="text" class="form-control" id="db_user" name="db_user" value="root" required>
            </div>
            <div class="mb-3">
                <label for="db_pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="db_pass" name="db_pass" placeholder="Dejar en blanco si no hay contraseña">
            </div>
            <div class="mb-3">
                <label for="db_name" class="form-label">Nombre de la Base de Datos</label>
                <input type="text" class="form-control" id="db_name" name="db_name" value="PlataformaEmpleos" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">📥 Instalar</button>
        </form>
    </div>
</body>

</html>