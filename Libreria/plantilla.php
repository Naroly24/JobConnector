<?php

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
        ?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>EduTrack</title>
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

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

                .mobile-menu-toggle {
                    display: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                }

                @media (max-width: 768px) {
                    .mobile-menu-toggle {
                        display: block;
                    }

                    nav {
                        display: none;
                        position: absolute;
                        top: var(--header-height);
                        left: 0;
                        width: 100%;
                        background-color: var(--white);
                        box-shadow: var(--shadow);
                    }

                    nav.active {
                        display: block;
                    }

                    nav ul {
                        flex-direction: column;
                        padding: 1rem;
                    }

                    nav ul li {
                        margin: 0.5rem 0;
                    }
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

                .form-footer {
                    text-align: center;
                    margin-top: 1.5rem;
                    padding-top: 1.5rem;
                    border-top: 1px solid #ddd;
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
            </style>

        </head>

        <body>
            <div class="container">

                <?php
    }

    public static function navbar()
    {
        ?>
                <header>
                    <div class="container header-container">
                        <div class="logo">
                            <img src="Img/logo.png" alt="JobConnect RD Logo">
                            <h1>Job<span>Connect RD</span></h1>
                        </div>
                        <div class="mobile-menu-toggle" id="mobile-toggle">
                            <i class="fas fa-bars"></i>
                        </div>
                        <nav id="nav-menu">
                            <ul>
                                <li><a href="index.php" class="nav_link active-link">Candidatos</a></li>
                                <li><a href="registro.php" class="nav_link">Empresas</a></li>
                                <li><a href="reparto.php" class="nav_link">Sobre Nosotros</a></li>
                                <li><a href="Login.php" class="nav_link login-link">Iniciar Sesión</a></li>
                            </ul>
                        </nav>
                    </div>
                </header>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const mobileToggle = document.getElementById('mobile-toggle');
                        const navMenu = document.getElementById('nav-menu');

                        if (mobileToggle) {
                            mobileToggle.addEventListener('click', function () {
                                navMenu.classList.toggle('active');
                            });

                            navMenu.querySelectorAll('a').forEach(link => {
                                link.addEventListener('click', () => {
                                    navMenu.classList.remove('active');
                                });
                            });
                        }

                        document.addEventListener('click', function (event) {
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
                                <li><a href="candidatos_index.html">Inicio para Candidatos</a></li>
                                <li><a href="#">Buscar Empleos</a></li>
                                <li><a href="empresas_index.html">Inicio para Empresas</a></li>
                                <li><a href="sobre-nosotros.html">Sobre Nosotros</a></li>
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