/**
 * background-animation.js
 * Animación de fondo con iconos de biblioteca flotantes
 * Versión CORREGIDA - Los iconos siempre se reposicionan correctamente
 */

// ===== CREAR EL ELEMENTO CANVAS =====
const canvas = document.createElement('canvas');
const ctx = canvas.getContext('2d');
document.body.appendChild(canvas);

// ===== ESTILOS DEL CANVAS =====
canvas.style.position = 'fixed';
canvas.style.top = '0';
canvas.style.left = '0';
canvas.style.width = '100%';
canvas.style.height = '100%';
canvas.style.zIndex = '-1'; 
canvas.style.pointerEvents = 'none';

// ===== VARIABLES GLOBALES =====
let items = [];
let fuenteCargada = false;
let animationFrame;

// ===== MAZO DE ICONOS DE BIBLIOTECA =====
const libraryIcons = [
    '\uf02d', '\uf02d', '\uf02d', // Libros (f02d) - Alta frecuencia
    '\uf5da', '\uf5da',           // Set de libros (f5da)
    '\uf15c',                     // Documento (f15c)
    '\uf304'                      // Pen (f304)
]; 

// ===== FUNCIÓN PRINCIPAL DE REDIMENSIONAMIENTO =====
function resize() {
    // Guardar el tamaño anterior
    const oldWidth = canvas.width;
    const oldHeight = canvas.height;
    
    // Establecer nuevo tamaño
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    // Si ya hay elementos, ajustar sus posiciones proporcionalmente
    if (items.length > 0 && oldWidth > 0 && oldHeight > 0) {
        const widthRatio = canvas.width / oldWidth;
        const heightRatio = canvas.height / oldHeight;
        
        items.forEach(item => {
            // Reposicionar proporcionalmente para que no se queden atorados
            item.x = item.x * widthRatio;
            item.y = item.y * heightRatio;
            
            // Asegurar que no se salgan completamente del canvas
            item.x = Math.max(-50, Math.min(canvas.width + 50, item.x));
            item.y = Math.max(-50, Math.min(canvas.height + 50, item.y));
        });
    }
}

// ===== LISTENER PARA REDIMENSIONAMIENTO =====
window.addEventListener('resize', () => {
    // Usar requestAnimationFrame para optimizar el rendimiento
    if (animationFrame) {
        cancelAnimationFrame(animationFrame);
    }
    animationFrame = requestAnimationFrame(() => {
        resize();
    });
});

// Llamar una vez al inicio
resize();

// ===== CLASE PARA LOS ICONOS FLOTANTES =====
class LibraryItem {
    constructor() {
        this.init();
    }

    init() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 25 + 20;
        this.speedX = Math.random() * 0.4 - 0.2;
        this.speedY = Math.random() * 0.4 - 0.2;
        this.rotation = Math.random() * Math.PI * 2;
        this.rotationSpeed = Math.random() * 0.008 - 0.004;
        this.icon = libraryIcons[Math.floor(Math.random() * libraryIcons.length)];
        this.opacity = Math.random() * 0.15 + 0.05;
        
        // Detectar qué nombre de fuente usar
        this.fontFamily = this.detectarFuente();
    }
    
    detectarFuente() {
        const posiblesFuentes = [
            'Font Awesome 7 Free',
            'Font Awesome 6 Free',
            'Font Awesome 5 Free',
            'FontAwesome'
        ];
        
        if (fuenteCargada) return fuenteCargada;
        
        for (let fuente of posiblesFuentes) {
            const testCanvas = document.createElement('canvas');
            const testCtx = testCanvas.getContext('2d');
            testCtx.font = `900 20px "${fuente}"`;
            
            if (testCtx.font.includes(fuente) || testCtx.font.includes('Font Awesome')) {
                console.log(`✅ Usando fuente: ${fuente}`);
                fuenteCargada = fuente;
                return fuente;
            }
        }
        
        return 'Font Awesome 7 Free';
    }

    update() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.rotation += this.rotationSpeed;

        // Rebote suave en los bordes en lugar de desaparecer
        if (this.x > canvas.width + 50) {
            this.x = canvas.width + 50;
            this.speedX *= -0.8; // Rebote con pérdida de velocidad
        }
        if (this.x < -50) {
            this.x = -50;
            this.speedX *= -0.8;
        }
        if (this.y > canvas.height + 50) {
            this.y = canvas.height + 50;
            this.speedY *= -0.8;
        }
        if (this.y < -50) {
            this.y = -50;
            this.speedY *= -0.8;
        }
    }

    draw() {
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation);
        
        ctx.font = `900 ${this.size}px "${this.fontFamily}"`;
        ctx.fillStyle = `rgba(0, 51, 102, ${this.opacity})`;
        ctx.fillText(this.icon, 0, 0);
        ctx.restore();
    }
}

// ===== INICIALIZAR LOS ICONOS =====
function init() {
    items = [];
    for (let i = 0; i < 50; i++) {
        items.push(new LibraryItem());
    }
}

// ===== BUCLE DE ANIMACIÓN =====
function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    items.forEach(item => {
        item.update();
        item.draw();
    });
    requestAnimationFrame(animate);
}

// ===== CARGAR LA FUENTE ANTES DE INICIAR =====
function iniciarAnimacion() {
    init();
    animate();
}

document.fonts.load('900 20px "Font Awesome 7 Free"')
    .then(() => {
        console.log('✅ Fuente Font Awesome 7 Free cargada correctamente');
        fuenteCargada = 'Font Awesome 7 Free';
        iniciarAnimacion();
    })
    .catch(() => {
        document.fonts.load('900 20px "Font Awesome 6 Free"')
            .then(() => {
                console.log('✅ Usando Font Awesome 6 Free como fallback');
                fuenteCargada = 'Font Awesome 6 Free';
                iniciarAnimacion();
            })
            .catch(() => {
                console.warn('⚠️ No se pudo cargar la fuente, iniciando de todas formas');
                iniciarAnimacion();
            });
    });

setTimeout(() => {
    if (items.length === 0) {
        console.log('⚠️ Usando método fallback para iniciar');
        iniciarAnimacion();
    }
}, 1000);