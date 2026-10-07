<style>
    /* ===== VARIABLES LOCALES ===== */
    /* Usa las variables globales definidas en la página principal */
    
    /* ===== CONTENEDOR PRINCIPAL DEL CONTROL DE VOLUMEN ===== */
    /* Versión compacta para el chatbot */
    .volume-container {
        display: inline-flex;
        align-items: center;
        gap: 6px;                       /* Reducido de 12px a 6px */
        background: rgba(0, 51, 102, 0.05);
        padding: 4px 10px;               /* Reducido de 8px 18px a 4px 10px */
        border-radius: 30px;             /* Un poco más pequeño */
        backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        
        /* ===== RESPONSIVE ===== */
        max-width: 100%;
        min-height: 32px;                 /* Reducido de 45px a 32px */
    }

    /* ===== ICONO Y TEXTO DEL VOLUMEN ===== */
    #vol-icon, #vol-value { 
        color: var(--bpez-dark-blue); 
        font-size: 0.75rem;               /* Reducido de 0.85rem a 0.75rem */
        font-weight: 600;                  /* Un poco menos grueso */
        white-space: nowrap;
        display: inline-block;
        min-width: 35px;                   /* Reducido de 45px a 35px */
        text-align: right;
    }

    /* ===== SLIDER PERSONALIZADO - MÁS PEQUEÑO ===== */
    #volume-slider {
        appearance: none; 
        -webkit-appearance: none;
        width: 60px;                       /* Reducido de 100px a 60px */
        height: 4px;                        /* Reducido de 6px a 4px */
        background: rgba(0, 51, 102, 0.1);
        border-radius: 10px;
        outline: none;
        cursor: pointer;
        accent-color: var(--bpez-rojo-fuego);
        
        /* ===== RESPONSIVE ===== */
        min-width: 50px;                   /* Reducido de 60px a 50px */
        flex: 1;
    }

    /* ===== THUMB MÁS PEQUEÑO (la bolita que se arrastra) ===== */
    #volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 12px;                        /* Reducido de 16px a 12px */
        height: 12px;                        /* Reducido de 16px a 12px */
        border-radius: 50%;
        background: var(--bpez-rojo-fuego);
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(206, 32, 41, 0.3);
        transition: transform 0.2s;
    }

    #volume-slider::-webkit-slider-thumb:hover {
        transform: scale(1.1);               /* Hover más suave */
    }

    /* ===== THUMB PARA FIREFOX ===== */
    #volume-slider::-moz-range-thumb {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--bpez-rojo-fuego);
        cursor: pointer;
        border: none;
        box-shadow: 0 2px 4px rgba(206, 32, 41, 0.3);
        transition: transform 0.2s;
    }

    #volume-slider::-moz-range-thumb:hover {
        transform: scale(1.1);
    }

    /* ===== TRACK PARA FIREFOX ===== */
    #volume-slider::-moz-range-track {
        width: 100%;
        height: 4px;
        background: rgba(0, 51, 102, 0.1);
        border-radius: 10px;
    }

    /* ===== RESPONSIVE PARA MÓVILES ===== */
    @media (max-width: 576px) {
        .volume-container {
            gap: 4px;
            padding: 3px 8px;
            min-height: 28px;
        }
        
        #vol-icon, #vol-value {
            font-size: 0.7rem;
            min-width: 30px;
        }
        
        #volume-slider {
            min-width: 40px;
            width: 50px;
        }
        
        /* Ajuste para pantallas muy pequeñas */
        @media (max-width: 380px) {
            .volume-container {
                gap: 3px;
                padding: 2px 6px;
            }
            
            #volume-slider {
                min-width: 35px;
            }
            
            #vol-icon, #vol-value {
                min-width: 25px;
                font-size: 0.65rem;
            }
        }
    }

    /* ===== RESPONSIVE PARA TABLETS ===== */
    @media (min-width: 577px) and (max-width: 992px) {
        .volume-container {
            padding: 4px 12px;
            gap: 5px;
        }
        
        #volume-slider {
            width: 55px;
        }
    }

    /* ===== RESPONSIVE PARA PANTALLAS GRANDES ===== */
    @media (min-width: 1400px) {
        .volume-container {
            padding: 5px 14px;
            gap: 8px;
        }
        
        #vol-icon, #vol-value {
            font-size: 0.85rem;
        }
        
        #volume-slider {
            width: 70px;                       /* Un poco más grande en TV */
            height: 5px;
        }
        
        #volume-slider::-webkit-slider-thumb {
            width: 14px;
            height: 14px;
        }
        
        #volume-slider::-moz-range-thumb {
            width: 14px;
            height: 14px;
        }
    }

    /* ===== ESTILO COMPACTO PARA EL CHATBOT (si se necesita aún más pequeño) ===== */
    .volume-container.chatbot-compact {
        gap: 4px;
        padding: 2px 8px;
        min-height: 26px;
    }
    
    .volume-container.chatbot-compact #vol-icon,
    .volume-container.chatbot-compact #vol-value {
        font-size: 0.65rem;
        min-width: 28px;
    }
    
    .volume-container.chatbot-compact #volume-slider {
        width: 45px;
        min-width: 40px;
    }
</style>

<!-- ===== CONTROL DE VOLUMEN ===== -->
<!-- Componente reutilizable para ajustar el volumen de la IA -->
<div class="volume-container">
    <!-- Ícono dinámico que cambia según el nivel de volumen -->
    <i class="fas fa-volume-down" id="vol-icon"></i>
    
    <!-- Slider de volumen - input range personalizado (más pequeño) -->
    <input type="range" id="volume-slider" min="0" max="100" step="1" value="50">
    
    <!-- Visualización del porcentaje actual -->
    <span id="vol-value">50%</span>
</div>

<!-- ===== JAVASCRIPT DEL CONTROL DE VOLUMEN ===== -->
<script>
(function() {
    // ===== REFERENCIAS A ELEMENTOS DEL DOM =====
    const slider = document.getElementById('volume-slider');
    const volValue = document.getElementById('vol-value');
    const volIcon = document.getElementById('vol-icon');

    // ===== FUNCIÓN PRINCIPAL: SINCRONIZAR VOLUMEN =====
    const sincronizarVolumen = (val) => {
        localStorage.setItem('globalVolume', val);
        window.currentVolumeIA = parseFloat(val) / 100;
        
        if(volValue) volValue.innerText = val + '%';
        
        if(volIcon) {
            if(val == 0) {
                volIcon.className = "fas fa-volume-mute";
            } else if(val < 50) {
                volIcon.className = "fas fa-volume-down";
            } else {
                volIcon.className = "fas fa-volume-up";
            }
        }
    };

    // ===== INICIALIZACIÓN =====
    const inicial = localStorage.getItem('globalVolume') || 50;
    slider.value = inicial;
    sincronizarVolumen(inicial);

    // ===== EVENTO INPUT DEL SLIDER =====
    slider.addEventListener('input', (e) => {
        const val = e.target.value;
        sincronizarVolumen(val);
        window.dispatchEvent(new CustomEvent('volumenRealTime', { 
            detail: parseFloat(val) / 100 
        }));
    });

    // ===== EVENTO PARA DETECTAR CAMBIOS DESDE OTROS SCRIPTS =====
    window.addEventListener('setVolumen', (e) => {
        const nuevoValor = e.detail * 100;
        slider.value = nuevoValor;
        sincronizarVolumen(nuevoValor);
    });
})();
</script>