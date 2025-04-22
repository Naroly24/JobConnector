<?php
require('../../libreria/motor.php');
require('../../libreria/plantilla.php');
plantilla::aplicar();
plantilla::navbar();

// Mensajes de error o éxito
$error = isset($_GET['error']) ? $_GET['error'] : "";
$success = isset($_GET['success']) ? $_GET['success'] : "";
?>

<main>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1 class="title">Iniciar Sesión</h1>
                <p>Accede a tu cuenta para explorar oportunidades profesionales o gestionar tus vacantes</p>
            </div>

            <?php if ($error): ?>
                <p class="error-msg"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="success-msg">✅ <?= htmlspecialchars($success) ?></p>
                <p class="success-msg">Serás redirigido en <span id="countdown">5</span> segundos...</p>
                <script>
                    let segundos = 5;
                    let countdown = document.getElementById("countdown");
                    let intervalo = setInterval(() => {
                        segundos--;
                        countdown.textContent = segundos;
                        if (segundos <= 0) {
                            clearInterval(intervalo);
                            window.location.href = "registro.php";
                        }
                    }, 1000);
                </script>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="registro-form">
                <div class="tabs">
                    <div class="tab-item active" data-tab="candidato">Candidato</div>
                    <div class="tab-item" data-tab="empresa">Empresa</div>
                </div>

                <!-- Formulario Candidato -->
                <div class="tab-content active" id="candidato-tab">
                    <form id="candidato-form" action="verificar_login.php" method="POST">
                        <div class="form-group">
                            <label for="c-email" class="form-label">Correo Electrónico *</label>
                            <input type="email" id="c-email" name="correo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="c-password" class="form-label">Contraseña *</label>
                            <div class="campo-password">
                                <input type="password" id="c-password" name="contrasena" class="form-control" required>
                                <button type="button" class="toggle-password"
                                    onclick="togglePassword('c-password')">👁</button>
                            </div>
                            <small class="form-text"><a href="recuperar_contrasena.html">¿Olvidaste tu
                                    contraseña?</a></small>
                        </div>
                        <div style="margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-secondary btn-block">Iniciar Sesión</button>
                        </div>
                        <div class="form-footer">
                            ¿No tienes una cuenta? <a href="registro.php">Crear Cuenta</a>
                        </div>
                    </form>
                </div>

                <!-- Formulario Empresa -->
                <!-- Formulario Empresa -->
                <div class="tab-content" id="empresa-tab">
                    <form id="empresa-form" action="verificar_login.php" method="POST">
                        <div class="form-group">
                            <label for="e-email" class="form-label">Correo Electrónico Corporativo *</label>
                            <input type="email" id="e-email" name="correo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="e-password" class="form-label">Contraseña *</label>
                            <div class="campo-password">
                                <input type="password" id="e-password" name="contrasena" class="form-control" required>
                                <button type="button" class="toggle-password"
                                    onclick="togglePassword('e-password')">👁</button>
                            </div>
                            <small class="form-text"><a href="recuperar_contrasena.html">¿Olvidaste tu
                                    contraseña?</a></small>
                        </div>
                        <div style="margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-secondary btn-block">Iniciar Sesión</button>
                        </div>
                        <div class="form-footer">
                            ¿No tienes una cuenta? <a href="registro.php">Crear Cuenta</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript para pestañas y validaciones -->
<script>
    // Cambiar pestañas
    document.querySelectorAll('.tab-item').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(tab.dataset.tab + "-tab").classList.add('active');
        });
    });

    // Mostrar/ocultar contraseña
    function togglePassword(inputId) {
        const campo = document.getElementById(inputId);
        campo.type = campo.type === "password" ? "text" : "password";
    }

    // Validación antes de enviar (solo ejemplo con formulario de candidato)
    document.getElementById("candidato-form").addEventListener("submit", function(event) {
        const email = document.getElementById("c-email").value.trim();
        const pass = document.getElementById("c-password").value.trim();
        if (email === "" || pass === "") {
            alert("⚠️ Todos los campos son obligatorios.");
            event.preventDefault();
        }
    });

    document.getElementById("empresa-form").addEventListener("submit", function(event) {
        const email = document.getElementById("e-email").value.trim();
        const pass = document.getElementById("e-password").value.trim();
        if (email === "" || pass === "") {
            alert("⚠️ Todos los campos son obligatorios.");
            event.preventDefault();
        }
    });
</script>

<!-- Estilos adicionales para coherencia visual -->
<style>

</style>