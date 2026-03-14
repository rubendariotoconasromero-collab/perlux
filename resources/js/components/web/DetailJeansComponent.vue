<template>
  <div>
    <TheHeader :user="user" />

    <div class="container-fluid product-container" v-if="product && product.images">
      <div class="row g-0 justify-content-center px-lg-4">

        <div class="col-lg-6 col-md-6 pe-lg-4 mb-4 mb-md-0">
          <div class="product-image-section">
            <div class="product-image-wrapper-main">
              <img :src="currentImage?.ImagePath" :alt="product.Name" class="product-image-main" loading="lazy">

              <button class="carousel-control prev" @click="prevImage" v-if="product.images.length > 1">
                <i class="fas fa-chevron-left icon-slider"></i>
              </button>
              <button class="carousel-control next" @click="nextImage" v-if="product.images.length > 1">
                <i class="fas fa-chevron-right icon-slider"></i>
              </button>

              <div class="carousel-indicators-custom" v-if="product.images.length > 1">
                <div v-for="(image, index) in product.images" :key="index" class="indicator"
                  :class="{ active: currentSlide === index }" @click="goToSlide(index)">
                </div>
              </div>

              <div class="heart-wishlist" @click="toggleWishlist">
                <i :class="isFavorite ? 'fas fa-heart' : 'far fa-heart'"
                  :style="{ color: isFavorite ? '#6da5da' : '#7e7e7e' }"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 col-md-6">
          <div class="product-details-sticky">
            
            <h1 class="product-title">{{ product.Name }}</h1>
            <div class="price">S/{{ getSelectedVariantPriceSelect() }}</div>

            <div class="rating-section d-flex align-items-center mb-4">
              <div class="stars">
                <i v-for="star in 5" :key="star"
                  :class="star <= Math.round(averageRating) ? 'fas fa-star filled' : 'far fa-star empty'"></i>
              </div>
              <span class="rating-text ms-2 text-muted small">{{ reviewCount }} calificaciones</span>
            </div>

            <div class="color-section mb-4">
              <div class="section-title">Color: <span class="fw-normal text-muted">{{ getColorName(selectedColor) }}</span></div>
              <div class="color-selector mt-2">
                <div v-for="colorId in getAvailableColors()" :key="colorId" class="color-option"
                  :style="{ backgroundColor: getColorHex(colorId) }" :title="getColorName(colorId)"
                  @click="selectColor(colorId)" :class="{ 'active': selectedColor == colorId }">
                </div>
              </div>
            </div>

            <div class="size-section mb-4">
              <div class="d-flex justify-content-between align-items-end mb-2">
                <div class="section-title mb-0">Tallas</div>
                <div class="size-guide" @click="showSizeGuide">Guía de tallas</div>
              </div>
              
              <div class="size-selector">
                <div v-if="!selectedColor" class="alert-light-custom text-muted">
                  <i class="fas fa-arrow-up me-2"></i> Selecciona un color para ver las tallas.
                </div>

                <div v-else class="d-flex flex-wrap gap-2">
                  <button v-for="sizeId in getAvailableSizesForSelectedColor()" :key="sizeId"
                    class="btn btn-size-select"
                    :class="{ 'active': selectedSize == sizeId }" @click="selectSize(sizeId)">
                    {{ getSizeName(sizeId) }}
                  </button>
                </div>

                <small v-if="selectedColor && getAvailableSizesForSelectedColor().length === 0" class="text-danger mt-2 d-block">
                  No hay tallas disponibles para este color.
                </small>
              </div>
            </div>

            <div class="action-buttons-group d-flex flex-column flex-sm-row gap-3 mt-4 mb-4">
              <div class="quantity-selector">
                <button class="btn border-0" type="button" @click="quantity > 1 ? quantity-- : 1">-</button>
                <input type="text" class="form-control text-center border-0 bg-transparent" :value="quantity" readonly>
                <button class="btn border-0" type="button" @click="quantity++">+</button>
              </div>

              <button class="add-to-cart-btn flex-grow-1" @click="updateCarrito" 
                :disabled="!selectedSize || !selectedColor"
                :class="{ 'disabled-btn': !selectedSize || !selectedColor }">
                Añadir al carrito
              </button>
            </div>

            <button class="btn-whatsapp w-100 mb-4" @click="pedirPorWhatsapp(product)">
              <i class="fab fa-whatsapp me-2"></i> PEDIR POR WHATSAPP
            </button>

            <div class="help-links d-flex flex-column gap-2 mb-4">
              <div class="qualify-link" @click="showQualifyModal">Calificar producto</div>
              <div class="qualify-link text-primary-custom" @click="showQualifyModal">
                ¿No encuentras tu talla? Haz tu pedido aquí
              </div>
            </div>

            <div class="tabs-section mt-5">
              <div class="custom-tabs">
                <button v-for="tab in tabs" :key="tab.id" class="tab-button" :class="{ active: activeTab === tab.id }"
                  @click="setActiveTab(tab.id)">
                  {{ tab.title }}
                </button>
              </div>
              <div class="tab-content mt-3 text-muted small lh-lg">
                <div v-if="activeTab == 'details'">
                  <p>{{ product.Description || 'Sin descripción disponible.' }}</p>
                  <ul v-if="product.details && product.details.length > 0" class="ps-3">
                    <li v-for="(d, i) in product.details" :key="i"><strong>{{ d.DetailName }}:</strong> {{ d.DetailValue }}</li>
                  </ul>
                </div>
                <div v-else-if="activeTab == 'shipping'">
                  <p>{{ product.ReturnPolicy || 'Envío gratis en compras mayores a S/200.' }}</p>
                  <ul v-if="product.policies && product.policies.length > 0" class="ps-3">
                    <li v-for="(p, i) in product.policies" :key="i"><strong>{{ p.PolicyName }}:</strong> {{ p.PolicyValue }}</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div v-else class="loading-container text-center py-5" style="margin-top: 150px; min-height: 50vh;">
      <div class="spinner-border text-dark" role="status"></div>
      <p class="mt-3 text-muted fw-bold text-uppercase tracking-widest">Cargando producto...</p>
    </div>

    <div class="third-section-container container-fluid py-5 bg-light-custom">
      <div class="text-center mb-5 content-logo-glam">
        <img src="/images/site/resources/novias-negro.svg" alt="Glam" class="glam-home-image img-fluid">
      </div>

      <div class="col-12">
        <div class="slider-container">
          <button class="slider-nav-btn slider-prev" @click="scrollSlider('left')">
            <i class="fas fa-chevron-left"></i>
          </button>

          <div class="slider-wrapper" ref="productSlider">
            <div class="slider-track">
              
              <div class="slider-item" v-for="(item, index) in glamProducts" :key="item.ProductID">
                <div class="card product-card h-100 border-0 bg-white rounded-0">
                  <div class="card-body p-0 d-flex flex-column h-100">
                    
                    <div class="product-image-container">
                      <a :href="'/detail_novias?product_id=' + item.ProductID">
                        <img :src="item.images[0]?.ImagePath || getPlaceholderImage(index)" :alt="item.Name"
                          class="card-img-top product-image-cards" loading="lazy">
                      </a>
                    </div>
                    
                    <div class="py-3 d-flex flex-column flex-grow-1 fondo-info-product">
                      <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex flex-column text-start overflow-hidden pe-2">
                          <h6 class="card-title product-name text-truncate fw-bold mb-1">{{ item.Name }}</h6>
                          <p class="card-text product-price text-muted mb-0">S/{{ item.Price }}</p>
                        </div>
                        <button class="btn heart-btn-bottom p-0 border-0" @click="toggleFavoriteList(item)"
                          :class="{ 'heart-beat': item.justFavorited }">
                          <i :class="isProductFavorite(item) ? 'fas fa-heart text-primary-custom' : 'far fa-heart'" style="font-size: 1.3rem;"></i>
                        </button>
                      </div>
                      
                      <div class="mt-auto">
                        <button class="btn btn-comprar w-100 mb-2" @click="comprar(item)">
                          COMPRAR AHORA
                        </button>
                        <button class="btn btn-whatsapp-card w-100" @click="pedirPorWhatsapp(item)">
                          <i class="fab fa-whatsapp me-2"></i> PEDIR POR WHATSAPP
                        </button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>

          <button class="slider-nav-btn slider-next" @click="scrollSlider('right')">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="third-section-container container-fluid bg-white py-5">
      <div class="calification-section container">

        <div class="section-header text-center mb-5">
          <h3 class="section-title-big">CALIFICACIONES</h3>
          <hr class="section-divider mx-auto">
        </div>

        <div class="rating-overview pb-5 border-bottom border-light-gray">
          <div class="row align-items-center">
            <div class="col-md-4 text-center border-end-md mb-4 mb-md-0">
              <div class="rating-big">
                <span class="rating-number">{{ averageRating }}</span><span class="rating-max">/5</span>
              </div>
              <div class="stars mb-2">
                <i v-for="star in 5" :key="star"
                  :class="star <= Math.round(averageRating) ? 'fas fa-star filled' : 'far fa-star empty'"></i>
              </div>
              <div class="text-muted small">
                {{ reviewCount }} calificaciones
                <span class="mx-2">|</span>
                <a href="#" @click.prevent="showQualifyModal" class="text-dark fw-bold text-decoration-underline">Escribir reseña</a>
              </div>
            </div>
  
            <div class="col-md-6 offset-md-1">
              <div class="rating-bars">
                <div v-for="star in [5, 4, 3, 2, 1]" :key="star" class="d-flex align-items-center mb-2">
                  <span class="star-label me-2">{{ star }} <i class="fas fa-star" style="font-size: 0.8rem;"></i></span>
                  <div class="progress flex-grow-1 custom-progress">
                    <div class="progress-bar custom-progress-bar" role="progressbar"
                      :style="{ width: ratingDistribution[star] + '%' }"></div>
                  </div>
                  <span class="count-label ms-3 text-muted small">{{ ratingCountsComputed[star] }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="reviews-list mt-5">
          <div v-if="isLoadingReviews" class="text-center py-5">
            <div class="spinner-border text-secondary" role="status"></div>
          </div>

          <div v-else>
            <div v-if="reviews.length === 0" class="text-center text-muted py-5">
              <i class="far fa-comment-dots fa-3x mb-3 opacity-50"></i>
              <p>Sé la primera persona en calificar este producto.</p>
            </div>

            <div v-else class="review-items">
              <div v-for="review in reviews" :key="review.id" class="review-item py-4 border-bottom border-light-gray">
                <div class="row">
                  <div class="col-md-3 mb-2 mb-md-0">
                    <h6 class="review-author fw-bold mb-1">{{ review.user?.name || 'Anónimo' }}</h6>
                    <div class="stars-small mt-1">
                      <i v-for="star in 5" :key="star"
                        :class="star <= review.rating ? 'fas fa-star filled-small' : 'far fa-star empty-small'"></i>
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
          <div class="modal-body text-center p-4 p-md-5 pt-2">
            <h3 class="fw-bold text-uppercase mb-3">Guía de Tallas</h3>
            <p class="text-muted mb-4 small">
              Encuentra la equivalencia de tallas según tu medida en centímetros.
            </p>
            <div class="table-responsive">
               <table class="table size-guide-table">
                  <thead>
                     <tr>
                        <th>USA</th>
                        <th>CM</th>
                        <th>Perú</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr><td>5</td><td>22 cm</td><td>36</td></tr>
                     <tr><td>6</td><td>23 cm</td><td>37</td></tr>
                     <tr><td>7</td><td>24 cm</td><td>38</td></tr>
                     <tr><td>8</td><td>24.5 cm</td><td>39</td></tr>
                     <tr><td>9</td><td>25.5 cm</td><td>40</td></tr>
                     <tr><td>10</td><td>26.5 cm</td><td>41</td></tr>
                  </tbody>
               </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalCalificacion" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow">
          <div class="modal-header border-0">
            <button type="button" class="btn-close" @click="closeQualifyModal"></button>
          </div>
          <div class="modal-body p-4 p-md-5 text-center">
            <div v-if="showSuccessAnimation">
              <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
              <h4 class="fw-bold">¡Gracias por tu reseña!</h4>
            </div>
            <div v-else>
              <h5 class="fw-bold text-uppercase mb-3">Califica este producto</h5>
              <div class="rating-selector mb-4">
                <i v-for="star in 5" :key="star" class="fa-star mx-1"
                  :class="star <= selectedRating ? 'fas text-warning' : 'far text-muted'"
                  style="font-size: 2rem; cursor: pointer; transition: 0.2s;" @click="selectRating(star)"></i>
              </div>
              <input v-model="reviewTitle" type="text" class="form-control rounded-0 mb-3" placeholder="Título (opcional)">
              <textarea v-model="reviewComment" class="form-control rounded-0 mb-4" rows="4" placeholder="Cuéntanos tu experiencia con este producto..."></textarea>
              <button class="btn btn-dark rounded-0 w-100 py-2 fw-bold" @click="submitReview" :disabled="isSubmitting">
                {{ isSubmitting ? 'ENVIANDO...' : 'ENVIAR RESEÑA' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 p-4 p-md-5 text-center border-0 shadow">
          <div class="modal-header border-0 p-0 mb-3">
             <button type="button" class="btn-close ms-auto" @click="closeAuthModal"></button>
          </div>
          <i class="far fa-user-circle fa-3x mb-3 text-muted"></i>
          <h5 class="fw-bold text-uppercase">Inicia sesión</h5>
          <p class="text-muted small mb-4">Debes estar registrado para realizar esta acción y guardar tus preferencias.</p>
          <div class="d-flex flex-column gap-2">
            <a href="/user" class="btn btn-dark rounded-0 py-2">INICIAR SESIÓN</a>
            <a href="/register" class="btn btn-outline-dark rounded-0 py-2">CREAR CUENTA</a>
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
      colors: [], sizes: [], products: [], favorites: [], products_carrito: [],
      reviews: [], isLoadingReviews: false, selectedRating: 0,
      reviewTitle: '', reviewComment: '', isSubmitting: false, showSuccessAnimation: false,
      tabs: [ { id: 'details', title: 'Detalles' }, { id: 'shipping', title: 'Envíos y Devoluciones' } ]
    };
  },
  computed: {
    isLoggedIn() { return !!this.user; },
    currentImage() { return this.product.images && this.product.images.length ? this.product.images[this.currentSlide] : null; },
    isFavorite() { return this.favorites.some(f => f.ProductID === this.product.ProductID); },

    glamProducts() { 
        return this.products.filter(item => item.Tipo === 'Novias' && item.ProductID !== this.product.ProductID); 
    },

    ratingCountsComputed() {
        const counts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
        if (this.reviews && this.reviews.length > 0) {
            this.reviews.forEach(r => { 
                const rating = Math.round(r.rating);
                if (counts[rating] !== undefined) counts[rating]++; 
            });
        }
        return counts;
    },
    ratingDistribution() {
        const dist = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
        const total = this.reviews.length;
        if (total > 0) {
            const counts = this.ratingCountsComputed;
            for (let s in counts) { dist[s] = (counts[s] / total) * 100; }
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
      interval = seconds / 604800;
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
        const phoneNumber = "51920775278"; 
        let message = `Hola Perlux, estoy interesada en el producto: *${product.Name}*`;
        if (this.selectedColor && this.selectedSize) {
            const colorName = this.getColorName(this.selectedColor);
            const sizeName = this.getSizeName(this.selectedSize);
            message += `\nColor: ${colorName}\nTalla: ${sizeName}`;
        } else {
            message += `\n(Aún no he seleccionado talla/color)`;
        }
        const price = this.getSelectedVariantPriceSelect();
        message += `\nPrecio: S/${price}`;
        message += `\nCantidad: ${this.quantity}`;
        message += `\n\n¿Tienen disponibilidad?`;

        const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank');
    },
    refreshCartData() {
        const stored = localStorage.getItem('products');
        this.products_carrito = stored ? JSON.parse(stored) : [];
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

    updateCarrito() {
        this.refreshCartData(); 
        if (!this.isLoggedIn) { $('#authModal').modal('show'); return; }
        if (!this.selectedColor) { Swal.fire({ icon: 'warning', title: 'Elige un color', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); return; }
        if (!this.selectedSize) { Swal.fire({ icon: 'warning', title: 'Elige una talla', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); return; }

        const variant = this.product.variants.find(v => v.ColorID === this.selectedColor && v.SizeID === this.selectedSize);
        if (!variant || variant.StockQuantity < this.quantity) {
            Swal.fire({ icon: 'error', title: 'Stock insuficiente', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 }); return;
        }

        const cartKey = `${this.product.ProductID}-${this.selectedSize}-${this.selectedColor}`;
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
        window.dispatchEvent(new Event('cart-updated'));

        Swal.fire({ icon: 'success', title: 'Agregado al carrito', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
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
        this.refreshCartData();
        const idx = this.favorites.findIndex(f => f.ProductID === item.ProductID);
        if (idx > -1) this.favorites.splice(idx, 1);
        else this.favorites.push(item);
        
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
        window.dispatchEvent(new Event('favorites-updated'));
    },
    isProductFavorite(item) { return this.favorites.some(f => f.ProductID === item.ProductID); },

    nextImage() { if (this.product.images) this.currentSlide = (this.currentSlide + 1) % this.product.images.length; },
    prevImage() { if (this.product.images) this.currentSlide = (this.currentSlide - 1 + this.product.images.length) % this.product.images.length; },
    goToSlide(i) { this.currentSlide = i; },
    
    scrollSlider(direction) {
      const slider = this.$refs.productSlider;

      const scrollAmount = slider.clientWidth; 
      if (direction === 'left') {
        slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      } else {
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      }
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
            Swal.fire({ icon: 'warning', title: 'Selecciona una calificación', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            return;
        }
        this.isSubmitting = true;
        try {
            await axios.post('/reviews', { 
                user_id: this.user.id, product_id: this.productId, 
                rating: this.selectedRating, title: this.reviewTitle, comment: this.reviewComment 
            });
            this.showSuccessAnimation = true;
            this.loadReviews();
            setTimeout(() => { 
                this.showSuccessAnimation = false; 
                this.closeQualifyModal(); 
                this.reviewTitle = ''; this.reviewComment = ''; this.selectedRating = 0;
            }, 1500);
        } catch (error) { 
            Swal.fire({ icon: 'error', title: 'Error al enviar', text: 'Inténtalo de nuevo más tarde', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        } finally { 
            this.isSubmitting = false; 
        }
    },
  },
  async mounted() {
    this.refreshCartData();
    window.addEventListener('cart-updated', this.refreshCartData);
    window.addEventListener('favorites-updated', this.refreshCartData);
    await this.loadData();
    await this.loadReviews();
  },
  beforeUnmount() {
    window.removeEventListener('cart-updated', this.refreshCartData);
    window.removeEventListener('favorites-updated', this.refreshCartData);
  }
};
</script>

<style scoped>

.product-container {
  padding-top: 140px;
  padding-bottom: 50px;
  background: #fff;
}

.product-image-wrapper-main {
  position: relative;
  width: 100%;
  aspect-ratio: 3 / 4; 
  background-color: #f8f9fa;
  overflow: hidden;
  border-radius: 4px;
}
.product-image-main {
  width: 100%; height: 100%; 
  object-fit: cover; object-position: top center;
}

.carousel-control {
  position: absolute; top: 50%; transform: translateY(-50%);
  background: rgba(255,255,255,0.7); border: none;
  font-size: 1.2rem; color: #333;
  width: 40px; height: 40px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  z-index: 10; transition: all 0.3s ease; cursor: pointer;
}
.carousel-control:hover { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.carousel-control.prev { left: 15px; }
.carousel-control.next { right: 15px; }

.carousel-indicators-custom {
  position: absolute; bottom: 20px; left: 50%;
  transform: translateX(-50%); display: flex; gap: 8px; z-index: 10;
}
.indicator { width: 8px; height: 8px; border-radius: 50%; background: rgba(0,0,0,0.3); cursor: pointer; transition: all 0.3s ease; }
.indicator.active { background: #000; transform: scale(1.2); }

.heart-wishlist {
  position: absolute; top: 20px; right: 20px;
  width: 40px; height: 40px; border-radius: 50%;
  background: #fff; display: flex; align-items: center; justify-content: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1); cursor: pointer; font-size: 1.2rem;
  transition: transform 0.2s; z-index: 10;
}
.heart-wishlist:hover { transform: scale(1.1); }

.product-details-sticky { position: sticky; top: 120px; padding: 0 20px; }
.product-title { font-size: 1.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #000; margin-bottom: 8px; }
.price { font-size: 1.4rem; color: #333; font-weight: 500; }
.section-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

.color-selector { display: flex; gap: 12px; }
.color-option { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e0e0e0; cursor: pointer; transition: all 0.2s; }
.color-option.active { transform: scale(1.1); box-shadow: 0 0 0 2px #fff, 0 0 0 3px #000; border-color: transparent; }

.size-guide { font-size: 0.8rem; text-decoration: underline; cursor: pointer; color: #666; font-weight: 600; }
.btn-size-select { border: 1px solid #ddd; background: #fff; color: #333; min-width: 50px; height: 45px; font-weight: 600; border-radius: 4px; transition: all 0.2s ease; }
.btn-size-select:hover { border-color: #000; }
.btn-size-select.active { background: #000; color: #fff; border-color: #000; }

.alert-light-custom { background: #f8f9fa; padding: 10px 15px; border-radius: 4px; font-size: 0.85rem; border: 1px solid #eee; }

.quantity-selector { display: flex; border: 1px solid #ddd; border-radius: 4px; width: 120px; }
.quantity-selector button { font-weight: bold; width: 40px; }
.quantity-selector input { font-weight: bold; pointer-events: none; }

.add-to-cart-btn {
  background: #000; color: #fff; border: 1px solid #000; padding: 14px;
  font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
  border-radius: 0; transition: all 0.3s;
}
.add-to-cart-btn:not(.disabled-btn):hover { background: #333; color: #fff; }
.disabled-btn { background: #ccc !important; border-color: #ccc !important; cursor: not-allowed; }

.text-primary-custom { color: #5b6da0; font-weight: 600; }
.qualify-link { font-size: 0.85rem; text-decoration: underline; cursor: pointer; color: #555; }

.custom-tabs { display: flex; border-bottom: 2px solid #f0f0f0; }
.tab-button {
  background: none; border: none; padding: 10px 0; margin-right: 30px;
  font-weight: 700; color: #999; text-transform: uppercase; font-size: 0.85rem;
  border-bottom: 2px solid transparent; margin-bottom: -2px; transition: color 0.3s;
}
.tab-button.active { color: #000; border-bottom-color: #000; }

.bg-light-custom { background-color: #fafafa; }

.glam-home-image {
  width: 100%;
  max-width: 220px;
  height: auto;
}

.slider-container {
  position: relative;
  padding: 0 60px;
}

.slider-wrapper {
  overflow-x: auto;
  scroll-behavior: smooth;
  scroll-snap-type: x mandatory;
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.slider-wrapper::-webkit-scrollbar {
  display: none;
}

.slider-track { 
  display: flex; 
  gap: 20px; 
}

.slider-item { 
  flex: 0 0 280px; 
  scroll-snap-align: center;
}

.product-image-cards { aspect-ratio: 3/4; object-fit: cover; width: 100%; border-radius:0px; }
.fondo-info-product { background: #fff; }

.heart-btn-bottom i { font-size: 1.2rem; }
.text-primary-custom { color: #6da5da !important; }

.btn-comprar {
  background: transparent; border: 1px solid #000; color: #000;
  font-weight: 700; font-size: 0.75rem; padding: 10px;
  text-transform: uppercase; transition: all 0.1s; border-radius: 0;
}
.btn-comprar:hover { background: #6da5da; color: #fff; border-color: #6da5da; }

.btn-whatsapp-card, .btn-whatsapp {
  background-color: #ffffff; color: #2b8d4f; border: 1px solid #2b8d4f;
  font-size: 0.75rem; font-weight: 700; padding: 10px; border-radius: 0;
  text-transform: uppercase; transition: all 0.1s ease;
  display: flex; align-items: center; justify-content: center;
}
.btn-whatsapp-card:hover, .btn-whatsapp:hover { background-color: #2b8d4f; color: #fff; }


.slider-nav-btn {
  position: absolute; top: 40%; transform: translateY(-50%);
  width: 45px; height: 45px; border-radius: 50%;
  background: #fff; border: 1px solid #eee;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 5;
  display: flex; align-items: center; justify-content: center; cursor: pointer;
  color: #000; font-size: 1.2rem;
}
.slider-prev { left: 5px; }
.slider-next { right: 5px; }

.section-title-big { font-size: 1.5rem; font-weight: 800; letter-spacing: 2px; }
.section-divider { width: 60px; border-top: 3px solid #000; opacity: 1; }
.rating-number { font-size: 4rem; font-weight: 700; line-height: 1; }
.rating-max { font-size: 1.5rem; color: #999; }
.border-light-gray { border-color: #eaeaea !important; }

.custom-progress { height: 8px; background-color: #f0f0f0; border-radius: 10px; }
.custom-progress-bar { background-color: #6da5da; border-radius: 10px; }
.star-label .fa-star{ width: 35px; font-weight: 600; font-size: 0.9rem; color: #6da5da;}
.count-label { width: 25px; text-align: right; }

.stars .filled { color: #6da5da; }
.stars .empty { color: #e0e0e0; }
.stars-small .filled-small { color: #6da5da; font-size: 0.85rem; }
.stars-small .empty-small { color: #e0e0e0; font-size: 0.85rem; }

.size-guide-table th { background: #f8f9fa; color: #000; font-weight: 700; padding: 15px; border-bottom: 2px solid #000; }
.size-guide-table td { padding: 15px; border-bottom: 1px solid #eee; }

@media (max-width: 991px) {
  .product-details-sticky { position: static; padding: 0; }
}

@media (max-width: 768px) {
  .product-container { padding-top: 100px; }
  .product-title { font-size: 1.5rem; }
  .border-end-md { border-right: none !important; }
  
  .action-buttons-group { flex-direction: column !important; }
  .quantity-selector { width: 100%; justify-content: space-between; margin-bottom: 10px; }
  
  .glam-home-image { max-width: 160px; }

  .slider-container { padding: 0 40px; }
  .slider-item { 
    flex: 0 0 100%;
  }
}
</style>