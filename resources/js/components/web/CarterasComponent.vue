<template>
  <div>
    <TheHeader :user="user" />

    <div class="collection-container container-fluid px-lg-5">
      <div class="row g-4">
        
        <div class="col-lg-3 col-md-4 col-12 filters-sidebar" :class="{ 'mobile-open': showMobileFilters }">
          <ProductFilters 
            :selectedSort="selectedSort"
            :filters="filters"
            :collections="collections"
            :colors="colors"
            :sizes="sizes"
            @update:selectedSort="filterProducts"
            @close="showMobileFilters = false"
          />
        </div>

        <div class="col-lg-9 col-md-8 col-12 products-grid">
          
          <div class="sticky-mobile-controls d-md-none">
            <div class="d-flex justify-content-between align-items-center py-2 px-3 bg-white border-bottom shadow-sm">
              <button class="btn btn-outline-dark btn-sm fw-bold rounded-0" @click="showMobileFilters = true">
                <i class="fas fa-sliders-h me-1"></i> FILTRAR
              </button>
            </div>
          </div>

          <div class="row row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3 g-md-4" :class="'row-cols-' + mobileGridCols">
            <div class="col" v-for="(product, index) in filteredProducts" :key="product.ProductID">
              <div class="product-card">
                <div class="product-image-wrapper-sq">
                  <a :href="'/detail_carteras?product_id=' + product.ProductID">
                    <img :src="product.images[0]?.ImagePath" :alt="product.Name" class="product-img-full">
                  </a>
                  <div v-if="isOutOfStock(product)" class="out-of-stock-badge">Agotado</div>
                </div>
                
                <div class="product-info">
                  <div class="d-flex justify-content-between align-items-start mt-3">
                    <div class="text-truncate me-2">
                      <h5 class="product-title">{{ product.Name }}</h5>
                      <p class="product-price">S/{{ product.Price }}</p>
                    </div>
                    <button class="btn-heart d-none d-md-block" @click="handleFavoriteClick(product)">
                      <i :class="product.isFavorite ? 'fas fa-heart' : 'far fa-heart'"></i>
                    </button>
                  </div>
                  
                  <div class="product-actions mt-3 d-none d-md-block">
                    <button class="btn-buy w-100 mb-2" @click="comprar(product)">
                      COMPRAR AHORA
                    </button>
                    <button class="btn-whatsapp w-100" @click="pedirPorWhatsapp(product)">
                      <i class="fab fa-whatsapp me-2"></i> PEDIR POR WHATSAPP
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="filteredProducts.length === 0" class="col-12 text-center py-5">
              <div class="empty-state">
                <i class="fas fa-search fa-3x mb-3 text-light-gray"></i>
                <p class="text-muted">No encontramos carteras con esos filtros.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <TheFooter />

    <div class="filter-sidebar-overlay d-md-none" :class="{ 'active': showMobileFilters }" @click="showMobileFilters = false"></div>

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
              <a href="/login" class="btn btn-dark">Iniciar Sesión</a>
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
import ProductFilters from '../shared/ProductFilters.vue'; 
import Swal from 'sweetalert2';

export default {
  components: { TheHeader, TheFooter, ProductFilters },
  props: {
    collection: { type: Number, required: false },
    user: { type: Object, required: false, default: null }
  },
  data() {
    return {
      selectedSort: '',
      showMobileFilters: false,
      mobileGridCols: 2,
      filters: {
        availability: [],
        collections: [],
        colors: [],
        sizes: []
      },
      collections: [],
      sizes: [],
      colors: [],
      products: [],
      originalProducts: [],
      favorites: []
    };
  },
  computed: {
    isLoggedIn() { return !!this.user; },
    filteredProducts() {
      let result = [...this.originalProducts];

      if (this.filters.availability.length > 0) {
        result = result.filter(p => {
          const inStock = this.calculateTotalStock(p) > 0;
          return (this.filters.availability.includes('inStock') && inStock) ||
                 (this.filters.availability.includes('outOfStock') && !inStock);
        });
      }

      if (this.filters.collections.length > 0) {
        result = result.filter(p => this.filters.collections.includes(p.CollectionID));
      }

      if (this.filters.sizes.length > 0) {
        result = result.filter(p => {
          if (p.variants && p.variants.length > 0) {
            return p.variants.some(variant => {
              const sizeObj = this.sizes.find(s => s.SizeID === variant.SizeID);
              return sizeObj && this.filters.sizes.includes(sizeObj.SizeName);
            });
          }
          return false;
        });
      }

      if (this.filters.colors.length > 0) {
        result = result.filter(p => {
          if (p.variants && p.variants.length > 0) {
            return p.variants.some(variant => this.filters.colors.includes(variant.ColorID));
          }
          return false;
        });
      }

      switch (this.selectedSort) {
        case '': result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at)); break;
        case '2': result.sort((a, b) => new Date(a.created_at) - new Date(b.created_at)); break;
        case '3': result.sort((a, b) => a.Name.localeCompare(b.Name)); break;
        case '4': result.sort((a, b) => b.Name.localeCompare(a.Name)); break;
        case '5': result.sort((a, b) => (parseFloat(a.Price) || 0) - (parseFloat(b.Price) || 0)); break;
        case '6': result.sort((a, b) => (parseFloat(b.Price) || 0) - (parseFloat(a.Price) || 0)); break;
        case '7': result.sort((a, b) => (b.IsFeatured ? 1 : 0) - (a.IsFeatured ? 1 : 0)); break;
      }
      return result;
    }
  },
  methods: {
    calculateTotalStock(p) {
        return p.variants ? p.variants.reduce((total, variant) => total + parseInt(variant.StockQuantity || 0), 0) : (p.StockQuantity || 0);
    },
    isOutOfStock(p) { return this.calculateTotalStock(p) <= 0; },
    
    pedirPorWhatsapp(product) {
      const phoneNumber = "51920775278";
      const message = `Hola Perlux, estoy interesada en la cartera: ${product.Name} (S/${product.Price}). ¿Tienen disponibilidad?`;
      window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
    },
    
    async loadData() {
      try {
        const response = await axios.get('/load_data');
        this.sizes = response.data.sizes || [];
        this.colors = response.data.colors || [];
        this.products = (response.data.products.filter(item => item.Tipo === 'Carteras') || []).map(p => ({
          ...p,
          isFavorite: false
        }));
        this.originalProducts = this.products;

        const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];
        this.favorites = savedFavorites;
        this.products.forEach(p => {
          p.isFavorite = this.favorites.some(fav => fav.ProductID === p.ProductID);
        });
      } catch (e) { console.error(e); }
    },
    
    async getCollections() {
      try {
        const response = await axios.get('/get_collections');
        this.collections = response.data || [];
      } catch (e) { console.error(e); }
    },

    filterProducts(val) { 
      this.selectedSort = val; 
    },
    
    handleFavoriteClick(product) {
      if (!this.isLoggedIn) { $('#authModal').modal('show'); return; }
      product.isFavorite = !product.isFavorite;
      this.updateFavorites(product);
    },
    updateFavorites(product) {
      if (product.isFavorite) {
        if (!this.favorites.some(f => f.ProductID === product.ProductID)) this.favorites.push({ ...product });
      } else {
        this.favorites = this.favorites.filter(fav => fav.ProductID !== product.ProductID);
      }
      localStorage.setItem('favorites', JSON.stringify(this.favorites));
    },
    
    closeAuthModal() { $('#authModal').modal('hide'); },
    comprar(product) { window.location.href = '/detail_carteras?product_id=' + product.ProductID; }
  },
  async mounted() {
    await this.loadData();
    await this.getCollections();
    if (this.collection) this.filters.collections.push(parseInt(this.collection));
  }
};
</script>

<style scoped>
.collection-container {
  padding-top: 140px;
  padding-bottom: 80px;
  background-color: #fff;
  max-width: 1600px;
  margin: 0 auto;
}

.filters-sidebar {
  padding-right: 30px;
  border-right: 1px solid #f0f0f0;
}

.sticky-mobile-controls {
  position: sticky;
  top: 70px;
  z-index: 100;
  margin-top: -10px;
  margin-bottom: 20px;
}

.product-card { height: 100%; display: flex; flex-direction: column; }
.product-image-wrapper-sq { position: relative; width: 100%; aspect-ratio: 1 / 1; overflow: hidden; background-color: #f7f7f7; border: 1px solid #eee; }
.product-img-full { width: 100%; height: 100%; object-fit: cover; transition: transform 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
.product-card:hover .product-img-full { transform: scale(1.1); }
.out-of-stock-badge { position: absolute; top: 10px; left: 10px; background: rgba(255, 255, 255, 0.9); color: #000; padding: 4px 12px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; z-index: 1; }
.product-title { font-size: 0.9rem; font-weight: 600; margin-bottom: 4px; text-transform: uppercase; color: #1a1a1a; }
.product-price { font-size: 0.95rem; color: #666; font-weight: 400; }
.btn-heart { background: none; border: none; padding: 0; color: #ccc; font-size: 1.1rem; }
.btn-heart .fas { color: #8a8a8a; }

.btn-buy, .btn-whatsapp { font-size: 0.7rem; font-weight: 700; letter-spacing: 1px; padding: 12px 5px; border-radius: 0; transition: all 0.1s ease; }
.btn-buy { background: #ffffff; color: #000000; border: 1px solid #000; }
.btn-buy:hover { background: #8a8a8a; border-color: #8a8a8a; color: #ffffff; }
.btn-whatsapp { background: #fff; color: #2b8d4f; border: 1px solid #2b8d4f; }
.btn-whatsapp:hover { background: #2b8d4f; color: #fff; }

.filter-sidebar-overlay {
  position: fixed;
  top: 0; left: 0; width: 100vw; height: 100vh;
  background: rgba(0,0,0,0.5);
  z-index: 1050;
  opacity: 0; visibility: hidden;
  transition: all 0.3s ease;
}
.filter-sidebar-overlay.active {
  opacity: 1; visibility: visible;
}

@media (min-width: 1200px) {
  .collection-container { padding-left: 60px; padding-right: 60px; }
}

@media (max-width: 991px) {
  .collection-container { padding-top: 100px; padding-left: 20px; padding-right: 20px; }
  .filters-sidebar { border-right: none; margin-bottom: 30px; }
}


@media (max-width: 767.98px) {
  .sticky-mobile-controls { top: 60px; } 
  .filters-sidebar {
    position: fixed;
    top: 0;
    left: -100%;
    width: 320px;
    max-width: 85vw;
    height: 100vh;
    background-color: #fff;
    z-index: 1060;
    overflow-y: auto;
    transition: left 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    padding: 25px;
    margin: 0;
  }
  .filters-sidebar.mobile-open {
    left: 0;
  }

  .products-grid > .row { --bs-gutter-x: 0.5rem; --bs-gutter-y: 0.5rem; }
  .product-title { font-size: 0.8rem; }
  .btn-buy, .btn-whatsapp { font-size: 0.65rem; padding: 10px 2px; }
}
</style>