<style>
    footer { 
        background-color: var(--header-bg-integrado);
        color: var(--bpez-dark-blue);
        border-top: 1px solid rgba(0,0,0,0.1);
        padding: 10px 0; 
    }
    
    .footer-text { 
        font-size: 0.75rem; 
        color: var(--bpez-dark-blue); 
        font-weight: 600; 
    }
    
    /* Limpieza de enlaces y animación */
    footer a { 
        color: var(--bpez-dark-blue) !important; 
        font-size: 0.75rem; 
        text-decoration: none !important; /* Elimina el guion bajo (_) */
        display: inline-block; /* Permite que la animación de escala funcione bien */
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Animación al pasar el mouse por los iconos o enlaces */
    footer a:hover { 
        color: var(--bpez-rojo-fuego) !important; 
        transform: scale(1.2) translateY(-2px); /* Crece y sube un poco */
    }

    /* Efecto especial para los iconos de redes sociales */
    .social-icon:hover {
        transform: scale(1.3) rotate(8deg); /* Un toque de rotación dinámica */
    }
</style>

<footer class="py-3">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-md-5 footer-text mb-3 mb-md-0">
                <strong>Biblioteca Pública del Estado Zulia, "María Calcaño"</strong><br>
                © 2026 Todos los derechos reservados.
            </div>
            
            <div class="col-md-2 text-center mb-3 mb-md-0">
                <a href="https://www.instagram.com/bibliotecapublicadelzulia2025/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="me-3 social-icon" 
                   title="Visitar Instagram Oficial"><i class="fab fa-instagram fa-lg"></i></a>

                <a href="https://www.facebook.com/TU_PAGINA" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="me-3 social-icon" 
                   title="Visitar Facebook Oficial"><i class="fab fa-facebook fa-lg"></i></a>
                
                <a href="mailto:contacto@bibliotecapublicadelzulia.org" 
                   class="me-3 social-icon" 
                   title="Enviar Correo Electrónico"><i class="fas fa-envelope fa-lg"></i></a>
                
                <a href="https://www.bibliotecapublicadelzulia.org/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="social-icon" 
                   title="Visitar Web Oficial"><i class="fas fa-globe fa-lg"></i></a>
            </div>

            <div class="col-md-5 text-md-end footer-text">
                <a href="#" class="me-3">Privacidad</a>
                <a href="#">Condiciones</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>