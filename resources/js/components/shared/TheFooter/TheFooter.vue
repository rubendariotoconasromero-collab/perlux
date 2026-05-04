<template>
  <footer class="text-center border-top">
    
    <div class="footer-section">
      <p class="siguenos">Síguenos en <span> <br>NUESTRAS REDES</span></p>

      <div class="d-flex flex-column align-items-center mb-3">
        <a href="https://www.facebook.com/profile.php?id=100049130269760" target="_blank" class="mb-2">
          <img src="images/site/svg/facebook.svg" alt="Facebook" class="social-icon" loading="lazy">
        </a>
        <div class="website-badge">
          perluxbyjd.com
        </div>
      </div>
    </div>

    <div class="container bg-white py-5">
      <div class="row content-footer">
        
        <div class="col-lg-3 col-md-4 mb-4 text-center">
          <div class="footer-brand">
            <img src="images/site/resources/jessica_davila.svg" alt="Perlux by Jessica Davila">
          </div>
        </div>

        <div class="col-lg-2 col-12 mb-0 mb-lg-4 text-center text-lg-start">
          <h5 class="footer-title d-flex justify-content-between align-items-center py-3 py-lg-0 m-0" @click="toggleSection('nav')">
            Navegación
            <span class="d-lg-none toggle-icon">{{ openSections.nav ? '−' : '+' }}</span>
          </h5>
          <ul class="list-unstyled footer-links accordion-content" :class="{ 'show': openSections.nav }">
            <li><a href="/" class="footer-link">Inicio</a></li>
            <li><a href="/glam" class="footer-link">Glam</a></li>
            <li><a href="/novias" class="footer-link">Novias</a></li>
            <li><a href="/nosotros" class="footer-link">Nosotros</a></li>
            <li><a href="/user" class="footer-link">Usuario</a></li>
            <li><a href="#" class="footer-link">Carrito de Compras</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-12 mb-0 mb-lg-4 text-center text-lg-start">
          <h5 class="footer-title d-flex justify-content-between align-items-center py-3 py-lg-0 m-0" @click="toggleSection('business')">
            Mi Negocio
            <span class="d-lg-none toggle-icon">{{ openSections.business ? '−' : '+' }}</span>
          </h5>
          <ul class="list-unstyled footer-links accordion-content" :class="{ 'show': openSections.business }">
            <li><a href="/libro-reclamaciones" class="footer-link">Libro de reclamaciones</a></li>
            <li><a href="/informacion?section=terminos" class="footer-link">Términos y condiciones</a></li>
            <li><a href="/informacion?section=envios" class="footer-link">Tiempos de envío</a></li>
            <li><a href="/informacion?section=privacidad" class="footer-link">Políticas de privacidad</a></li>
            <li><a href="/informacion?section=cambios" class="footer-link">Cambios y devoluciones</a></li>
            <li><a href="/informacion?section=certificado" class="footer-link">Certificado de autenticidad</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-12 mb-0 mb-lg-4 text-center text-lg-start">
          <h5 class="footer-title d-flex justify-content-between align-items-center py-3 py-lg-0 m-0" @click="toggleSection('contact')">
            Contacto
            <span class="d-lg-none toggle-icon">{{ openSections.contact ? '−' : '+' }}</span>
          </h5>
          <ul class="list-unstyled footer-contact accordion-content" :class="{ 'show': openSections.contact }">
            <li>
              <a href="mailto:contacto@perluxbyjd.com" class="footer-link">Correo: contacto@perluxbyjd.com</a>
            </li>
            <li>
              <a href="tel:+51991348833" class="footer-link">Teléfono: +51 920 775 278</a>
            </li>
          </ul>
        </div>

        <div class="col-lg-2 col-12 mb-0 mb-lg-4 text-center text-lg-start">
          <h5 class="footer-title d-flex justify-content-between align-items-center py-3 py-lg-0 m-0" @click="toggleSection('social')">
            Nuestras Redes
            <span class="d-lg-none toggle-icon">{{ openSections.social ? '−' : '+' }}</span>
          </h5>
          <div class="social-links d-flex justify-content-center justify-content-lg-start accordion-content" :class="{ 'show': openSections.social }">
            <a href="https://www.facebook.com/profile.php?id=100049130269760" class="social-link me-3" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <a class="whatsapp-float" 
       href="https://wa.me/51920775278?text=Hola%20Perlux,%20quisiera%20más%20información" 
       target="_blank">
      <img src="images/site/whatsapp.webp" alt="WhatsApp" class="float-icon" loading="lazy">
    </a>

    <a class="arrow-top" href="#top">
      <i class="fas fa-arrow-up float-icon text-secondary"></i>
    </a>
  </footer>
</template>

<script>
export default {
  name: "TheFooter",
  data() {
    return {
      openSections: {
        nav: false,
        business: false,
        contact: false,
        social: false
      }
    };
  },
  methods: {
    toggleSection(section) {
      if (window.innerWidth < 992) {
        this.openSections[section] = !this.openSections[section];
      }
    }
  }
};
</script>

<style scoped>
/* FOOTER GENERAL */
footer {
  background: #fff;
  font-family: 'Helvetica Neue', Arial, sans-serif;
}

/* BARRA AZUL SUPERIOR (Ahora Beige Suave) */
.footer-section {
  background-color: #e1deda;
  padding-top: 5rem;
  padding-bottom: 5rem;
}

.footer-section .siguenos {
  color: #1a1a1a;
  font-size: 2.2rem;
  line-height: 1.1;
  margin-bottom: 2rem;
}

.footer-section span {
  color: #1a1a1a;
  font-size: 2.8rem;
  font-weight: 700;
}

.social-icon {
  width: 55px;
  height: 55px;
  object-fit: contain;
  transition: transform 0.3s ease;
  filter: brightness(0); /* Negro por defecto sobre fondo claro */
}

.website-badge {
  display: inline-block;
  padding: 4px 20px;
  background-color: #e1deda;
  border: 1px solid #000;
  border-radius: 20px;
  color: #000;
  font-size: 1rem;
  font-weight: 500;
  letter-spacing: 1px;
}

/* Hover Gris en Iconos Barra Azul */
.footer-section a:hover .social-icon {
  transform: scale(1.1);
  filter: brightness(0) saturate(100%) invert(56%) sepia(0%) saturate(0%) hue-rotate(198deg) brightness(91%) contrast(93%) !important;
}

/* CONTENIDO BLANCO */
.footer-brand img {
  max-width: 180px;
  height: auto;
  margin-bottom: 20px;
}

.footer-title {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: #000;
}

.footer-link {
  color: #555;
  text-decoration: none;
  font-size: 0.95rem;
  transition: color 0.3s;
}

.footer-link:hover {
  color: #000;
  text-decoration: underline;
}

.list-unstyled li {
  margin-bottom: 10px;
}

/* REDES SOCIALES (Iconos redondos negros) */
.social-link {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 35px;
  height: 35px;
  background-color: #000;
  color: #fff !important;
  border-radius: 50%;
  font-size: 1rem;
  transition: transform 0.3s, background 0.3s;
  text-decoration: none;
}

.social-link:hover {
  transform: translateY(-3px);
  background-color: #333;
}

/* BOTONES FLOTANTES */
.whatsapp-float {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  z-index: 1000;
  transition: transform 0.3s;
}

.whatsapp-float:hover {
  transform: scale(1.1);
}

.float-icon {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.arrow-top {
  position: fixed;
  bottom: 100px;
  right: 40px;
  width: 45px;
  height: auto;
  font-size: 1.5rem;
  z-index: 999;
  text-decoration: none;
  color: #aaa;
  transition: transform 0.3s;
  display: flex;
  justify-content: center;
}

.arrow-top:hover {
  transform: translateY(-5px);
  color: #333;
}

.arrow-top i {
  font-size: 1.5rem;
}

/* ACCORDION MOBILE */
.toggle-icon {
  font-size: 1.2rem;
  font-weight: 300;
  color: #555;
}

.accordion-content {
  overflow: hidden;
  transition: max-height 0.4s ease, opacity 0.3s ease, margin 0.3s ease;
}

/* RESPONSIVE */
@media (max-width: 991.98px) {
  .accordion-content {
    max-height: 0;
    opacity: 0;
    margin: 0 !important;
  }

  .accordion-content.show {
    max-height: 500px;
    opacity: 1;
    margin-bottom: 2rem !important;
    padding-top: 0.5rem;
  }

  .footer-title {
    cursor: pointer;
    user-select: none;
    font-size: 1rem;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .social-links, .text-lg-start {
    text-align: left !important;
    justify-content: flex-start !important;
  }

  .footer-title {
    text-align: left !important;
    justify-content: space-between !important;
    width: 100%;
  }
}

@media (max-width: 768px) {
  .footer-section {
    padding-top: 3rem;
    padding-bottom: 3rem;
  }
  .footer-section span {
    font-size: 2rem;
  }
  .whatsapp-float {
    width: 50px;
    height: 50px;
    bottom: 20px;
    right: 20px;
  }
  .arrow-top {
    bottom: 80px;
    right: 28px;
    font-size: 1.2rem;
  }
}
</style>