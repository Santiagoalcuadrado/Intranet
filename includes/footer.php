<footer class="py-3">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <!-- Columna izquierda: Información de la biblioteca -->
            <div class="col-12 col-md-4 footer-text mb-2 mb-md-0">
                <strong>Biblioteca Pública del Estado Zulia, "María Calcaño"</strong><br>
                © 2026 Todos los derechos reservados.
            </div>
            
            <!-- Columna central: Redes sociales -->
            <div class="col-12 col-md-3 text-center mb-2 mb-md-0">
                <a href="https://www.instagram.com/bibliotecapublicadelzulia2025/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="social-icon" 
                   title="Visitar Instagram Oficial">
                   <i class="fab fa-instagram"></i>
                </a>

                <a href="https://www.facebook.com/TU_PAGINA" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="social-icon" 
                   title="Visitar Facebook Oficial">
                   <i class="fab fa-facebook"></i>
                </a>
                
                <a href="mailto:bpzsolicitudes@gmail.com" 
                   class="social-icon" 
                   title="Enviar Correo Electrónico">
                   <i class="fas fa-envelope"></i>
                </a>
                
                <a href="https://www.bibliotecapublicadelzulia.org/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="social-icon" 
                   title="Visitar Web Oficial">
                   <i class="fas fa-globe"></i>
                </a>
            </div>

            <!-- Columna derecha: Enlaces legales + Ayuda -->
            <div class="col-12 col-md-5 text-md-end footer-text">
                <!-- NUEVO BOTÓN DE AYUDA -->
                <a href="#" onclick="abrirModal('ayuda'); return false;" class="me-2 me-md-3">
                    <i class="fas fa-question-circle me-1"></i>Ayuda
                </a>
                <a href="#" onclick="abrirModal('privacidad'); return false;" class="me-2 me-md-3">Privacidad</a>
                <a href="#" onclick="abrirModal('condiciones'); return false;">Condiciones</a>
            </div>
        </div>
    </div>
</footer>

<!-- MODAL LEGAL (OCULTO POR DEFECTO) - REUTILIZADO PARA AYUDA -->
<div id="legalModal" class="modal-overlay" style="display: none;" onclick="cerrarModal()">
    <div class="modal-glass" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2><i class="fas fa-shield-alt me-2" style="color: var(--bpez-azul-alegre);" id="modalIcon"></i><span id="modalTitle"></span></h2>
            <button onclick="cerrarModal()" class="btn-cerrar">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>

        <div class="modal-content" id="modalContent">
            <!-- El contenido se cargará dinámicamente con JavaScript -->
        </div>

        <div class="modal-footer" id="modalFooter">
            <button onclick="cerrarModal()" class="btn-aceptar">
                <i class="fas fa-check-circle me-2"></i>Aceptar y Cerrar
            </button>
        </div>
    </div>
</div>

<style>
/* ===== ESTILOS DEL FOOTER (los que ya tenías) ===== */
footer { 
    background-color: var(--header-bg-integrado);
    color: var(--bpez-dark-blue);
    border-top: 1px solid rgba(0,0,0,0.1);
    padding: 15px 0;
    width: 100%;
    flex-shrink: 0;
    margin-top: auto;
}

.footer-text { 
    font-size: clamp(0.65rem, 1.2vw, 0.8rem);
    color: var(--bpez-dark-blue); 
    font-weight: 600; 
    line-height: 1.5;
}

footer a { 
    color: var(--bpez-dark-blue) !important; 
    font-size: clamp(0.65rem, 1.2vw, 0.8rem);
    text-decoration: none !important;
    display: inline-block;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    white-space: nowrap;
}

footer a:hover { 
    color: var(--bpez-rojo-fuego) !important; 
    transform: scale(1.2) translateY(-2px);
}

.social-icon {
    font-size: clamp(0.9rem, 1.5vw, 1.2rem);
    margin: 0 5px;
}

.social-icon:hover {
    transform: scale(1.3) rotate(8deg);
}

/* ===== ESTILOS DEL MODAL ===== */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: overlayFadeIn 0.3s ease-out;
}

@keyframes overlayFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-glass {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 30px;
    padding: 30px;
    max-width: 800px;
    width: 90%;
    max-height: 85vh;
    margin: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-left: 8px solid var(--bpez-azul-alegre);
    animation: modalAppear 0.4s ease-out;
    display: flex;
    flex-direction: column;
}

@keyframes modalAppear {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 2px solid var(--bpez-cian);
    padding-bottom: 15px;
    flex-shrink: 0;
}

.modal-header h2 {
    color: var(--bpez-dark-blue);
    font-weight: 800;
    font-size: clamp(1.2rem, 4vw, 1.8rem);
    margin: 0;
}

.btn-cerrar {
    background: rgba(206, 32, 41, 0.1);
    border: 1px solid rgba(206, 32, 41, 0.3);
    border-radius: 50px;
    padding: 8px 16px;
    color: var(--bpez-dark-blue);
    font-weight: 600;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: none;
    font-size: clamp(0.8rem, 2vw, 0.9rem);
}

.btn-cerrar:hover {
    background: rgba(206, 32, 41, 0.2);
    color: var(--bpez-azul-alegre);
    transform: translateY(-2px);
}

.btn-cerrar i {
    color: var(--bpez-rojo-fuego);
    font-size: clamp(0.8rem, 2vw, 1rem);
}

.modal-content {
    color: var(--bpez-dark-blue);
    overflow-y: auto;
    padding-right: 10px;
    flex-grow: 1;
}

.modal-content::-webkit-scrollbar {
    width: 8px;
}

.modal-content::-webkit-scrollbar-track {
    background: rgba(0, 51, 102, 0.05);
    border-radius: 10px;
}

.modal-content::-webkit-scrollbar-thumb {
    background: var(--bpez-cian);
    border-radius: 10px;
}

.modal-content h4 {
    color: var(--bpez-dark-blue);
    font-weight: 700;
    font-size: clamp(1rem, 2.5vw, 1.2rem);
    margin: 20px 0 10px 0;
    border-left: 4px solid var(--bpez-rojo-fuego);
    padding-left: 12px;
}

.modal-content p {
    line-height: 1.6;
    margin-bottom: 15px;
    font-size: clamp(0.85rem, 2vw, 1rem);
}

.modal-content ul {
    list-style-type: none;
    padding-left: 0;
}

.modal-content li {
    margin-bottom: 10px;
    padding-left: 20px;
    position: relative;
    font-size: clamp(0.85rem, 2vw, 1rem);
}

.modal-content li:before {
    content: "•";
    color: var(--bpez-rojo-fuego);
    font-weight: bold;
    position: absolute;
    left: 0;
}

/* Estilo especial para el visor PDF */
.pdf-container {
    width: 100%;
    height: 60vh;
    border: 1px solid rgba(0, 51, 102, 0.2);
    border-radius: 12px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.5);
    margin-bottom: 20px;
}

.pdf-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.pdf-nota {
    background: rgba(0, 119, 182, 0.1);
    border-left: 4px solid var(--bpez-azul-alegre);
    padding: 12px 15px;
    border-radius: 8px;
    margin-top: 15px;
    font-size: 0.85rem;
    color: var(--bpez-dark-blue);
}

.pdf-nota i {
    color: var(--bpez-azul-alegre);
    margin-right: 8px;
}

/* Ajuste para el footer del modal en modo PDF */
.modal-footer {
    margin-top: 25px;
    padding-top: 15px;
    border-top: 1px solid rgba(0, 51, 102, 0.1);
    text-align: right;
    flex-shrink: 0;
}

.btn-aceptar {
    background: var(--bpez-azul-alegre);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    font-size: clamp(0.9rem, 2vw, 1rem);
    border: none;
}

.btn-aceptar:hover {
    background: var(--bpez-dark-blue);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 51, 102, 0.3);
}

.btn-descargar-pdf {
    background: var(--bpez-azul-alegre);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    font-size: clamp(0.9rem, 2vw, 1rem);
    border: none;
    margin-left: 10px;
}

.btn-descargar-pdf:hover {
    background: var(--bpez-dark-blue);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 51, 102, 0.3);
}

/* Responsive del modal */
@media (min-width: 1400px) {
    .modal-glass {
        max-width: 1000px;
        padding: 40px;
    }
    .modal-content {
        max-height: 70vh;
    }
    .pdf-container {
        height: 65vh;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .modal-glass {
        width: 85%;
        padding: 25px;
    }
}

@media (min-width: 576px) and (max-width: 767px) {
    .modal-glass {
        width: 90%;
        padding: 20px;
        max-height: 80vh;
    }
    .modal-header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
    .btn-cerrar {
        align-self: flex-end;
    }
    .pdf-container {
        height: 50vh;
    }
    .btn-descargar-pdf {
        margin-left: 0;
        margin-top: 10px;
        width: 100%;
    }
}

@media (max-width: 575px) {
    .modal-glass {
        width: 95%;
        padding: 15px;
        max-height: 85vh;
        margin: 10px;
    }
    .modal-header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
    .btn-cerrar, .btn-aceptar, .btn-descargar-pdf {
        width: 100%;
        justify-content: center;
    }
    .btn-descargar-pdf {
        margin-left: 0;
        margin-top: 10px;
    }
    .modal-footer {
        text-align: center;
    }
    .pdf-container {
        height: 45vh;
    }
}

@media (max-width: 400px) {
    .modal-glass {
        padding: 12px;
    }
    .modal-content h4 {
        font-size: 1rem;
    }
}

/* Responsive del footer */
@media (max-width: 768px) {
    footer {
        padding: 12px 0;
    }
    .footer-text {
        font-size: 0.7rem;
        text-align: center !important;
    }
    footer a {
        font-size: 0.7rem;
        white-space: normal;
    }
    .social-icon {
        font-size: 1rem;
        margin: 0 8px;
    }
    .col-md-5.text-md-end {
        text-align: center !important;
        margin-top: 8px;
    }
}

@media (max-width: 576px) {
    footer {
        padding: 12px 0 10px 0;
    }
    .footer-text {
        font-size: 0.65rem;
        line-height: 1.4;
    }
    footer a {
        font-size: 0.65rem;
    }
    .social-icon {
        font-size: 1.1rem;
        margin: 0 10px;
    }
    .row > div {
        margin-bottom: 8px;
    }
    .row > div:last-child {
        margin-bottom: 0;
    }
}
</style>

<script>
// Contenido de los modals (directamente en el footer)
const contenidoPrivacidad = `
    <h4>1. Responsable del Tratamiento</h4>
    <p><strong>Biblioteca Pública del Estado Zulia "María Calcaño"</strong><br>
    Dirección: Avenida 2 El Milagro, entre las calles 86 y 87, en la parroquia Santa Lucía, Maracaibo, Estado Zulia<br>
    Correo: protecciondedatos@bpez.gob.ve</p>

    <h4>2. Datos que Recopilamos</h4>
    <ul>
        <li><strong>Datos de identificación:</strong> nombres, apellidos, cédula, fecha de nacimiento, género.</li>
        <li><strong>Datos de contacto:</strong> correo electrónico, teléfono, dirección.</li>
        <li><strong>Datos laborales:</strong> cargo, rol dentro del sistema, fecha de ingreso, fecha de egreso, estado del usuario (Activo/Inactivo/Suspendido).</li>
        <li><strong>Datos de acceso:</strong> 
            <ul>
                <li>Intentos de inicio de sesión (fallidos y exitosos).</li>
                <li>Fecha y hora del último inicio de sesión.</li>
                <li>Fecha de registro en el sistema.</li>
                <li>Fechas de modificación de datos personales (teléfono, email, dirección, contraseña, rol).</li>
            </ul>
        </li>
        <li><strong>Datos de documentos:</strong> 
            <ul>
                <li>Documentos subidos por el usuario (título, descripción, tipo).</li>
                <li>Registro de quién creó, modificó o eliminó cada documento.</li>
                <li>Historial de versiones de documentos.</li>
            </ul>
        </li>
        <li><strong>Datos de auditoría:</strong> 
            <ul>
                <li>Todas las acciones realizadas en el sistema (subir, descargar, aprobar, rechazar, eliminar, editar perfil, cambiar contraseña, cambiar rol).</li>
                <li>Nombre, cédula y rol del usuario que ejecutó cada acción.</li>
                <li>ID del registro afectado y detalles del cambio (valores anteriores y nuevos cuando aplica).</li>
            </ul>
        </li>
    </ul>

    <h4>3. Finalidad del Tratamiento</h4>
    <p>Los datos personales recopilados serán utilizados exclusivamente para:</p>
    <ul>
        <li>Gestionar el acceso y uso de la intranet institucional.</li>
        <li>Mantener un registro detallado de intentos de inicio de sesión para fines de seguridad y auditoría.</li>
        <li>Registrar la fecha y hora del último acceso de cada usuario.</li>
        <li>Facilitar la comunicación interna y la gestión del personal.</li>
        <li>Cumplir con obligaciones legales y administrativas.</li>
        <li>Llevar un control de versiones de documentos y auditoría de cambios.</li>
        <li>Mantener un historial completo de todas las acciones realizadas en el sistema para garantizar la transparencia y la rendición de cuentas.</li>
        <li>Detectar e investigar posibles accesos no autorizados o actividades sospechosas.</li>
    </ul>

    <h4>4. Medidas de Seguridad</h4>
    <p>Implementamos medidas técnicas y organizativas apropiadas para proteger sus datos personales, incluyendo:</p>
    <ul>
        <li><strong>Cifrado de contraseñas:</strong> Todas las contraseñas se almacenan utilizando algoritmos seguros (bcrypt).</li>
        <li><strong>Controles de acceso:</strong> Sistema de roles y permisos que garantiza que cada usuario acceda solo a la información necesaria para sus funciones.</li>
        <li><strong>Monitoreo continuo:</strong> Registro detallado de intentos de inicio de sesión y de todas las acciones realizadas en el sistema.</li>
        <li><strong>Auditoría completa:</strong> Trazabilidad de quién hizo qué, cuándo y sobre qué registro, incluyendo valores anteriores y nuevos en las modificaciones.</li>
        <li><strong>Soft delete:</strong> Los documentos nunca se eliminan físicamente, solo se marcan como eliminados para preservar la auditoría.</li>
        <li><strong>Respaldos periódicos:</strong> Copias de seguridad regulares de la base de datos y los archivos subidos.</li>
    </ul>

    <h4>5. Conservación de Datos</h4>
    <p>Los datos de los usuarios se conservarán de manera indefinida mientras la relación laboral esté vigente. Los registros de auditoría y logs del sistema se conservarán de manera permanente para fines de seguridad y transparencia institucional. En caso de egreso del usuario, su cuenta será marcada como "Inactiva" y sus datos permanecerán en el sistema para fines de auditoría, pero no podrá acceder nuevamente.</p>

    <h4>6. Derechos de los Usuarios</h4>
    <p>Usted tiene derecho a acceder, rectificar, cancelar u oponerse al tratamiento de sus datos personales. Para ejercer estos derechos, puede contactarnos a través de protecciondedatos@bpez.gob.ve. Tenga en cuenta que, debido a la naturaleza de auditoría del sistema, algunos datos no podrán ser eliminados (como los registros de acciones), pero podrán ser bloqueados para su visualización pública.</p>
`;

const contenidoCondiciones = `
    <h4>1. Aceptación de los Términos</h4>
    <p>Al acceder y utilizar la Intranet de la Biblioteca Pública del Estado Zulia "María Calcaño", usted acepta estar sujeto a estos Términos y Condiciones de Uso. Si no está de acuerdo con alguno de estos términos, no podrá acceder ni utilizar este sistema.</p>

    <h4>2. Uso Autorizado</h4>
    <p>El acceso a esta intranet está restringido al personal autorizado de la institución. Cada usuario es responsable de mantener la confidencialidad de sus credenciales de acceso y de todas las actividades que ocurran bajo su cuenta. Cualquier intento de acceso no autorizado será registrado y podrá ser investigado.</p>

    <h4>3. Propiedad Intelectual</h4>
    <p>Todos los contenidos, logos, diseños, documentos y materiales presentes en esta intranet son propiedad exclusiva de la Biblioteca Pública del Estado Zulia "María Calcaño" y están protegidos por las leyes de propiedad intelectual venezolanas e internacionales. Los documentos subidos por los usuarios son de su responsabilidad y autoría.</p>

    <h4>4. Conducta del Usuario</h4>
    <ul>
        <li><strong>Credenciales:</strong> No compartir credenciales de acceso con terceros no autorizados. Cada acción queda registrada bajo su nombre.</li>
        <li><strong>Acceso:</strong> No intentar acceder a información o áreas restringidas para su rol. Todos los intentos de acceso son monitoreados.</li>
        <li><strong>Seguridad:</strong> No realizar actividades que puedan comprometer la seguridad del sistema (inyección de código, fuerza bruta, etc.).</li>
        <li><strong>Uso de información:</strong> Utilizar la información institucional únicamente para fines laborales y autorizados.</li>
        <li><strong>Documentos:</strong> Al subir documentos, usted certifica que tiene los derechos necesarios y que el contenido cumple con las políticas institucionales.</li>
        <li><strong>Modificaciones:</strong> No alterar, eliminar o modificar información de otros usuarios sin la debida autorización.</li>
    </ul>

    <h4>5. Auditoría y Monitoreo</h4>
    <p>Usted reconoce y acepta que todas las acciones realizadas en el sistema son registradas en una bitácora de auditoría que incluye:</p>
    <ul>
        <li>Fecha y hora de cada acción.</li>
        <li>Identificación del usuario que ejecutó la acción (nombre, cédula, rol).</li>
        <li>Descripción detallada de la acción, incluyendo valores anteriores y nuevos cuando corresponda.</li>
        <li>Documentos subidos, descargados, aprobados o rechazados.</li>
        <li>Cambios en el perfil del usuario (teléfono, email, dirección, contraseña).</li>
        <li>Intentos de inicio de sesión (exitosos y fallidos).</li>
    </ul>
    <p>Estos registros son de carácter permanente y podrán ser utilizados en investigaciones internas o legales.</p>

    <h4>6. Limitación de Responsabilidad</h4>
    <p>La Biblioteca Pública del Estado Zulia "María Calcaño" no será responsable por daños directos, indirectos, incidentales o consecuentes que resulten del uso o la imposibilidad de usar esta intranet, siempre que se hayan implementado las medidas de seguridad descritas. El usuario es responsable por el uso indebido de sus credenciales y por la veracidad de la información que proporcione.</p>

    <h4>7. Modificaciones a los Términos</h4>
    <p>Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Las modificaciones serán notificadas a través de la intranet y entrarán en vigencia inmediatamente después de su publicación. El uso continuado del sistema constituye la aceptación de los nuevos términos.</p>

    <h4>8. Legislación Aplicable</h4>
    <p>Estos términos se rigen por las leyes de la República Bolivariana de Venezuela. Cualquier controversia relacionada con el uso de la intranet será sometida a la jurisdicción de los tribunales competentes del Estado Zulia.</p>
`;

// Función para abrir el modal
function abrirModal(tipo) {
    const modal = document.getElementById('legalModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalIcon = document.getElementById('modalIcon');
    const modalContent = document.getElementById('modalContent');
    const modalFooter = document.getElementById('modalFooter');
    
    if (tipo === 'privacidad') {
        modalTitle.textContent = 'Política de Privacidad';
        modalIcon.className = 'fas fa-shield-alt me-2';
        modalContent.innerHTML = contenidoPrivacidad;
        // Restaurar footer original
        modalFooter.innerHTML = `
            <button onclick="cerrarModal()" class="btn-aceptar">
                <i class="fas fa-check-circle me-2"></i>Aceptar y Cerrar
            </button>
        `;
    } 
    else if (tipo === 'condiciones') {
        modalTitle.textContent = 'Términos y Condiciones';
        modalIcon.className = 'fas fa-file-contract me-2';
        modalContent.innerHTML = contenidoCondiciones;
        // Restaurar footer original
        modalFooter.innerHTML = `
            <button onclick="cerrarModal()" class="btn-aceptar">
                <i class="fas fa-check-circle me-2"></i>Aceptar y Cerrar
            </button>
        `;
    }
    else if (tipo === 'ayuda') {
        modalTitle.textContent = 'Manual de Usuario - Intranet BPEZ';
        modalIcon.className = 'fas fa-question-circle me-2';
        
        // Crear contenido con visor PDF
        modalContent.innerHTML = `
            <div class="pdf-container">
                <iframe src="/uploads/manuales/manual_usuario_intranet.pdf#toolbar=1&navpanes=1" 
                        type="application/pdf"
                        title="Manual de Usuario Intranet BPEZ">
                    <p>Tu navegador no soporta iframes. Puedes 
                    <a href="/uploads/manuales/manual_usuario_intranet.pdf" target="_blank">descargar el manual aquí</a>.</p>
                </iframe>
            </div>
            <div class="pdf-nota">
                <i class="fas fa-info-circle"></i>
                Si el PDF no se visualiza correctamente, puedes descargarlo usando el botón "Descargar Manual".
            </div>
        `;
        
        // Footer especial con botón de descarga
        modalFooter.innerHTML = `
            <a href="/uploads/manuales/manual_usuario_intranet.pdf" 
               target="_blank" 
               class="btn-descargar-pdf"
               download="Manual_Usuario_Intranet_BPEZ.pdf">
                <i class="fas fa-download me-2"></i>Descargar Manual
            </a>
            <button onclick="cerrarModal()" class="btn-aceptar">
                <i class="fas fa-check-circle me-2"></i>Cerrar
            </button>
        `;
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Evita scroll del fondo
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('legalModal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Restaura el scroll
}

// Cerrar con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});
</script>