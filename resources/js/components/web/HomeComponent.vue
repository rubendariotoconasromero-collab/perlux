<template>
  <div>
    <TheHeader :user="user" />

    <div class="container-fluid p-0">

      <div class="first-section">
        <div class="slider-container">
          <div v-for="(slide, index) in slides" :key="slide.id || index" class="slide"
            :class="{ active: currentSlide === index }" :style="{ backgroundImage: `url(${isMobile ? slide.imageMobile : slide.image})` }">
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

      <!-- seccion categorias de perlux -->
      <div class="container-fluid second-section" :class="{'categories-slider-mobile': isMobile}">
        <div class="row g-0 justify-content-center h-100" :class="{'categories-wrapper': isMobile}" :style="isMobile ? { transform: `translateX(-${currentCategorySlide * (100 / categories.length)}%)` } : {}">
          <div v-for="(cat, index) in categories" :key="cat.id" 
               class="col-lg-6 col-md-6 col-12" :class="{'category-slide': isMobile}">
            <div class="perlux-card" :class="{'perlux-card-start': index === 0 && !isMobile, 'perlux-card-end': index === 1 && !isMobile}">
              <img :src="cat.image" :alt="cat.alt" class="img-fondo">
              <div class="card-overlay">
                <img :src="cat.logo" :alt="cat.alt" class="img-type">
                <a :href="cat.link" class="btn btn-perlux">VER MÁS</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Indicadores para el slider de categorías en móvil -->
        <div class="category-indicators" v-if="isMobile">
          <span v-for="(cat, index) in categories" :key="'ind-' + index" 
                class="indicator-bar" :class="{ active: currentCategorySlide === index }" 
                @click="currentCategorySlide = index">
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
      currentSlide: 0,
      currentCategorySlide: 0,
      currentGlamIndex: 0,
      currentNoviasIndex: 0,
      currentCarterasIndex: 0,
      currentBrandSlide: 0,
      slideInterval: null,
      categoryInterval: null,
      glamInterval: null,
      noviasInterval: null,
      carterasInterval: null,
      brandInterval: null,
      brandImages: [
        { id: 1, url: '/images/site/slider/perlux1.png' },
        { id: 2, url: '/images/site/slider/perlux2.png' },
        { id: 3, url: '/images/site/slider/perlux3.png' },
        { id: 4, url: '/images/site/slider/perlux4.png' }
      ],
      categories: [
        {
          id: 1,
          image: "images/site/images/zapato_home2.jpeg",
          logo: "images/site/resources/glam_white.svg",
          link: "/glam",
          alt: "Glam"
        },
        {
          id: 2,
          image: "images/site/images/second-section2.jpeg",
          logo: "images/site/resources/novias_white.svg",
          link: "/novias",
          alt: "Novias"
        }
      ],
      slides: [
        {
          id: 1,
          image: "/images/site/slider/bg1.jpg",
          imageMobile: "/images/site/slider/bg4.jpg",
          title: "",
          subtitle: "",
          buttonText: "Comprar ahora",
          buttonLink: "#",
          buttonClass: "btn-light"
        },
        {
          id: 2,
          image: "/images/site/slider/bg2.jpg",
          imageMobile: "/images/site/slider/bg5.jpg",
          title: "",
          subtitle: "",
          buttonText: "Ver colección",
          buttonLink: "/glam",
          buttonClass: "btn-dark"
        },
        {
          id: 3,
          image: "/images/site/slider/bg3.jpg",
          imageMobile: "/images/site/slider/bg6.jpg",
          title: "",
          subtitle: "",
          buttonText: "Descubrir",
          buttonLink: "/novias",
          buttonClass: "btn-dark"
        }
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

    nextSlide() { this.currentSlide = (this.currentSlide + 1) % this.slides.length; },
    prevSlide() { this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1; },
    goToSlide(index) { this.currentSlide = index; },
    startSlideshow() { this.slideInterval = setInterval(() => { this.nextSlide(); }, 5000); },
    stopSlideshow() { if (this.slideInterval) clearInterval(this.slideInterval); },

    nextCategorySlide() { this.currentCategorySlide = (this.currentCategorySlide + 1) % this.categories.length; },
    startCategorySlideshow() { this.categoryInterval = setInterval(() => { this.nextCategorySlide(); }, 5000); },
    stopCategorySlideshow() { if (this.categoryInterval) clearInterval(this.categoryInterval); },

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
    },

    comprar(product) {
      window.location.href = '/detail_glam?product_id=' + product.ProductID;
    }
  },
  mounted() {
    this.checkMobile();
    window.addEventListener('resize', this.checkMobile);
    this.loadData();
    this.startSlideshow();
    this.startCategorySlideshow();
    this.startGlamSlideshow();
    this.startNoviasSlideshow();
    this.startCarterasSlideshow();
    this.startBrandSlideshow();
  },
  unmounted() {
    window.removeEventListener('resize', this.checkMobile);
    this.stopSlideshow();
    this.stopCategorySlideshow();
    this.stopGlamSlideshow();
    this.stopNoviasSlideshow();
    this.stopCarterasSlideshow();
    this.stopBrandSlideshow();
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
