/**
 * BPEZ IA - Lógica de Voz Global y Control de Volumen
 */

let mensajeActual = null;
let frasesGlobal = [];
let indiceActualGlobal = 0;

// Función Principal para hablar
function hablar(texto) {
    window.speechSynthesis.cancel();
    // Segmentamos por pausas naturales
    frasesGlobal = texto.replace(/[*#_]/g, '').split(/[.,;:]/);
    indiceActualGlobal = 0;
    ejecutarLocucion();
}

function ejecutarLocucion() {
    if (indiceActualGlobal < frasesGlobal.length) {
        const textoFrase = frasesGlobal[indiceActualGlobal].trim();
        if (textoFrase.length > 0) {
            mensajeActual = new SpeechSynthesisUtterance(textoFrase);
            mensajeActual.lang = 'es-ES';
            
            // Prioridad: 1. Variable global del slider | 2. LocalStorage | 3. Default 0.5
            const volGuardado = localStorage.getItem('globalVolume') ? parseFloat(localStorage.getItem('globalVolume')) / 100 : 0.5;
            mensajeActual.volume = window.currentVolumeIA !== undefined ? window.currentVolumeIA : volGuardado;

            mensajeActual.onend = () => {
                indiceActualGlobal++;
                ejecutarLocucion();
            };
            window.speechSynthesis.speak(mensajeActual);
        } else {
            indiceActualGlobal++;
            ejecutarLocucion();
        }
    }
}

function detenerVoz() { 
    window.speechSynthesis.cancel();
    indiceActualGlobal = frasesGlobal.length; 
}

// Escuchador para cambios del slider en tiempo real
window.addEventListener('volumenRealTime', (e) => {
    if (window.speechSynthesis.speaking) {
        window.speechSynthesis.cancel();
        setTimeout(() => {
            ejecutarLocucion();
        }, 10);
    }
});

// Detener voz si el usuario cambia de página o cierra la pestaña
window.addEventListener('beforeunload', () => { window.speechSynthesis.cancel(); });