<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?php echo $titulo_pagina; ?> - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE LOCALES ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --navbar-height: 130px;
            --footer-bg: #1a2a3a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body { 
            height: 100%; 
            margin: 0;
            overflow-x: hidden;
        }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #1e2e3e;
            min-height: 100vh;
        }

        .main-content { 
            flex: 1 0 auto;
            padding: calc(var(--navbar-height) + 20px) 20px 40px 20px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: calc(var(--navbar-height) + 10px) 15px 30px 15px;
            }
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .admin-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-left: 6px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            border-bottom: 3px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 4px;
            font-size: clamp(1rem, 4vw, 1.5rem);
        }

        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.85rem, 2.5vw, 1rem);
            line-height: 1.5;
            text-align: center;
            max-width: 750px;
            margin: 12px auto 0;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: 60px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 10px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 24px 18px;
            text-align: center;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-left: 4px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            color: var(--bpez-dark-blue);
            cursor: pointer;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-left-color: var(--bpez-rojo-fuego);
            background: rgba(255, 255, 255, 0.35);
        }

        .feature-card i {
            font-size: 2.8rem;
            color: var(--bpez-azul-alegre);
        }

        .feature-card:hover i {
            transform: scale(1.08);
            color: var(--bpez-rojo-fuego);
        }

        .feature-card h3 {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .feature-card p {
            font-size: 0.85rem;
            margin: 0;
            opacity: 0.9;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 18px;
            margin: 12px 0 8px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 16px 12px;
            text-align: center;
            border-left: 3px solid var(--bpez-azul-alegre);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.3);
        }

        .stat-icon { font-size: 1.8rem; color: var(--bpez-azul-alegre); margin-bottom: 8px; }
        .stat-valor { font-size: 1.8rem; font-weight: 800; color: var(--bpez-dark-blue); line-height: 1.2; margin-bottom: 6px; }
        .stat-label { font-size: 0.75rem; font-weight: 600; color: #1e4663; text-transform: uppercase; letter-spacing: 0.4px; }

        .stat-card.audit {
            border-left-color: var(--bpez-rojo-fuego);
            background: rgba(206, 32, 41, 0.08);
        }
        .stat-card.audit .stat-icon { color: var(--bpez-rojo-fuego); }

        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-custom {
            width: 100%;
            background: rgba(255,255,240,0.1);
            border-radius: 20px;
            backdrop-filter: blur(4px);
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-custom th, .table-custom td {
            padding: 12px 15px;
            color: #003366;
            border-bottom: 1px solid rgba(0,119,182,0.2);
        }
        
        .table-custom th {
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            background: rgba(0, 119, 182, 0.1);
        }
        
        .table-custom tr:hover {
            background: rgba(118, 199, 192, 0.1);
        }
        
        .badge-ranking {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        .badge-vip { background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; }
        .badge-activo { background: linear-gradient(135deg, #76C7C0, #0077B6); color: white; }
        .badge-regular { background: #6c757d; color: white; }

        footer {
            flex-shrink: 0;
            background: var(--footer-bg);
            color: #f0f0f0;
            text-align: center;
            padding: 20px 16px;
            margin-top: auto;
            width: 100%;
            border-top: 3px solid var(--bpez-cian);
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 32px;
        }
        
        .form-control {
            background: #f8f9fc;
            border: 1px solid rgba(0,51,102,0.2);
            border-radius: 60px;
            padding: 10px 18px;
        }
        
        .btn-backup, .btn-restore {
            background: linear-gradient(95deg, rgba(0,119,182,0.1), rgba(0,119,182,0.05));
            border: 1px solid #0077B6;
            color: #003366;
            font-weight: 600;
            border-radius: 60px;
            transition: 0.2s;
            padding: 10px 20px;
        }
        
        .btn-restore {
            border-color: #CE2029;
            background: rgba(206,32,41,0.08);
            color: #8b1a1a;
        }

        @media (max-width: 992px) {
            .features-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .features-grid { grid-template-columns: 1fr; }
            .feature-card { flex-direction: row; text-align: left; padding: 18px; gap: 16px; }
            .feature-card i { font-size: 2.2rem; }
            .feature-card .btn-info-text { margin-left: auto; }
        }

        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .stat-valor { font-size: 1.4rem; }
        }
        
        .progress-bar { background-color: var(--bpez-azul-alegre); border-radius: 20px; }
        .text-center { text-align: center; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .me-2 { margin-right: 0.5rem; }
        .fw-bold { font-weight: 700; }
        .small { font-size: 0.875rem; }
        .text-muted { color: #6c757d; }
        .bg-light { background-color: rgba(248, 249, 250, 0.9); }
        .w-100 { width: 100%; }
        .d-grid { display: grid; }
        .gap-3 { gap: 1rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    </style>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<div class="main-content">
    <div class="admin-container">
        
        <!-- CARD PRINCIPAL -->
        <div class="admin-card">
            <div class="text-center mb-2">
                <i class="fas fa-cog" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">Panel Administrativo</h2>
            </div>
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                Módulo exclusivo para administradores. Gestión y control del sistema.
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="admin-card">
            <h3 class="section-title" style="font-size: 1rem;">Acciones Rápidas</h3>
            <div class="features-grid">
                <div class="feature-card" onclick="window.location.href='/modules/admin/crud_admin.php'">
                    <i class="fas fa-users-cog"></i>
                    <h3>Gestión de Usuarios</h3>
                    <p>Crear, editar y desactivar usuarios.</p>
                    <span class="btn-info-text"><i class="fas fa-arrow-right"></i> Administrar</span>
                </div>
                <div class="feature-card" onclick="window.location.href='/modules/admin/reportes.php'">
                    <i class="fas fa-file-alt"></i>
                    <h3>Reportes del Sistema</h3>
                    <p>Reporte general, específico y detallado.</p>
                    <span class="btn-info-text"><i class="fas fa-arrow-right"></i> Generar</span>
                </div>
                <div class="feature-card" onclick="abrirModalBackup()">
                    <i class="fas fa-database"></i>
                    <h3>Exportar/Importar BD</h3>
                    <p>Copia de seguridad completa y restauración.</p>
                    <span class="btn-info-text"><i class="fas fa-arrow-right"></i> Gestionar</span>
                </div>
            </div>
        </div>

        <!-- ESTADÍSTICAS DEL SISTEMA -->
        <div class="admin-card">
            <h3 class="section-title"><i class="fas fa-chart-line me-2"></i>Estadísticas del Sistema</h3>
            
            <!-- USUARIOS -->
            <h4 class="mt-3 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-users me-2"></i>Usuarios
            </h4>
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-users"></i></div><div class="stat-valor"><?php echo $stats['total_usuarios'] ?? 0; ?></div><div class="stat-label">Total Usuarios</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-user-check"></i></div><div class="stat-valor"><?php echo $stats['usuarios_activos'] ?? 0; ?></div><div class="stat-label">Activos</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-user-slash"></i></div><div class="stat-valor"><?php echo $stats['usuarios_inactivos'] ?? 0; ?></div><div class="stat-label">Inactivos</div></div>
                <div class="stat-card audit"><div class="stat-icon"><i class="fas fa-ban"></i></div><div class="stat-valor"><?php echo $stats['usuarios_suspendidos'] ?? 0; ?></div><div class="stat-label">Suspendidos</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-crown"></i></div><div class="stat-valor"><?php echo $stats['total_administradores'] ?? 0; ?></div><div class="stat-label">Administradores</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-user"></i></div><div class="stat-valor"><?php echo $stats['usuarios_regulares'] ?? 0; ?></div><div class="stat-label">Regulares</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-week"></i></div><div class="stat-valor"><?php echo $stats['nuevos_7_dias'] ?? 0; ?></div><div class="stat-label">Nuevos (7d)</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-alt"></i></div><div class="stat-valor"><?php echo $stats['nuevos_30_dias'] ?? 0; ?></div><div class="stat-label">Nuevos (30d)</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-clock"></i></div><div class="stat-valor"><?php echo $stats['activos_hoy'] ?? 0; ?></div><div class="stat-label">Activos Hoy</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-week"></i></div><div class="stat-valor"><?php echo $stats['activos_semana'] ?? 0; ?></div><div class="stat-label">Activos (7d)</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-alt"></i></div><div class="stat-valor"><?php echo $stats['activos_mes'] ?? 0; ?></div><div class="stat-label">Activos (30d)</div></div>
            </div>
            
            <!-- DOCUMENTOS -->
            <h4 class="mt-4 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-file-alt me-2"></i>Documentos
            </h4>
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-file"></i></div><div class="stat-valor"><?php echo $stats['total_documentos'] ?? 0; ?></div><div class="stat-label">Total Documentos</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-alt"></i></div><div class="stat-valor"><?php echo $stats['documentos_ultimo_mes'] ?? 0; ?></div><div class="stat-label">Subidos (30d)</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-day"></i></div><div class="stat-valor"><?php echo $stats['documentos_hoy'] ?? 0; ?></div><div class="stat-label">Subidos Hoy</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-hdd"></i></div><div class="stat-valor"><?php echo number_format(($stats['tamano_uploads'] ?? 0) / 1024 / 1024, 2); ?> MB</div><div class="stat-label">Espacio Uploads</div></div>
            </div>
            
            <!-- ACTIVIDAD -->
            <h4 class="mt-4 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-chart-simple me-2"></i>Actividad del Sistema
            </h4>
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-history"></i></div><div class="stat-valor"><?php echo number_format($stats['total_logs'] ?? 0); ?></div><div class="stat-label">Total Acciones</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-day"></i></div><div class="stat-valor"><?php echo $stats['logs_hoy'] ?? 0; ?></div><div class="stat-label">Acciones Hoy</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-week"></i></div><div class="stat-valor"><?php echo $stats['logs_semana'] ?? 0; ?></div><div class="stat-label">Acciones (7d)</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-alt"></i></div><div class="stat-valor"><?php echo $stats['logs_mes'] ?? 0; ?></div><div class="stat-label">Acciones (30d)</div></div>
            </div>
            
            <!-- SEGURIDAD -->
            <h4 class="mt-4 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-shield-alt me-2"></i>Seguridad
            </h4>
            <div class="stats-grid">
                <div class="stat-card audit"><div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="stat-valor"><?php echo $stats['intentos_fallidos_totales'] ?? 0; ?></div><div class="stat-label">Intentos Fallidos Totales</div></div>
                <div class="stat-card audit"><div class="stat-icon"><i class="fas fa-exclamation-circle"></i></div><div class="stat-valor"><?php echo $stats['intentos_fallidos_semana'] ?? 0; ?></div><div class="stat-label">Intentos Fallidos (7d)</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-key"></i></div><div class="stat-valor"><?php echo $stats['intentos_recuperacion_totales'] ?? 0; ?></div><div class="stat-label">Intentos Recuperación</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-check-circle"></i></div><div class="stat-valor"><?php echo $stats['recuperaciones_exitosas'] ?? 0; ?></div><div class="stat-label">Recuperaciones Exitosas</div></div>
            </div>
            
            <!-- FECHAS IMPORTANTES -->
            <h4 class="mt-4 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-calendar-alt me-2"></i>Fechas Importantes
            </h4>
            <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-user-plus"></i></div><div class="stat-valor" style="font-size: 1rem;"><?php echo date('d/m/Y', strtotime($stats['primer_usuario'] ?? 'now')); ?></div><div class="stat-label">Primer Usuario</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-user-check"></i></div><div class="stat-valor" style="font-size: 1rem;"><?php echo date('d/m/Y', strtotime($stats['ultimo_usuario'] ?? 'now')); ?></div><div class="stat-label">Último Usuario</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-file-upload"></i></div><div class="stat-valor" style="font-size: 1rem;"><?php echo date('d/m/Y', strtotime($stats['primer_documento'] ?? 'now')); ?></div><div class="stat-label">Primer Documento</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-file-upload"></i></div><div class="stat-valor" style="font-size: 1rem;"><?php echo date('d/m/Y', strtotime($stats['ultimo_documento'] ?? 'now')); ?></div><div class="stat-label">Último Documento</div></div>
                <div class="stat-card audit"><div class="stat-icon"><i class="fas fa-database"></i></div><div class="stat-valor" style="font-size: 0.9rem;"><?php echo date('d/m/Y H:i', strtotime($stats['ultimo_backup'] ?? 'now')); ?></div><div class="stat-label">Último Backup</div></div>
            </div>

            <!-- ===== TOP 10 USUARIOS MÁS ACTIVOS ===== -->
            <h4 class="mt-4 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-trophy me-2"></i>Top 10 Usuarios Más Activos
            </h4>
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr><th style="width: 60px;">#</th><th>Usuario</th><th>Cédula</th><th>Acciones</th><th>Nivel</th></tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stats['usuarios_mas_activos'])): ?>
                            <?php $posicion = 1; ?>
                            <?php foreach ($stats['usuarios_mas_activos'] as $usuario): ?>
                                <tr>
                                    <td><?php if ($posicion == 1): ?>🥇<?php elseif ($posicion == 2): ?>🥈<?php elseif ($posicion == 3): ?>🥉<?php else: echo $posicion; endif; ?></td>
                                    <td><strong><?php echo htmlspecialchars($usuario['usuario_nombre']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($usuario['usuario_cedula']); ?></td>
                                    <td><span class="badge-ranking" style="background: var(--bpez-azul-alegre); color: white;"><?php echo number_format($usuario['acciones']); ?></span></td>
                                    <td><?php if ($usuario['acciones'] > 5000): ?><span class="badge-ranking badge-vip">VIP</span><?php elseif ($usuario['acciones'] > 1000): ?><span class="badge-ranking badge-activo">Activo</span><?php else: ?><span class="badge-ranking badge-regular">Regular</span><?php endif; ?></td>
                                </tr>
                                <?php $posicion++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No hay datos de actividad registrados</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- ===== TOP 10 USUARIOS CON MÁS DOCUMENTOS ===== -->
            <h4 class="mt-4 mb-2" style="color: var(--bpez-dark-blue); font-size: 0.9rem; border-left: 3px solid var(--bpez-azul-alegre); padding-left: 10px;">
                <i class="fas fa-file-upload me-2"></i>Top 10 Colaboradores (Más Documentos)
            </h4>
            <div class="table-responsive-custom">
                <table class="table-custom">
                    <thead>
                        <tr><th style="width: 60px;">#</th><th>Usuario</th><th>Cédula</th><th>Documentos</th><th>Último Documento</th></tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stats['usuarios_mas_documentos'])): ?>
                            <?php $posicion = 1; ?>
                            <?php foreach ($stats['usuarios_mas_documentos'] as $usuario): ?>
                                <tr>
                                    <td><?php if ($posicion == 1): ?>📚<?php elseif ($posicion == 2): ?>📖<?php elseif ($posicion == 3): ?>📑<?php else: echo $posicion; endif; ?></td>
                                    <td><strong><?php echo htmlspecialchars($usuario['usuario_nombre']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($usuario['usuario_cedula']); ?></td>
                                    <td><span class="badge-ranking" style="background: var(--bpez-azul-alegre); color: white;"><?php echo $usuario['total_documentos']; ?></span></td>
                                    <td><?php echo date('d/m/Y', strtotime($usuario['ultimo_documento'])); ?></td>
                                </tr>
                                <?php $posicion++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No hay documentos subidos</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODALES BACKUP -->
<div class="modal fade" id="modalBackup" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="fas fa-database me-2"></i>Gestión de Backups</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-shield-alt fa-3x" style="color: var(--bpez-azul-alegre);"></i>
                    <p class="mt-2">Realice copias de seguridad completas o restaure desde un backup</p>
                </div>
                <div class="d-grid gap-3">
                    <button type="button" class="btn-backup py-2" onclick="abrirModalExportar()"><i class="fas fa-download me-2"></i> Exportar Backup Completo</button>
                    <button type="button" class="btn-restore py-2" onclick="abrirModalImportar()"><i class="fas fa-upload me-2"></i> Importar Backup Completo</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalExportar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="fas fa-download me-2"></i>Exportar Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formExportar" action="/modules/admin/backup_export.php" method="POST" target="_blank">
                    <div class="mb-3">
                        <label class="form-label">Motivo * (mínimo 9 letras)</label>
                        <textarea class="form-control" id="motivo_exportacion" name="motivo" rows="3" required></textarea>
                        <div class="text-counter mt-1">Letras válidas: <span id="caracteresExportar">0</span>/9</div>
                    </div>
                    <button type="submit" class="btn-backup w-100 py-2" id="btnExportarConfirmar" disabled><i class="fas fa-check-circle me-2"></i> Generar Backup</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImportar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Importar Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning mb-3"><i class="fas fa-exclamation-triangle me-2"></i> Esta acción reemplazará TODOS los datos actuales.</div>
                <form id="formImportar" action="/modules/admin/backup_import.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Motivo *</label>
                        <textarea class="form-control" id="motivo_importacion" name="motivo" rows="3" required></textarea>
                        <div class="text-counter mt-1">Letras válidas: <span id="caracteresImportar">0</span>/9</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo ZIP</label>
                        <input type="file" name="archivo_zip" class="form-control" accept=".zip" required>
                    </div>
                    <button type="submit" class="btn-restore w-100 py-2" id="btnImportarConfirmar" disabled><i class="fas fa-check-circle me-2"></i> Restaurar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>

<script>
function contarLetras(t) { return t.replace(/\s+/g, '').length; }
function abrirModalBackup() { new bootstrap.Modal(document.getElementById('modalBackup')).show(); }
function abrirModalExportar() { bootstrap.Modal.getInstance(document.getElementById('modalBackup')).hide(); new bootstrap.Modal(document.getElementById('modalExportar')).show(); document.getElementById('formExportar').reset(); document.getElementById('caracteresExportar').textContent='0'; document.getElementById('btnExportarConfirmar').disabled=true; }
function abrirModalImportar() { bootstrap.Modal.getInstance(document.getElementById('modalBackup')).hide(); new bootstrap.Modal(document.getElementById('modalImportar')).show(); document.getElementById('formImportar').reset(); document.getElementById('caracteresImportar').textContent='0'; document.getElementById('btnImportarConfirmar').disabled=true; }

document.getElementById('motivo_exportacion')?.addEventListener('input', function() { let v=contarLetras(this.value); document.getElementById('caracteresExportar').textContent=v; document.getElementById('caracteresExportar').style.color=v>=9?'#28a745':'#dc3545'; document.getElementById('btnExportarConfirmar').disabled=v<9; });
document.getElementById('motivo_importacion')?.addEventListener('input', function() { let v=contarLetras(this.value); document.getElementById('caracteresImportar').textContent=v; document.getElementById('caracteresImportar').style.color=v>=9?'#28a745':'#dc3545'; document.getElementById('btnImportarConfirmar').disabled=v<9; });

document.getElementById('formExportar')?.addEventListener('submit', function(e) { if(contarLetras(document.getElementById('motivo_exportacion').value)<9){ e.preventDefault(); alert('El motivo debe tener al menos 9 letras'); } });
document.getElementById('formImportar')?.addEventListener('submit', function(e) { if(contarLetras(document.getElementById('motivo_importacion').value)<9){ e.preventDefault(); alert('El motivo debe tener al menos 9 letras'); } let f=document.querySelector('#formImportar input[type="file"]').files[0]; if(!f){ e.preventDefault(); alert('Seleccione un archivo ZIP'); } else if(f.size>200*1024*1024){ e.preventDefault(); alert('El archivo excede 200MB'); } else if(f.name.split('.').pop().toLowerCase()!=='zip'){ e.preventDefault(); alert('Solo archivos .zip'); } });
</script>

</body>
</html>