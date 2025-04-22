<?php
require_once '../../bd/conexion.php';
require_once 'crud_ofertas.php';
session_start();

// Simulación de sesión si no está logueado
if (!isset($_SESSION['id_empresa'])) {
     $id_empresa = $_SESSION['id_empresa'] ?? 0; // Simulación si no hay login aún
} else {
     $id_empresa = $_SESSION['id_empresa'];
}

// Verificar si se pasa el ID de la oferta
if (!isset($_GET['id_oferta'])) {
     echo "❌ ID de oferta no proporcionado.";
     exit;
}

// Obtener el ID de la oferta desde la URL o formulario
$id_oferta = $_GET['id_oferta'] ?? null;


// Obtener los datos de la oferta
$oferta = null;
if ($id_oferta) {
     $oferta = verOferta($id_oferta, $id_empresa);
     if (!$oferta) {
          echo "❌ Oferta no encontrada o no autorizada.";
          exit;
     }
}


// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $data = [
          'id_oferta' => $_POST['id_oferta'],
          'id_empresa' => $_SESSION['id_empresa'],
          'titulo' => $_POST['titulo'],
          'descripcion' => $_POST['descripcion'],
          'requisitos' => $_POST['requisitos']
     ];

     // Llamar a la función para actualizar
     if (actualizarOferta($data)) {
          echo "<script>alert('✅ Oferta actualizada con éxito'); window.location.href='../empresa_panel.php';</script>";
          exit;
     } else {
          echo "<script>alert('❌ Error al actualizar la oferta'); window.location.href='../empresa_panel.php';</script>";
          exit;
     }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>JobConnect RD - Editar Oferta</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../../Libreria/style_empresas.css">
</head>

<body>
     <!-- Header -->
     <header>
          <div class="header-container">
               <div class="logo">
                    <img src="../../Libreria/logo.png" alt="JobConnect RD Logo">
                    <h1>Job<span>Connect RD</span></h1>
               </div>
               <div class="mobile-menu-toggle" id="mobile-toggle">
                    <i class="fas fa-bars"></i>
               </div>
               <div class="user-menu">
                    <div class="user-avatar">TS</div>
                    <span class="user-name">Tech Solutions</span>
                    <div class="dropdown-toggle"><i class="fas fa-chevron-down"></i></div>
               </div>
          </div>
     </header>

     <!-- Dashboard Container -->
     <div class="dashboard-container">
          <!-- Sidebar -->
          <div class="sidebar" id="sidebar">
               <div class="sidebar-header">
                    <h3>Panel de Empresa</h3>
               </div>
               <div class="sidebar-menu">
                    <ul>
                         <li class="menu-item">
                              <a href="../empresa_panel.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                         </li>
                         <li class="menu-item">
                              <a href="crear_oferta.php"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                         </li>
                         <li class="menu-item">
                              <a href="../candidatos.php"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                         </li>
                         <li class="menu-item">
                              <a href="../perfil_empresa.html"><i class="fas fa-building"></i> <span>Perfil de Empresa</span></a>
                         </li>
                         <li class="menu-item" style="color: var(--danger);">
                              <a href="../../general/index_empresas.html" style="color: var(--danger);"><i
                                        class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar
                                        Sesión</span></a>
                         </li>
                    </ul>
               </div>
          </div>

          <!-- Main Content -->
          <div class="main-content">
               <div class="page-title">
                    <h1>Editar Oferta</h1>
               </div>
               <form action="editar_oferta.php?id_oferta=<?= $oferta['id_oferta'] ?>" method="POST" class="container mt-4">
                    <input type="hidden" name="id_oferta" value="<?= $oferta['id_oferta'] ?>">
                    <div class="form-group mb-3">
                         <label class="form-label">Título</label>
                         <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($oferta['titulo']) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                         <label class="form-label">Descripción</label>
                         <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($oferta['descripcion']) ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                         <label class="form-label">Requisitos</label>
                         <textarea name="requisitos" class="form-control" required><?= htmlspecialchars($oferta['requisitos']) ?></textarea>
                    </div>
                    <input type="hidden" name="fecha_publicacion" value="<?= $oferta['fecha_publicacion'] ?>">
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
               </form>
          </div> <!-- Cierra .main-content -->
     </div> <!-- Cierra .dashboard-container -->
</body>

</html>