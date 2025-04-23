<?php
$ocultar_footer = true; // o false si lo quieres mostrar
require('../../libreria/motor.php');
require('../../libreria/plantilla.php');

plantilla::aplicar();
if (isset($ocultar_footer) && $ocultar_footer) {
     echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();

if (!isset($_GET['id_oferta'])) {
     echo "ID de oferta no proporcionado.";
     exit;
}
$id_oferta = $_GET['id_oferta'];

// Aquí asumimos que la empresa está autenticada y su ID está en la sesión
if (!isset($_SESSION['id_empresa'])) {
     $id_empresa = $_SESSION['id_empresa'] ?? 2; // Simulación para pruebas
} else {
     $id_empresa = $_SESSION['id_empresa'];
}

?>
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
                              <a href="../perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de
                                        Empresa</span></a>
                         </li>
                         <li class="menu-item" style="color: var(--danger);">
                              <a href="../../general/index_empresas.php" style="color: var(--danger);"><i
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