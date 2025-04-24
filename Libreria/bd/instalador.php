<?php
$configFile = 'db_config.php';

// Si ya existe db_config.php, redirigir a la aplicación
if (file_exists($configFile)) {
    header("Location: instalador.php");
    exit;
}

// Si se envía el formulario, procesar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbHost = $_POST['db_host'];
    $dbUser = $_POST['db_user'];
    $dbPass = $_POST['db_pass'];
    $dbName = $_POST['db_name'];

    try {
        // Conectar al servidor
        $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Crear la base de datos
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // Conectar a la base de datos
        $pdo->exec("USE `$dbName`");

        // Crear las tablas
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
    id_usuario INT NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    resumen_profesional TEXT,
    profesion VARCHAR(100),
    disponibilidad VARCHAR(50),
    redes_profesionales VARCHAR(255),
    foto LONGBLOB,
    cv_pdf LONGBLOB,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
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
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla Formaciones_Academicas
CREATE TABLE IF NOT EXISTS Formaciones_Academicas (
    id_formacion INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    institucion VARCHAR(255),
    titulo VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);

-- Tabla Experiencias_Laborales
CREATE TABLE IF NOT EXISTS Experiencias_Laborales (
    id_experiencia INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    empresa VARCHAR(255),
    puesto VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);

-- Tabla Habilidades
CREATE TABLE IF NOT EXISTS Habilidades (
    id_habilidad INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    habilidad VARCHAR(100),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);

-- Tabla Idiomas
CREATE TABLE IF NOT EXISTS Idiomas (
    id_idioma INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    idioma VARCHAR(100),
    nivel VARCHAR(100),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);

-- Tabla Logros_Proyectos
CREATE TABLE IF NOT EXISTS Logros_Proyectos (
    id_logro INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);

-- Tabla Referencias
CREATE TABLE IF NOT EXISTS Referencias (
    id_referencia INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    nombre_contacto VARCHAR(255),
    descripcion_contacto TEXT,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
);

-- Tabla Ofertas
CREATE TABLE IF NOT EXISTS Ofertas (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT NOT NULL,
    titulo VARCHAR(255),
    descripcion TEXT,
    requisitos TEXT,
    fecha_publicacion DATE,
    FOREIGN KEY (id_empresa) REFERENCES Empresas(id_empresa) ON DELETE CASCADE
);

-- Tabla Aplicaciones
CREATE TABLE IF NOT EXISTS Aplicaciones (
    id_aplicacion INT AUTO_INCREMENT PRIMARY KEY,
    id_candidato INT NOT NULL,
    id_oferta INT NOT NULL,
    fecha_aplicacion DATE,
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE,
    FOREIGN KEY (id_oferta) REFERENCES Ofertas(id_oferta) ON DELETE CASCADE
);
SQL;

        $pdo->exec($sql);

        // Guardar configuración
        $configContent = "<?php
define('DB_HOST', '$dbHost');
define('DB_USER', '$dbUser');
define('DB_PASS', '$dbPass');
define('DB_NAME', '$dbName');
?>";

        file_put_contents($configFile, $configContent);

        header("Location: registro.php");
        exit;
    } catch (PDOException $e) {
        $error = "❌ Error en la instalación: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Instalador PlataformaEmpleos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        form {
            display: inline-block;
            text-align: left;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }

        button {
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>🔧 Instalador PlataformaEmpleos</h2>
    <p>Complete los datos para crear la base de datos e iniciar la aplicación.</p>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Servidor de Base de Datos:</label>
        <input type="text" name="db_host" value="localhost" required>

        <label>Usuario de Base de Datos:</label>
        <input type="text" name="db_user" value="root" required>

        <label>Contraseña:</label>
        <input type="password" name="db_pass">

        <label>Nombre de la Base de Datos:</label>
        <input type="text" name="db_name" value="PlataformaEmpleos" required>

        <button type="submit">📥 Instalar</button>
    </form>
</body>

</html>