<style>
    .volume-container {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: rgba(0, 51, 102, 0.05);
        padding: 8px 18px;
        border-radius: 50px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    #vol-icon, #vol-value { color: var(--bpez-dark-blue); font-size: 0.85rem; font-weight: 700; }
    #volume-slider {
        appearance: none; 
        -webkit-appearance: none;
        width: 100px;
        height: 6px;
        background: rgba(0, 51, 102, 0.1);
        border-radius: 10px;
        outline: none;
        cursor: pointer;
        accent-color: var(--bpez-rojo-fuego); 
    }
</style>

<div class="volume-container">
    <i class="fas fa-volume-down" id="vol-icon"></i>
    <input type="range" id="volume-slider" min="0" max="100" step="1" value="50">
    <span id="vol-value">50%</span>
</div>

<script>
(function() {
    const slider = document.getElementById('volume-slider');
    const volValue = document.getElementById('vol-value');
    const volIcon = document.getElementById('vol-icon');

    const sincronizarVolumen = (val) => {
        // Guardamos en el navegador y en una propiedad global
        localStorage.setItem('globalVolume', val);
        window.currentVolumeIA = parseFloat(val) / 100; // Escala 0.0 a 1.0
        
        // Actualizar Interfaz
        if(volValue) volValue.innerText = val + '%';
        if(volIcon) {
            if(val == 0) volIcon.className = "fas fa-volume-mute";
            else if(val < 50) volIcon.className = "fas fa-volume-down";
            else volIcon.className = "fas fa-volume-up";
        }
    };

    // Al cargar, recuperar lo guardado
    const inicial = localStorage.getItem('globalVolume') || 50;
    slider.value = inicial;
    sincronizarVolumen(inicial);

    slider.addEventListener('input', (e) => {
    const val = e.target.value;
    sincronizarVolumen(val);

    // Emitimos un evento personalizado para cambios en tiempo real
    window.dispatchEvent(new CustomEvent('volumenRealTime', { detail: parseFloat(val) / 100 }));
    });
})();
</script>