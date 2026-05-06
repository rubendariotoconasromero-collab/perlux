<template>
  <div>
    <TheHeader :user="user" />

    <div class="container-fluid p-0">


      <!-- Sliders de Colecciones -->
      <!-- Glam Slider -->
      <div class="first-section">
        <div class="slider-container">
          <div v-for="(slide, index) in glamSlides" :key="'glam-'+index" class="slide"
            :class="{ active: currentGlamSlider === index }" :style="{ backgroundImage: `url(${slide.image})` }">
            <div class="section-new-woman position-absolute text-white">
              <a :href="slide.link" class="btn btn-lista btn-modern">
                VER COLECCIÓN
              </a>
            </div>
          </div>
        </div>
        <div class="slider-dots-modern">
          <span v-for="(slide, index) in glamSlides" :key="'glam-dot-'+index" class="dot-modern" :class="{ active: currentGlamSlider === index }"
            @click="currentGlamSlider = index">
          </span>
        </div>
      </div>

      <!-- Novias Slider -->
      <div class="first-section">
        <div class="slider-container">
          <div v-for="(slide, index) in noviasSlides" :key="'novias-'+index" class="slide"
            :class="{ active: currentNoviasSlider === index }" :style="{ backgroundImage: `url(${slide.image})` }">
            <div class="section-new-woman position-absolute text-white">
              <a :href="slide.link" class="btn btn-lista btn-modern">
                VER COLECCIÓN
              </a>
            </div>
          </div>
        </div>
        <div class="slider-dots-modern">
          <span v-for="(slide, index) in noviasSlides" :key="'novias-dot-'+index" class="dot-modern" :class="{ active: currentNoviasSlider === index }"
            @click="currentNoviasSlider = index">
          </span>
        </div>
      </div>

      <!-- Carteras Slider -->
      <div class="first-section">
        <div class="slider-container">
          <div v-for="(slide, index) in carterasSlides" :key="'carteras-'+index" class="slide"
            :class="{ active: currentCarterasSlider === index }" :style="{ backgroundImage: `url(${slide.image})` }">
            <div class="section-new-woman position-absolute text-white">
              <a :href="slide.link" class="btn btn-lista btn-modern">
                VER COLECCIÓN
              </a>
            </div>
          </div>
        </div>
        <div class="slider-dots-modern">
          <span v-for="(slide, index) in carterasSlides" :key="'carteras-dot-'+index" class="dot-modern" :class="{ active: currentCarterasSlider === index }"
            @click="currentCarterasSlider = index">
          </span>
        </div>
      </div>


      <!-- seccion de perlux glam -->
      <section class="third-section" :class="{'collection-slider-full': isMobile}">
        <div class="container h-100 p-0" :class="{'mw-100': isMobile}">
          <div class="text-center my-5" v-if="!isMobile">
            <img src="images/site/resources/glam-plomo.svg" alt="Glam Logo" class="glam-home-image">
          </div>

          <div class="grid-layout h-100" v-if="!isMobile">
            <div v-for="(producto, index) in productos" :key="producto.ProductID" class="grid-item">
              <div class="card product-card h-100 bg-transparent">
                <div class="card-body p-0 d-flex flex-column h-100">
                  <div class="product-image-container">
                    <a :href="'/detail_glam?product_id=' + producto.ProductID">
                      <img :src="producto.imagen" :alt="producto.nombre" class="product-image">
                    </a>
                  </div>
                  <div class="info-container flex-grow-1 pt-3">
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

          <!-- Slider para móvil Glam -->
          <div class="mobile-collection-slider h-100 w-100" v-else>
            <div v-for="(producto, index) in productos" :key="'glam-mob-'+index" 
                 class="mobile-product-slide" :class="{ active: currentGlamIndex === index }">
                 <a :href="'/detail_glam?product_id=' + producto.ProductID">
                    <img :src="producto.imagen" :alt="producto.nombre" class="full-screen-product-img">
                 </a>
                 <div class="collection-label">PERLUX GLAM</div>
                 <div class="mobile-buy-button-container">
                    <button class="btn btn-comprar w-100" @click="comprar(producto)">
                      COMPRAR AHORA
                    </button>
                 </div>
            </div>
          </div>
        </div>
      </section>

      <!-- seccion de perlux novias -->
      <section class="products-section" :class="{'collection-slider-full': isMobile}">
        <div class="container h-100 p-0" :class="{'mw-100': isMobile}">
          <div class="text-center my-5" v-if="!isMobile">
            <img src="images/site/resources/novias-negro.svg" alt="Novias Logo" class="glam-home-image">
          </div>

          <div class="grid-layout h-100" v-if="!isMobile">
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

          <!-- Slider para móvil Novias -->
          <div class="mobile-collection-slider h-100 w-100" v-else>
            <div v-for="(producto, index) in productos_novias" :key="'novias-mob-'+index" 
                 class="mobile-product-slide" :class="{ active: currentNoviasIndex === index }">
                 <a :href="'/detail_novias?product_id=' + producto.ProductID">
                    <img :src="producto.imagen" :alt="producto.nombre" class="full-screen-product-img">
                 </a>
                 <div class="collection-label">PERLUX NOVIAS</div>
                 <div class="mobile-buy-button-container">
                    <button class="btn btn-comprar-novias w-100" @click="comprar(producto)">
                      COMPRAR AHORA
                    </button>
                 </div>
            </div>
          </div>
        </div>
      </section>

      <!-- seccion de perlux carteras -->
      <section class="third-section" :class="{'collection-slider-full': isMobile}">
        <div class="container h-100 p-0" :class="{'mw-100': isMobile}">
          <div class="text-center my-5" v-if="!isMobile">
            <h2 class="display-6 font-weight-bold" style="letter-spacing: 5px; color: black; text-transform: uppercase;">PERLUX CARTERAS</h2>
          </div>

          <div class="grid-layout h-100" v-if="!isMobile">
            <div v-for="(producto, index) in productos_carteras" :key="producto.ProductID" class="grid-item">
              <div class="card product-card h-100 bg-transparent">
                <div class="card-body p-0 d-flex flex-column h-100">
                  <div class="product-image-container">
                    <a :href="'/detail_glam?product_id=' + producto.ProductID">
                      <img :src="producto.imagen" :alt="producto.nombre" class="product-image">
                    </a>
                  </div>
                  <div class="info-container flex-grow-1 pt-3">
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

          <!-- Slider para móvil Carteras -->
          <div class="mobile-collection-slider h-100 w-100" v-else>
            <div v-for="(producto, index) in productos_carteras" :key="'carteras-mob-'+index" 
                 class="mobile-product-slide" :class="{ active: currentCarterasIndex === index }">
                 <a :href="'/detail_glam?product_id=' + producto.ProductID">
                    <img :src="producto.imagen" :alt="producto.nombre" class="full-screen-product-img">
                 </a>
                 <div class="collection-label">PERLUX CARTERAS</div>
                 <div class="mobile-buy-button-container">
                    <button class="btn btn-comprar w-100" @click="comprar(producto)">
                      COMPRAR AHORA
                    </button>
                 </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Nueva Sección Lujo Peruano Brand Showcase - Rediseño Profesional -->
      <section class="brand-showcase-v2" v-if="!isMobile">
        <div class="showcase-container">
          <div class="showcase-text-content">
            <div class="showcase-header">
              <span class="showcase-subtitle">PASIÓN POR EL DETALLE</span>
              <h2 class="showcase-title">LUJO PERUANO <br> HECHO ARTE</h2>
            </div>
            <div class="showcase-body">
              <p class="showcase-manifesto">
                En PERLUX glam, la belleza y el arte convergen en un diseño de autor. Elevamos materiales nobles a su máxima expresión de elegancia, creando piezas atemporales destinadas a perdurar.
              </p>
              <div class="showcase-controls">
                <div class="slider-numbers">
                  <span class="current">0{{ currentBrandSlide + 1 }}</span>
                  <span class="divider">/</span>
                  <span class="total">0{{ brandImages.length }}</span>
                </div>
                <div class="slider-progress-container">
                  <div class="slider-progress-bar" :style="{ width: ((currentBrandSlide + 1) / brandImages.length * 100) + '%' }"></div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="showcase-visual-content">
            <div class="brand-slider-v2">
              <div v-for="(img, index) in brandImages" :key="img.id" 
                   class="brand-slide-v2" :class="{ active: currentBrandSlide === index }">
                <div class="image-wrapper">
                  <img :src="img.url" alt="Perlux Lujo Peruano" class="brand-img-v2">
                </div>
              </div>
            </div>
            
            <!-- Botones de navegación sutiles -->
            <div class="showcase-arrows">
              <button class="arrow-btn prev" @click="prevBrandSlide">
                <i class="fas fa-chevron-left"></i>
              </button>
              <button class="arrow-btn next" @click="nextBrandSlide">
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- Vista móvil simplificada para consistencia -->
      <section class="brand-showcase-mobile" v-else>
         <div class="mobile-collection-slider h-100 w-100">
            <div v-for="(img, index) in brandImages" :key="'brand-mob-'+index" 
                 class="mobile-product-slide" :class="{ active: currentBrandSlide === index }">
                 <img :src="img.url" alt="Lujo Peruano" class="full-screen-product-img">
                 <div class="collection-label">LUJO PERUANO HECHO ARTE</div>
                 <div class="mobile-brand-caption">
                    <p>En PERLUX glam, la belleza y el arte convergen en un diseño de autor. Elevamos materiales nobles a su máxima expresión de elegancia, creando piezas atemporales destinadas a perdurar.</p>
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
      isMobile: false,
      favorites: [],
      currentGlamIndex: 0,
      currentNoviasIndex: 0,
      currentCarterasIndex: 0,
      currentBrandSlide: 0,
      currentGlamSlider: 0,
      currentNoviasSlider: 0,
      currentCarterasSlider: 0,
      glamSlides: [
        { image: "/images/site/slider/Glam1.jpeg", link: "/glam" },
        { image: "/images/site/slider/Glam2.jpeg", link: "/glam" },
        { image: "/images/site/slider/Glam3.jpeg", link: "/glam" }
      ],
      noviasSlides: [
        { image: "/images/site/slider/Novias1.jpeg", link: "/novias" },
        { image: "/images/site/slider/Novias2.jpeg", link: "/novias" }
      ],
      carterasSlides: [
        { image: "/images/site/slider/Carteras1.jpeg", link: "/carteras" },
        { image: "/images/site/slider/Carteras2.jpeg", link: "/carteras" },
        { image: "/images/site/slider/Carteras3.jpeg", link: "/carteras" }
      ],
      glamInterval: null,
      noviasInterval: null,
      carterasInterval: null,
      brandInterval: null,
      glamSliderInterval: null,
      noviasSliderInterval: null,
      carterasSliderInterval: null,
      brandImages: [
        { id: 1, url: '/images/site/slider/perlux1.png' },
        { id: 2, url: '/images/site/slider/perlux2.png' },
        { id: 3, url: '/images/site/slider/perlux3.png' },
        { id: 4, url: '/images/site/slider/perlux4.png' }
      ],
      productos: [],
      productos_novias: [],
      productos_carteras: [],
      allProducts: [],
    };
  },
  methods: {
    checkMobile() {
      this.isMobile = window.innerWidth <= 768;
    },
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
        
        this.productos = allProducts.filter(item => item.Tipo === 'Glam').slice(0, 3);
        this.productos_novias = allProducts.filter(item => item.Tipo === 'Jeans Rat' || item.Tipo === 'Novias').slice(0, 3);
        this.productos_carteras = allProducts.filter(item => item.Tipo === 'Carteras').slice(0, 3);
        this.allProducts = allProducts;
      } catch (e) {
        console.error("Error cargando datos:", e);
      }
    },

    comprar(product) {
      window.location.href = '/detail_glam?product_id=' + product.ProductID;
    },

    nextGlamSlider() { this.currentGlamSlider = (this.currentGlamSlider + 1) % this.glamSlides.length; },
    startGlamSliderSlideshow() { this.glamSliderInterval = setInterval(() => { this.nextGlamSlider(); }, 5000); },
    stopGlamSliderSlideshow() { if (this.glamSliderInterval) clearInterval(this.glamSliderInterval); },

    nextNoviasSlider() { this.currentNoviasSlider = (this.currentNoviasSlider + 1) % this.noviasSlides.length; },
    startNoviasSliderSlideshow() { this.noviasSliderInterval = setInterval(() => { this.nextNoviasSlider(); }, 5000); },
    stopNoviasSliderSlideshow() { if (this.noviasSliderInterval) clearInterval(this.noviasSliderInterval); },

    nextCarterasSlider() { this.currentCarterasSlider = (this.currentCarterasSlider + 1) % this.carterasSlides.length; },
    startCarterasSliderSlideshow() { this.carterasSliderInterval = setInterval(() => { this.nextCarterasSlider(); }, 5000); },
    stopCarterasSliderSlideshow() { if (this.carterasSliderInterval) clearInterval(this.carterasSliderInterval); },

    // Mantener también los de productos y brand por si acaso
    nextGlamProduct() { if (this.productos.length > 0) this.currentGlamIndex = (this.currentGlamIndex + 1) % this.productos.length; },
    startGlamSlideshow() { this.glamInterval = setInterval(() => { this.nextGlamProduct(); }, 4000); },
    stopGlamSlideshow() { if (this.glamInterval) clearInterval(this.glamInterval); },

    nextNoviasProduct() { if (this.productos_novias.length > 0) this.currentNoviasIndex = (this.currentNoviasIndex + 1) % this.productos_novias.length; },
    startNoviasSlideshow() { this.noviasInterval = setInterval(() => { this.nextNoviasProduct(); }, 4000); },
    stopNoviasSlideshow() { if (this.noviasInterval) clearInterval(this.noviasInterval); },

    nextCarterasProduct() { if (this.productos_carteras.length > 0) this.currentCarterasIndex = (this.currentCarterasIndex + 1) % this.productos_carteras.length; },
    startCarterasSlideshow() { this.carterasInterval = setInterval(() => { this.nextCarterasProduct(); }, 4000); },
    stopCarterasSlideshow() { if (this.carterasInterval) clearInterval(this.carterasInterval); },

    nextBrandSlide() { this.currentBrandSlide = (this.currentBrandSlide + 1) % this.brandImages.length; },
    prevBrandSlide() { this.currentBrandSlide = this.currentBrandSlide === 0 ? this.brandImages.length - 1 : this.currentBrandSlide - 1; },
    startBrandSlideshow() { this.brandInterval = setInterval(() => { this.nextBrandSlide(); }, 4000); },
    stopBrandSlideshow() { if (this.brandInterval) clearInterval(this.brandInterval); },

    toggleFavorite(product) {
      if (!this.user) {
        $('#authModal').modal('show');
        return;
      }
      product.favorito = !product.favorito;
      const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];
      if (product.favorito) {
        if (!savedFavorites.some(f => f.ProductID === product.ProductID)) {
          savedFavorites.push({ ...product });
        }
      } else {
        const index = savedFavorites.findIndex(fav => fav.ProductID === product.ProductID);
        if (index > -1) savedFavorites.splice(index, 1);
      }
      localStorage.setItem('favorites', JSON.stringify(savedFavorites));
    }
  },
  mounted() {
    this.checkMobile();
    window.addEventListener('resize', this.checkMobile);
    this.loadData();
    this.startGlamSlideshow();
    this.startNoviasSlideshow();
    this.startCarterasSlideshow();
    this.startBrandSlideshow();
    this.startGlamSliderSlideshow();
    this.startNoviasSliderSlideshow();
    this.startCarterasSliderSlideshow();
  },
  unmounted() {
    window.removeEventListener('resize', this.checkMobile);
    this.stopGlamSlideshow();
    this.stopNoviasSlideshow();
    this.stopCarterasSlideshow();
    this.stopBrandSlideshow();
    this.stopGlamSliderSlideshow();
    this.stopNoviasSliderSlideshow();
    this.stopCarterasSliderSlideshow();
  }
};
</script>

<style scoped>
/* Brand Showcase V2 - Base & Tablet */
.brand-showcase-v2 {
  min-height: 100vh;
  width: 100%;
  background-color: #fff;
  display: flex;
  align-items: center;
  overflow: hidden;
  position: relative;
  padding: 4rem 0;
}

.showcase-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  width: 100%;
  height: auto;
  align-items: center;
}

.showcase-text-content {
  padding: 0 8%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* Specific Desktop Refinement (>= 1024px) */
@media (min-width: 1024px) {
  .brand-showcase-v2 {
    height: 100vh;
    padding: 0;
    background-color: #fdfdfd; /* Extremely subtle off-white for luxury feel */
  }

  .showcase-container {
    width: 84%; /* margins of 8vw each side approx */
    max-width: 1600px;
    margin: 0 auto;
    height: 75vh;
    grid-template-columns: 0.9fr 1.1fr;
    background-color: #fff;
    box-shadow: 0 30px 100px rgba(0,0,0,0.03);
    overflow: hidden;
  }

  .showcase-text-content {
    padding: 0 10% 0 12%;
  }

  .showcase-visual-content {
    height: 100%;
    width: 100%;
  }

  .showcase-arrows {
    display: none !important; /* Remove buttons on desktop as requested */
  }

  .showcase-title {
    font-size: 3.8rem;
    margin-bottom: 3rem;
  }

  .showcase-manifesto {
    font-size: 1.2rem;
    max-width: 520px;
    margin-bottom: 4rem;
  }
}

.showcase-subtitle {
  font-size: 0.8rem;
  letter-spacing: 6px;
  color: #999;
  display: block;
  margin-bottom: 1.5rem;
  font-weight: 700;
  text-transform: uppercase;
}

.showcase-title {
  font-size: 3.5rem;
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: 2px;
  color: #1a1a1a;
  margin-bottom: 2.5rem;
  text-transform: uppercase;
}

.showcase-manifesto {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #555;
  max-width: 480px;
  margin-bottom: 3.5rem;
  font-weight: 300;
  font-style: italic;
}

.showcase-controls {
  display: flex;
  align-items: center;
  gap: 25px;
}

.slider-numbers {
  font-family: 'Montserrat', sans-serif;
  font-size: 1rem;
  letter-spacing: 2px;
  color: #1a1a1a;
}

.slider-numbers .current {
  font-weight: 700;
}

.slider-numbers .divider {
  margin: 0 5px;
  color: #ddd;
}

.slider-progress-container {
  width: 150px;
  height: 1px;
  background-color: #eee;
  position: relative;
}

.slider-progress-bar {
  height: 100%;
  background-color: #1a1a1a;
  transition: width 0.8s cubic-bezier(0.65, 0, 0.35, 1);
}

.showcase-visual-content {
  position: relative;
  height: 100vh;
}

.brand-slider-v2 {
  height: 100%;
  width: 100%;
  position: relative;
}

.brand-slide-v2 {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  visibility: hidden;
  transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.brand-slide-v2.active {
  opacity: 1;
  visibility: visible;
  z-index: 2;
}

.brand-img-v2 {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.showcase-arrows {
  position: absolute;
  bottom: 50px;
  right: 50px;
  display: flex;
  gap: 15px;
  z-index: 10;
}

.arrow-btn {
  width: 50px;
  height: 50px;
  border: 1px solid rgba(0,0,0,0.1);
  background: white;
  color: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.arrow-btn:hover {
  background: #1a1a1a;
  color: white;
  border-color: #1a1a1a;
}

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
  margin-top: 100px; /* Ajuste para bajar el slider */
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
  visibility: hidden;
  transition: opacity 1.5s ease-in-out, visibility 1.5s;
  overflow: hidden;
}

.slide.active {
  opacity: 1;
  visibility: visible;
}

/* Ken Burns Effect */
.slide.active::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: inherit;
  background-size: cover;
  background-position: center;
  animation: kenburns 20s ease infinite;
  z-index: -1;
}

@keyframes kenburns {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

.slider-dots-modern {
  position: absolute;
  bottom: 40px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 15px;
  z-index: 10;
}

.dot-modern {
  width: 40px;
  height: 2px;
  background-color: rgba(255, 255, 255, 0.3);
  cursor: pointer;
  transition: all 0.4s ease;
}

.dot-modern.active {
  width: 80px;
  background-color: #ffffff;
}

.btn-modern {
  background-color: rgba(255, 255, 255, 0.1) !important;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.5) !important;
  color: #fff !important;
  letter-spacing: 4px;
  padding: 15px 45px !important;
  font-size: 0.9rem !important;
  text-transform: uppercase;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.btn-modern:hover {
  background-color: #fff !important;
  color: #000 !important;
  border-color: #fff !important;
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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

.third-section .product-image-container {
  height: 400px;
  padding-top: 4rem;
  display: block;
}

.third-section .product-image,
.products-section .product-image {
  height: 100%;
  width: 100%;
  object-fit: cover;
}

.glam-home-image {
  max-width: 200px;
  height: auto;
  margin-bottom: 1rem;
}

.product-image-container {
  background-color: #ffffff;
  width: 100%;
  height: 400px;
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
    height: 100vh;
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
    margin-top: 10rem;
    align-self: center;
    background-color: rgba(0, 0, 0, 0.15) !important;
    border: 1px solid rgba(255, 255, 255, 0.8) !important;
    color: #ffffff !important;
    font-size: 0.9rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 12px 35px;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .first-section .section-new-woman .btn-lista:hover {
    background-color: rgba(255, 255, 255, 0.9) !important;
    color: #000000 !important;
    border-color: #ffffff !important;
  }

  .slider-dots {
    bottom: 50px;
    gap: 10px;
  }

  .dot {
    width: 35px;
    height: 3px;
    border-radius: 10px;
    background-color: rgba(255, 255, 255, 0.3);
    transition: all 0.4s ease;
  }

  .dot.active {
    width: 60px;
    background-color: #ffffff;
    transform: none;
  }

  .slider-arrow {
    display: none;
  }

  .second-section {
    padding: 0;
    width: 100vw;
    max-width: 100vw;
    margin: 0;
  }

  .third-section,
  .products-section {
    padding-top: 2rem;
    padding-bottom: 2rem;
  }

  .perlux-card {
    height: 400px;
  }

  .categories-slider-mobile {
    padding: 0 !important;
    height: 100vh;
    overflow: hidden;
    position: relative;
    background-color: #000;
  }

  .categories-wrapper {
    display: flex;
    flex-wrap: nowrap;
    width: 200%;
    height: 100%;
    transition: transform 0.7s cubic-bezier(0.65, 0, 0.35, 1);
  }

  .category-slide {
    flex: 0 0 50%;
    height: 100%;
    padding: 0 !important;
  }

  .category-slide .perlux-card {
    height: 100%;
    width: 100%;
    margin: 0;
  }

  .category-indicators {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 15px;
    z-index: 20;
  }

  .indicator-bar {
    width: 40px;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
    cursor: pointer;
    transition: all 0.4s ease;
  }

  .indicator-bar.active {
    background: #fff;
    width: 70px;
  }

  .category-slide .card-overlay {
    background: rgba(0, 0, 0, 0.2);
  }

  .category-slide .btn-perlux {
    bottom: 100px;
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

  .collection-slider-full {
    height: 100vh !important;
    padding: 0 !important;
    margin: 0 !important;
    overflow: hidden;
  }

  .mobile-collection-slider {
    position: relative;
    height: 100vh;
    width: 100vw;
  }

  .mobile-product-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1.2s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
  }

  .mobile-product-slide.active {
    opacity: 1;
    z-index: 5;
  }

  .full-screen-product-img {
    width: 100%;
    height: 100vh;
    object-fit: cover;
    object-position: center;
  }

  .collection-label {
    position: absolute;
    top: 30px;
    left: 20px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 2px;
    color: #000;
    background-color: #fff;
    padding: 8px 16px;
    z-index: 10;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-radius: 2px;
  }

  .collection-label.white {
    background-color: #000;
    color: #fff;
  }

  .mobile-buy-button-container {
    position: absolute;
    bottom: 80px;
    left: 50%;
    transform: translateX(-50%);
    width: 75%;
    z-index: 15;
  }

  .brand-showcase-mobile {
    height: 70vh;
    width: 100vw;
    position: relative;
  }

  .brand-showcase-mobile .mobile-collection-slider,
  .brand-showcase-mobile .full-screen-product-img {
    height: 70vh !important;
  }

  .mobile-brand-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 25px 20px 40px 20px;
    background: rgba(255, 255, 255, 0.95);
    text-align: center;
    z-index: 10;
    border-top: 1px solid rgba(0,0,0,0.05);
  }

  .mobile-brand-caption p {
    font-size: 0.85rem;
    margin: 0;
    color: #333;
    line-height: 1.4;
  }
}

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

