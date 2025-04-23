<?php
session_start();
$ocultar_footer = true;
require('../../libreria/motor.php');
require('../../libreria/plantilla.php');
require_once 'crud_ofertas.php';

// Check if empresa is logged in
if (!isset($_SESSION['id_empresa'])) {
     header("Location: ../../general/Login_y_Registro/login.php");
     exit();
}

// Verificar si se pasa el ID de la oferta
if (!isset($_GET['id_oferta']) || !is_numeric($_GET['id_oferta'])) {
     header("Location: ../empresa_panel.php?error=ID de oferta inválido");
     exit();
}

$id_oferta = (int)$_GET['id_oferta'];
$id_empresa = $_SESSION['id_empresa'];

// Obtener los datos de la oferta
$oferta = verOferta($id_oferta, $id_empresa);
if (!$oferta) {
     header("Location: ../empresa_panel.php?error=Oferta no encontrada o no autorizada");
     exit();
}

// Obtener los candidatos que aplicaron a la oferta
$candidatos = conexion::consulta("
    SELECT u.nombre, u.apellido, u.correo, c.profesion, c.cv_pdf, a.fecha_aplicacion,
           GROUP_CONCAT(DISTINCT fa.titulo ORDER BY fa.fecha_inicio DESC SEPARATOR '\n') AS formacion_academica,
           GROUP_CONCAT(DISTINCT el.puesto ORDER BY el.fecha_inicio DESC SEPARATOR '\n') AS experiencia_laboral,
           GROUP_CONCAT(DISTINCT h.habilidad ORDER BY h.habilidad SEPARATOR ', ') AS habilidades
    FROM Aplicaciones a
    INNER JOIN Candidatos c ON a.id_candidato = c.id_candidato
    INNER JOIN Usuarios u ON c.id_usuario = u.id_usuario
    LEFT JOIN Formaciones_Academicas fa ON c.id_candidato = fa.id_candidato
    LEFT JOIN Experiencias_Laborales el ON c.id_candidato = el.id_candidato
    LEFT JOIN Habilidades h ON c.id_candidato = h.id_candidato
    WHERE a.id_oferta = :id_oferta
    GROUP BY c.id_candidato, u.nombre, u.apellido, u.correo, c.profesion, c.cv_pdf, a.fecha_aplicacion
    ORDER BY a.fecha_aplicacion DESC
", [':id_oferta' => $id_oferta]);

plantilla::aplicar();
if ($ocultar_footer) {
     echo '<style>footer { display: none !important; }</style>';
}
plantilla::navbar();
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
                         <a href="../perfil_empresa.php"><i class="fas fa-building"></i> <span>Perfil de Empresa</span></a>
                    </li>
                    <li class="menu-item" style="color: var(--danger);">
                         <a href="../../general/Login_y_Registro/logout.php" style="color: var(--danger);"><i
                                   class="fas fa-sign-out-alt" style="color: var(--danger);"></i> <span>Cerrar Sesión</span></a>
                    </li>
               </ul>
          </div>
     </div>

     <!-- Main Content -->
     <div class="main-content">
          <div class="page-title">
               <h2>Detalles de la Oferta</h2>
          </div>

          <div class="offer-card">
               <div class="offer-header">
                    <h3 class="offer-title"><?= htmlspecialchars($oferta['titulo']) ?></h3>
                    <span class="offer-date">
                         <i class="fas fa-calendar-alt"></i>
                         <?= date('d M Y', strtotime($oferta['fecha_publicacion'])) ?>
                    </span>
               </div>

               <div class="offer-body">
                    <div class="offer-description">
                         <h4>Descripción</h4>
                         <p><?= nl2br(htmlspecialchars($oferta['descripcion'])) ?></p>
                    </div>

                    <div class="offer-description">
                         <h4>Requisitos</h4>
                         <p><?= nl2br(htmlspecialchars($oferta['requisitos'])) ?></p>
                    </div>

                    <!-- Lista de Candidatos -->
                    <div class="candidates-section mt-4">
                         <h4>Candidatos que Aplicaron (<?= count($candidatos) ?>)</h4>
                         <?php if (empty($candidatos)): ?>
                              <p>No hay candidatos que hayan aplicado a esta oferta.</p>
                         <?php else: ?>
                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th>Nombre</th>
                                             <th>Correo</th>
                                             <th>Profesión</th>
                                             <th>Fecha de Aplicación</th>
                                             <th>CV PDF</th>
                                             <th>CV Digital</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php foreach ($candidatos as $candidato): ?>
                                             <tr>
                                                  <td><?= htmlspecialchars($candidato['nombre'] . ' ' . $candidato['apellido']) ?></td>
                                                  <td><?= htmlspecialchars($candidato['correo']) ?></td>
                                                  <td><?= htmlspecialchars($candidato['profesion'] ?: 'N/A') ?></td>
                                                  <td>
                                                       <?php if ($candidato['cv_pdf']): ?>
                                                            <a href="/uploads/cvs/<?= htmlspecialchars(basename($candidato['cv_pdf'])) ?>"
                                                                 class="btn btn-sm btn-primary" target="_blank">Descargar PDF</a>
                                                       <?php else: ?>
                                                            No disponible
                                                       <?php endif; ?>
                                                  </td>
                                                  <td>
                                                       <?php if ($candidato['formacion_academica'] || $candidato['experiencia_laboral'] || $candidato['habilidades']): ?>
                                                            <div class="cv-digital">
                                                                 <?php if ($candidato['formacion_academica']): ?>
                                                                      <h6>Formación Académica</h6>
                                                                      <p><?= nl2br(htmlspecialchars($candidato['formacion_academica'])) ?></p>
                                                                 <?php endif; ?>
                                                                 <?php if ($candidato['experiencia_laboral']): ?>
                                                                      <h6>Experiencia Laboral</h6>
                                                                      <p><?= nl2br(htmlspecialchars($candidato['experiencia_laboral'])) ?></p>
                                                                 <?php endif; ?>
                                                                 <?php if ($candidato['habilidades']): ?>
                                                                      <h6>Habilidades</h6>
                                                                      <p><?= nl2br(htmlspecialchars($candidato['habilidades'])) ?></p>
                                                                 <?php endif; ?>
                                                            </div>
                                                       <?php else: ?>
                                                            No disponible
                                                       <?php endif; ?>
                                                  </td>
                                             </tr>
                                        <?php endforeach; ?>
                                   </tbody>
                              </table>
                         <?php endif; ?>
                    </div>
               </div>

               <div class="offer-footer">
                    <a href="../empresa_panel.php" class="btn btn-outline">⬅ Volver</a>
               </div>
          </div>
     </div>
</div>