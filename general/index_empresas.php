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
                <h2>Empresas en JobConnect RD</h2>
                <p>Encuentra las mejores empresas dominicanas que buscan talento como el tuyo. Explora sus perfiles y descubre oportunidades laborales.</p>
                <a href="#" class="btn btn-secondary btn-lg">Publicar Oferta</a>
            </div>
        </section>

        <!-- Featured Companies Section -->
        <section class="container">
            <h2 style="margin-bottom: 1.5rem;">Empresas Destacadas</h2>
            
            <div class="row">
                <!-- Company 1 -->
                <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                    <div class="card" style="text-align: center;">
                        <h3 class="card-title">TechRD Solutions</h3>
                        <div class="card-body">
                            <p>Soluciones tecnológicas innovadoras para empresas dominicanas.</p>
                            <p><strong>Ubicación:</strong> Santo Domingo, RD</p>
                            <p><strong>Industria:</strong> Tecnología</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary btn-sm">Ver Ofertas</a>
                        </div>
                    </div>
                </div>
                
                <!-- Company 2 -->
                <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                    <div class="card" style="text-align: center;">
                        <h3 class="card-title">Innovatech RD</h3>
                        <div class="card-body">
                            <p>Agencia digital líder en desarrollo de software en Santo Domingo.</p>
                            <p><strong>Ubicación:</strong> Santiago, RD</p>
                            <p><strong>Industria:</strong> Desarrollo de Software</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary btn-sm">Ver Ofertas</a>
                        </div>
                    </div>
                </div>
                
                <!-- Company 3 -->
                <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                    <div class="card" style="text-align: center;">
                        <h3 class="card-title">CreativeTech RD</h3>
                        <div class="card-body">
                            <p>Estudio de diseño enfocado en experiencias digitales para turismo.</p>
                            <p><strong>Ubicación:</strong> Punta Cana, RD</p>
                            <p><strong>Industria:</strong> Diseño</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary btn-sm">Ver Ofertas</a>
                        </div>
                    </div>
                </div>
                
                <!-- Company 4 -->
                <div class="col-md-6 col-lg-4 col-sm-12" style="margin-bottom: 1.5rem;">
                    <div class="card" style="text-align: center;">
                        <h3 class="card-title">DataDominicana</h3>
                        <div class="card-body">
                            <p>Especialistas en análisis de datos para negocios locales.</p>
                            <p><strong>Ubicación:</strong> La Romana, RD</p>
                            <p><strong>Industria:</strong> Análisis de Datos</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary btn-sm">Ver Ofertas</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="#" class="btn btn-outline">Ver Todas las Empresas</a>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
            <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); text-align: center; padding: 3rem 1rem; border-radius: var(--radius);">
                <h2 style="margin-bottom: 1rem; font-size: 2rem;">¿Quieres encontrar talento excepcional?</h2>
                <p style="margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">Registra tu empresa en JobConnect RD y comienza a conectar con los mejores profesionales de República Dominicana.</p>
                <a href="#" class="btn btn-secondary btn-lg">Registrar Empresa</a>
            </div>
        </section>
    </main>
