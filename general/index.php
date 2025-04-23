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
            <h2>Encuentra tu próxima oportunidad profesional en República Dominicana</h2>
            <p>Conectamos talento dominicano con las mejores empresas del país. Crea tu perfil, sube tu CV y comienza a
                aplicar a ofertas de trabajo en Santo Domingo, Santiago y más.</p>
            <a href="Login_y_Registro/registro.php" class="btn btn-secondary btn-lg">Registrarse Ahora</a>
        </div>
    </section>

    <!-- AQUI PONDRE LAS FUNCIONES DE LISTAR OFERTAS -->
    <!-- Featured Jobs Section -->


    <!-- Ofertas Destacadas -->
    <section class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Ofertas Destacadas</h2>
        <div class="row">

            <!-- Oferta 1 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card h-100">
                    <div style="font-size: 2rem; color: var(--primary); margin-top: 1rem; text-align: center;">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="job-title">Desarrollador Frontend</h3>
                        <div class="job-company">TechRD Solutions</div>
                        <div class="job-details my-2">
                            <div><i class="fas fa-map-marker-alt"></i> Santo Domingo, RD</div>
                            <div><i class="fas fa-clock"></i> Tiempo Completo</div>
                            <div><i class="fas fa-dollar-sign"></i> RD$1,200,000 - RD$1,500,000</div>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-primary">React</span>
                            <span class="badge bg-primary">JavaScript</span>
                            <span class="badge bg-primary">CSS</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Oferta 2 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card h-100">
                    <div style="font-size: 2rem; color: var(--primary); margin-top: 1rem; text-align: center;">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="job-title">Ingeniero de Software Backend</h3>
                        <div class="job-company">Innovatech RD</div>
                        <div class="job-details my-2">
                            <div><i class="fas fa-map-marker-alt"></i> Santiago, RD</div>
                            <div><i class="fas fa-clock"></i> Tiempo Completo</div>
                            <div><i class="fas fa-dollar-sign"></i> RD$1,400,000 - RD$1,800,000</div>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-primary">Python</span>
                            <span class="badge bg-primary">Django</span>
                            <span class="badge bg-primary">SQL</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Oferta 3 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card h-100">
                    <div style="font-size: 2rem; color: var(--primary); margin-top: 1rem; text-align: center;">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="job-title">Diseñador UX/UI</h3>
                        <div class="job-company">CreativeTech RD</div>
                        <div class="job-details my-2">
                            <div><i class="fas fa-map-marker-alt"></i> Punta Cana, RD</div>
                            <div><i class="fas fa-clock"></i> Tiempo Completo</div>
                            <div><i class="fas fa-dollar-sign"></i> RD$1,000,000 - RD$1,300,000</div>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-primary">Figma</span>
                            <span class="badge bg-primary">Adobe XD</span>
                            <span class="badge bg-primary">Sketch</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">Ver Detalles</a>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- How It Works Section -->
    <section class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">¿Cómo Funciona?</h2>

        <div class="row">
            <!-- Step 1 -->
            <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="card-title">1. Crea tu Perfil</h3>
                    <div class="card-body">
                        <p>Regístrate y completa tu perfil profesional con tus experiencias, habilidades y formación
                            académica.</p>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="card-title">2. Sube tu CV</h3>
                    <div class="card-body">
                        <p>Carga tu currículum actualizado para que las empresas puedan conocer mejor tu trayectoria
                            profesional.</p>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="card-title">3. Aplica a Ofertas</Fh3>
                        <div class="card-body">
                            <p>Explora las ofertas disponibles y postúlate fácilmente a aquellas que se alineen con tus
                                intereses y habilidades profesionales.</p>
                        </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Companies Section -->
    <section class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Empresas Destacadas</h2>

        <div class="row">
            <!-- Company 1 -->
            <div class="col-md-6 col-lg-3 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <h3 class="card-title">TechRD Solutions</h3>
                    <div class="card-body">
                        <p>Soluciones tecnológicas innovadoras para empresas dominicanas.</p>
                    </div>
                    <div class="card-footer">
                        <a href="empresas.html" class="btn btn-outline btn-sm">Ver Perfil</a>
                    </div>
                </div>
            </div>

            <!-- Company 2 -->
            <div class="col-md-6 col-lg-3 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <h3 class="card-title">Innovatech RD</h3>
                    <div class="card-body">
                        <p>Agencia digital líder en desarrollo de software en Santo Domingo.</p>
                    </div>
                    <div class="card-footer">
                        <a href="empresas.html" class="btn btn-outline btn-sm">Ver Perfil</a>
                    </div>
                </div>
            </div>

            <!-- Company 3 -->
            <div class="col-md-6 col-lg-3 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <h3 class="card-title">CreativeTech RD</h3>
                    <div class="card-body">
                        <p>Estudio de diseño enfocado en experiencias digitales para turismo.</p>
                    </div>
                    <div class="card-footer">
                        <a href="empresas.html" class="btn btn-outline btn-sm">Ver Perfil</a>
                    </div>
                </div>
            </div>

            <!-- Company 4 -->
            <div class="col-md-6 col-lg-3 col-sm-12" style="margin-bottom: 1.5rem;">
                <div class="card" style="text-align: center;">
                    <h3 class="card-title">DataDominicana</h3>
                    <div class="card-body">
                        <p>Especialistas en análisis de datos para negocios locales.</p>
                    </div>
                    <div class="card-footer">
                        <a href="empresas.html" class="btn btn-outline btn-sm">Ver Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Testimonios</h2>

        <div class="row">
            <!-- Testimonial 1 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card">
                    <div style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem; text-align: center;">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="card-body">
                        <p style="font-style: italic;">JobConnect RD me ayudó a encontrar un trabajo en Santo Domingo en
                            solo tres semanas. ¡La plataforma es súper fácil de usar!</p>
                        <div style="margin-top: 1.5rem;">
                            <strong>María Gómez</strong>
                            <div style="color: var(--gray);">Desarrolladora Frontend</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card">
                    <div style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem; text-align: center;">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="card-body">
                        <p style="font-style: italic;">Como empresa, encontramos en JobConnect RD candidatos talentosos
                            que encajan perfectamente con nuestra visión.</p>
                        <div style="margin-top: 1.5rem;">
                            <strong>Juan Pérez</strong>
                            <div style="color: var(--gray);">Director de RRHH, Innovatech RD</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="col-md-6-col-lg-4-col-sm-12">
                <div class="card">
                    <div style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem; text-align: center;">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="card-body">
                        <p style="font-style: italic;">Gracias a JobConnect RD conseguí un empleo en Punta Cana que
                            combina mi pasión por el diseño y el turismo.</p>
                        <div style="margin-top: 1.5rem;">
                            <strong>Laura Sánchez</strong>
                            <div style="color: var(--gray);">Diseñadora UX/UI</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
        <div
            style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); text-align: center; padding: 3rem 1rem; border-radius: var(--radius);">
            <h2 style="margin-bottom: 1rem; font-size: 2rem;">¿Listo para impulsar tu carrera profesional?</h2>
            <p style="margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">Únete a JobConnect
                RD hoy mismo y conecta con las mejores oportunidades profesionales. Registro gratuito y fácil.</p>
            <div>
                <a href="registro.html" class="btn btn-secondary btn-lg" style="margin-right: 1rem;">Crear Cuenta
                    Candidato o Registrar empresa</a>
            </div>
        </div>
    </section>
</main>