<?php
define('BASE_URL', '/JobConnector/');

class Plantilla
{
    static $instance = null;

    public static function aplicar()
    {
        if (self::$instance == null) {
            self::$instance = new Plantilla();
        }
    }

    public function __construct()
    {
        // Iniciar sesión si no se ha hecho aún
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>JobConnect RD</title>
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                   /* --main-content-width: calc(100% - var(--sidebar-width)); */
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

                header {
                    background-color: var(--white);
                    box-shadow: var(--shadow);
                    height: var(--header-height);
                    position: fixed;
                    width: 100%;
                    top: 0;
                    z-index: 1000;
                }

                .header-container {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    height: 100%;
                    padding: 0 1rem;
                    /* max-width: var(--max-width); */
                    margin: 0 auto;
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

                .logo-link {
                    display: flex;
                    align-items: center;
                    text-decoration: none;
                    /* Quita el subrayado */
                }

                .logo-link img {
                    height: 40px;
                    /* ajusta según tu diseño */
                    margin-right: 10px;
                }

                .logo-link h1 {
                    font-size: 24px;
                    margin: 0;
                }


                nav {
                    display: flex;
                }

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

                a {
                    color: var(--primary);
                    text-decoration: none;
                    transition: var(--transition);
                }

                a:hover {
                    color: var(--primary-dark);
                }

                /* Contenedor principal */
                .container {
                    width: 100%;
                    margin: auto auto;
                }

                /* Main content */
                main {
                    margin-top: var(--header-height);
                    flex: 1;
                    padding: 1.5rem 1rem;
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

                .btn-sm {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.875rem;
                }

                .btn-block {
                    display: block;
                    width: 100%;
                }

                /* Formularios */
                .form-group {
                    margin-bottom: 1.5rem;
                }

                .form-label {
                    display: block;
                    margin-bottom: 0.5rem;
                    font-weight: 500;
                }

                .form-control {
                    width: 100%;
                    padding: 0.75rem;
                    border: 1px solid #ddd;
                    border-radius: var(--radius);
                    font-size: 1rem;
                    transition: var(--transition);
                }

                .form-control:focus {
                    outline: none;
                    border-color: var(--primary);
                    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
                }

                .form-text {
                    display: block;
                    margin-top: 0.25rem;
                    font-size: 0.875rem;
                    color: var(--gray);
                }

                /* Footer */
                footer {
                    background-color: var(--dark);
                    color: var(--white);
                    padding: 12px;
                }

                .footer-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                    gap: 1.5rem;
                    /* Añade separación controlada entre columnas */
                    margin-bottom: 0.5rem;
                    /* Baja un poco el bloque de columnas */
                }

                .footer-section {
                    flex: 1;
                    min-width: 200px;
                    padding-right: 1rem;
                    padding-top: 0.5rem;
                    /* Baja el contenido dentro de la sección */
                }

                .footer-section h3 {
                    margin-bottom: 1rem;
                    font-size: 1.1rem;
                    /* Ligeramente más pequeño */
                    color: var(--light);
                }

                .footer-section ul {
                    list-style: none;
                }

                .footer-section ul li {
                    margin-bottom: 0.3rem;
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
                    padding-top: 0.8rem;
                    /* Menos separación superior */
                    margin-top: 1rem;
                    /* Menos margen para subir el bloque */
                    font-size: 0.9rem;
                    /* Tamaño más pequeño */
                    border-top: 1px solid rgba(255, 255, 255, 0.1);
                }

                .form-footer {
                    text-align: center;
                    margin-top: 1.5rem;
                    padding-top: 1.5rem;
                    border-top: 1px solid #ddd;
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

                .checkbox-group {
                    margin-top: 1rem;
                }

                .checkbox-label {
                    display: flex;
                    align-items: flex-start;
                    margin-bottom: 0.5rem;
                }

                .checkbox-label input {
                    margin-right: 0.5rem;
                    margin-top: 0.3rem;
                }

                /* General */
                img {
                    max-width: 100%;
                    height: auto;
                }

                .btn-lg {
                    padding: 1rem 2rem;
                    font-size: 1.25rem;
                }

                /* Registro */
                .registro-container {
                    max-width: 800px;
                    margin: 2rem auto;
                    background-color: var(--white);
                    border-radius: var(--radius);
                    box-shadow: var(--shadow);
                    overflow: hidden;
                }

                .registro-header {
                    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                    color: var(--white);
                    padding: 2rem;
                    text-align: center;
                }

                .registro-header h2 {
                    font-size: 2rem;
                    margin-bottom: 0.5rem;
                }

                .registro-form {
                    padding: 2rem;
                }

                /* Login */
                .login-container {
                    max-width: 800px;
                    margin: 2rem auto;
                    background-color: var(--white);
                    border-radius: var(--radius);
                    box-shadow: var(--shadow);
                    overflow: hidden;
                }

                .login-header {
                    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                    color: var(--white);
                    padding: 2rem;
                    text-align: center;
                }

                .login-header h2 {
                    font-size: 2rem;
                    margin-bottom: 0.5rem;
                }

                .form-row {
                    display: flex;
                    flex-wrap: wrap;
                    margin: 0 -0.5rem;
                }

                .form-col {
                    flex: 1;
                    min-width: 200px;
                    padding: 0 0.5rem;
                }

                /* Divider */
                .form-divider {
                    margin: 1.5rem 0;
                    border-top: 1px solid #ddd;
                    position: relative;
                    text-align: center;
                }

                .form-divider span {
                    position: absolute;
                    top: -12px;
                    background: var(--white);
                    padding: 0 1rem;
                    color: var(--gray);
                }

                /* Social signup */
                .social-signup {
                    display: flex;
                    justify-content: center;
                    gap: 1rem;
                    margin: 1.5rem 0;
                }

                .social-btn {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.75rem 1rem;
                    border-radius: var(--radius);
                    border: 1px solid #ddd;
                    background-color: var(--white);
                    color: var(--dark);
                    transition: var(--transition);
                    cursor: pointer;
                    width: 180px;
                }

                /* Toggle contraseña refinado */
                .password-toggle {
                    position: relative;
                }

                .password-toggle input {
                    padding-right: 2.5rem;
                }

                .password-toggle .toggle-btn {
                    position: absolute;
                    top: 65%;
                    right: 10px;
                    transform: translateY(-50%);
                    background: transparent;
                    border: none;
                    cursor: pointer;
                    font-size: 1.1rem;
                }

                .error-msg {
                    color: red;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 15px;
                }

                .success-msg {
                    color: green;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 15px;
                }

                .campo-password {
                    position: relative;
                }

                .toggle-password {
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    border: none;
                    background: transparent;
                    cursor: pointer;
                    font-size: 16px;
                }

                .tabs {
                    display: flex;
                    justify-content: space-around;
                    margin-bottom: 20px;
                    border-bottom: 2px solid #ccc;
                }

                .tab-item {
                    padding: 10px 20px;
                    cursor: pointer;
                    font-weight: bold;
                    border-bottom: 3px solid transparent;
                }

                .tab-item.active {
                    border-color: #007bff;
                    color: #007bff;
                }

                .tab-content {
                    display: none;
                }

                .tab-content.active {
                    display: block;
                }

                /* Por defecto (pantallas grandes) */
                .mobile-menu-toggle {
                    display: none;
                }

                /* Menú lateral desde la derecha */
                .side-menu {
                    position: fixed;
                    top: var(--header-height);
                    right: -250px;
                    /* ← inicia oculto fuera de la pantalla, hacia la derecha */
                    width: 250px;
                    height: 100vh;
                    background-color: var(--white);
                    box-shadow: var(--shadow);
                    padding: 20px;
                    transition: right 0.3s ease;
                    z-index: 999;
                    display: flex;
                    flex-direction: column;
                }

                .side-menu.active {
                    right: 0;
                    /* ← aparece al hacer clic */
                }

                .side-menu ul {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                }

                .side-menu ul li a {
                    color: var(--dark);
                    font-weight: 500;
                }

                .side-menu ul li a:hover {
                    color: var(--primary);
                }

                /* Pantallas grandes: volver al menú horizontal */
                @media (min-width: 769px) {
                    .mobile-menu-toggle {
                        display: none;
                    }

                    .side-menu {
                        position: static;
                        height: auto;
                        width: auto;
                        background: none;
                        box-shadow: none;
                        padding: 0;
                        display: flex !important;
                        flex-direction: row;
                    }

                    .side-menu ul {
                        flex-direction: row;
                        gap: 1.5rem;
                    }
                }

                /* Ajuste el tamaño de la pantalla */

                @media (max-width: 768px) {
                    .header-container {
                        flex-direction: row;
                        justify-content: space-between;
                        align-items: center;
                        padding: 10px;
                    }

                    .logo-link {
                        justify-content: center;
                        width: 100%;
                    }

                    nav {
                        display: none;
                        width: 100%;
                        background-color: var(--white);
                    }

                    nav.active {
                        display: block;
                    }

                    nav ul {
                        flex-direction: column;
                        padding: 10px;
                    }

                    nav ul li {
                        margin: 10px 0;
                    }

                    .mobile-menu-toggle {
                        display: block;
                        cursor: pointer;
                        font-size: 1.5rem;
                    }

                    body {
                        overflow-x: hidden;
                        /* 💡 evita scroll horizontal */
                    }

                    .login-container,
                    .registro-container {
                        padding: 1rem;
                        margin: 1rem;
                    }


                    .form-row {
                        flex-direction: column;
                    }

                    .form-col {
                        padding: 0;
                        margin-bottom: 1rem;
                    }

                    .footer-container {
                        flex-direction: column;
                        gap: 2rem;
                    }

                    .footer-section {
                        padding-right: 0;
                    }

                    .social-signup {
                        flex-direction: column;
                        align-items: center;
                    }

                    .social-btn {
                        width: 100%;
                        max-width: 300px;
                    }

                    .registro-form,
                    .login-form {
                        padding: 1rem;
                    }
                }

                .user-menu {
                    position: relative;
                    display: flex;
                    align-items: center;
                    cursor: pointer;
                }

                .dropdown-toggle {
                    margin-left: 0.5rem;
                }

                .dropdown-menu {
                    position: absolute;
                    top: 100%;
                    right: 0;
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                    display: none;
                    flex-direction: column;
                    min-width: 160px;
                    z-index: 1000;
                }

                .user-menu:hover .dropdown-menu {
                    display: flex;
                }

                .dropdown-menu a {
                    padding: 0.75rem 1rem;
                    text-decoration: none;
                    color: #333;
                    font-size: 14px;
                    white-space: nowrap;
                }

                .dropdown-menu a:hover {
                    background-color: #f0f0f0;
                }

                .user-avatar {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    font-size: 14px;
                    margin-right: 0.5rem;
                }

                /* Colores dinámicos */
                .avatar-candidato {
                    background-color: #3498db;
                    /* Azul */
                }

                .avatar-empresa {
                    background-color: #e74c3c;
                    /* Rojo */
                }

                /* Seccion empresas */

                /* Dashboard */
                .dashboard-container {
                    display: flex;
                    margin-top: var(--header-height);
                    flex: 1;
                }

                /* Sidebar */
                .sidebar {
                    width: var(--sidebar-width);
                    background-color: var(--white);
                    box-shadow: var(--shadow);
                    height: calc(100vh - var(--header-height) + 210px);

                    overflow-y: auto;
                    transition: var(--transition);
                }

                .sidebar-header {
                    padding: 1.5rem 1rem;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                }

                .sidebar-menu {
                    padding: 1rem 0;
                }

                .sidebar-menu ul {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .menu-item {
                    padding: 0.75rem 1.5rem;
                    display: flex;
                    align-items: center;
                    transition: var(--transition);
                    cursor: pointer;
                }

                .menu-item.active {
                    background-color: rgba(52, 152, 219, 0.1);
                    border-left: 4px solid var(--primary);
                }

                .menu-item:hover {
                    background-color: rgba(52, 152, 219, 0.05);
                }

                .menu-item i {
                    margin-right: 0.75rem;
                    width: 20px;
                    text-align: center;
                    color: var(--primary);
                }

                /* Contenido principal */
                .main-content {
                    flex: 1;
                    padding: 2rem;
                    
                }

                .page-title {
                    margin-bottom: 1.5rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                /* Cards para Dashboard */
                .stats-container {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                    gap: 1.5rem;
                    margin-bottom: 2rem;
                }

                .stat-card {
                    background-color: var(--white);
                    border-radius: var(--radius);
                    box-shadow: var(--shadow);
                    padding: 1.5rem;
                    display: flex;
                    align-items: center;
                }

                .stat-icon {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    background-color: rgba(52, 152, 219, 0.1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.5rem;
                    color: var(--primary);
                    margin-right: 1rem;
                }

                .stat-info h3 {
                    font-size: 1.25rem;
                    margin-bottom: 0.25rem;
                }

                .stat-info p {
                    color: var(--gray);
                    font-size: 0.875rem;
                }

                /* Secciones de contenido */
                .content-section {
                    background-color: var(--white);
                    border-radius: var(--radius);
                    box-shadow: var(--shadow);
                    margin-bottom: 2rem;
                }

                .section-header {
                    padding: 1.25rem 1.5rem;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .section-body {
                    padding: 1.5rem;
                }

                /* Aplicaciones a trabajos */
                .job-application {
                    display: flex;
                    align-items: center;
                    padding: 1rem 0;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                }

                .job-application:last-child {
                    border-bottom: none;
                }

                .application-company {
                    width: 50px;
                    height: 50px;
                    background-color: rgba(52, 152, 219, 0.1);
                    border-radius: var(--radius);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: var(--primary);
                    font-weight: bold;
                    margin-right: 1rem;
                }

                .application-info {
                    flex: 1;
                }

                .application-title {
                    font-weight: 500;
                    font-size: 1.1rem;
                    margin-bottom: 0.25rem;
                }

                .application-company-name {
                    font-size: 0.9rem;
                    color: var(--primary);
                    margin-bottom: 0.25rem;
                }

                .application-meta {
                    font-size: 0.875rem;
                    color: var(--gray);
                    display: flex;
                    align-items: center;
                }

                .application-meta span {
                    margin-right: 1rem;
                    display: flex;
                    align-items: center;
                }

                .application-meta i {
                    margin-right: 0.25rem;
                }

                .application-status {
                    min-width: 120px;
                    text-align: right;
                }

                .status-badge {
                    display: inline-block;
                    padding: 0.25rem 0.75rem;
                    border-radius: 50px;
                    font-size: 0.75rem;
                    font-weight: 700;
                }

                .status-applied {
                    background-color: rgba(52, 152, 219, 0.1);
                    color: var(--primary);
                }

                /*Ofertas de empleo*/
                .offer-card {
                    background-color: #fff;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    padding: 20px;
                    margin-bottom: 30px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                }

                .offer-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 10px;
                }

                .offer-title {
                    font-size: 1.5rem;
                    font-weight: bold;
                    margin: 0;
                    color: #333;
                }

                .offer-date {
                    font-size: 0.9rem;
                    color: #666;
                }

                .offer-body {
                    margin-bottom: 15px;
                }

                .offer-description {
                    font-size: 1rem;
                    line-height: 1.5;
                    color: #444;
                }

                .offer-footer {
                    display: flex;
                    gap: 10px;
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
                    text-align: center;
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
                    justify-content: center;
                    margin: 0 -1rem;
                }

                .col-md-6-col-sm-12 {
                    flex: 0 0 50%;
                    max-width: 50%;
                    padding: 10px;
                }

                .col-md-6-col-lg-4-col-sm-12 {
                    flex: 0 0 33.3333%;
                    max-width: 33.3333%;
                    padding: 25px;
                }


                .col {
                    flex: 2;
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
            </style>

        </head>

        <body>
            <div class="container">

            <?php
        }

        public static function navbar()
        {

            $tipoUsuario = $_SESSION['tipo_usuario'] ?? '';

            ?>
                <header>
                    <div class="container header-container">
                        <div class="logo">
                            <a href="/general/index.php" class="logo-link">
                                <img src="/Libreria/logo.png" alt="JobConnect RD Logo">
                                <h1>Job<span>Connect RD</span></h1>
                            </a>
                        </div>
                        <div class="mobile-menu-toggle" id="mobile-toggle">
                            <i class="fas fa-bars"></i>
                        </div>
                        <nav id="nav-menu" class="side-menu">
                            <ul>
                                <li><a href="/general/index.php" class="nav_link active-link">Inicio</a></li>
                                <li><a href="/general/sobre-nosotros.php" class="nav_link">Sobre Nosotros</a></li>

                                <?php if ($tipoUsuario === 'empresa'): ?>
                                    <li><a href="/panel_empresas/empresa_panel.php" class="nav_link">Panel</a></li>
                                    </li>

                                <?php elseif ($tipoUsuario === 'candidato'): ?>
                                    <li><a href="/panel_candidatos/buscar_empleos.php" class="nav_link">Buscar Empleos</a></li>
                                    <li><a href="/panel_candidatos/candidato_panel.php" class="nav_link">Panel</a></li>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['id_usuario'])): ?>
                                    <?php
                                    $tipoUsuario = $_SESSION['tipo_usuario'] ?? '';
                                    // Definir la clase del avatar según el tipo de usuario
                                    $claseColor = (strtolower($tipoUsuario) === 'empresa') ? 'avatar-empresa' : 'avatar-candidato';

                                    // Usar el correo para iniciales y nombre si nombre/apellido no están en la sesión
                                    $correo = $_SESSION['correo'] ?? 'Usuario';
                                    $iniciales = strtoupper(substr($correo, 0, 2)); // Primeras dos letras del correo
                                    $nombreCompleto = $correo; // Mostrar correo como nombre por defecto

                                    $sql = "SELECT nombre, apellido FROM Usuarios WHERE id_usuario = ?";
                                    $parametros = [$_SESSION['id_usuario']];
                                    $resultado = Conexion::select($sql, $parametros);
                                    if ($resultado) {
                                        $iniciales = strtoupper(substr($resultado['nombre'], 0, 1));
                                        $nombreCompleto = $resultado['nombre'];
                                        if ($resultado['apellido'] && $resultado['apellido'] !== '-' && $resultado['apellido'] !== '') {
                                            $iniciales .= strtoupper(substr($resultado['apellido'], 0, 1));
                                            $nombreCompleto .= ' ' . $resultado['apellido'];
                                        }
                                    }
                                    ?>

                                    <li>
                                        <div class="user-menu">
                                            <div class="user-avatar <?= $claseColor ?>">
                                                <?= htmlspecialchars($iniciales) ?>
                                            </div>
                                            <span class="user-name"><?= htmlspecialchars($nombreCompleto) ?></span>
                                            <div class="dropdown-toggle"><i class="fas fa-chevron-down"></i></div>
                                            <div class="dropdown-menu">
                                                <a href="/general/Login_y_registro/logout.php">Cerrar Sesión</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li><a href="/general/Login_y_Registro/Login.php" class="nav_link login-link">Iniciar Sesión</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </header>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const mobileToggle = document.getElementById('mobile-toggle');
                        const navMenu = document.getElementById('nav-menu');

                        if (mobileToggle) {
                            mobileToggle.addEventListener('click', function() {
                                navMenu.classList.toggle('active');
                            });

                            navMenu.querySelectorAll('a').forEach(link => {
                                link.addEventListener('click', () => {
                                    navMenu.classList.remove('active');
                                });
                            });
                        }

                        document.addEventListener('click', function(event) {
                            if (!navMenu.contains(event.target) && !mobileToggle.contains(event.target)) {
                                navMenu.classList.remove('active');
                            }
                        });
                    });
                </script>
            <?php
        }



        public function __destruct()
        {
            ?>
            </div>

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
                                <li><a href="/general/index_candidatos.php">Inicio para Candidatos</a></li>
                                <li><a href="/panel_candidatos/buscar_empleos.html">Buscar Empleos</a></li>
                                <li><a href="/general/index_empresas.php">Inicio para Empresas</a></li>
                                <li><a href="/general/sobre-nosotros.php">Sobre Nosotros</a></li>
                            </ul>
                        </div>

                        <!-- Contact Section -->
                        <div class="footer-section">
                            <h3>Contacto</h3>
                            <ul>
                                <li><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i> info@jobconnectrd.com</li>
                                <li><i class="fas fa-phone" style="margin-right: 0.5rem;"></i> +1 809-555-1234</li>
                                <li><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i> Av. Winston Churchill,
                                    Santo
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
<?php
        }
    }
?>