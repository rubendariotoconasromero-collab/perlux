<template>
  <div>
    <TheHeader :user="user" />

    <section class="about-section">
      <div class="container">
        <div class="row align-items-center about-content">
          <div class="col-lg-7 mb-4 mb-lg-0 about-content-section">
            <h2 class="about-title">Sobre Nosotros: Lujo Peruano</h2>
            <p class="about-text">
              En Perlux, abreviatura de Peruvian Luxury, fusionamos la pasión por la belleza, el arte y el diseño con el compromiso inquebrantable de la excelencia. Nuestra marca nace de una visión: elevar los estándares de la moda peruana a un nivel comparable con las firmas de lujo más sofisticadas a nivel mundial.
            </p>
            <p class="about-text">
              Cada accesorio y cada insumo que utilizamos en la elaboración de nuestros productos reflejan una dedicación minuciosa y una atención impecable a cada detalle. Creemos firmemente que el verdadero lujo reside en la calidad, la artesanía y la capacidad de cada pieza para contar una historia.
            </p>
          </div>
    
          <div class="col-lg-5 about-content-image d-flex justify-content-center">
            <img src="/images/site/images/zapato_home4.jpeg" alt="Zapato de lujo Perlux con flor blanca" class="about-image img-fluid" loading="lazy" />
          </div>
        </div>
      </div>
    </section>

    <section class="vision-section">
      <div class="vision-overlay">
        <h2 class="vision-title">Nuestra Visión</h2>
        <p class="vision-text">
          Visualizamos un mundo donde el lujo peruano sea sinónimo de excelencia, autenticidad y sofisticación. Nos esforzamos por ser la vanguardia en el diseño y la producción de piezas que no solo adornen, sino que también inspiren y conecten profundamente con quienes valoran lo extraordinario. Nuestra ambición es trascender fronteras, llevando la esencia del arte y la maestría artesanal peruana a un escenario global.
        </p>
      </div>
    </section>

    <section class="mision-section">
      <div class="mision-overlay">
        <h2 class="mision-title">Nuestra Misión</h2>
        <p class="mision-text">
          En Perlux, nuestra misión es celebrar la belleza del lujo peruano creando piezas que conmuevan, inspiren y conecten.
          Cada diseño surge de una profunda pasión por el arte, la elegancia y la artesanía, concebido para aquellos que 
          aprecian lo excepcional en cada detalle.
        </p>
        <br>
        <p class="mision-text">
          Nos dedicamos a transformar materiales nobles en obras de sofisticación, rindiendo tributo al tiempo, el talento y la
          emoción inherentes en este proceso. Además, asumimos un compromiso vital: rescatar y preservar saberes 
          ancestrales de la industria del calzado peruano. Frente al avance del fast fashion, hemos tomado la responsabilidad de
          recuperar prácticas tradicionales, como el uso de suela en la planta, una técnica casi extinta. Trabajamos de la mano 
          con los pocos artesanos que aún dominan este arte, asegurando que este legado trascienda a las nuevas
          generaciones. Así, garantizamos un calzado 100% en cuero: duradero, auténtico y profundamente arraigado en 
          nuestra identidad cultural.
        </p>
      </div>
    </section>

    <section class="valores-section">
      <div class="valores-overlay">
        <h2 class="valores-title">Nuestros valores</h2>
        <p class="valores-text">
          En Perlux, nuestra misión es celebrar la belleza del lujo peruano creando piezas que conmuevan, inspiren y conecten.
          Cada diseño surge de una profunda pasión por el arte, la elegancia y la artesanía, concebido para aquellos que 
          aprecian lo excepcional en cada detalle.
        </p>
        <br>
        <p class="valores-text">
          Nos dedicamos a transformar materiales nobles en obras de sofisticación, rindiendo tributo al tiempo, el talento y la
          emoción inherentes en este proceso. Además, asumimos un compromiso vital: rescatar y preservar saberes 
          ancestrales de la industria del calzado peruano. Frente al avance del fast fashion, hemos tomado la responsabilidad de
          recuperar prácticas tradicionales, como el uso de suela en la planta, una técnica casi extinta. Trabajamos de la mano 
          con los pocos artesanos que aún dominan este arte, asegurando que este legado trascienda a las nuevas
          generaciones. Así, garantizamos un calzado 100% en cuero: duradero, auténtico y profundamente arraigado en 
          nuestra identidad cultural.
        </p>
      </div>
    </section>

    <section class="showroom-section">
      <h2 class="showroom-title">Visita nuestro showroom</h2>
      <p class="showroom-text">
        Nos encontramos en Surco, reserva una cita y descubre nuestros productos.
      </p>
      <a href="#" class="btn btn-reservar">Reservar</a>
    </section>

    <TheFooter />

  </div>
</template>

<script>
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';

export default {
  name: 'Nosotros',
  components: { 
    TheHeader, 
    TheFooter 
  },
  props: {
    user: {
      type: Object,
      required: false,
      default: null,
    }
  },
  // Como es una página estática/informativa, no necesitamos mucha lógica aquí.
  // El Header maneja su propio estado de carrito/favoritos internamente gracias a los eventos.
};
</script>

<style scoped>
/* =========================================
   SECCIÓN SOBRE NOSOTROS
   ========================================= */
.about-section {
  padding-top: 140px; /* Espacio para el header fixed */
  padding-bottom: 5rem;
  background-color: #f9f9f9;
}

.about-content .about-content-section {
  display: flex;
  justify-content: center;
  flex-direction: column;
}

.about-title {
  font-size: 1.8rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.about-text {
  font-size: 1.1rem;
  line-height: 1.6;
  color: #555;
  margin-bottom: 1.5rem;
  text-align: justify;
}

.about-image {
  border-radius: 0px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  max-height: 450px;
  width: 100%;
  object-fit: cover;
}

/* =========================================
   SECCIONES CON IMAGEN DE FONDO (Visión, Misión)
   ========================================= */
.vision-section, .mision-section, .valores-section {
  position: relative;
  min-height: 600px;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 4rem 1rem;
}

/* Fondos Específicos */
.vision-section {
  background-image: url('/images/site/resources/vision.jpg');
  color: white;
}

.mision-section {
  background-image: url('/images/site/resources/mision.jpg');
  color: white;
}

.valores-section {
  /* background-image: url('images/site/resources/valores.jpg'); */
  background-color: #fff; /* Fondo blanco según tu código original */
  color: #000;
}

/* Overlay Común */
.vision-overlay, .mision-overlay, .valores-overlay {
  padding: 3rem;
  border-radius: 0; /* Más elegante sin bordes redondeados en secciones full width */
  max-width: 900px;
  backdrop-filter: blur(5px); /* Efecto cristal */
  background-color: rgba(0, 0, 0, 0.4); /* Oscurecer fondo para leer texto blanco */
}

/* Ajuste específico para Valores (Fondo blanco) */
.valores-overlay {
  background-color: transparent; /* No oscurecer si el fondo es blanco */
  backdrop-filter: none;
}

/* Títulos */
.vision-title, .mision-title {
  font-size: 2.5rem;
  font-weight: 700;
  letter-spacing: 2px;
  margin-bottom: 2rem;
  text-transform: uppercase;
  color: white;
}

.valores-title {
  font-size: 2.5rem;
  font-weight: 700;
  letter-spacing: 2px;
  margin-bottom: 2rem;
  text-transform: uppercase;
  color: #000;
}

/* Textos */
.vision-text, .mision-text {
  font-size: 1.25rem;
  line-height: 1.6;
  color: #f8f9fa;
  font-weight: 300;
}

.valores-text {
  font-size: 1.25rem;
  line-height: 1.6;
  color: #333;
  font-weight: 300;
}

/* =========================================
   SHOWROOM
   ========================================= */
.showroom-section {
  background-color: rgb(67, 88, 116);
  text-align: center;
  padding: 6rem 2rem;
}

.showroom-title {
  font-size: 2.3rem;
  font-weight: 700;
  letter-spacing: 1px;
  margin-bottom: 1rem;
  text-transform: uppercase;
  color: #fff;
}

.showroom-text {
  font-size: 1.1rem;
  line-height: 1.6;
  margin-bottom: 2rem;
  opacity: 0.9;
  color: #fff;
}

.btn-reservar {
  background-color: transparent;
  border: 2px solid white;
  color: white;
  padding: 12px 40px;
  font-size: 1rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  transition: all 0.3s ease;
  border-radius: 0;
  min-width: 200px;
}

.btn-reservar:hover {
  background-color: #fff;
  color: rgb(67, 88, 116);
  transform: translateY(-2px);
}

/* =========================================
   RESPONSIVE
   ========================================= */
@media (max-width: 992px) {
  .about-section {
    padding-top: 120px;
  }
  
  .about-content {
    flex-direction: column-reverse; /* Imagen arriba en móvil si se desea, o normal */
  }

  .about-content-image {
    margin-bottom: 2rem;
  }

  .vision-title, .mision-title, .valores-title {
    font-size: 2rem;
  }
  
  .vision-overlay, .mision-overlay, .valores-overlay {
    padding: 1.5rem;
    max-width: 100%;
  }
}
</style>