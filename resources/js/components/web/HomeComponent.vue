<template>
  <div>
    <TheHeader :user="user" />

    <div class="container-fluid p-0">

      <div class="first-section">
        <div class="slider-container">
          <div v-for="(slide, index) in slides" :key="slide.id || index" class="slide"
            :class="{ active: currentSlide === index }" :style="{ backgroundImage: `url(${slide.image})` }">
            <div class="section-new-woman position-absolute text-white">
              <h1 class="display-4">{{ slide.title }}</h1>
              <h3 class="lead" v-html="slide.subtitle"></h3>
              <a :href="slide.buttonLink" class="btn btn-lista" :class="slide.buttonClass">
                {{ slide.buttonText }}
              </a>
            </div>
          </div>
        </div>

        <div class="slider-dots">
          <span v-for="(slide, index) in slides" :key="index" class="dot" :class="{ active: currentSlide === index }"
            @click="goToSlide(index)">
          </span>
        </div>

        <button class="slider-arrow prev" @click="prevSlide">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15,18 9,12 15,6"></polyline>
          </svg>
        </button>
        <button class="slider-arrow next" @click="nextSlide">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9,18 15,12 9,6"></polyline>
          </svg>
        </button>
      </div>


      <div class="container-fluid second-section">
        <div class="row g-4 justify-content-center">
          <div class="col-lg-6 col-md-6 col-12">
            <div class="perlux-card perlux-card-start">
              <img src="images/site/images/zapato_home2.jpeg" alt="Perlux Boots" class="img-fondo">
              <div class="card-overlay">
                <img src="images/site/resources/glam_white.svg" alt="Glam" class="img-type">
                <a href="/glam" class="btn btn-perlux">VER MÁS</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-12">
            <div class="perlux-card perlux-card-end">
              <img src="images/site/images/second-section2.jpeg" alt="Perlux Novias" class="img-fondo">
              <div class="card-overlay">
                <img src="images/site/resources/novias_white.svg" alt="Novias" class="img-type">
                <a href="/novias" class="btn btn-perlux">VER MÁS</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="third-section">
        <div class="container">
          <div class="text-center my-5">
            <img src="images/site/resources/glam-plomo.svg" alt="Glam Logo" class="glam-home-image">
          </div>

          <div class="grid-layout">
            <div v-for="(producto, index) in productos" :key="producto.ProductID" class="grid-item">

              <div class="card product-card h-100 bg-transparent">
                <div class="card-body p-0 d-flex flex-column h-100">

                  <div class="product-image-container">
                    <a :href="'/detail_glam?product_id=' + producto.ProductID">
                      <img :src="producto.imagen" :alt="producto.nombre" class="product-image">
                    </a>
                  </div>
                  <div class="info-container flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="d-flex flex-column">
                        <h5 class="card-title product-name">{{ producto.nombre }}</h5>
                        <p class="card-text product-price">{{ producto.precio }}</p>
                      </div>
                      <button class="btn heart-btn-bottom" @click="toggleFavorite(producto)">
                        <i :class="producto.favorito ? 'fas fa-heart select-heart' : 'far fa-heart'"></i>
                      </button>
                    </div>
                  </div>

                  <div class="mt-auto">
                    <button class="btn btn-comprar w-100 mx-0" @click="comprar(producto)">
                      COMPRAR AHORA
                    </button>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

      <section class="products-section">
        <div class="container">
          <div class="text-center my-5">
            <img src="images/site/resources/novias-negro.svg" alt="Novias Logo" class="glam-home-image">
          </div>

          <div class="grid-layout">
            <div v-for="(producto, index) in productos_novias" :key="producto.ProductID" class="grid-item">

              <div class="card product-card h-100 bg-transparent">
                <div class="card-body p-0 d-flex flex-column h-100">

                  <div class="product-image-container">
                    <a :href="'/detail_novias?product_id=' + producto.ProductID">
                      <img :src="producto.imagen" :alt="producto.nombre" class="product-image">
                    </a>
                  </div>

                  <div class="info-container flex-grow-1 pt-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="d-flex flex-column">
                        <h5 class="card-title product-name">{{ producto.nombre }}</h5>
                        <p class="card-text product-price">{{ producto.precio }}</p>
                      </div>
                      <button class="btn heart-btn-bottom-novias" @click="toggleFavorite(producto)">
                        <i :class="producto.favorito ? 'fas fa-heart select-heart' : 'far fa-heart'"></i>
                      </button>
                    </div>
                  </div>

                  <div class="mt-auto">
                    <button class="btn btn-comprar-novias w-100 mx-0" @click="comprar(producto)">
                      COMPRAR AHORA
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>

    <TheFooter />
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header border-0">
            <button type="button" class="btn-close" @click="closeAuthModal"></button>
          </div>
          <div class="modal-body text-center p-5">
            <i class="far fa-heart fa-3x mb-3 text-muted"></i>
            <h4 class="mb-3">Guarda tus favoritos</h4>
            <p class="text-muted mb-4">Inicia sesión o regístrate para guardar productos en tu lista de deseos.</p>
            <div class="d-grid gap-2">
              <a href="/user" class="btn btn-dark">Iniciar Sesión</a>
              <a href="/register" class="btn btn-outline-dark">Crear Cuenta</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';

export default {
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
  data() {
    return {
      favorites: [],
      currentSlide: 0,
      slideInterval: null,
      slides: [
        {
          id: 1,
          image: "/images/site/slider/bg1.jpg",
          title: "",
          subtitle: "",
          buttonText: "Comprar ahora",
          buttonLink: "#",
          buttonClass: "btn-light"
        },
        {
          id: 2,
          image: "/images/site/slider/bg2.jpg",
          title: "",
          subtitle: "",
          buttonText: "Ver colección",
          buttonLink: "/glam",
          buttonClass: "btn-dark"
        },
        {
          id: 3,
          image: "/images/site/slider/bg3.jpg",
          title: "",
          subtitle: "",
          buttonText: "Descubrir",
          buttonLink: "/novias",
          buttonClass: "btn-dark"
        }
      ],
      productos: [],
      productos_novias: [],
      allProducts: [],
    };
  },
  methods: {
    closeAuthModal() { $('#authModal').modal('hide'); },
    async loadData() {
      try {
        const response = await axios.get('/load_data');
        const allProducts = (response.data.products || []).map(p => ({
          ...p,
          nombre: p.Name,
          precio: `S/${p.Price}`,
          imagen: p.images && p.images.length > 0 ? p.images[0].ImagePath : '/images/placeholder.jpg',
          favorito: false,
          ProductID: p.ProductID,
          Price: p.Price,
          Name: p.Name,
          images: p.images
        }));

        const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];
        allProducts.forEach(p => {
          p.favorito = savedFavorites.some(fav => fav.ProductID === p.ProductID);
        });
        this.productos = allProducts
          .filter(item => item.Tipo === 'Glam')
          .slice(0, 3);
        this.productos_novias = allProducts
          .filter(item => item.Tipo === 'Jeans Rat' || item.Tipo === 'Novias')
          .slice(0, 3);

        this.allProducts = allProducts;

      } catch (e) {
        console.error("Error cargando datos:", e);
      }
    },

    nextSlide() { this.currentSlide = (this.currentSlide + 1) % this.slides.length; },
    prevSlide() { this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1; },
    goToSlide(index) { this.currentSlide = index; },
    startSlideshow() { this.slideInterval = setInterval(() => { this.nextSlide(); }, 5000); },
    stopSlideshow() { if (this.slideInterval) clearInterval(this.slideInterval); },

    toggleFavorite(product) {
      if (!this.user) {
        $('#authModal').modal('show');
        return;
      }

      product.isFavorite = !product.isFavorite;
      this.updateFavorites(product);
    },

    updateFavorites(product) {
      product.favorito = !product.favorito;
      if (product.isFavorite) {
        // Agregar si no existe
        if (!this.favorites.some(f => f.ProductID === product.ProductID)) {
          this.favorites.push({ ...product });
        }
      } else {
        // Remover
        this.favorites = this.favorites.filter(fav => fav.ProductID !== product.ProductID);
      }
      localStorage.setItem('favorites', JSON.stringify(this.favorites));
    },

    comprar(product) {
      window.location.href = '/detail_glam?product_id=' + product.ProductID;
    }

  },
  mounted() {
    this.loadData();
    this.startSlideshow();
  },
  beforeDestroy() {
    this.stopSlideshow();
  }
};
</script>

<style scoped>
.grid-layout {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
  width: 100%;
}

.grid-item {
  width: 100%;
}

.info-container {
  padding: 15px 0 10px 0;
}

.first-section {
  height: 100vh;
  position: relative;
  overflow: hidden;
}

.slider-container {
  width: 100%;
  height: 100vh;
}

.slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background-size: cover;
  background-position: center;
  opacity: 0;
  transition: opacity 1s ease-in-out;
}

.slide.active {
  opacity: 1;
}

.slider-dots {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 12px;
  z-index: 10;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: rgba(90, 90, 90, 0.5);
  cursor: pointer;
  transition: all 0.3s;
}

.dot.active,
.dot:hover {
  background-color: #ffffff;
  transform: scale(1.2);
}

.slider-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  width: 50px;
  height: 50px;
  color: white;
  cursor: pointer;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
}

.slider-arrow:hover {
  color: #34618b;
}

.slider-arrow.prev {
  left: 30px;
}

.slider-arrow.next {
  right: 30px;
}

.first-section .section-new-woman {
  width: 100%;
  left: 0;
  padding-left: 100px;
  padding-right: 100px;
  top: 60%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  text-align: left;
}

.first-section .section-new-woman .btn-lista {
  align-self: center;
  margin-top: 10rem;
  border-radius: 0;
  padding: 10px 40px;
  font-weight: 600;
  font-size: 1.2rem;
  transition: all 0.3s ease;
}

.display-4 {
  font-size: 5rem;
  font-weight: 900;
  margin-bottom: 0 !important;
}

.lead {
  font-size: 2rem;
}

.second-section {
  padding: 5rem 10rem;
  overflow: hidden;
  background-color: #fff;
}

.perlux-card {
  position: relative;
  width: 100%;
  height: 550px;
  overflow: hidden;
  cursor: pointer;
  background-color: #fff;
  align-items: center;
  justify-content: center;
}

.img-fondo {
  height: 100%;
  width: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.6s ease-in-out;
}

.perlux-card:hover .img-fondo {
  transform: scale(1.05);
}

.card-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.perlux-card:hover .card-overlay {
  background: rgba(0, 0, 0, 0.2);
}

.img-type {
  width: 280px;
  height: auto;
  max-width: 80%;
  z-index: 2;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.btn-perlux {
  position: absolute;
  bottom: 70px;
  background-color: #ffffff;
  color: #333333;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 1px;
  padding: 12px 30px;
  border: 1px solid #ffffff;
  border-radius: 0;
  text-transform: uppercase;
  transition: all 0.3s ease;
  z-index: 2;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-perlux:hover {
  background-color: transparent;
  color: #ffffff;
  border-color: #ffffff;
}

.third-section {
  padding-top: 4rem;
  padding-bottom: 6rem;
  background-color: #e0d9d9;
}

.product-card {
  width: 90%;
  border: 0;
}

.glam-home-image {
  max-width: 200px;
  height: auto;
  margin-bottom: 1rem;
}

.product-image-container {
  background-color: #ffffff;
  width: 100%;
  height: 350px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.product-image {
  width: 100%;
  height: 350px;
  object-fit: cover;
  object-position: center;
  transition: transform 0.5s ease;
}

.product-card:hover .product-image {
  transform: scale(1.08);
}

.fondo-info-product {
  padding: 15px 0 0 0 !important;
}

.product-name {
  font-size: 1rem;
  font-weight: 700;
  color: #333;
  margin-bottom: 2px;
}

.product-price {
  font-size: 0.95rem;
  color: #555;
}

.heart-btn-bottom {
  padding: 0;
  border: none;
  background: transparent;
  font-size: 1.5rem;
  color: #444;
}

.third-section .select-heart {
  color: #ffffff;
}

.products-section .select-heart {
  color: #7eb2e6;
}


.third-section .heart-btn-bottom:hover {
  color: #fff;
}

.products-section .heart-btn-bottom:hover {
  color: #7eb2e6;
}

.btn-comprar {
  background-color: transparent;
  border: 1px solid #444;
  color: #333;
  border-radius: 0;
  font-size: 0.85rem;
  font-weight: 700;
  padding: 10px 0;
  text-transform: uppercase;
  margin-top: 10px;
  width: 100%;
  transition: all 0.3s ease;
}

.btn-comprar:hover {
  background-color: #fff;
  color: #333;
  border: 1px solid #fff;
}

.products-section {
  padding-top: 4rem;
  padding-bottom: 6rem;
  background-color: #f9f9f9;

}


.products-section .product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.products-section .product-card:hover .product-image {
  transform: scale(1.05);
}

.heart-btn-bottom-novias {
  padding: 0;
  border: none;
  background: transparent;
  font-size: 1.2rem;
  color: #888;
}

.heart-btn-bottom-novias:hover,
.heart-btn-bottom-novias i.fas {
  color: #7eb2e6 !important;
}

.btn-comprar-novias {
  background: transparent;
  border: 1px solid #333333;
  color: #333333;
  border-radius: 0;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 1px;
  padding: 12px 0;
  text-transform: uppercase;
  margin-top: 15px;
  width: 100%;
  transition: all 0.3s ease;
}

.btn-comprar-novias:hover {
  background-color: #7eb2e6;
  border-color: #7eb2e6;
  color: #ffffff;
  box-shadow: 0 4px 10px rgba(106, 140, 175, 0.3);
}


@media (max-width: 1400px) and (min-width: 993px) {
  .first-section .section-new-woman {
    top: 70%;
  }
}

@media (max-width: 991.98px) {
  .slider-arrow {
    width: 40px;
    height: 40px;
  }

  .slider-arrow.prev {
    left: 15px;
  }

  .slider-arrow.next {
    right: 15px;
  }

  .display-4 {
    font-size: 3rem;
  }

  .lead {
    font-size: 1rem;
  }

  .first-section .section-new-woman {
    padding-left: 50px;
    padding-right: 50px;
    top: 50%;
    transform: translateY(-50%);
  }

  .second-section {
    padding: 3rem 4rem;
  }
}

@media (max-width: 768px) {

  .first-section,
  .slider-container,
  .slide {
    height: 45vh;
    min-height: 400px;
  }

  .slide {
    background-position: top center;
  }

  .first-section .section-new-woman {
    padding-left: 20px;
    padding-right: 20px;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    align-items: center;
    text-align: center;
  }

  .first-section .section-new-woman .btn-lista {
    margin-top: 18rem;
    align-self: center;
  }

  .slider-dots {
    bottom: 20px;
  }

  .slider-arrow {
    display: none; /* Opcional: Ocultar flechas en móvil para limpiar la vista */
  }

  .second-section {
    padding: 2rem 1.5rem;
  }

  .third-section,
  .products-section {
    padding-top: 2rem;
    padding-bottom: 2rem;
  }

  .perlux-card {
    height: 400px;
  }

  .product-image-container {
    height: 350px;
  }

  .product-image {
    height: 100%;
  }

  .img-type {
    width: 180px;
  }

  .grid-layout {
    grid-template-columns: 1fr !important;
    gap: 30px;
  }


  .product-card {
    width: 100%;
    border: 0;
    margin: 0 auto;
  }
}

/* 4. MÓVILES PEQUEÑOS (Menos de 576px) */
@media (max-width: 576px) {
  .display-4 {
    font-size: 2.5rem;
  }

  .lead {
    font-size: 0.9rem;
  }

  .slider-dots {
    bottom: 15px;
  }

  .second-section {
    padding: 1rem;
  }

  /* Aseguramos 1 columna también aquí */
  .grid-layout {
    grid-template-columns: 1fr !important;
  }
}

@media (max-width: 992px) {
  .grid-layout {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
}
</style>