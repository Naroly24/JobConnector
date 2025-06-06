<?php
$ocultar_footer = false;
require('../libreria/motor.php');
require_once('../libreria/plantilla.php');

plantilla::aplicar();
if (isset($ocultar_footer) && $ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();
?>
<!-- Main Content -->
<main>
    <!-- Hero Section -->
    <section class="container">
        <div class="hero">
            <h2>Sobre JobConnect RD</h2>
            <p>Conoce nuestra misión, visión y el equipo detrás de la plataforma líder en conexión de talento dominicano con oportunidades profesionales.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Nuestra Historia</h2>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p>JobConnect RD nació en 2023 con la misión de transformar el mercado laboral dominicano. Nos propusimos crear una plataforma que no solo conecte a profesionales con empresas, sino que también fomente el crecimiento profesional y económico en República Dominicana.</p>
                        <p>Hoy, somos la plataforma líder en el país, ayudando a miles de dominicanos a encontrar empleos en Santo Domingo, Santiago, Punta Cana y más, mientras apoyamos a empresas a descubrir talento excepcional.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission and Vision -->
    <section class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Misión y Visión</h2>
        <div class="row">
            <!-- Mission -->
            <div class="col-md-6-col-sm-12">
                <div class="card">
                    <h3 class="card-title">Misión</h3>
                    <div class="card-body">
                        <p>Conectar el talento dominicano con oportunidades laborales significativas, promoviendo el desarrollo profesional y el bienestar económico en el país.</p>
                    </div>
                </div>
            </div>
            <!-- Vision -->
            <div class="col-md-6-col-sm-12">
                <div class="card">
                    <h3 class="card-title">Visión</h3>
                    <div class="card-body">
                        <p>Ser la plataforma de empleo número uno en República Dominicana, reconocida por su innovación, accesibilidad y compromiso con el éxito de profesionales y empresas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Nuestro Equipo</h2>
        <div class="row">
            <!-- Team Member 1 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card">
                    <h3 class="card-title">Ana Martínez</h3>
                    <div class="card-body">
                        <p><strong>Fundadora y CEO</strong></p>
                        <p>Líder apasionada por conectar talento con oportunidades en RD.</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 2 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card">
                    <h3 class="card-title">Carlos Díaz</h3>
                    <div class="card-body">
                        <p><strong>Director de Tecnología</strong></p>
                        <p>Experto en construir plataformas digitales innovadoras.</p>
                    </div>
                </div>
            </div>
            <!-- Team Member 3 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card">
                    <h3 class="card-title">Sofía López</h3>
                    <div class="card-body">
                        <p><strong>Gerente de Operaciones</strong></p>
                        <p>Dedicada a garantizar una experiencia fluida para usuarios y empresas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
        <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); text-align: center; padding: 3rem 1rem; border-radius: var(--radius);">
            <h2 style="margin-bottom: 1rem; font-size: 2rem;">Únete a Nuestra Comunidad</h2>
            <p style="margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">Regístrate en JobConnect RD y forma parte de la plataforma que está transformando el mercado laboral dominicano.</p>
            <a href="#" class="btn btn-secondary btn-lg">Crear Cuenta</a>
        </div>
    </section>
</main>