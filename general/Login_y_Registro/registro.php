<?php

if (!file_exists('../../libreria/bd/db_config.php')) {
    header("Location: ../../libreria/bd/instalador.php");
    exit;
}

ob_start();

require('../../libreria/bd/conexion.php');
require('../../libreria/plantilla.php');

plantilla::aplicar();
plantilla::navbar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre = $_POST['nombre'];
    $apellido = ($tipo_usuario === 'candidato') ? $_POST['apellido'] : '-';
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    if ($tipo_usuario === 'candidato') {
        $contrasena = $_POST['contrasena'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';
    } else {
        $contrasena = $_POST['contrasena_empresa'] ?? '';
        $confirmar = $_POST['confirmar_empresa'] ?? '';
    }

    if (!str_contains($correo, '@')) {
        echo "<script>alert('⚠️ El correo debe contener @');</script>";
    } elseif ($contrasena !== $confirmar) {
        echo "<script>alert('⚠️ Las contraseñas no coinciden');</script>";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $contrasena)) {
        echo "<script>alert('⚠️ La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número');</script>";
    } else {
        try {
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            $sql_usuario = "INSERT INTO Usuarios (nombre, apellido, correo, contrasena, fecha, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)";
            $parametros_usuario = [$nombre, $apellido, $correo, $contrasena_hash, $fecha, $tipo_usuario];
            $id_usuario = Conexion::insert($sql_usuario, $parametros_usuario);

            if ($tipo_usuario === 'candidato') {
                $telefono = $_POST['telefono'];
                $ciudad = $_POST['ciudad'];
                $profesion = $_POST['profesion'];

                $sql_candidato = "INSERT INTO Candidatos (id_usuario, telefono, ciudad, profesion, resumen_profesional, disponibilidad, redes_profesionales, cv_pdf, foto, direccion)
                                  VALUES (?, ?, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL)";
                $params_candidato = [$id_usuario, $telefono, $ciudad, $profesion];
                Conexion::insert($sql_candidato, $params_candidato);
            } elseif ($tipo_usuario === 'empresa') {
                $rnc = $_POST['rnc'];
                $sector = $_POST['sector'];
                $direccion = $_POST['direccion'];
                $ciudad_empresa = $_POST['ciudad_empresa'];
                $telefono_empresa = $_POST['telefono_empresa'];
                $correo_corporativo = $_POST['correo_corporativo'];
                $sitio_web = $_POST['sitio_web'];
                $descripcion = $_POST['descripcion'];

                $sql_empresa = "INSERT INTO Empresas (id_usuario, rnc, sector, direccion, ciudad, telefono, correo_corporativo, sitio_web, descripcion)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $params_empresa = [$id_usuario, $rnc, $sector, $direccion, $ciudad_empresa, $telefono_empresa, $correo_corporativo, $sitio_web, $descripcion];
                Conexion::insert($sql_empresa, $params_empresa);
            }

            ob_end_clean();
            header("Location: Login.php");
            exit;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error al registrar: {$e->getMessage()}</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="registro-container">
                <div class="registro-header">
                    <h1 class="title" id="tituloRegistro">Registro de Usuario</h1>
                    <p>Complete sus datos para crear una cuenta.</p>
                </div>
                <div class="registro-form">
                    <div class="tabs">
                        <div class="tab-item active" data-tab="candidato">Candidato</div>
                        <div class="tab-item" data-tab="empresa">Empresa</div>
                    </div>

                    <!-- Candidato -->
                    <div class="tab-content active" id="candidato-tab">
                        <div id="alerta_candidato" class="alerta"></div>
                        <form id="candidato-form" method="POST">
                            <input type="hidden" name="tipo_usuario" value="candidato">
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="nombre">Nombre *</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="apellido">Apellido *</label>
                                        <input type="text" name="apellido" id="apellido" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico *</label>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group password-toggle">
                                        <label for="contrasena_candidato">Contraseña *</label>
                                        <div class="campo-password">
                                            <input type="password" name="contrasena" id="e-password"
                                                class="form-control" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                                                title="Debe tener al menos 8 caracteres, incluyendo una letra y un número"
                                                required>
                                            <button type="button" class="toggle-password"
                                                onclick="togglePassword('e-password')">👁</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-col">
                                    <div class="form-group password-toggle">
                                        <label for="confirmar_contrasena">Confirmar Contraseña *</label>
                                        <div class="campo-password">
                                            <input type="password" name="confirmar" id="confirmar-password"
                                                class="form-control" required placeholder="Repite la contraseña">
                                            <button type="button" class="toggle-password"
                                                onclick="togglePassword('confirmar-password')">👁</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="ciudad">Ciudad *</label>
                                <input type="text" name="ciudad" id="ciudad" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="profesion">Profesión o Título *</label>
                                <input type="text" name="profesion" id="profesion" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha de Nacimiento *</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>
                            <div style="margin-top: 1.5rem;">
                                <button type="submit" class="btn btn-secondary btn-block">Crear Cuenta</button>
                            </div>
                        </form>
                    </div>

                    <!-- Empresa -->
                    <div class="tab-content" id="empresa-tab">
                        <form id="empresa-form" method="POST">
                            <input type="hidden" name="tipo_usuario" value="empresa">
                            <div class="form-group">
                                <label for="nombre">Nombre de la Empresa *</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico de Inicio de Sesión *</label>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group password-toggle">
                                        <label for="contrasena_empresa">Contraseña *</label>
                                        <div class="campo-password">
                                            <input type="password" name="contrasena_empresa" id="contrasena_empresa"
                                                class="form-control" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                                                title="Debe tener al menos 8 caracteres, incluyendo una letra y un número"
                                                required>
                                            <button type="button" class="toggle-password"
                                                onclick="togglePassword('contrasena_empresa')">👁</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-col">
                                    <div class="form-group password-toggle">
                                        <label for="confirmar_empresa">Confirmar Contraseña *</label>
                                        <div class="campo-password">
                                            <input type="password" name="confirmar_empresa" id="confirmar_empresa"
                                                class="form-control" required placeholder="Repite la contraseña">

                                            <button type="button" class="toggle-password"
                                                onclick="togglePassword('confirmar_empresa')">👁</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rnc">RNC *</label>
                                <input type="text" name="rnc" id="rnc" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="sector">Sector *</label>
                                <input type="text" name="sector" id="sector" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección *</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="ciudad_empresa">Ciudad *</label>
                                <input type="text" name="ciudad_empresa" id="ciudad_empresa" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="telefono_empresa">Teléfono *</label>
                                <input type="text" name="telefono_empresa" id="telefono_empresa" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="correo_corporativo">Correo Electrónico Corporativo *</label>
                                <input type="email" name="correo_corporativo" id="correo_corporativo"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="sitio_web">Sitio Web</label>
                                <input type="text" name="sitio_web" id="sitio_web" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción de la Empresa *</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="4"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha de Fundación *</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>
                            <div style="margin-top: 1.5rem;">
                                <button type="submit" class="btn btn-secondary btn-block">Registrar Empresa</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </main>

    <script>
        const tituloRegistro = document.getElementById('tituloRegistro');

        function actualizarTitulo(tabActivo) {
            const tipo = tabActivo.dataset.tab;
            tituloRegistro.textContent = tipo === 'empresa' ? 'Registro de Empresa' : 'Registro de Candidato';
        }

        // Establecer título inicial según el tab activo
        const tabInicial = document.querySelector('.tab-item.active');
        if (tabInicial) {
            actualizarTitulo(tabInicial);
        }

        // Mostrar/ocultar contraseña
        function togglePassword(inputId) {
            const campo = document.getElementById(inputId);
            campo.type = campo.type === "password" ? "text" : "password";
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Función para alternar la visibilidad de contraseñas
            function togglePasswordVisibility(button) {
                const input = button.previousElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    button.textContent = "👁";
                } else {
                    input.type = "password";
                    button.textContent = "👁";
                }
            }

            // Asignar toggle a todos los botones 👁
            document.querySelectorAll('.toggle-btn').forEach(button => {
                button.addEventListener('click', () => togglePasswordVisibility(button));
            });

            // Lógica de tabs (Candidato / Empresa)
            const tabItems = document.querySelectorAll('.tab-item');
            const tabContents = document.querySelectorAll('.tab-content');

            tabItems.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabItems.forEach(i => i.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    tab.classList.add('active');
                    const target = document.getElementById(tab.dataset.tab + '-tab');
                    target.classList.add('active');

                    // Actualizar el título dinámicamente
                    actualizarTitulo(tab);
                });
            });


            // Validación de contraseñas coincidentes
            function aplicarValidacionContraseñas(form) {
                const pass = form.querySelector('input[name="contrasena"]');
                const confirm = form.querySelector('input[name="confirmar"]');
                if (!pass || !confirm) return;

                function validarCoincidencia() {
                    if (pass.value !== confirm.value) {
                        confirm.setCustomValidity("Las contraseñas no coinciden");
                    } else {
                        confirm.setCustomValidity("");
                    }
                }

                pass.addEventListener("input", validarCoincidencia);
                confirm.addEventListener("input", validarCoincidencia);
            }

            // Validaciones de campos clave
            function validarFormulario(form) {
                const tipo = form.querySelector('input[name="tipo_usuario"]').value;
                const correo = form.querySelector('input[name="correo"]').value;
                const contrasena = form.querySelector('input[name="contrasena"]').value;
                const confirmar = form.querySelector('input[name="confirmar"]').value;
                const alerta = document.getElementById(tipo === 'empresa' ? 'alerta_empresa' : 'alerta_candidato');

                alerta.textContent = "";

                if (!correo.includes("@")) {
                    alerta.textContent = "⚠️ El correo debe contener un @";
                    return false;
                }

                if (contrasena !== confirmar) {
                    alerta.textContent = "⚠️ Las contraseñas no coinciden";
                    return false;
                }

                const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
                if (!regex.test(contrasena)) {
                    alerta.textContent = "⚠️ La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número";
                    return false;
                }

                return true;
            }

            const candidatoForm = document.getElementById('candidato-form');
            const empresaForm = document.getElementById('empresa-form');

            aplicarValidacionContraseñas(candidatoForm);
            aplicarValidacionContraseñas(empresaForm);

            candidatoForm.addEventListener('submit', function (e) {
                if (!validarFormulario(this)) e.preventDefault();
            });

            empresaForm.addEventListener('submit', function (e) {
                if (!validarFormulario(this)) e.preventDefault();
            });
        });
    </script>

</body>

</html>