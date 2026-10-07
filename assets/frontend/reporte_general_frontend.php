<?php
/**
 * reporte_general_frontend.php
 * VISTA para el Reporte General del Sistema - SOLO FILTROS
 * Ubicación: /assets/frontend/reporte_general_frontend.php
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - Intranet BPEZ</title>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --navbar-height: 130px;
        }

        html, body { 
            height: 100%; 
            margin: 0; 
            overflow: auto; 
        }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            color: #333;
        }

        .main-content { 
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: calc(var(--navbar-height) + 20px) 20px 40px 20px;
        }

        .reporte-container {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 35px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 8px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            text-align: center;
        }

        .card-glass:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .title-icon {
            color: var(--bpez-azul-alegre);
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 5px;
            font-size: clamp(1.3rem, 4vw, 1.8rem);
            margin-bottom: 15px;
        }

        .descripcion-text {
            color: var(--bpez-dark-blue);
            font-size: 0.9rem;
            margin-bottom: 25px;
            opacity: 0.8;
        }

        /* FILTROS */
        .filtros-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .filtros-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filtro-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            min-width: 150px;
        }

        .filtro-group label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--bpez-dark-blue);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }

        .filtro-select {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 12px 18px;
            color: var(--bpez-dark-blue);
            font-weight: 500;
            cursor: pointer;
            font-size: 0.95rem;
            width: 100%;
        }

        .filtro-select:focus { 
            outline: none; 
            border-color: var(--bpez-azul-alegre);
            background: rgba(255, 255, 255, 0.3);
        }

        .filtro-select option { 
            background: white; 
            color: var(--bpez-dark-blue);
        }

        .btn-pdf {
            background: linear-gradient(135deg, rgba(206, 32, 41, 0.2), rgba(206, 32, 41, 0.1));
            border: 1px solid rgba(206, 32, 41, 0.4);
            color: var(--bpez-dark-blue);
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            justify-content: center;
        }

        .btn-pdf:hover { 
            background: rgba(206, 32, 41, 0.3); 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(206, 32, 41, 0.2);
        }

        .btn-pdf i { 
            font-size: 1.2rem; 
        }

        .btn-back {
            background: rgba(108, 117, 125, 0.2);
            border: 1px solid rgba(108, 117, 125, 0.3);
            color: var(--bpez-dark-blue);
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-back:hover { 
            background: rgba(108, 117, 125, 0.3); 
            transform: translateY(-2px);
        }

        .info-filtros {
            background: rgba(0, 119, 182, 0.1);
            border-left: 4px solid var(--bpez-azul-alegre);
            padding: 12px 18px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .info-filtros p {
            margin: 0;
            color: var(--bpez-dark-blue);
            font-size: 0.8rem;
        }

        .info-filtros i {
            color: var(--bpez-azul-alegre);
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .main-content { padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; }
            .card-glass { padding: 25px; }
            .filtros-row { flex-direction: column; gap: 15px; }
            .btn-pdf { width: 100%; }
        }

        @media (max-width: 576px) {
            .card-glass { padding: 20px; }
            .title-icon { font-size: 2.5rem; }
            .section-title { font-size: 1.3rem; }
        }
    </style>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<div class="main-content">
    <div class="reporte-container">
        
        <div class="card-glass">
            <div class="title-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h1 class="section-title"><?php echo $titulo_pagina; ?></h1>
            <p class="descripcion-text"><?php echo $descripcion_pagina; ?></p>
            
            <form id="formReportePDF" method="POST" action="/modules/admin/reporte_general.php" target="_blank">
                <div class="filtros-container">
                    <div class="filtros-row">
                        <div class="filtro-group">
                            <label><i class="fas fa-calendar-alt me-1"></i> Año *</label>
                            <select name="anio" id="filtroAnio" class="filtro-select" required>
                                <option value="">Seleccione año</option>
                                <?php
                                // Obtener años disponibles desde la base de datos
                                try {
                                    $stmt = $pdo->query("
                                        SELECT DISTINCT YEAR(fecha) as anio FROM logs 
                                        UNION 
                                        SELECT DISTINCT YEAR(fecha_registro) FROM usuarios
                                        UNION 
                                        SELECT DISTINCT YEAR(fecha_creacion) FROM documentos
                                        ORDER BY anio DESC
                                    ");
                                    $anos = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                    foreach ($anos as $anio): ?>
                                        <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                    <?php endforeach;
                                } catch (PDOException $e) {
                                    echo '<option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filtro-group">
                            <label><i class="fas fa-calendar-week me-1"></i> Mes</label>
                            <select name="mes" id="filtroMes" class="filtro-select">
                                <option value="">Todos los meses</option>
                                <?php
                                $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo $m; ?>"><?php echo $meses[$m]; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="filtro-group">
                            <label><i class="fas fa-calendar-day me-1"></i> Día</label>
                            <select name="dia" id="filtroDia" class="filtro-select">
                                <option value="">Todos los días</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                    <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" name="generar_pdf" value="1" class="btn-pdf" id="btnGenerarPDF">
                        <i class="fas fa-file-pdf"></i> GENERAR REPORTE PDF
                    </button>
                </div>
            </form>
            
            <div class="info-filtros">
                <p><i class="fas fa-info-circle"></i> Seleccione el año, mes y/o día para filtrar la información. Al hacer clic en "GENERAR REPORTE PDF" se descargará un documento con todos los datos del sistema correspondientes al período seleccionado.</p>
            </div>
            
            <div class="mt-3">
                <a href="/modules/admin/reportes.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Volver a Reportes
                </a>
            </div>
        </div>
        
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>

<script>
document.getElementById('btnGenerarPDF').addEventListener('click', function(e) {
    const anio = document.getElementById('filtroAnio').value;
    const mes = document.getElementById('filtroMes').value;
    const dia = document.getElementById('filtroDia').value;
    
    // Si seleccionó mes o día pero no año, mostrar advertencia
    if ((mes || dia) && !anio) {
        e.preventDefault();
        alert('⚠️ ATENCIÓN: Para filtrar por mes o día, debe seleccionar un año.\n\nSe utilizará el año actual (' + new Date().getFullYear() + ') para generar el reporte.');
        // Permitir continuar con el año actual
        document.getElementById('filtroAnio').value = new Date().getFullYear();
        setTimeout(() => {
            document.getElementById('formReportePDF').submit();
        }, 100);
        return false;
    }
    
    return true;
});
</script>

</body>
</html>