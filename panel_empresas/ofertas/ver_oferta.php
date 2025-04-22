<?php
require_once '../../bd/conexion.php';

if (!isset($_GET['id_oferta'])) {
     echo "ID de oferta no proporcionado.";
     exit;
}
$id_oferta = $_GET['id_oferta'];
$id_empresa = $_SESSION['id_empresa'] ?? 0;

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
          <!-- Main Content -->
          <div class="main-content">
               <div class="page-title">
                    <h2>Detalles de la Oferta</h2>
               </div>

               <div class="offer-card">
                    <div class="offer-header">
                         <h3 class="offer-title"><?php echo htmlspecialchars($oferta['titulo']); ?></h3>
                         <span class="offer-date">
                              <i class="fas fa-calendar-alt"></i>
                              <?php echo date('d M Y', strtotime($oferta['fecha_publicacion'])); ?>
                         </span>
                    </div>

                    <div class="offer-body">
                         <div class="offer-description">
                              <h4>Descripción</h4>
                              <p><?php echo nl2br(htmlspecialchars($oferta['descripcion'])); ?></p>
                         </div>

                         <div class="offer-description">
                              <h4>Requisitos</h4>
                              <p><?php echo nl2br(htmlspecialchars($oferta['requisitos'])); ?></p>
                         </div>
                    </div>

                    <div class="offer-footer">
                         <a href="../empresa_panel.php" class="btn btn-outline">⬅ Volver</a>
                    </div>
               </div>
          </div>
     </div>
</body>

</html>