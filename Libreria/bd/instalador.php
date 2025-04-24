<?php
// Default database configuration
$default_host = 'localhost';
$default_user = 'root';
$default_pass = '';
$default_db = 'PlataformaEmpleos';

// Check if database already exists to avoid redundant installation
try {
    $pdo = new PDO("mysql:host=$default_host;dbname=$default_db", $default_user, $default_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Database exists, redirect to index.php
    header("Location: ../../general/index.php");
    exit;
} catch (PDOException $e) {
    // Database doesn't exist, proceed to installation
}

        // Handle installation form submission
        // Handle installation form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['install'])) {
            $error_log = [];
            try {
                // Connect to MySQL server
                $pdo = new PDO("mysql:host=$default_host", $default_user, $default_pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Create database
                $pdo->exec("CREATE DATABASE IF NOT EXISTS PlataformaEmpleos");
                $pdo->exec("USE PlataformaEmpleos");

                // Array of SQL statements for table creation
                $sql_statements = [
                    "CREATE TABLE IF NOT EXISTS Usuarios (
                id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                apellido VARCHAR(100) NOT NULL,
                correo VARCHAR(100) NOT NULL UNIQUE,
                contrasena VARCHAR(255) NOT NULL,
                fecha DATE NOT NULL,
                tipo_usuario ENUM('candidato', 'empresa') NOT NULL
            )",
                    "CREATE TABLE IF NOT EXISTS Candidatos (
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
                UNIQUE KEY uk_id_usuario (id_usuario),
                FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Empresas (
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
            )",
                    "CREATE TABLE IF NOT EXISTS Formaciones_Academicas (
                id_formacion INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                institucion VARCHAR(255),
                titulo VARCHAR(255),
                fecha_inicio DATE,
                fecha_fin DATE,
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Experiencias_Laborales (
                id_experiencia INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                empresa VARCHAR(255),
                puesto VARCHAR(255),
                fecha_inicio DATE,
                fecha_fin DATE,
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Habilidades (
                id_habilidad INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                habilidad VARCHAR(100),
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Idiomas (
                id_idioma INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                idioma VARCHAR(100),
                nivel VARCHAR(100),
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Logros_Proyectos (
                id_logro INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                descripcion TEXT,
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Referencias (
                id_referencia INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                nombre_contacto VARCHAR(255),
                descripcion_contacto TEXT,
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Ofertas (
                id_oferta INT AUTO_INCREMENT PRIMARY KEY,
                id_empresa INT NOT NULL,
                titulo VARCHAR(255),
                descripcion TEXT,
                requisitos TEXT,
                fecha_publicacion DATE,
                FOREIGN KEY (id_empresa) REFERENCES Empresas(id_empresa) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS Aplicaciones (
                id_aplicacion INT AUTO_INCREMENT PRIMARY KEY,
                id_candidato INT NOT NULL,
                id_oferta INT NOT NULL,
                fecha_aplicacion DATE,
                FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato) ON DELETE CASCADE,
                FOREIGN KEY (id_oferta) REFERENCES Ofertas(id_oferta) ON DELETE CASCADE
            )"
                ];

                // Execute each SQL statement
                foreach ($sql_statements as $index => $sql) {
                    try {
                        $pdo->exec($sql);
                    } catch (PDOException $e) {
                        $error_log[] = "Error en la consulta #$index: " . $e->getMessage() . " SQL: " . $sql;
                    }
                }

                if (!empty($error_log)) {
                    throw new Exception("Errores al crear tablas:\n" . implode("\n", $error_log));
                }

                // Create db_config.php
                $config_content = "<?php
define('DB_HOST', '$default_host');
define('DB_USER', '$default_user');
define('DB_PASS', '$default_pass');
define('DB_NAME', '$default_db');
?>";
        if (!file_put_contents('db_config.php', $config_content)) {
            throw new Exception("No se pudo crear db_config.php. Verifique los permisos de escritura en el directorio bd/.");
        }

        // Redirect to index.php
        header("Location: ../../general/index.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error al crear la base de datos: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación de JobConnect RD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS from curriculum.php/index.php for consistency */
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
        }

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
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 2rem;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        p {
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            background-color: var(--primary);
            color: var(--white);
            font-size: 1rem;
        }

        .btn:hover {
            background-color: var(--primary-dark);
        }

        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border-left: 5px solid;
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border-left-color: var(--danger);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Instalación de JobConnect RD</h1>
        <p>La base de datos no está configurada. Haga clic en el botón a continuación para instalar la base de datos necesaria para la aplicación.</p>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="post">
            <button type="submit" name="install" class="btn">Instalar Base de Datos</button>
        </form>
    </div>
</body>

</html>