/**
 * buscador_documentos.js
 * Búsqueda en tiempo real de documentos por título, tipo, descripción, etc.
 * Ubicación: /assets/js/buscador_documentos.js
 */

class BuscadorDocumentos {
    constructor(config) {
        this.config = {
            inputId: null,
            resultsContainerId: null,
            hiddenFieldId: null,
            selectedInfoId: null,
            apiUrl: '/modules/admin/buscador_documentos_ajax.php',
            minChars: 2,
            debounceMs: 400,
            maxResults: 10,
            onSelect: null,
            ...config
        };
        
        if (!this.config.inputId || !this.config.resultsContainerId) {
            console.error('BuscadorDocumentos: inputId y resultsContainerId son requeridos');
            return;
        }
        
        this.input = document.getElementById(this.config.inputId);
        this.resultsContainer = document.getElementById(this.config.resultsContainerId);
        this.hiddenField = this.config.hiddenFieldId ? document.getElementById(this.config.hiddenFieldId) : null;
        this.selectedInfo = this.config.selectedInfoId ? document.getElementById(this.config.selectedInfoId) : null;
        
        this.searchTimeout = null;
        this.selectedDocument = null;
        
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
                const firstItem = this.resultsContainer.querySelector('.documento-item');
                if (firstItem && this.resultsContainer.classList.contains('active')) {
                    firstItem.click();
                }
            }
        });
    }
    
    onInput(e) {
        const termino = e.target.value.trim();
        
        if (this.selectedDocument && termino !== this.selectedDocument.titulo) {
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
                <i class="fas fa-spinner fa-spin"></i> Buscando documentos...
            </div>
        `;
        this.resultsContainer.classList.add('active');
    }
    
    showNoResults(termino) {
        this.resultsContainer.innerHTML = `
            <div class="buscador-no-results">
                😕 No se encontraron documentos para "${this.escapeHTML(termino)}"
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
    
    showResults(documentos) {
        let html = '';
        
        documentos.forEach(doc => {
            html += `
                <div class="documento-item" 
                     data-id="${doc.id}"
                     data-titulo="${this.escapeHTML(doc.titulo)}"
                     data-tipo="${doc.tipo_documento}"
                     data-estado="${doc.estado}">
                    <div class="documento-item-header">
                        <span class="documento-titulo">${doc.tipo_icono} ${this.escapeHTML(doc.titulo)}</span>
                        <span class="documento-tipo">${this.escapeHTML(doc.tipo_documento)}</span>
                    </div>
                    <div class="documento-item-details">
                        <span class="documento-badge ${doc.estado_class}">
                            ${doc.estado_icono} ${doc.estado_texto}
                        </span>
                        <span><i class="fas fa-user"></i> ${this.escapeHTML(doc.creado_por_nombre)}</span>
                        <span><i class="fas fa-calendar"></i> ${doc.fecha_formateada}</span>
                    </div>
                    ${doc.descripcion ? `<div class="documento-descripcion"><i class="fas fa-align-left"></i> ${this.escapeHTML(doc.descripcion)}</div>` : ''}
                    ${doc.gaceta ? `<div class="documento-gaceta"><i class="fas fa-newspaper"></i> Gaceta: ${this.escapeHTML(doc.gaceta)}</div>` : ''}
                </div>
            `;
        });
        
        this.resultsContainer.innerHTML = html;
        this.resultsContainer.classList.add('active');
        
        document.querySelectorAll('.documento-item').forEach(item => {
            item.addEventListener('click', () => {
                this.selectDocument({
                    id: item.dataset.id,
                    titulo: item.dataset.titulo,
                    tipo: item.dataset.tipo,
                    estado: item.dataset.estado
                });
            });
        });
    }
    
    selectDocument(documento) {
        this.selectedDocument = documento;
        this.input.value = documento.titulo;
        
        if (this.hiddenField) {
            this.hiddenField.value = documento.titulo;
        }
        
        if (this.selectedInfo) {
            const estadoClass = documento.estado === 'aprobado' ? 'estado-aprobado' : 
                               (documento.estado === 'pendiente' ? 'estado-pendiente' : 'estado-rechazado');
            const estadoTexto = documento.estado === 'aprobado' ? 'Aprobado' : 
                               (documento.estado === 'pendiente' ? 'En revisión' : 'Rechazado');
            
            this.selectedInfo.innerHTML = `
                <div class="documento-seleccionado">
                    <span>
                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        <strong>${this.escapeHTML(documento.titulo)}</strong>
                        <span class="documento-badge ${estadoClass}">${estadoTexto}</span>
                    </span>
                    <button type="button" class="documento-limpiar">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
            `;
            this.selectedInfo.style.display = 'block';
            
            this.selectedInfo.querySelector('.documento-limpiar').addEventListener('click', () => {
                this.clearSelection();
            });
        }
        
        this.hideSuggestions();
        
        if (this.config.onSelect && typeof this.config.onSelect === 'function') {
            this.config.onSelect(documento);
        }
    }
    
    clearSelection() {
        this.selectedDocument = null;
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
    
    getSelectedDocument() {
        return this.selectedDocument;
    }
}