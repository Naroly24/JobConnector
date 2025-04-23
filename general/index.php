<?php

if (!file_exists('../libreria/bd/db_config.php')) {
    header("Location: instalador.php");
    exit;
}

require('../libreria/motor.php');
require('../libreria/plantilla.php');

plantilla::aplicar();
Plantilla::navbar();

?>

<main>
    <section class="home">
        <div class="bienvenida">
            <h1>Registro de Visitas</h1>
            <p>Bienvenido al sistema de registro de visitas. Por favor, regístrese para acceder a nuestras instalaciones.</p>
            <a href="Login_y_Registro/registro.php" class="btn btn-secondary">Registrarse</a>
            <a href="Login_y_Registro/Login.php" class="btn btn-secondary">Ingresar</a>
        </div>

    </section>
</main>