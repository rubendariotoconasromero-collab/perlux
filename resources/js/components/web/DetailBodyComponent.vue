<template>
  <div>
    <TheHeader :user="user" />

    <div class="container-fluid product-container" v-if="product && product.images">
      <div class="row g-0">

        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center col-md-6-image">
          <div class="product-image-section">
            <img :src="currentImage?.ImagePath" :alt="product.Name" class="product-image" loading="lazy">

            <button class="carousel-control prev" @click="prevImage" v-if="product.images.length > 1">
              <i class="fas fa-chevron-left icon-slider"></i>
            </button>
            <button class="carousel-control next" @click="nextImage" v-if="product.images.length > 1">
              <i class="fas fa-chevron-right icon-slider"></i>
            </button>

            <div class="carousel-indicators mx-auto" v-if="product.images.length > 1">
              <div v-for="(image, index) in product.images" :key="index" class="indicator"
                :class="{ active: currentSlide === index }" @click="goToSlide(index)">
              </div>
            </div>

            <div class="heart-wishlist" @click="toggleWishlist">
              <i :class="isFavorite ? 'fas fa-heart' : 'far fa-heart'"
                :style="{ color: isFavorite ? '#7e7e7e' : '#7e7e7e' }"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="product-details">
            <h1 class="product-title">{{ product.Name }}</h1>
            
            <div class="price">S/{{ getSelectedVariantPriceSelect() }}</div>

            <div class="rating-section">
              <div class="stars">
                <i v-for="star in 5" :key="star"
                  :class="star <= Math.round(averageRating) ? 'fas fa-star filled' : 'far fa-star empty'"></i>
              </div>
              <span class="rating-text">{{ reviewCount }} calificaciones</span>
            </div>

            <div class="color-section">
              <div class="section-title">Color</div>
              <div class="color-selector">
                <div v-for="colorId in getAvailableColors()" :key="colorId" class="color-option"
                  :style="{ backgroundColor: getColorHex(colorId) }" :title="getColorName(colorId)"
                  @click="selectColor(colorId)" :class="{ 'active': selectedColor == colorId }">
                </div>
              </div>
            </div>

            <div class="size-section">
              <div class="size-header d-flex justify-content-between align-items-center mb-2">
                <div class="section-title mb-0">Tallas</div>
                <div class="size-guide" @click="showSizeGuide">Guía de tallas</div>
              </div>
              
              <div class="size-selector">
                
                <div v-if="!selectedColor" class="alert alert-light border-0 p-0 text-muted d-flex align-items-center" style="font-size: 0.9rem;">
                    <i class="fas fa-arrow-up me-2"></i> 
                    <span>Por favor, <strong>selecciona un color</strong> arriba para ver las tallas disponibles.</span>
                </div>

                <div v-else class="d-flex flex-wrap gap-2">
                  <button v-for="sizeId in getAvailableSizesForSelectedColor()" :key="sizeId"
                    class="btn btn-sm px-3 py-1 rounded size-btn"
                    :class="{ 'active': selectedSize == sizeId }" @click="selectSize(sizeId)">
                    {{ getSizeName(sizeId) }}
                  </button>
                </div>

                <small v-if="selectedColor && getAvailableSizesForSelectedColor().length === 0" class="text-danger mt-2 d-block">
                  No hay tallas disponibles para este color.
                </small>

              </div>
            </div>

            <div class="w-100 d-flex flex-sm-row align-items-center gap-3 mt-4 mb-3">
              <div class="input-group input-group-sm add-to-count-btn" style="width: 120px;">
                <button class="btn border-0" type="button" @click="quantity > 1 ? quantity-- : 1">-</button>
                <input type="text" class="form-control text-center border-0 bg-transparent" :value="quantity" readonly>
                <button class="btn border-0" type="button" @click="quantity++">+</button>
              </div>

              <button class="add-to-cart-btn flex-grow-1" @click="updateCarrito" 
                :disabled="!selectedSize || !selectedColor"
                :class="{ 'opacity-50': !selectedSize || !selectedColor }">
                Añadir al carrito
              </button>
            </div>

            <button class="btn-whatsapp w-100 mb-4" @click="pedirPorWhatsapp(product)">
              <i class="fab fa-whatsapp me-2"></i> PEDIR POR WHATSAPP
            </button>

            <div class="d-flex gap-4 mb-4">
              <div class="qualify-link" @click="showQualifyModal">Calificar</div>
              <div class="qualify-link" style="color:#5b6da0" @click="showQualifyModal">
                ¿No encuentras tu talla? Haz tu pedido aquí
              </div>
            </div>

            

            <div class="tabs-section mt-4">
              <div class="custom-tabs">
                <button v-for="tab in tabs" :key="tab.id" class="tab-button" :class="{ active: activeTab === tab.id }"
                  @click="setActiveTab(tab.id)">
                  {{ tab.title }}
                </button>
              </div>
              <div class="tab-content mt-3">
                <div v-if="activeTab == 'details'">
                  <p>{{ product.Description || 'Sin descripción disponible.' }}</p>
                  <ul v-if="product.details && product.details.length > 0">
                    <li v-for="(d, i) in product.details" :key="i"><strong>{{ d.DetailName }}:</strong> {{ d.DetailValue }}</li>
                  </ul>
                </div>
                <div v-else-if="activeTab == 'fit'">
                   <p>{{ product.Fabric || 'Información de tela no especificada.' }}</p>
                   <ul v-if="product.settings && product.settings.length > 0">
                    <li v-for="(s, i) in product.settings" :key="i"><strong>{{ s.SettingName }}:</strong> {{ s.SettingValue }}</li>
                  </ul>
                </div>
                <div v-else-if="activeTab == 'shipping'">
                  <p>{{ product.ReturnPolicy || 'Envío gratis en compras mayores a S/200.' }}</p>
                  <ul v-if="product.policies && product.policies.length > 0">
                    <li v-for="(p, i) in product.policies" :key="i"><strong>{{ p.PolicyName }}:</strong> {{ p.PolicyValue }}</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div v-else class="loading-container text-center py-5" style="margin-top: 100px;">
      <div class="spinner-border" role="status"></div>
      <p class="mt-2">Cargando producto...</p>
    </div>

    <div class="third-section-container container-fluid py-5">
      <div class="text-center mb-5 content-logo-glam">
        <img src="/images/site/resources/glam-plomo.svg" alt="Glam" class="glam-home-image img-fluid">
      </div>

      <div class="col-md-12 col-12 content-products">
        <div class="slider-container">
          <button class="slider-nav-btn slider-prev" @click="slideLeft" :disabled="currentSlideProducts <= 0">
            <i class="fas fa-chevron-left"></i>
          </button>

          <div class="slider-wrapper">
            <div class="slider-track" :style="{ transform: `translateX(-${slideOffset}px)` }">
              <div class="slider-item" v-for="(item, index) in glamProducts" :key="item.ProductID">
                <div class="card product-card h-100 border-0 shadow-sm bg-white">
                  <div class="card-body p-0">
                    <div class="product-image-container">
                      <a :href="'/detail_glam?product_id=' + item.ProductID">
                        <img :src="item.images[0]?.ImagePath || getPlaceholderImage(index)" :alt="item.Name"
                          class="card-img-top product-image-cards" loading="lazy">
                      </a>
                      <div class="pb-1 pt-3 fondo-info-product">
                        <div class="d-flex justify-content-between align-items-start">
                          <div class="d-flex flex-column">
                            <h6 class="card-title product-name text-truncate fw-bold">{{ item.Name }}</h6>
                            <p class="card-text product-price">S/{{ item.Price }}</p>
                          </div>
                          <button class="btn heart-btn-bottom" @click="toggleFavoriteList(item)"
                            :class="{ 'heart-beat': item.justFavorited }">
                            <i :class="isProductFavorite(item) ? 'fas fa-heart text-secondary' : 'far fa-heart'"></i>
                          </button>
                        </div>
                      </div>
                      <button class="btn btn-comprar w-100 mx-0" @click="comprar(item)">
                        COMPRAR AHORA
                      </button>
                      <button class="btn-whatsapp w-100 mt-2" @click="pedirPorWhatsapp(item)">
                        <i class="fab fa-whatsapp me-2"></i> PEDIR POR WHATSAPP
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <button class="slider-nav-btn slider-next" @click="slideRight" :disabled="currentSlideProducts >= maxSlides">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    
    <div class="third-section-container container-fluid bg-white py-5">
      <div class="calification-section container">

        <div class="section-header text-center mb-5">
          <h3 class="section-title">CALIFICACIÓN</h3>
          <hr class="section-divider">
        </div>

        <div class="rating-overview align-items-center pb-5 border-bottom border-dark">
          <div class="row">
            <div class="col-md-4 text-center border-end-md">
              <div class="rating-big">
                <span class="rating-number">{{ averageRating }}/5</span>
              </div>
              
              <div class="review-meta text-muted small">
                {{ reviewCount }} calificaciones
                <span class="mx-2">|</span>
                <a href="#" @click.prevent="showQualifyModal" class="text-decoration-underline text-dark">Calificar</a>
              </div>
              <div class="stars mt-2">
                <i v-for="star in 5" :key="star"
                  :class="star <= Math.round(averageRating) ? 'fas fa-star filled' : 'far fa-star empty'"></i>
              </div>
            </div>
  
            <div class="col-md-5 ps-md-5 mt-4 mt-md-0">
              <div class="rating-bars">
                <div v-for="star in [5, 4, 3, 2, 1]" :key="star" class="d-flex align-items-center mb-2">
                  <span class="star-label me-3">{{ star }} &nbsp;<i class="fas fa-star text-xs"></i></span>
                  <div class="progress flex-grow-1">
                    <div class="progress-bar" role="progressbar"
                      :style="{ width: ratingDistribution[star] + '%', backgroundColor: '#9e9e9e' }"></div>
                  </div>
                  <span class="count-label ms-3 text-muted">{{ ratingCountsComputed[star] }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="reviews-list">
          <div v-if="isLoadingReviews" class="text-center py-5">
            <div class="spinner-border text-secondary" role="status"></div>
          </div>

          <div v-else>
            <div v-if="reviews.length === 0" class="text-center text-muted py-5">
              <p>Sé la primera en calificar este producto.</p>
            </div>

            <div v-else class="review-items">
              <div v-for="review in reviews" :key="review.id" class="review-item py-4 border-bottom border-dark">
                <div class="row">
                  <div class="col-md-3 mb-2 mb-md-0">
                    <h6 class="review-author fw-bold mb-1">{{ review.user?.name || 'Anónimo' }}</h6>
                    <div class="stars-small mt-2">
                      <i v-for="star in 5" :key="star"
                        :class="[
                          star <= review.rating ? 'fas fa-star filled-small' : 'far fa-star empty-small',
                          'ms-1' 
                        ]">
                      </i>
                    </div>
                  </div>

                  <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <h6 class="review-title fw-bold mb-0">{{ review.title || 'Sin título' }}</h6>
                      <span class="review-date text-muted small">hace {{ timeSince(review.created_at) }}</span>
                    </div>

                    <p class="review-body text-secondary mb-0">
                      {{ review.comment }}
                    </p>

                  </div>
                </div>
              </div>
            </div>

            <div class="text-center mt-5">
              <a href="#" class="text-muted text-decoration-underline" style="font-size: 0.9rem;">Ver más</a>
            </div>
          </div>
        </div>

      </div>
    </div>
    <TheFooter />

    <div class="modal fade" id="modalTallas" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0 border-0">
          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-5 pt-2">
            
            <h3 class="fw-bold text-uppercase mb-3">ESTILOS VERDADEROS</h3>
            <p class="text-muted mb-5 small">
              Descripcion de cada producto y precios con opción de compra bajo pedido para tallas sin stock
            </p>
            
            <div class="d-flex justify-content-center">
               <table class="table size-guide-table">
                  <thead>
                     <tr>
                        <th>USA</th>
                        <th>CM</th>
                        <th>Perú</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr><td>5</td><td>22 cm</td><td>36/36</td></tr>
                     <tr><td>6</td><td>23 cm</td><td>36/37</td></tr>
                     <tr><td>7</td><td>24 cm</td><td>37/38</td></tr>
                     <tr><td>8</td><td>24.5 cm</td><td>38/39</td></tr>
                     <tr><td>9</td><td>25.5 cm</td><td>39/40</td></tr>
                     <tr><td>10</td><td>26.5 cm</td><td>40/41</td></tr>
                  </tbody>
               </table>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalCalificacion" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
          <div class="modal-header border-0">
            <button type="button" class="btn-close" @click="closeQualifyModal"></button>
          </div>
          <div class="modal-body p-4 text-center">
            <div v-if="showSuccessAnimation">
              <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
              <h4>¡Gracias!</h4>
            </div>
            <div v-else>
              <h5 class="mb-3">Califica este producto</h5>
              <div class="rating-selector mb-3">
                <i v-for="star in 5" :key="star" class="fa-star mx-1"
                  :class="star <= selectedRating ? 'fas text-warning' : 'far text-muted'"
                  style="font-size: 2rem; cursor: pointer;" @click="selectRating(star)"></i>
              </div>
              <input v-model="reviewTitle" type="text" class="form-control mb-2" placeholder="Título (opcional)">
              <textarea v-model="reviewComment" class="form-control mb-3" rows="3" placeholder="Tu experiencia..."></textarea>
              <button class="btn btn-dark w-100" @click="submitReview" :disabled="isSubmitting">
                {{ isSubmitting ? 'Enviando...' : 'Enviar' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 p-4 text-center">
          <div class="modal-header border-0"><button type="button" class="btn-close" @click="closeAuthModal"></button></div>
          <h5>Inicia sesión</h5>
          <p class="text-muted small">Debes estar registrado para realizar esta acción.</p>
          <div class="d-grid gap-2 mt-3">
            <a href="/user" class="btn btn-dark">Login</a>
            <a href="/register" class="btn btn-outline-dark">Registro</a>
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
  components: { TheHeader, TheFooter },
  props: {
    productId: { type: String, required: true },
    user: { type: Object, required: false, default: null }
  },
  data() {
    return {
      product: { images: [], variants: [], details: [], settings: [], policies: [] },
      currentSlide: 0,
      selectedColor: null,
      selectedSize: null,
      quantity: 1,
      activeTab: 'details',

      colors: [],
      sizes: [],
      products: [], 
      favorites: [],
      products_carrito: [], // Almacén local para validar duplicados

      currentSlideProducts: 0,
      itemsPerView: 4,

      reviews: [],
      // ratingCounts: { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 },
      isLoadingReviews: false,
      selectedRating: 0,
      reviewTitle: '',
      reviewComment: '',
      isSubmitting: false,
      showSuccessAnimation: false,

      tabs: [
        { id: 'details', title: 'Detalles' },
        { id: 'shipping', title: 'Compras y devoluciones' }
      ]
    };
  },
  computed: {
    isLoggedIn() { return !!this.user; },
    currentImage() { return this.product.images && this.product.images.length ? this.product.images[this.currentSlide] : null; },
    isFavorite() { return this.favorites.some(f => f.ProductID === this.product.ProductID); },

    glamProducts() { 
        return this.products.filter(item => item.Tipo === 'Glam' && item.ProductID !== this.product.ProductID); 
    },
    maxSlides() { return Math.max(0, this.glamProducts.length - this.itemsPerView); },
    slideOffset() { return this.currentSlideProducts * 300; },

    // --- CORRECCIÓN DEL BUCLE INFINITO AQUÍ ---
    
    // 1. Calculamos los conteos en su propia propiedad pura
    ratingCountsComputed() {
        const counts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
        if (this.reviews && this.reviews.length > 0) {
            this.reviews.forEach(r => { 
                // Aseguramos que el rating sea un entero válido entre 1 y 5
                const rating = Math.round(r.rating);
                if (counts[rating] !== undefined) counts[rating]++; 
            });
        }
        return counts;
    },

    // 2. Calculamos la distribución basándonos en la computada anterior
    ratingDistribution() {
        const dist = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
        const total = this.reviews.length;
        
        if (total > 0) {
            const counts = this.ratingCountsComputed; // Usamos la computada
            for (let s in counts) {
                dist[s] = (counts[s] / total) * 100;
            }
        }
        return dist;
    },

    averageRating() {
      if (!this.reviews.length) return 0;
      const sum = this.reviews.reduce((a, b) => a + b.rating, 0);
      return (sum / this.reviews.length).toFixed(1);
    },
    
    reviewCount() { return this.reviews.length; }
  },
  methods: {
    timeSince(date) {
      const seconds = Math.floor((new Date() - new Date(date)) / 1000);
      let interval = seconds / 31536000;

      if (interval > 1) return Math.floor(interval) + " años";
      interval = seconds / 2592000;
      if (interval > 1) return Math.floor(interval) + " meses";
      interval = seconds / 604800; // Semanas
      if (interval > 1) return Math.floor(interval) + " semanas";
      interval = seconds / 86400;
      if (interval > 1) return Math.floor(interval) + " días";
      interval = seconds / 3600;
      if (interval > 1) return Math.floor(interval) + " horas";
      interval = seconds / 60;
      if (interval > 1) return Math.floor(interval) + " minutos";
      return Math.floor(seconds) + " segundos";
    },
    pedirPorWhatsapp(product) {
        const phoneNumber = "51920775278"; // Tu número
        let message = `Hola Perlux, estoy interesada en el producto: *${product.Name}*`;
        
        // Agregar detalles si están seleccionados
        if (this.selectedColor && this.selectedSize) {
            const colorName = this.getColorName(this.selectedColor);
            const sizeName = this.getSizeName(this.selectedSize);
            message += `\nColor: ${colorName}\nTalla: ${sizeName}`;
        } else {
            message += `\n(Aún no he seleccionado talla/color)`;
        }

        // Agregar precio y cantidad
        const price = this.getSelectedVariantPriceSelect();
        message += `\nPrecio: S/${price}`;
        message += `\nCantidad: ${this.quantity}`;
        message += `\n\n¿Tienen disponibilidad?`;

        // Crear URL y abrir
        const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank');
    },
    // --- Sincronización de Carrito (Nuevo Método) ---
    refreshCartData() {
        // Lee el estado más reciente del localStorage para evitar errores de "ya existe"
        // cuando el Header ha borrado algo.
        const stored = localStorage.getItem('products');
        this.products_carrito = stored ? JSON.parse(stored) : [];
        
        // También refrescamos favoritos por si acaso
        const storedFav = localStorage.getItem('favorites');
        this.favorites = storedFav ? JSON.parse(storedFav) : [];
    },

    async loadData() {
      try {
        const response = await axios.get('/load_data');
        this.colors = response.data.colors || [];
        this.sizes = response.data.sizes || [];
        this.products = response.data.products || [];

        const found = this.products.find(p => p.ProductID == this.productId);
        if (found) {
            this.product = { ...found };
            if (!this.product.variants) this.product.variants = [];
        }
        this.updateSliderSettings();
      } catch (e) { console.error("Error:", e); }
    },

    async loadReviews() {
        this.isLoadingReviews = true;
        try {
            const response = await axios.get(`/reviews/product/${this.productId}`);
            if (response.data.success) this.reviews = response.data.reviews;
        } catch (error) { console.error(error); } finally { this.isLoadingReviews = false; }
    },

    getAvailableColors() {
        if (!this.product.variants) return [];
        return [...new Set(this.product.variants.map(v => v.ColorID))];
    },
    getAvailableSizesForSelectedColor() {
        if (!this.selectedColor || !this.product.variants) return [];
        return this.product.variants.filter(v => v.ColorID === this.selectedColor && v.StockQuantity > 0).map(v => v.SizeID);
    },
    getSelectedVariantPriceSelect() {
        if (this.selectedColor && this.selectedSize && this.product.variants) {
            const variant = this.product.variants.find(v => v.ColorID === this.selectedColor && v.SizeID === this.selectedSize);
            if (variant && variant.Price) return parseFloat(variant.Price).toFixed(2);
        }
        return parseFloat(this.product.Price || 0).toFixed(2);
    },
    
    getColorHex(id) { return this.colors.find(c => c.ColorID === id)?.HexCode || '#ccc'; },
    getColorName(id) { return this.colors.find(c => c.ColorID === id)?.ColorName || ''; },
    getSizeName(id) { return this.sizes.find(s => s.SizeID === id)?.SizeName || ''; },
    getPlaceholderImage(i) { return `https://via.placeholder.com/300x400?text=Prod+${i}`; },

    selectColor(id) { this.selectedColor = id; this.selectedSize = null; },
    selectSize(id) { this.selectedSize = id; },

    // --- AGREGAR AL CARRITO (CORREGIDO) ---
    updateCarrito() {
        // Asegurarnos de tener la versión más fresca del carrito
        this.refreshCartData(); 

        if (!this.isLoggedIn) { $('#authModal').modal('show'); return; }
        if (!this.selectedColor) { Swal.fire({ icon: 'warning', title: 'Elige un color', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); return; }
        if (!this.selectedSize) { Swal.fire({ icon: 'warning', title: 'Elige una talla', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); return; }

        const variant = this.product.variants.find(v => v.ColorID === this.selectedColor && v.SizeID === this.selectedSize);
        if (!variant || variant.StockQuantity < this.quantity) {
            Swal.fire({ icon: 'error', title: 'Stock insuficiente', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); return;
        }

        const cartKey = `${this.product.ProductID}-${this.selectedSize}-${this.selectedColor}`;
        // Usamos this.products_carrito que ya está actualizado
        const exists = this.products_carrito.some(item => 
            `${item.ProductID}-${item.selectedSize}-${item.selectedColor}` === cartKey
        );

        if (exists) {
            Swal.fire({ icon: 'info', title: 'Ya está en el carrito', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            return;
        }

        const productToAdd = {
            ...this.product,
            selectedSize: this.selectedSize,
            selectedColor: this.selectedColor,
            selectedVariant: variant,
            quantity: this.quantity
        };

        this.products_carrito.push(productToAdd);
        localStorage.setItem('products', JSON.stringify(this.products_carrito));
        
        // ¡ESTA ES LA CLAVE! Disparar evento para que el Header se entere sin recargar
        window.dispatchEvent(new Event('cart-updated'));

        Swal.fire({ icon: 'success', title: 'Agregado', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
    },

    toggleWishlist() {
        if (!this.isLoggedIn) { $('#authModal').modal('show'); return; }
        this.toggleFavoriteLogic(this.product);
    },
    toggleFavoriteList(item) {
        if (!this.isLoggedIn) { $('#authModal').modal('show'); return; }
        item.justFavorited = true; setTimeout(() => item.justFavorited = false, 600);
        this.toggleFavoriteLogic(item);
    },
    toggleFavoriteLogic(item) {
        this.refreshCartData(); // Refrescar antes de modificar
        const idx = this.favorites.findIndex(f => f.ProductID === item.ProductID);
        if (idx > -1) this.favorites.splice(idx, 1);
        else this.favorites.push(item);
        
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
        // Avisar al Header
        window.dispatchEvent(new Event('favorites-updated'));
    },
    isProductFavorite(item) { return this.favorites.some(f => f.ProductID === item.ProductID); },

    nextImage() { if (this.product.images) this.currentSlide = (this.currentSlide + 1) % this.product.images.length; },
    prevImage() { if (this.product.images) this.currentSlide = (this.currentSlide - 1 + this.product.images.length) % this.product.images.length; },
    goToSlide(i) { this.currentSlide = i; },
    slideLeft() { if (this.currentSlideProducts > 0) this.currentSlideProducts--; },
    slideRight() { if (this.currentSlideProducts < this.maxSlides) this.currentSlideProducts++; },
    updateSliderSettings() {
        const w = window.innerWidth;
        this.itemsPerView = w >= 1200 ? 4 : w >= 992 ? 3 : w >= 768 ? 2 : 1;
    },
    comprar(item) { window.location.href = `/detail_glam?product_id=${item.ProductID}`; },

    setActiveTab(t) { this.activeTab = t; },
    showSizeGuide() { $('#modalTallas').modal('show'); },
    showQualifyModal() {
        if (!this.isLoggedIn) { $('#authModal').modal('show'); return; }
        $('#modalCalificacion').modal('show');
    },
    closeQualifyModal() { $('#modalCalificacion').modal('hide'); },
    closeAuthModal() { $('#authModal').modal('hide'); },
    selectRating(n) { this.selectedRating = n; },

    async submitReview() {
        if (this.selectedRating === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Por favor, selecciona una calificación',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }
        this.isSubmitting = true;
        try {
            await axios.post('/reviews', { 
                user_id: this.user.id, 
                product_id: this.productId, 
                rating: this.selectedRating, 
                title: this.reviewTitle, 
                comment: this.reviewComment 
            });
            
            this.showSuccessAnimation = true;
            this.loadReviews();
            
            setTimeout(() => { 
                this.showSuccessAnimation = false; 
                this.closeQualifyModal(); 
                this.reviewTitle = '';
                this.reviewComment = '';
                this.selectedRating = 0;
            }, 1500);

        } catch (error) { 
            Swal.fire({
                icon: 'error', 
                title: 'Error al enviar', 
                text: 'Inténtalo de nuevo más tarde',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } finally { 
            this.isSubmitting = false; 
        }
    },

    formatDate(d) { return new Date(d).toLocaleDateString(); },
  },
  
  async mounted() {
    window.addEventListener('resize', this.updateSliderSettings);
    
    // Carga inicial de datos locales
    this.refreshCartData();

    // ESCUCHAR CAMBIOS DEL HEADER:
    // Si el header elimina algo, este evento se dispara.
    // Nosotros volvemos a leer el localStorage para estar sincronizados.
    window.addEventListener('cart-updated', this.refreshCartData);
    window.addEventListener('favorites-updated', this.refreshCartData);

    await this.loadData();
    await this.loadReviews();
  },
  
  beforeUnmount() {
    window.removeEventListener('resize', this.updateSliderSettings);
    // Limpiar listeners para evitar fugas de memoria
    window.removeEventListener('cart-updated', this.refreshCartData);
    window.removeEventListener('favorites-updated', this.refreshCartData);
  }
};
</script>
<style scoped>
/* ========================
   ESTILOS GENERALES
   ======================== */
.product-container {
  padding-top: 120px;
  padding-bottom: 50px;
  background: #fff;
}

.col-md-6-image {
  background-color: #ffffff;
  height: 750px;
  position: relative;
}

.product-image-section {
  position: relative;
  width: 80%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  /* border:1px solid red; */
}

/* CARRUSEL PRODUCTO */
.carousel-control {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  font-size: 1.5rem;
  color: #8f8f8f;
  z-index: 10;
  width: 40px;
}

.carousel-control:hover {
  color: #333;
}

.carousel-control.prev {
  left: 10px;
}

.carousel-control.next {
  right: 10px;
}

.carousel-indicators {
  position: absolute;
  bottom: 20px;
  display: flex;
  gap: 8px;
  margin: 0;
}

.indicator {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #ccc;
  cursor: pointer;
  opacity: 1;
}

.indicator.active {
  background: #7c7c7c;
}

/* FAV */
.heart-wishlist {
  position: absolute;
  top: 20px;
  right: 20px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  font-size: 1.2rem;
  transition: transform 0.2s;
}

.heart-wishlist:hover {
  transform: scale(1.1);
}

.heart-btn-bottom i{
  font-size: 1.2rem;
}

.heart-btn-bottom .text-secondary {
  color: #838383 !important;
}

.heart-beat {
  animation: heartBeat 0.5s;
}

@keyframes heartBeat {
  0% { transform: scale(1); }
  50% { transform: scale(1.3); }
  100% { transform: scale(1); }
}

/* DETALLES */
.product-details {
  padding: 40px 60px;
  height: 100%;
}

.product-title {
  font-size: 2rem;
  font-weight: 700;
  text-transform: uppercase;
  margin-bottom: 10px;
  color: #000;
}

.price {
  font-size: 1.5rem;
  font-weight: 400;
  color: #333;
  margin-bottom: 20px;
}

.section-title {
  font-weight: 700;
  font-size: 0.9rem;
  margin-bottom: 10px;
  text-transform: uppercase;
}

/* SELECTORES */
.color-selector {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
}

.color-option {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  border: 2px solid transparent;
  cursor: pointer;
  box-shadow: 0 0 0 1px #ddd;
}

.color-option.active {
  transform: scale(1.1);
  box-shadow: 0 0 0 2px #fff, 0 0 0 3px #969696; 
  border-color: transparent;
}

.size-btn {
  border: 1px solid #7a7a7a;
  background: #fff;
  color: #7a7a7a;
  min-width: 45px;
  border-radius: 0 !important;
  font-weight: 600;
}

.size-btn.active {
  background: #969696;
  color: #fff;
  border-color: #969696;
}

.size-guide {
  font-size: 0.85rem;
  text-decoration: underline;
  cursor: pointer;
  color: #555;
}

/* BOTONES */
.add-to-cart-btn {
  background: #969696;
  color: #fff;
  border: none;
  padding: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0;
  transition: background 0.3s;
}

.add-to-cart-btn:hover {
  background: #969696;
}

.add-to-cart-btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.add-to-count-btn {
  border: 1px solid #ddd;
}

.btn-comprar {
  width: 100%;
  border: 1px solid #000;
  background: transparent;
  padding: 10px;
  font-weight: 700;
  font-size: 0.85rem;
  margin-top: 10px;
  transition: all 0.3s;
  border-radius: 0;
  text-transform: uppercase;
}

.btn-comprar:hover {
  background: #969696;
  border: 1px solid #969696;
  color: #ffffff;
}

.qualify-link {
  font-size: 0.9rem;
  text-decoration: underline;
  cursor: pointer;
  color: #555;
}

/* Tabs */
.custom-tabs {
  border-bottom: 1px solid #eee;
  display: flex;
  gap: 30px;
  width: 100%;
}

.tab-button {
  background: none;
  border: none;
  padding-bottom: 10px;
  font-weight: 600;
  color: #999;
  border-bottom: 2px solid transparent;
  margin-left:auto;
  margin-right:auto;

  flex: 1;            /* 1. Hace que el botón crezca para ocupar el espacio disponible */
  text-align: center; /* 2. Centra el texto dentro del nuevo ancho del botón */
  width: 100%;        /* 3. Refuerzo para asegurar expansión */
  cursor: pointer;
}

.tab-button.active {
  color: #000;
  border-bottom-color: #000;
}

.tab-content {
  color: #555;
  font-size: 0.95rem;
  line-height: 1.6;
}

/* SECCIÓN CALIFICACIÓN */

.calification-section {
  max-width: 85%;
  margin: 0 auto;
  font-family: 'Public Sans', sans-serif; /* O tu fuente principal */
}

/* Encabezado */
.section-title {
  font-size: 1.2rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 10px;
}
.section-divider {
  border-top: 1px solid #000;
  opacity: 1;
  margin: 0;
}

/* Resumen Rating */
.rating-big {
  margin-bottom: 5px;
}
.rating-number {
  font-size: 3.5rem;
  font-weight: 300; /* Letra fina como en la imagen */
  line-height: 1;
}

.rating-overview .small {
  font-size: 12px !important;
}

.rating-overview .text-rating {
  font-size: 11px !important;
}

.stars .filled { color: #7a7a7a; font-size: 1.2rem; } /* Estrellas negras/gris oscuro */
.stars .empty { color: #ccc; font-size: 1.2rem; }

/* Barras */
.star-label {
  width: 40px;
  font-size: 0.9rem;
  font-weight: 600;
  color: #7a7a7a;
}
.progress {
  background-color: #f0f0f0;
  border-radius: 10px;
  box-shadow: none;
  height: 12px;

}
.progress-bar {
  background-color: #7a7a7a !important; /* Color Taupe/Gris de la imagen */
  border-radius: 10px;
}
.count-label {
  width: 30px;
  text-align: right;
  font-size: 0.85rem;
}

/* Lista de Reseñas */
.review-item {
  border-bottom: 1px solid #ddd;
}
.review-author {
  font-size: 0.95rem;
  color: #000;
}
.review-user-meta {
  font-size: 0.8rem;
  line-height: 1.4;
  margin-top: 5px;
}

.stars-small .filled-small { color: #7a7a7a;; font-size: 0.8rem;} /* Estrellas pequeñas grises */
.stars-small .empty-small { color: #e0e0e0; font-size: 0.8rem;}

.review-title {
  font-size: 1rem;
  color: #000;
}
.review-body {
  font-size: 0.95rem;
  line-height: 1.6;
  color: #555;
  margin-top: 5px;
}
.review-date {
  font-size: 0.85rem;
  white-space: nowrap;
}

/* ESTILOS SLIDER SIMILARES & LOGO */
.glam-home-image {
  width: 180px;
  height: auto;
}

.slider-container {
  position: relative;
  overflow: hidden;
  padding: 0 0;
}

.slider-wrapper {
  overflow: hidden;
}

.slider-track {
  display: flex;
  gap: 30px;
  transition: transform 0.5s ease;
}

.slider-item {
  flex: 0 0 300px;
}

.slider-nav-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #fff;
  border: 1px solid #eee;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 5;
}

.slider-prev {
  left: 0;
}

.slider-next {
  right: 0;
}

.slider-nav-btn:disabled {
  opacity: 0.5;
  cursor: default;
}

.product-card {
  transition: transform 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
}

.product-image-cards {
  height: 300px;
  object-fit: cover;
  width: 100%;
  border-radius:0px;
}

.fondo-info-product {
  background: #fff;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .border-end-md {
    border-right: 1px solid #eee;
  }
  .product-container {
    padding-top: 100px;
    padding-left: 0;
    padding-right: 0;
  }

  .col-md-6-image {
    height: 400px;
  }

  .product-details {
    padding: 30px 20px;
  }

  .slider-item {
    flex: 0 0 300px !important;
  }
}

/* ESTILOS BOTÓN WHATSAPP */
.btn-whatsapp {
  background-color: #ffffff; /* Verde WhatsApp */
  color: 2b8d4ffff;
  border: 1px solid #2b8d4f;
  padding: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0; /* Manteniendo tu estilo cuadrado */
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
}

.btn-whatsapp:hover {
  background-color: #26b16b; /* Verde más oscuro al hover */
  border-color: #26b16b;
  color: #fff;
  box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
}

.btn-whatsapp i {
  font-size: 1.2rem;
}

/* ESTILOS TABLA TALLAS */
.size-guide-table {
  max-width: 500px;
  width: 100%;
  border-collapse: separate; /* Permite espaciado entre celdas si es necesario */
  border-spacing: 0;
}

.size-guide-table th {
  background-color: #000;
  color: #fff;
  text-align: center;
  padding: 10px;
  font-weight: 700;
  text-transform: uppercase;
  border: none;
  /* El borde blanco derecho crea el efecto de separación */
  border-right: 5px solid #fff; 
  font-size: 1.1rem;
}

.size-guide-table th:last-child {
  border-right: none;
}

.size-guide-table td {
  text-align: center;
  padding: 12px;
  color: #333;
  font-size: 1rem;
  border-bottom: 1px solid #f0f0f0; /* Línea sutil divisora */
}

/* Quitar bordes por defecto de bootstrap si interfieren */
.size-guide-table > :not(caption) > * > * {
  box-shadow: none; 
}
</style>