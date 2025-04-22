<?php
require_once '../../bd/config.php';
require_once 'crud_ofertas.php';
session_start();

if (!isset($_SESSION['id_empresa'])) {
     $_SESSION['id_empresa'] = 2; // Simulación si no hay login aún
}

if (!isset($_GET['id_oferta'])) {
     echo "ID no proporcionado.";
     exit;
}

$id_oferta = $_GET['id_oferta'];
$id_empresa = $_SESSION['id_empresa'];

try {
     $conn = conectarBD();
     $stmt = $conn->prepare("SELECT * FROM Ofertas WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa");
     $stmt->execute([':id_oferta' => $id_oferta, ':id_empresa' => $id_empresa]);
     $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

     if (!$oferta) {
          echo "Oferta no encontrada.";
          exit;
     }
} catch (PDOException $e) {
     echo "❌ Error al obtener oferta: " . $e->getMessage();
     exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>JobConnect RD - Editar Oferta</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../../assets/style_empresas.css">
</head>

<body>
     <!-- Header -->
     <header>
          <div class="header-container">
               <div class="logo">
                    <img src="../../assets/logo.png" alt="JobConnect RD Logo">
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
                              <a href="crear_oferta.html"><i class="fas fa-search"></i> <span>Ofertas de Empleo</span></a>
                         </li>
                         <li class="menu-item">
                              <a href="../candidatos.html"><i class="fas fa-users"></i> <span>Candidatos</span></a>
                         </li>
                         <li class="menu-item">
                              <a href="../perfil_empresa.html"><i class="fas fa-building"></i> <span>Perfil de
                                        Empresa</span></a>
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
               <form action="procesar_edicion.php" method="POST" class="container mt-4">
                    <input type="hidden" name="id_oferta" value="<?= $oferta['id_oferta'] ?>">
                    <div class="form-group mb-3">
                         <label class="form-label">Título</label>
                         <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($oferta['titulo']) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                         <label class="form-label">Descripción</label>
                         <input type="text" name="descripcion" class="form-control" value="<?= htmlspecialchars($oferta['descripcion']) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                         <label class="form-label">Requisitos</label>
                         <input type="text" name="requisitos" class="form-control" value="<?= htmlspecialchars($oferta['requisitos']) ?>" required>
                    </div>
                    <input type="hidden" name="fecha_publicacion" value="<?= $oferta['fecha_publicacion'] ?>">
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
               </form>
               </main>
</body>

</html>