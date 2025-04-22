<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect RD - Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        <?php include 'estilos_registro.css'; ?>
    </style>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="../assets/logo.png" alt="JobConnect RD Logo">
                <h1>Job<span>Connect RD</span></h1>
            </div>
            <div class="mobile-menu-toggle" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <nav id="nav-menu">
                <ul>
                    <li><a href="index_candidatos.html" class="active">Candidatos</a></li>
                    <li><a href="index_empresas.html">Empresas</a></li>
                    <li><a href="sobre-nosotros.html">Sobre Nosotros</a></li>
                    <li><a href="login.html" class="btn btn-primary btn-sm">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="registro-container">
                <div class="registro-header">
                    <h2>Crear una cuenta</h2>
                    <p>Unete a la mayor red de empleo profesional en República Dominicana</p>
                </div>
                <?php include 'formularios/candidato_form.php'; ?>
                <?php include 'formularios/empresa_form.php'; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Sobre JobConnect RD</h3>
                    <p style="opacity: 0.8; margin-bottom: 1rem;">Plataforma líder en conectar talento dominicano con oportunidades profesionales en el país.</p>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="candidatos_index.html">Inicio para Candidatos</a></li>
                        <li><a href="#">Buscar Empleos</a></li>
                        <li><a href="empresas_index.html">Inicio para Empresas</a></li>
                        <li><a href="sobre-nosotros.html">Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <ul>
                        <li><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i> info@jobconnectrd.com</li>
                        <li><i class="fas fa-phone" style="margin-right: 0.5rem;"></i> +1 809-555-1234</li>
                        <li><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i> Av. Winston Churchill, Santo Domingo</li>
                    </ul>
                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileToggle = document.getElementById('mobile-toggle');
            const navMenu = document.getElementById('nav-menu');
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function () {
                    navMenu.classList.toggle('active');
                });
            }

            const tabItems = document.querySelectorAll('.tab-item');
            const tabContents = document.querySelectorAll('.tab-content');
            tabItems.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabItems.forEach(item => item.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId + '-tab').classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
