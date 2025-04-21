<?php
// Verificar si existe el archivo de configuración
if (!file_exists('../../bd/config.php')) {
    header("Location: ../../bd/instalador.php");
    exit;
}

require_once('../../bd/conexion.php');
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_usuario = $_POST['tipo_usuario'];

    // Campos comunes
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    // Validaciones
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "⚠️ El correo no es válido";
    } elseif ($contrasena !== $confirmar) {
        $mensaje = "⚠️ Las contraseñas no coinciden";
    } elseif (empty($tipo_usuario)) {
        $mensaje = "⚠️ Debe seleccionar un tipo de usuario";
    } else {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        try {
            $sqlUsuarios = "INSERT INTO Usuarios (nombre, correo, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)";
            $id_usuario = conexion::insert($sqlUsuarios, [$nombre, $correo, $contrasena_hash, $tipo_usuario]);

            if ($tipo_usuario === 'candidato') {
                $telefono = $_POST['telefono'] ?? '';
                $ciudad = $_POST['ciudad'] ?? '';
                $profesion = $_POST['profesion'] ?? '';
                $sqlCandidato = "INSERT INTO Candidatos (id_usuario, telefono, ciudad, resumen_profesional) VALUES (?, ?, ?, ?)";
                conexion::ejecutar($sqlCandidato, [$id_usuario, $telefono, $ciudad, $profesion]);

            } elseif ($tipo_usuario === 'empresa') {
                $telefono = $_POST['telefono'] ?? '';
                $direccion = $_POST['direccion'] ?? '';
                $sqlEmpresa = "INSERT INTO Empresas (id_usuario, telefono, direccion) VALUES (?, ?, ?)";
                conexion::ejecutar($sqlEmpresa, [$id_usuario, $telefono, $direccion]);
            }

            header("Location: login.html");
            exit;
        } catch (Exception $e) {
            $mensaje = "❌ Error al registrar: " . $e->getMessage();
        }
    }
}
?>

<?php if (!empty($mensaje)): ?>
<div style="color: red; text-align: center; padding: 1rem;">
    <?= $mensaje ?>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const pass = form.querySelector('input[name="contrasena"]').value;
            const confirm = form.querySelector('input[name="confirmar"]').value;
            if (pass !== confirm) {
                alert('Las contraseñas no coinciden');
                e.preventDefault();
            }
        });
    });
});
</script>

<!-- FORMULARIO CANDIDATO -->
<form id="candidato-form" method="POST" action="">
    <input type="hidden" name="tipo_usuario" value="candidato">
    <input type="text" name="nombre" id="c-nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" id="c-apellido" placeholder="Apellido" required>
    <input type="email" name="correo" id="c-email" placeholder="Correo Electrónico" required>
    <input type="password" name="contrasena" id="c-password" placeholder="Contraseña" required>
    <input type="password" name="confirmar" id="c-confirm-password" placeholder="Confirmar Contraseña" required>
    <input type="text" name="telefono" id="c-telefono" placeholder="Teléfono">
    <select name="ciudad" id="c-ciudad" required>
        <option value="">Seleccionar ciudad</option>
        <option value="santo-domingo">Santo Domingo</option>
        <option value="santiago">Santiago</option>
        <option value="punta-cana">Punta Cana</option>
        <option value="puerto-plata">Puerto Plata</option>
        <option value="la-romana">La Romana</option>
        <option value="otra">Otra</option>
    </select>
    <input type="text" name="profesion" id="c-profesion" placeholder="Profesión o Título" required>
    <button type="submit">Crear Cuenta</button>
</form>

<!-- FORMULARIO EMPRESA -->
<form id="empresa-form" method="POST" action="">
    <input type="hidden" name="tipo_usuario" value="empresa">
    <input type="text" name="nombre" id="e-nombre" placeholder="Nombre Empresa" required>
    <input type="email" name="correo" id="e-email" placeholder="Correo" required>
    <input type="password" name="contrasena" id="e-password" placeholder="Contraseña" required>
    <input type="password" name="confirmar" id="e-confirm-password" placeholder="Confirmar Contraseña" required>
    <input type="text" name="telefono" id="e-telefono" placeholder="Teléfono" required>
    <input type="text" name="direccion" id="e-direccion" placeholder="Dirección" required>
    <button type="submit">Registrar Empresa</button>
</form>
