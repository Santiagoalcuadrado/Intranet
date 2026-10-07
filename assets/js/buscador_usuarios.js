/**
 * buscador_usuarios.js
 * Búsqueda en tiempo real de usuarios por nombre, apellido o cédula
 * Ubicación: /assets/js/buscador_usuarios.js
 */

class BuscadorUsuarios {
    constructor(config) {
        this.config = {
            inputId: null,
            resultsContainerId: null,
            hiddenFieldId: null,
            selectedInfoId: null,
            apiUrl: '/modules/admin/buscador_usuarios_ajax.php',
            minChars: 2,
            debounceMs: 400,
            maxResults: 10,
            onSelect: null,
            ...config
        };
        
        if (!this.config.inputId || !this.config.resultsContainerId) {
            console.error('BuscadorUsuarios: inputId y resultsContainerId son requeridos');
            return;
        }
        
        this.input = document.getElementById(this.config.inputId);
        this.resultsContainer = document.getElementById(this.config.resultsContainerId);
        this.hiddenField = this.config.hiddenFieldId ? document.getElementById(this.config.hiddenFieldId) : null;
        this.selectedInfo = this.config.selectedInfoId ? document.getElementById(this.config.selectedInfoId) : null;
        
        this.searchTimeout = null;
        this.selectedUser = null;
        
        if (this.input && this.resultsContainer) {
            this.init();
        }
    }
    
    init() {
        this.input.addEventListener('input', (e) => this.onInput(e));
        
        document.addEventListener('click', (e) => {
            if (!this.input.contains(e.target) && !this.resultsContainer.contains(e.target)) {
                this.hideSuggestions();
            }
        });
        
        this.input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const firstItem = this.resultsContainer.querySelector('.buscador-item');
                if (firstItem && this.resultsContainer.classList.contains('active')) {
                    firstItem.click();
                }
            }
        });
    }
    
    onInput(e) {
        const termino = e.target.value.trim();
        
        if (this.selectedUser && termino !== this.selectedUser.nombre_completo) {
            this.clearSelection();
        }
        
        if (this.searchTimeout) clearTimeout(this.searchTimeout);
        
        this.searchTimeout = setTimeout(() => {
            if (termino.length >= this.config.minChars) {
                this.buscar(termino);
            } else {
                this.hideSuggestions();
            }
        }, this.config.debounceMs);
    }
    
    async buscar(termino) {
        this.showLoading();
        
        try {
            const url = `${this.config.apiUrl}?q=${encodeURIComponent(termino)}&limit=${this.config.maxResults}`;
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.error) {
                this.showError(data.error);
                return;
            }
            
            if (!data.data || data.data.length === 0) {
                this.showNoResults(termino);
                return;
            }
            
            this.showResults(data.data);
            
        } catch (error) {
            console.error('Error:', error);
            this.showError('Error de conexión');
        }
    }
    
    showLoading() {
        this.resultsContainer.innerHTML = `
            <div class="buscador-loading">
                <i class="fas fa-spinner fa-spin"></i> Buscando...
            </div>
        `;
        this.resultsContainer.classList.add('active');
    }
    
    showNoResults(termino) {
        this.resultsContainer.innerHTML = `
            <div class="buscador-no-results">
                😕 No se encontraron usuarios para "${this.escapeHTML(termino)}"
            </div>
        `;
        this.resultsContainer.classList.add('active');
    }
    
    showError(mensaje) {
        this.resultsContainer.innerHTML = `
            <div class="buscador-error">
                ⚠️ ${this.escapeHTML(mensaje)}
            </div>
        `;
        this.resultsContainer.classList.add('active');
    }
    
    showResults(usuarios) {
        let html = '';
        
        usuarios.forEach(usuario => {
            html += `
                <div class="buscador-item" 
                     data-id="${usuario.id}"
                     data-nombre="${this.escapeHTML(usuario.nombre_completo)}"
                     data-cedula="${this.escapeHTML(usuario.cedula)}"
                     data-email="${this.escapeHTML(usuario.email)}"
                     data-estado="${usuario.estado}">
                    <div class="buscador-item-header">
                        <span class="buscador-nombre">${this.escapeHTML(usuario.nombre_completo)}</span>
                        <span class="buscador-cedula">${this.escapeHTML(usuario.cedula)}</span>
                    </div>
                    <div class="buscador-item-details">
                        <span><i class="fas fa-envelope"></i> ${this.escapeHTML(usuario.email)}</span>
                        <span class="buscador-badge ${usuario.estado_class}">${usuario.estado}</span>
                        <span class="buscador-badge ${usuario.rol_class}">${usuario.rol_nombre}</span>
                    </div>
                </div>
            `;
        });
        
        this.resultsContainer.innerHTML = html;
        this.resultsContainer.classList.add('active');
        
        document.querySelectorAll('.buscador-item').forEach(item => {
            item.addEventListener('click', () => {
                this.selectUser({
                    id: item.dataset.id,
                    nombre_completo: item.dataset.nombre,
                    cedula: item.dataset.cedula,
                    email: item.dataset.email,
                    estado: item.dataset.estado
                });
            });
        });
    }
    
    selectUser(usuario) {
        this.selectedUser = usuario;
        this.input.value = usuario.nombre_completo;
        
        if (this.hiddenField) {
            this.hiddenField.value = usuario.cedula;
        }
        
        if (this.selectedInfo) {
            const estadoClass = usuario.estado === 'Activo' ? 'estado-activo' : 
                               (usuario.estado === 'Inactivo' ? 'estado-inactivo' : 'estado-suspendido');
            
            this.selectedInfo.innerHTML = `
                <div class="buscador-seleccionado">
                    <span>
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <strong>${this.escapeHTML(usuario.nombre_completo)}</strong>
                        (${this.escapeHTML(usuario.cedula)})
                        <span class="buscador-badge ${estadoClass}">${usuario.estado}</span>
                    </span>
                    <button type="button" class="buscador-limpiar">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
            `;
            this.selectedInfo.style.display = 'block';
            
            this.selectedInfo.querySelector('.buscador-limpiar').addEventListener('click', () => {
                this.clearSelection();
            });
        }
        
        this.hideSuggestions();
        
        if (this.config.onSelect && typeof this.config.onSelect === 'function') {
            this.config.onSelect(usuario);
        }
    }
    
    clearSelection() {
        this.selectedUser = null;
        this.input.value = '';
        
        if (this.hiddenField) {
            this.hiddenField.value = '';
        }
        
        if (this.selectedInfo) {
            this.selectedInfo.innerHTML = '';
            this.selectedInfo.style.display = 'none';
        }
        
        this.hideSuggestions();
    }
    
    hideSuggestions() {
        this.resultsContainer.classList.remove('active');
        this.resultsContainer.innerHTML = '';
    }
    
    escapeHTML(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    getSelectedUser() {
        return this.selectedUser;
    }
}