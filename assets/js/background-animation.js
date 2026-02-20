// assets/js/background-animation.js
const canvas = document.createElement('canvas');
const ctx = canvas.getContext('2d');
document.body.appendChild(canvas);

canvas.style.position = 'fixed';
canvas.style.top = '0';
canvas.style.left = '0';
canvas.style.width = '100%';
canvas.style.height = '100%';
canvas.style.zIndex = '-1'; 
canvas.style.pointerEvents = 'none';

let items = [];
// Mazo de iconos: El libro (\uf02d) aparece 3 veces para que salga con más frecuencia
const libraryIcons = [
    '\uf02d', '\uf02d', '\uf02d', // Libros (Alta frecuencia)
    '\uf5da', '\uf5da',           // Set de libros
    '\uf15c',                     // Documento
    '\uf303'                      // Pluma/Escritura
]; 

function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

window.addEventListener('resize', resize);
resize();

class LibraryItem {
    constructor() {
        this.init();
    }

    init() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 25 + 20; // Iconos un poco más grandes
        this.speedX = Math.random() * 0.4 - 0.2;
        this.speedY = Math.random() * 0.4 - 0.2;
        this.rotation = Math.random() * Math.PI * 2;
        this.rotationSpeed = Math.random() * 0.008 - 0.004;
        this.icon = libraryIcons[Math.floor(Math.random() * libraryIcons.length)];
        this.opacity = Math.random() * 0.15 + 0.05; 
    }

    update() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.rotation += this.rotationSpeed;

        if (this.x > canvas.width + 50) this.x = -50;
        if (this.x < -50) this.x = canvas.width + 50;
        if (this.y > canvas.height + 50) this.y = -50;
        if (this.y < -50) this.y = canvas.height + 50;
    }

    draw() {
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation);
        // "900" es necesario para Font Awesome 6 Solid/Free
        ctx.font = `900 ${this.size}px "Font Awesome 6 Free"`;
        ctx.fillStyle = `rgba(0, 51, 102, ${this.opacity})`;
        ctx.fillText(this.icon, 0, 0);
        ctx.restore();
    }
}

function init() {
    items = [];
    for (let i = 0; i < 50; i++) { // Aumentado a 50 elementos
        items.push(new LibraryItem());
    }
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    items.forEach(item => {
        item.update();
        item.draw();
    });
    requestAnimationFrame(animate);
}

// Carga instantánea: Forzamos la carga de la fuente antes de iniciar
document.fonts.load('10pt "Font Awesome 6 Free"').then(() => {
    init();
    animate();
});

// Por si acaso el método de arriba falla en algún navegador, iniciamos igual
if (items.length === 0) {
    init();
    animate();
}