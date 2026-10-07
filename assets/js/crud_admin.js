// ===== VARIABLES GLOBALES =====
let paginaActual = 1;
let totalPaginas = 1;
let modalInstance = null;
let usuarioEditando = null;
let preguntasDisponibles = [];
let editandoUsuario = false; // Nuevo: para saber si estamos en modo edición

// ===== AGREGAR EVENT LISTENER PARA EL CHECKBOX =====
document.addEventListener('DOMContentLoaded', function() {
    cargarUsuarios();
    cargarPreguntasSeguridad();
    
    const modalElement = document.getElementById('usuarioModal');
    if (modalElement) {
        modalInstance = new bootstrap.Modal(modalElement);
    }
    
    // Configurar validación de fechas en tiempo real
    document.getElementById('fecha_ingreso').addEventListener('change', validarFechas);
    document.getElementById('fecha_egreso').addEventListener('change', validarFechas);
    
    // Event listener para el checkbox de preguntas
    const checkbox = document.getElementById('editarPreguntasCheckbox');
    if (checkbox) {
        checkbox.addEventListener('change', function() {
            togglePreguntasEdit(this.checked);
        });
    }
});

// ===== VALIDAR FECHAS =====
function validarFechas() {
    const fechaIngreso = document.getElementById('fecha_ingreso').value;
    const fechaEgreso = document.getElementById('fecha_egreso').value;
    const estado = document.getElementById('estado').value;
    
    // Validar que fecha ingreso no sea futura
    const hoy = new Date().toISOString().split('T')[0];
    if (fechaIngreso > hoy) {
        mostrarMensaje('La fecha de ingreso no puede ser futura', 'error');
        return false;
    }
    
    // Si hay fecha de egreso, validar que sea >= fecha ingreso
    if (fechaEgreso) {
        if (fechaEgreso < fechaIngreso) {
            mostrarMensaje('La fecha de egreso no puede ser anterior a la fecha de ingreso', 'error');
            return false;
        }
        
        // Si el estado no es inactivo, advertir
        if (estado !== 'Inactivo') {
            if (!confirm('⚠️ Has ingresado una fecha de egreso pero el estado no es "Inactivo". ¿Deseas continuar de todos modos?')) {
                return false;
            }
        }
    }
    
    return true;
}

// ===== FUNCIONES DE VALIDACIÓN =====
function validarNombre(nombre, campo) {
    if (!nombre || nombre.trim() === '') {
        return `El ${campo} es obligatorio`;
    }
    const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,}$/u;
    if (!regex.test(nombre.trim())) {
        return `El ${campo} debe tener al menos 3 letras y no puede contener números ni espacios`;
    }
    return null;
}

function validarTelefono(telefono) {
    if (!telefono) {
        return 'El teléfono es obligatorio';
    }
    const soloNumeros = telefono.replace(/\D/g, '');
    if (!/^\d{10,11}$/.test(soloNumeros)) {
        return 'El teléfono debe tener entre 10 y 11 dígitos numéricos';
    }
    return null;
}

function validarCedula(cedula) {
    if (!cedula) {
        return 'La cédula es obligatoria';
    }
    const soloNumeros = cedula.replace(/\D/g, '');
    if (!/^\d{7,10}$/.test(soloNumeros)) {
        return 'La cédula debe tener entre 7 y 10 dígitos numéricos';
    }
    return null;
}

function validarEmail(email) {
    if (!email) {
        return 'El email es obligatorio';
    }
    if (email.length < 5) {
        return 'El email debe tener al menos 5 caracteres';
    }
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(email)) {
        return 'El formato del email no es válido';
    }
    return null;
}

function validarDireccion(direccion) {
    if (!direccion) {
        return 'La dirección es obligatoria';
    }
    if (direccion.length < 10) {
        return 'La dirección debe tener al menos 10 caracteres';
    }
    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,\*#\?\-\(\)]+$/;
    if (!regex.test(direccion)) {
        return 'La dirección contiene caracteres no permitidos';
    }
    return null;
}

function validarPassword(password) {
    if (!password) {
        return 'La contraseña es obligatoria';
    }
    if (password.length < 9) {
        return 'La contraseña debe tener al menos 9 caracteres';
    }
    if (password.length > 50) {
        return 'La contraseña no puede tener más de 50 caracteres';
    }
    const regex = /^[a-zA-Z0-9.*#]+$/;
    if (!regex.test(password)) {
        return 'La contraseña solo puede contener letras, números y .*#';
    }
    return null;
}

function validarFormulario(data, esCreacion = false) {
    // Validar nombres
    let error = validarNombre(data.primer_nombre, 'primer nombre');
    if (error) { mostrarMensaje(error, 'error'); return false; }
    
    if (data.segundo_nombre && data.segundo_nombre.trim() !== '') {
        error = validarNombre(data.segundo_nombre, 'segundo nombre');
        if (error) { mostrarMensaje(error, 'error'); return false; }
    }
    
    error = validarNombre(data.primer_apellido, 'primer apellido');
    if (error) { mostrarMensaje(error, 'error'); return false; }
    
    if (data.segundo_apellido && data.segundo_apellido.trim() !== '') {
        error = validarNombre(data.segundo_apellido, 'segundo apellido');
        if (error) { mostrarMensaje(error, 'error'); return false; }
    }
    
    error = validarCedula(data.cedula);
    if (error) { mostrarMensaje(error, 'error'); return false; }
    
    error = validarTelefono(data.telefono);
    if (error) { mostrarMensaje(error, 'error'); return false; }
    
    error = validarEmail(data.email);
    if (error) { mostrarMensaje(error, 'error'); return false; }
    
    error = validarDireccion(data.direccion);
    if (error) { mostrarMensaje(error, 'error'); return false; }
    
    if (!data.fecha_nacimiento) {
        mostrarMensaje('La fecha de nacimiento es obligatoria', 'error');
        return false;
    }
    if (!data.genero) {
        mostrarMensaje('El género es obligatorio', 'error');
        return false;
    }
    if (!data.id_rol) {
        mostrarMensaje('El rol es obligatorio', 'error');
        return false;
    }
    if (!data.fecha_ingreso) {
        mostrarMensaje('La fecha de ingreso es obligatoria', 'error');
        return false;
    }
    
    // Validar fechas
    if (!validarFechas()) {
        return false;
    }
    
    return true;
}

// ===== FUNCIONES DEL CRUD =====

function cargarUsuarios(pagina = 1) {
    paginaActual = pagina;
    
    fetch(`/modules/admin/crud_admin_ajax.php?accion=listar&pagina=${pagina}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderizarTabla(data.usuarios);
                renderizarPaginacion(data.total_paginas, data.pagina_actual);
            } else {
                mostrarMensaje('Error al cargar usuarios', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error de conexión', 'error');
        });
}

function renderizarTabla(usuarios) {
    const tbody = document.getElementById('tabla-usuarios');
    
    if (!usuarios || usuarios.length === 0) {
        tbody.innerHTML = '<tr><td colspan="13" class="text-center">No hay usuarios registrados</td></tr>';
        return;
    }
    
    let html = '';
    usuarios.forEach(u => {
        const estadoClass = `badge-estado badge-${u.estado.toLowerCase()}`;
        
        // ===== CORREGIDO: Formatear fechas manualmente SIN usar new Date() =====
        let fechaIngreso = '-';
        if (u.fecha_ingreso) {
            const partes = u.fecha_ingreso.split('-');
            if (partes.length === 3) {
                // partes = [YYYY, MM, DD] -> DD/MM/YYYY
                fechaIngreso = `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
        }
        
        let fechaEgreso = '-';
        if (u.fecha_egreso && u.fecha_egreso !== '0000-00-00' && u.fecha_egreso !== null) {
            const partes = u.fecha_egreso.split('-');
            if (partes.length === 3) {
                fechaEgreso = `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
        }
        
        // Botones según estado
        let botonEstado;
        let botonEliminar;
        
        if (u.estado === 'Inactivo') {
            botonEstado = `<button class="btn-admin btn-success me-1" onclick="activarUsuario(${u.id})" title="Activar usuario">
                <i class="fas fa-check-circle"></i>
            </button>`;
            botonEliminar = `<button class="btn-admin btn-eliminar" disabled style="opacity:0.5; cursor:not-allowed;" title="Usuario ya inactivo">
                <i class="fas fa-trash-alt"></i>
            </button>`;
        } else {
            botonEstado = `<button class="btn-admin btn-estado me-1" onclick="cambiarEstado(${u.id}, '${u.estado}')" title="Cambiar estado">
                <i class="fas fa-sync-alt"></i>
            </button>`;
            botonEliminar = `<button class="btn-admin btn-eliminar" onclick="inactivarUsuario(${u.id})" title="Inactivar usuario">
                <i class="fas fa-trash-alt"></i>
            </button>`;
        }
        
        html += `<tr>
            <td>${u.id}</td>
            <td>${u.cedula}</td>
            <td>${u.primer_nombre || ''}</td>
            <td>${u.segundo_nombre || ''}</td>
            <td>${u.primer_apellido || ''}</td>
            <td>${u.segundo_apellido || ''}</td>
            <td>${u.email}</td>
            <td>${u.telefono}</td>
            <td>${u.nombre_rol}</td>
            <td><span class="${estadoClass}">${u.estado}</span></td>
            <td>${fechaIngreso}</td>
            <td>${fechaEgreso}</td>
            <td>
                <button class="btn-admin btn-editar me-1" onclick="editarUsuario(${u.id})" title="Editar usuario">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn-admin btn-password me-1" onclick="cambiarPassword(${u.id})" title="Cambiar contraseña">
                    <i class="fas fa-key"></i>
                </button>
                ${botonEstado}
                ${botonEliminar}
            </td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

function renderizarPaginacion(total, actual) {
    totalPaginas = total;
    const paginacion = document.getElementById('paginacion');
    let html = '';
    
    if (actual > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarUsuarios(${actual - 1}); return false;">Anterior</a></li>`;
    }
    
    for (let i = 1; i <= total; i++) {
        if (i === actual) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarUsuarios(${i}); return false;">${i}</a></li>`;
        }
    }
    
    if (actual < total) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="cargarUsuarios(${actual + 1}); return false;">Siguiente</a></li>`;
    }
    
    paginacion.innerHTML = html;
}

function abrirModalCrear() {
    editandoUsuario = false; // Marcar que NO estamos editando
    usuarioEditando = null;
    document.getElementById('modalTitle').textContent = 'Crear Nuevo Usuario';
    document.getElementById('usuarioForm').reset();
    document.getElementById('usuarioId').value = '';
    document.getElementById('passwordInfo').style.display = 'block';
    
    // ===== OCULTAR CAMPO DE FECHA EGRESO AL CREAR =====
    document.getElementById('fecha_egreso_container').style.display = 'none';
    
    // Establecer fecha máxima para fecha ingreso (hoy)
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_ingreso').max = hoy;
    
    // ===== CONFIGURAR PREGUNTAS PARA CREACIÓN =====
    configurarPreguntasCreacion();
    
    modalInstance.show();
}

function editarUsuario(id) {
    editandoUsuario = true; // Marcar que estamos editando
    fetch(`/modules/admin/crud_admin_ajax.php?accion=obtener&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                usuarioEditando = data.usuario;
                document.getElementById('modalTitle').textContent = 'Editar Usuario';
                document.getElementById('usuarioId').value = data.usuario.id;
                document.getElementById('primer_nombre').value = data.usuario.primer_nombre;
                document.getElementById('segundo_nombre').value = data.usuario.segundo_nombre || '';
                document.getElementById('primer_apellido').value = data.usuario.primer_apellido;
                document.getElementById('segundo_apellido').value = data.usuario.segundo_apellido || '';
                document.getElementById('cedula').value = data.usuario.cedula;
                document.getElementById('fecha_nacimiento').value = data.usuario.fecha_nacimiento;
                document.getElementById('genero').value = data.usuario.genero;
                document.getElementById('telefono').value = data.usuario.telefono;
                document.getElementById('email').value = data.usuario.email;
                document.getElementById('direccion').value = data.usuario.direccion;
                document.getElementById('fecha_ingreso').value = data.usuario.fecha_ingreso;
                document.getElementById('fecha_egreso').value = data.usuario.fecha_egreso || '';
                document.getElementById('id_rol').value = data.usuario.id_rol;
                document.getElementById('estado').value = data.usuario.estado;
                document.getElementById('passwordInfo').style.display = 'none';
                
                // ===== MOSTRAR CAMPO DE FECHA EGRESO AL EDITAR =====
                document.getElementById('fecha_egreso_container').style.display = 'block';
                
                // Establecer fecha máxima para fecha ingreso (hoy)
                const hoy = new Date().toISOString().split('T')[0];
                document.getElementById('fecha_ingreso').max = hoy;
                document.getElementById('fecha_egreso').max = hoy;
                
                // ===== CONFIGURAR PREGUNTAS PARA EDICIÓN =====
                configurarPreguntasEdicion(id);
                
                modalInstance.show();
            } else {
                mostrarMensaje('Error al cargar datos del usuario', 'error');
            }
        });
}

// ===== NUEVA FUNCIÓN: CONFIGURAR PREGUNTAS PARA CREACIÓN =====
function configurarPreguntasCreacion() {
    // Mostrar alerta de creación
    document.getElementById('alertCreacion').style.display = 'block';
    
    // Ocultar checkbox de edición
    document.getElementById('checkboxPreguntasContainer').style.display = 'none';
    
    // Habilitar y limpiar preguntas
    const container = document.getElementById('preguntasContainer');
    container.classList.remove('preguntas-disabled');
    container.classList.add('preguntas-enabled');
    
    // Habilitar selects e inputs
    for (let i = 1; i <= 3; i++) {
        const select = document.getElementById(`pregunta_id_${i}`);
        const input = document.getElementById(`respuesta_${i}`);
        
        select.disabled = false;
        select.value = '';
        select.required = true;
        
        input.disabled = false;
        input.value = '';
        input.placeholder = 'Respuesta (mínimo 3 caracteres)';
        input.required = true;
        
        // Limpiar errores
        const errorPregunta = document.getElementById(`preguntaError${i}`);
        const errorRespuesta = document.getElementById(`respuestaError${i}`);
        if (errorPregunta) errorPregunta.style.display = 'none';
        if (errorRespuesta) errorRespuesta.style.display = 'none';
    }
    
    // Cargar preguntas disponibles
    cargarPreguntasSeguridad();
}

// ===== NUEVA FUNCIÓN: CONFIGURAR PREGUNTAS PARA EDICIÓN =====
function configurarPreguntasEdicion(usuarioId) {
    // Ocultar alerta de creación
    document.getElementById('alertCreacion').style.display = 'none';
    
    // Mostrar checkbox de edición
    document.getElementById('checkboxPreguntasContainer').style.display = 'block';
    
    // Deshabilitar preguntas por defecto
    const container = document.getElementById('preguntasContainer');
    container.classList.add('preguntas-disabled');
    container.classList.remove('preguntas-enabled');
    
    // Deshabilitar selects e inputs
    for (let i = 1; i <= 3; i++) {
        const select = document.getElementById(`pregunta_id_${i}`);
        const input = document.getElementById(`respuesta_${i}`);
        
        select.disabled = true;
        select.required = false;
        
        input.disabled = true;
        input.value = '';
        input.placeholder = 'Marque la opción para cambiar';
        input.required = false;
    }
    
    // Cargar preguntas disponibles
    cargarPreguntasSeguridad();
    
    // Cargar preguntas del usuario
    setTimeout(() => {
        cargarPreguntasUsuario(usuarioId);
    }, 500);
}

// ===== NUEVA FUNCIÓN: TOGGLE PREGUNTAS POR CHECKBOX =====
function togglePreguntasEdit(activar) {
    const container = document.getElementById('preguntasContainer');
    const selects = document.querySelectorAll('.pregunta-select');
    const inputs = document.querySelectorAll('.respuesta-input');
    
    if (activar) {
        container.classList.remove('preguntas-disabled');
        container.classList.add('preguntas-enabled');
        
        selects.forEach(select => {
            select.disabled = false;
            select.required = true;
        });
        
        inputs.forEach(input => {
            input.disabled = false;
            input.required = true;
            input.value = '';
            input.placeholder = 'Respuesta (mínimo 3 caracteres)';
        });
    } else {
        container.classList.add('preguntas-disabled');
        container.classList.remove('preguntas-enabled');
        
        selects.forEach((select, index) => {
            select.disabled = true;
            select.required = false;
            // ===== MEJORA: RESTAURAR VALORES ORIGINALES =====
            if (usuarioEditando && usuarioEditando.preguntas && usuarioEditando.preguntas[index]) {
                select.value = usuarioEditando.preguntas[index].pregunta_id;
            } else {
                select.value = '';
            }
        });
        
        inputs.forEach(input => {
            input.disabled = true;
            input.required = false;
            input.value = '';
            input.placeholder = 'Marque la opción para cambiar';
            
            // Limpiar errores
            const index = parseInt(input.id.replace('respuesta_', ''));
            const error = document.getElementById(`respuestaError${index}`);
            if (error) error.style.display = 'none';
        });
    }
}

function guardarUsuario() {
    const form = document.getElementById('usuarioForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    // Validar formulario
    if (!validarFormulario(data, !usuarioEditando)) {
        return;
    }
    
    // ===== VALIDAR PREGUNTAS (solo si aplica) =====
    if (!validarPreguntas()) {
        mostrarMensaje('Por favor, complete correctamente las preguntas de seguridad', 'error');
        return;
    }
    
    // Confirmación antes de guardar
    const mensaje = usuarioEditando 
        ? '⚠️ ¿Estás seguro de que deseas GUARDAR LOS CAMBIOS en este usuario?' 
        : '⚠️ ¿Estás seguro de que deseas CREAR este nuevo usuario?';
    
    if (!confirm(mensaje)) {
        return;
    }
    
    // Primero guardar/actualizar usuario
    const url = usuarioEditando ? '/modules/admin/crud_admin_ajax.php?accion=editar' : '/modules/admin/crud_admin_ajax.php?accion=crear';
    
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const usuarioId = usuarioEditando ? usuarioEditando.id : data.id;
            
            // ===== VERIFICAR SI DEBEMOS GUARDAR PREGUNTAS =====
            const checkbox = document.getElementById('editarPreguntasCheckbox');
            const debeGuardarPreguntas = !usuarioEditando || (checkbox && checkbox.checked);
            
            if (debeGuardarPreguntas) {
                // ===== GUARDAR PREGUNTAS =====
                const pregunta_ids = [];
                const respuestas = [];
                
                for (let i = 1; i <= 3; i++) {
                    pregunta_ids.push(document.getElementById(`pregunta_id_${i}`).value);
                    respuestas.push(document.getElementById(`respuesta_${i}`).value.trim());
                }
                
                return fetch('/modules/admin/crud_admin_ajax.php?accion=guardar_preguntas', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        usuario_id: usuarioId,
                        pregunta_ids: pregunta_ids,
                        respuestas: respuestas
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        modalInstance.hide();
                        mostrarMensaje('Usuario y preguntas de seguridad guardados correctamente', 'success');
                        cargarUsuarios(paginaActual);
                    } else {
                        mostrarMensaje(data.error || 'Error al guardar preguntas', 'error');
                    }
                });
            } else {
                // No hay que guardar preguntas, solo usuario
                modalInstance.hide();
                mostrarMensaje('Usuario actualizado correctamente', 'success');
                cargarUsuarios(paginaActual);
            }
        } else {
            throw new Error(data.errores ? data.errores.join('<br>') : 'Error al guardar usuario');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje(error.message || 'Error al guardar', 'error');
    });
}

function cambiarPassword(id) {
    const nuevaPassword = prompt("Ingrese la nueva contraseña (mínimo 9 caracteres, solo letras, números y .*#):");
    
    if (!nuevaPassword) return;
    
    const error = validarPassword(nuevaPassword);
    if (error) {
        mostrarMensaje(error, 'error');
        return;
    }
    
    if (!confirm('⚠️ ¿Estás seguro de cambiar la contraseña de este usuario?')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('accion', 'cambiar_password');
    formData.append('id', id);
    formData.append('password', nuevaPassword);
    
    fetch('/modules/admin/crud_admin_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje(data.mensaje, 'success');
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error al cambiar contraseña', 'error');
        }
    });
}

function inactivarUsuario(id) {
    if (!confirm('⚠️ ¿Estás seguro de que deseas INACTIVAR este usuario?\n\nEsta acción moverá al usuario al final de la lista y registrará la fecha de egreso.')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('accion', 'inactivar');
    formData.append('id', id);
    
    fetch('/modules/admin/crud_admin_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje(data.mensaje, 'success');
            cargarUsuarios(paginaActual);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error al inactivar', 'error');
        }
    });
}

function cambiarEstado(id, estadoActual) {
    if (estadoActual === 'Inactivo') {
        mostrarMensaje('Los usuarios inactivos deben ser reactivados editando su estado manualmente', 'error');
        return;
    }
    
    const nuevoEstado = estadoActual === 'Activo' ? 'Suspendido' : 'Activo';
    
    if (!confirm(`⚠️ ¿Estás seguro de cambiar el estado a ${nuevoEstado}?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('accion', 'cambiar_estado');
    formData.append('id', id);
    formData.append('estado', nuevoEstado);
    
    fetch('/modules/admin/crud_admin_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje(data.mensaje, 'success');
            cargarUsuarios(paginaActual);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error al cambiar estado', 'error');
        }
    });
}

function mostrarMensaje(texto, tipo = 'success') {
    const mensajeDiv = document.getElementById('mensajeFlotante');
    const icono = tipo === 'success' ? 'fa-check-circle' : 
                  tipo === 'error' ? 'fa-exclamation-triangle' : 
                  'fa-info-circle';
    
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

function activarUsuario(id) {
    if (!confirm('⚠️ ¿Estás seguro de que deseas ACTIVAR este usuario?\n\nEl usuario volverá a estar activo y su fecha de egreso será eliminada.')) {
        return;
    }
    
    mostrarMensaje('Activando usuario...', 'info');
    
    const formData = new FormData();
    formData.append('accion', 'activar');
    formData.append('id', id);
    
    fetch('/modules/admin/crud_admin_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje(data.mensaje, 'success');
            cargarUsuarios(paginaActual);
        } else {
            mostrarMensaje(data.errores ? data.errores.join('<br>') : 'Error al activar', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error de conexión', 'error');
    });
}

// ===== CARGAR PREGUNTAS DISPONIBLES =====
function cargarPreguntasSeguridad() {
    fetch('/modules/admin/crud_admin_ajax.php?accion=listar_preguntas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                preguntasDisponibles = data.preguntas;
                llenarSelectoresPreguntas();
            } else {
                console.error('Error al cargar preguntas:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
}

// ===== LLENAR SELECTORES CON PREGUNTAS =====
function llenarSelectoresPreguntas() {
    for (let i = 1; i <= 3; i++) {
        const select = document.getElementById(`pregunta_id_${i}`);
        if (select) {
            select.innerHTML = '<option value="">-- Seleccione una pregunta --</option>';
            preguntasDisponibles.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.pregunta;
                select.appendChild(option);
            });
        }
    }
}

// ===== CARGAR PREGUNTAS DEL USUARIO PARA EDICIÓN =====
function cargarPreguntasUsuario(usuarioId) {
    fetch(`/modules/admin/crud_admin_ajax.php?accion=obtener_preguntas_usuario&usuario_id=${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.preguntas) {
                // Guardar preguntas en usuarioEditando
                if (!usuarioEditando) usuarioEditando = {};
                usuarioEditando.preguntas = data.preguntas;
                
                // Llenar selects con las preguntas actuales
                data.preguntas.forEach((pregunta, index) => {
                    const select = document.getElementById(`pregunta_id_${index + 1}`);
                    if (select) {
                        select.value = pregunta.pregunta_id;
                    }
                });
            } else {
                // Si no tiene preguntas
                for (let i = 1; i <= 3; i++) {
                    const select = document.getElementById(`pregunta_id_${i}`);
                    if (select) select.value = '';
                }
            }
        })
        .catch(error => console.error('Error al cargar preguntas del usuario:', error));
}

// ===== VALIDAR PREGUNTAS =====
function validarPreguntas() {
    // Si estamos en modo edición y el checkbox NO está marcado, no validar
    if (editandoUsuario) {
        const checkbox = document.getElementById('editarPreguntasCheckbox');
        if (checkbox && !checkbox.checked) {
            return true; // No validar preguntas
        }
    }
    
    let todasValidas = true;
    const selects = [];
    const respuestas = [];
    
    for (let i = 1; i <= 3; i++) {
        selects.push(document.getElementById(`pregunta_id_${i}`));
        respuestas.push(document.getElementById(`respuesta_${i}`));
    }
    
    // Limpiar errores previos
    selects.forEach((select, index) => {
        const errorDiv = document.getElementById(`preguntaError${index + 1}`);
        if (select) {
            select.classList.remove('is-invalid');
            if (errorDiv) errorDiv.style.display = 'none';
        }
    });
    
    respuestas.forEach((input, index) => {
        const errorDiv = document.getElementById(`respuestaError${index + 1}`);
        if (input) {
            input.classList.remove('is-invalid');
            if (errorDiv) errorDiv.style.display = 'none';
        }
    });
    
    // Verificar que todas las preguntas estén seleccionadas
    const valores = [];
    selects.forEach((select, index) => {
        const errorDiv = document.getElementById(`preguntaError${index + 1}`);
        if (!select.value) {
            select.classList.add('is-invalid');
            if (errorDiv) errorDiv.style.display = 'block';
            todasValidas = false;
        } else {
            valores.push(select.value);
        }
    });
    
    // Verificar duplicados
    if (new Set(valores).size !== valores.length) {
        selects.forEach((select, index) => {
            if (valores.filter(v => v === select.value).length > 1) {
                const errorDiv = document.getElementById(`preguntaError${index + 1}`);
                select.classList.add('is-invalid');
                if (errorDiv) {
                    errorDiv.textContent = 'Esta pregunta ya fue seleccionada';
                    errorDiv.style.display = 'block';
                }
            }
        });
        todasValidas = false;
    }
    
    // Verificar respuestas
    respuestas.forEach((input, index) => {
        const errorDiv = document.getElementById(`respuestaError${index + 1}`);
        const valor = input.value.trim();
        
        if (valor.length === 0) {
            input.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.textContent = 'La respuesta es obligatoria';
                errorDiv.style.display = 'block';
            }
            todasValidas = false;
        } else if (valor.length < 3) {
            input.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.textContent = 'La respuesta debe tener al menos 3 caracteres';
                errorDiv.style.display = 'block';
            }
            todasValidas = false;
        } else if (valor.length > 50) {
            input.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.textContent = 'La respuesta no puede tener más de 50 caracteres';
                errorDiv.style.display = 'block';
            }
            todasValidas = false;
        }
    });
    
    return todasValidas;
}

// ===== LIMPIAR CAMPOS DE PREGUNTAS =====
function limpiarPreguntas() {
    for (let i = 1; i <= 3; i++) {
        const select = document.getElementById(`pregunta_id_${i}`);
        const input = document.getElementById(`respuesta_${i}`);
        if (select) select.value = '';
        if (input) {
            input.value = '';
            input.placeholder = 'Respuesta (mín. 3 caracteres)';
        }
        
        const errorPregunta = document.getElementById(`preguntaError${i}`);
        const errorRespuesta = document.getElementById(`respuestaError${i}`);
        if (errorPregunta) errorPregunta.style.display = 'none';
        if (errorRespuesta) errorRespuesta.style.display = 'none';
    }
}