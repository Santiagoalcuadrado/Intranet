// ===== VARIABLES GLOBALES =====
let paginaActual = 1;
let totalPaginas = 1;
let ordenActual = 'fecha_desc'; // Valor por defecto

// ===== CARGAR DOCUMENTOS =====
document.addEventListener('DOMContentLoaded', function() {
    cargarDocumentos(1);
});

// ===== FUNCIÓN PRINCIPAL PARA CARGAR DOCUMENTOS CON ORDEN =====
function cargarDocumentos(pagina = 1) {
    paginaActual = pagina;
    
    fetch(`/modules/contexto/contexto_venezolano_ajax.php?accion=listar&pagina=${pagina}&orden=${ordenActual}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderizarTabla(data.documentos);
                renderizarPaginacion(data.total_paginas, data.pagina_actual);
            } else {
                mostrarMensaje('Error al cargar documentos', 'error');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            mostrarMensaje('Error de conexión con el servidor', 'error');
        });
}

// ===== FUNCIÓN PARA CAMBIAR EL ORDEN =====
function cambiarOrden() {
    ordenActual = document.getElementById('selectorOrden').value;
    cargarDocumentos(1); // Volver a la primera página con el nuevo orden
}

function renderizarTabla(documentos) {
    const tbody = document.getElementById('tabla-documentos');
    
    if (!documentos || documentos.length === 0) {
        tbody.innerHTML = '<td colspan="5" class="text-center">No hay leyes registradas</td>';
        return;
    }
    
    let html = '';
    documentos.forEach(doc => {
        const estadoClass = `badge-estado badge-${doc.estado}`;
        let estadoTexto = doc.estado === 'pendiente' ? 'En Revisión' : 
                         doc.estado === 'aprobado' ? 'Aprobado' : 'No Disponible';
        
        const esRechazado = (doc.estado === 'rechazado');
        
        html += `<tr>
                    <td>${escapeHtml(doc.titulo)}</td>
                    <td>${escapeHtml(doc.gaceta || '-')}</td>
                    <td>${escapeHtml(doc.descripcion || '-')}</td>
                    <td><span class="${estadoClass}">${estadoTexto}</span></td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-admin btn-ver" onclick="verDocumento(${doc.id}, '${escapeHtml(doc.titulo).replace(/'/g, "\\'")}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-admin btn-descargar" onclick="descargarDocumento(${doc.id})">
                                    <i class="fas fa-download"></i>
                                </button>`;

        if (window.rolUsuario === 'Administrador') {
            if (esRechazado) {
                // ===== DOCUMENTOS RECHAZADOS: 4 botones (Ver, Descargar, Recuperar, Ver Motivo) =====
                html += `
                                <button class="btn-admin btn-recuperar" onclick="recuperarDocumento(${doc.id})">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                            </div>
                            <div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-admin btn-info" style="background: #17a2b8; color: white;" onclick="verMotivoEliminacion(${doc.id})">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </div>`;
            } else {
                // ===== DOCUMENTOS ACTIVOS: 5 botones (Ver, Descargar, Editar, Cambiar Estado, Eliminar) =====
                html += `
                                <button class="btn-admin btn-editar" onclick="editarDocumento(${doc.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                            <div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-admin btn-estado" onclick="cambiarEstado(${doc.id})">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <button class="btn-admin btn-eliminar" onclick="eliminarDocumento(${doc.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>`;
            }
        } else {
            // Usuarios no administradores solo ven Ver y Descargar
            html += `</div>`;
        }

        html += `</div>
                </td>
            </tr>`;
    });
    
    tbody.innerHTML = html;
}

// ===== NUEVA FUNCIÓN: RECUPERAR DOCUMENTO =====
function recuperarDocumento(id) {
    if (confirm('¿Está seguro de que desea recuperar este documento? Volverá a estar en estado "En Revisión".')) {
        const formData = new FormData();
        formData.append('accion', 'recuperar');
        formData.append('id', id);
        
        fetch('/modules/contexto/contexto_venezolano_ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarMensaje(data.mensaje, 'success');
                cargarDocumentos(paginaActual);
            } else {
                mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error', 'error');
            }
        })
        .catch(error => {
            mostrarMensaje('Error de conexión', 'error');
            console.error('Error:', error);
        });
    }
}

// ===== NUEVA FUNCIÓN: VER MOTIVO DE ELIMINACIÓN CON DATOS COMPLETOS =====
function verMotivoEliminacion(id) {
    fetch(`/modules/contexto/contexto_venezolano_ajax.php?accion=obtener_motivo&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.motivo) {
                const motivo = data.motivo;
                const fechaEliminacion = new Date(motivo.fecha_eliminacion).toLocaleString('es-ES');
                const fechaCreacion = new Date(motivo.fecha_creacion).toLocaleString('es-ES');
                
                // Crear modal dinámico con más información
                const modalHtml = `
                    <div class="modal fade" id="modalMotivoEliminacion" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="border-bottom: 2px solid #dc3545;">
                                    <h5 class="modal-title" style="color: #dc3545;">
                                        <i class="fas fa-info-circle me-2"></i>Detalles del Documento Eliminado
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Información del documento -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Información del Documento</h6>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Título:</label>
                                                <p class="mb-2">${escapeHtml(motivo.titulo)}</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="fw-bold">Última Actualización / Gaceta:</label>
                                                <p class="mb-2">${escapeHtml(motivo.gaceta || 'No especificado')}</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="fw-bold">Fecha de Creación:</label>
                                                <p class="mb-2">${fechaCreacion}</p>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Resumen de Impacto Administrativo:</label>
                                                <div class="alert alert-light" style="background: #f8f9fa; border-left: 3px solid #0077B6;">
                                                    ${escapeHtml(motivo.descripcion || 'No especificado')}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Separador -->
                                    <hr class="my-3">
                                    
                                    <!-- Información de eliminación -->
                                    <div class="mb-3">
                                        <h6 class="fw-bold text-danger mb-3"><i class="fas fa-trash-alt me-2"></i>Información de Eliminación</h6>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Motivo de eliminación:</label>
                                                <div class="alert alert-secondary" style="background: #f8d7da; border-left: 3px solid #dc3545;">
                                                    ${escapeHtml(motivo.motivo_eliminacion || 'No especificado')}
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="fw-bold">Eliminado por:</label>
                                                <p>${escapeHtml(motivo.eliminado_por_nombre || 'Desconocido')}</p>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="fw-bold">Cédula:</label>
                                                <p>${escapeHtml(motivo.eliminado_por_cedula || '-')}</p>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="fw-bold">Rol:</label>
                                                <p>${escapeHtml(motivo.eliminado_por_rol || '-')}</p>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Fecha de eliminación:</label>
                                                <p>${fechaEliminacion}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remover modal existente si lo hay
                const existingModal = document.getElementById('modalMotivoEliminacion');
                if (existingModal) {
                    existingModal.remove();
                }
                
                // Agregar modal al body
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                
                // Mostrar modal
                const modalElement = document.getElementById('modalMotivoEliminacion');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
                
                // Limpiar modal al cerrar
                modalElement.addEventListener('hidden.bs.modal', function() {
                    modalElement.remove();
                });
                
            } else {
                mostrarMensaje('No se pudo obtener el motivo de eliminación', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error de conexión', 'error');
        });
}

// ===== FUNCIÓN ESCAPE HTML (ya existente pero la añadimos por si acaso) =====
function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// ===== RENDERIZAR PAGINACIÓN =====
function renderizarPaginacion(total, actual) {
    totalPaginas = total;
    const paginacion = document.getElementById('paginacion');
    let html = '';
    
    if (actual > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocumentos(${actual - 1}); return false;">Anterior</a></li>`;
    }
    
    for (let i = 1; i <= total; i++) {
        if (i === actual) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocumentos(${i}); return false;">${i}</a></li>`;
        }
    }
    
    if (actual < total) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarDocumentos(${actual + 1}); return false;">Siguiente</a></li>`;
    }
    
    paginacion.innerHTML = html;
}

// ===== SUBIR =====
function abrirModalSubir() {
    document.getElementById('formSubir').reset();
    new bootstrap.Modal(document.getElementById('modalSubir')).show();
}

// ===== SUBIR DOCUMENTO (CON VALIDACIONES) =====
function subirDocumento() {
    const titulo = document.getElementById('titulo').value.trim();
    const gaceta = document.getElementById('gaceta').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const archivo = document.getElementById('archivo').files[0];
    
    // ===== VALIDAR CAMPOS OBLIGATORIOS =====
    if (!titulo) {
        mostrarMensaje('❌ El título es obligatorio', 'error');
        return;
    }
    
    if (!gaceta) {
        mostrarMensaje('❌ La gaceta/actualización es obligatoria', 'error');
        return;
    }
    
    if (!descripcion) {
        mostrarMensaje('❌ El resumen de impacto es obligatorio', 'error');
        return;
    }
    
    if (!archivo) {
        mostrarMensaje('❌ Debe seleccionar un archivo PDF', 'error');
        return;
    }
    
    // Validar tamaño y extensión
    const tamañoMB = archivo.size / (1024 * 1024);
    if (tamañoMB > 120) {
        mostrarMensaje('❌ El archivo excede el límite de 120MB', 'error');
        return;
    }
    
    const extension = archivo.name.split('.').pop().toLowerCase();
    if (extension !== 'pdf') {
        mostrarMensaje('❌ Solo se permiten archivos PDF', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('accion', 'subir');
    formData.append('titulo', titulo);
    formData.append('gaceta', gaceta);
    formData.append('descripcion', descripcion);
    formData.append('archivo', archivo);
    
    // Mostrar indicador de carga
    const btnSubir = document.querySelector('#modalSubir .btn-primary');
    const textoOriginal = btnSubir.innerHTML;
    btnSubir.disabled = true;
    btnSubir.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Subiendo...';
    
    fetch('/modules/contexto/contexto_venezolano_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalSubir')).hide();
            mostrarMensaje(data.mensaje, 'success');
            cargarDocumentos(1);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error', 'error');
        }
    })
    .catch(error => {
        mostrarMensaje('Error de conexión', 'error');
        console.error('Error:', error);
    })
    .finally(() => {
        // Restaurar botón
        btnSubir.disabled = false;
        btnSubir.innerHTML = textoOriginal;
    });
}

// ===== EDITAR =====
function editarDocumento(id) {
    fetch(`/modules/contexto/contexto_venezolano_ajax.php?accion=obtener&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_id').value = data.documento.id;
                document.getElementById('edit_titulo').value = data.documento.titulo;
                document.getElementById('edit_gaceta').value = data.documento.gaceta || '';
                document.getElementById('edit_descripcion').value = data.documento.descripcion || '';
                new bootstrap.Modal(document.getElementById('modalEditar')).show();
            }
        })
        .catch(error => {
            mostrarMensaje('Error al cargar el documento', 'error');
            console.error('Error:', error);
        });
}

// ===== GUARDAR EDICIÓN (CON VALIDACIONES) =====
function guardarEdicion() {
    const titulo = document.getElementById('edit_titulo').value.trim();
    const gaceta = document.getElementById('edit_gaceta').value.trim();
    const descripcion = document.getElementById('edit_descripcion').value.trim();
    const id = document.getElementById('edit_id').value;
    
    // ===== VALIDAR CAMPOS OBLIGATORIOS =====
    if (!titulo) {
        mostrarMensaje('❌ El título es obligatorio', 'error');
        return;
    }
    
    if (!gaceta) {
        mostrarMensaje('❌ La gaceta/actualización es obligatoria', 'error');
        return;
    }
    
    if (!descripcion) {
        mostrarMensaje('❌ El resumen de impacto es obligatorio', 'error');
        return;
    }
    
    const data = {
        id: id,
        titulo: titulo,
        gaceta: gaceta,
        descripcion: descripcion
    };
    
    fetch('/modules/contexto/contexto_venezolano_ajax.php?accion=editar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
            mostrarMensaje(data.mensaje, 'success');
            cargarDocumentos(paginaActual);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error', 'error');
        }
    })
    .catch(error => {
        mostrarMensaje('Error de conexión', 'error');
        console.error('Error:', error);
    });
}

// ===== CAMBIAR ESTADO =====
function cambiarEstado(id) {
    document.getElementById('estado_id').value = id;
    new bootstrap.Modal(document.getElementById('modalEstado')).show();
}

function guardarEstado() {
    const id = document.getElementById('estado_id').value;
    const estado = document.getElementById('nuevo_estado').value;
    
    const formData = new FormData();
    formData.append('accion', 'cambiar_estado');
    formData.append('id', id);
    formData.append('estado', estado);
    
    fetch('/modules/contexto/contexto_venezolano_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalEstado')).hide();
            mostrarMensaje(data.mensaje, 'success');
            cargarDocumentos(paginaActual);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error', 'error');
        }
    })
    .catch(error => {
        mostrarMensaje('Error de conexión', 'error');
        console.error('Error:', error);
    });
}

// ===== ELIMINAR =====
function eliminarDocumento(id) {
    document.getElementById('eliminar_id').value = id;
    document.getElementById('motivo_eliminacion').value = '';
    new bootstrap.Modal(document.getElementById('modalEliminar')).show();
}

// ===== FUNCIÓN PARA CONTAR SOLO LETRAS (ignorar espacios y saltos) =====
function contarLetras(texto) {
    // Elimina espacios, saltos de línea, tabulaciones y cualquier whitespace
    const soloLetras = texto.replace(/\s+/g, '');
    return soloLetras.length;
}

// ===== ELIMINAR CON VALIDACIÓN DE MÍNIMO 9 LETRAS (IGNORANDO ESPACIOS) =====
function confirmarEliminar() {
    const id = document.getElementById('eliminar_id').value;
    const motivo = document.getElementById('motivo_eliminacion').value;
    
    // ===== VALIDACIÓN: ¿ESTÁ VACÍO O SOLO ESPACIOS? =====
    if (!motivo || motivo.trim() === '') {
        mostrarMensaje('❌ Debe especificar un motivo', 'error');
        return;
    }
    
    // ===== NUEVA VALIDACIÓN: CONTAR SOLO LETRAS (ignorar espacios) =====
    const letrasValidas = contarLetras(motivo);
    if (letrasValidas < 9) {
        mostrarMensaje('❌ El motivo debe tener al menos 9 letras (sin contar espacios)', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('accion', 'eliminar');
    formData.append('id', id);
    formData.append('motivo', motivo); // Enviamos el motivo original (con espacios)
    
    fetch('/modules/contexto/contexto_venezolano_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalEliminar')).hide();
            mostrarMensaje(data.mensaje, 'success');
            cargarDocumentos(paginaActual);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error', 'error');
        }
    })
    .catch(error => {
        mostrarMensaje('Error de conexión', 'error');
        console.error('Error:', error);
    });
}

// ===== CONTADOR DE LETRAS MEJORADO (solo letras, ignora espacios) =====
document.addEventListener('DOMContentLoaded', function() {
    const motivoInput = document.getElementById('motivo_eliminacion');
    if (motivoInput) {
        motivoInput.addEventListener('input', function() {
            const motivo = this.value;
            const letrasValidas = contarLetras(motivo);
            const span = document.getElementById('caracteresActuales');
            if (span) {
                span.textContent = letrasValidas;
                span.style.color = letrasValidas >= 9 ? '#28a745' : '#dc3545';
            }
        });
    }
});

// ===== VER =====
function verDocumento(id, titulo) {
    document.getElementById('ver_titulo').textContent = titulo;
    document.getElementById('visor_pdf').src = `/modules/contexto/contexto_venezolano_ajax.php?accion=ver&id=${id}`;
    new bootstrap.Modal(document.getElementById('modalVer')).show();
}

// ===== DESCARGAR =====
function descargarDocumento(id) {
    window.location.href = `/modules/contexto/contexto_venezolano_ajax.php?accion=descargar&id=${id}`;
}

// ===== MENSAJE =====
function mostrarMensaje(texto, tipo = 'success') {
    const mensajeDiv = document.getElementById('mensajeFlotante');
    const icono = tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
    mensajeDiv.innerHTML = `
        <div class="mensaje-contenido mensaje-${tipo}">
            <i class="fas ${icono} fa-2x"></i>
            <span>${texto}</span>
        </div>
    `;
    
    // Usar clases en lugar de style.display
    mensajeDiv.classList.add('mostrar');
    mensajeDiv.classList.remove('oculto');
    
    setTimeout(() => {
        mensajeDiv.classList.remove('mostrar');
        mensajeDiv.classList.add('oculto');
        
        // Limpiar contenido después de la animación
        setTimeout(() => {
            mensajeDiv.innerHTML = '';
        }, 300);
    }, 3000);
}