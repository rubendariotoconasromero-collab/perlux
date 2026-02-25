<template>
  <div>
    <header id="main-header" class="fixed-top"
      :class="{ 'header-scrolled': activeDropdown === 'bodys' || activeDropdown === 'jeans' || scrolled }">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg p-0">
          
          <button class="navbar-toggler order-1 d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <a href="/" class="navbar-brand order-2 order-lg-1">
            <img src="/images/site/resources/logo_perlux.svg" alt="Perlux Logo" class="img-fluid" loading="lazy"/>
          </a>

          <div class="d-flex align-items-center order-3 order-lg-3">
            <a href="/user" class="me-3 nav-icon-link" id="user-nav-link" style="text-decoration:none">
              <template v-if="!user">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              </template>
              <template v-else>
                <div class="user-avatar" :title="user.name">
                  {{ getUserInitial(user.name) }}
                </div>
              </template>
            </a>
            
            <a href="#" class="me-3 position-relative nav-icon-link" @click.prevent="toggleFavoritesSidebar">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
              <span v-if="favoritesCount > 0"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark favorites-badge">
                {{ favoritesCount }}
              </span>
            </a>

            <a href="#" class="position-relative nav-icon-link" @click.prevent="toggleCartSidebar">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
              <span v-if="cartCount > 0"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark favorites-badge">
                {{ cartCount }}
              </span>
            </a>
          </div>

          <div class="collapse navbar-collapse order-4 order-lg-2 justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="/">Inicio</a>
              </li>
              
              <li class="nav-item dropdown" @mouseenter="showDropdown('bodys')" @mouseleave="hideDropdown('bodys')">
                <a class="nav-link" href="/glam" role="button" :class="{ active: activeDropdown === 'bodys' }">
                  Glam
                </a>
                <div class="dropdown-menu collections-dropdown" :class="{ 'show': activeDropdown === 'bodys' }">
                  <div class="container py-4"> 
                    <div class="row">
                      <div class="col-lg-3 d-flex align-items-center justify-content-center border-end">
                          <img src="/images/site/resources/glam-plomo.svg" alt="Perlux Glam" class="img-fluid" style="max-width: 160px;">
                      </div>
                      <div class="col-lg-3 ps-5 d-flex flex-column justify-content-center">
                        <h6 class="dropdown-header text-dark fw-bold mb-3">CATEGORÍAS</h6>
                        <ul class="list-unstyled category-list">
                          <li v-for="cat in collections.slice(0,4)" :key="cat.CollectionID">
                              <a :href="'/glam?CollectionID='+cat.CollectionID" class="dropdown-item">{{ cat.CollectionName }}</a>
                          </li>
                          <li class="mt-2"><a href="/glam" class="dropdown-item fw-bold text-decoration-underline">Ver todo</a></li>
                        </ul>
                      </div>

                      <div class="col-lg-6">
                        <div class="row g-3">
                          <div class="col-4 text-center" v-for="collection in collections.slice(-3)" :key="collection.CollectionID">
                            
                            <a :href="'/glam?CollectionID=' + collection.CollectionID" class="product-preview-link">
                              
                              <div class="img-wrapper mb-2">
                                <img :src="collection.Image" :alt="collection.CollectionName" class="img-fluid">
                              </div>
                              
                              <span class="fw-bold text-dark small">{{ collection.CollectionName }}</span>
                            </a>

                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item dropdown" @mouseenter="showDropdown('jeans')" @mouseleave="hideDropdown('jeans')">
                <a class="nav-link" href="/novias" role="button" :class="{ active: activeDropdown === 'jeans' }">
                  Novias
                </a>
                <div class="dropdown-menu collections-dropdown" :class="{ 'show': activeDropdown === 'jeans' }">
                  <div class="container py-4"> 
                    <div class="row">
                      <div class="col-lg-3 d-flex align-items-center justify-content-center border-end">
                          <img src="/images/site/resources/glam-plomo.svg" alt="Perlux Glam" class="img-fluid" style="max-width: 160px;">
                      </div>
                      <div class="col-lg-3 ps-5 d-flex flex-column justify-content-center">
                        <h6 class="dropdown-header text-dark fw-bold mb-3">CATEGORÍAS</h6>
                        <ul class="list-unstyled category-list">
                          <li v-for="cat in collections_novias.slice(0,4)" :key="cat.CollectionID">
                              <a :href="'/novias?CollectionID='+cat.CollectionID" class="dropdown-item">{{ cat.CollectionName }}</a>
                          </li>
                          <li class="mt-2"><a href="/novias" class="dropdown-item fw-bold text-decoration-underline">Ver todo</a></li>
                        </ul>
                      </div>

                      <div class="col-lg-6">
                        <div class="row g-3">
                          <div class="col-4 text-center" v-for="collection in collections_novias.slice(-3)" :key="collection.CollectionID">
                            
                            <a :href="'/novias?CollectionID=' + collection.CollectionID" class="product-preview-link">
                              
                              <div class="img-wrapper mb-2">
                                <img :src="collection.Image" :alt="collection.CollectionName" class="img-fluid">
                              </div>
                              
                              <span class="fw-bold text-dark small">{{ collection.CollectionName }}</span>
                            </a>

                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/nosotros">Nosotros</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <div class="favorites-sidebar" :class="{ 'active': showFavoritesSidebar }">
      <div class="sidebar-header">
        <h5 class="mb-0">
          <i class="fas fa-heart me-2"></i> Mis Favoritos ({{ favoritesCount }})
        </h5>
        <!--<button class="btn-close-sidebar" @click="closeFavoritesSidebar">
          <i class="fas fa-times"></i>
        </button>-->
        <button class="btn-close-sidebar" @click="closeFavoritesSidebar" aria-label="Cerrar">
          <i class="fas fa-times"></i>
        </button>

      </div>

      <div class="sidebar-content">
        <div v-if="favorites.length === 0" class="empty-favorites">
          <i class="fas fa-heart-broken empty-icon"></i>
          <p>No tienes productos en favoritos aún</p>
        </div>
        <div v-else class="favorites-list">
          <div v-for="product in favorites" :key="product.ProductID" class="favorite-item">
            <div class="favorite-image">
              <img :src="getProductImage(product)" :alt="product.Name" class="img-fluid">
            </div>
            <div class="favorite-info">
              <h6 class="product-name">{{ product.Name }}</h6>
              <p class="product-price">S/{{ product.Price }}</p>
              <a :href="'/detail_glam?product_id='+product.ProductID" class="btn btn-sm btn-link px-0 text-decoration-none">Ver producto</a>
            </div>
            <div class="favorite-actions">
              <button class="btn-remove-favorite" @click="removeFavorite(product)">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="favorites.length > 0" class="sidebar-footer">
        <a href="/user?section=favoritos" class="btn btn-primary w-100">Ver todos</a>
      </div>
    </div>
    
    <div class="favorites-sidebar" :class="{ 'active': showCartSidebar }">
      <div class="sidebar-header">
        <h5 class="mb-0">
          <i class="fas fa-shopping-cart me-2"></i> Mi Carrito ({{ cartCount }})
        </h5>
        <button class="btn-close-sidebar" @click="closeCartSidebar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="sidebar-content">
        <div v-if="products_carrito.length === 0" class="empty-favorites">
          <i class="fas fa-shopping-cart empty-icon"></i>
          <p>Tu carrito está vacío</p>
        </div>
        <div v-else class="favorites-list">
          <div v-for="(product, index) in products_carrito" 
               :key="generateCartKey(product, index)" 
               class="cart-item">
            <div class="cart-item-image">
              <img :src="getProductImage(product)" :alt="product.Name" class="product-image">
            </div>
            <div class="cart-item-details">
              <h6 class="product-title">{{ product.Name }}</h6>
              <span class="product-price">S/ {{ getCartItemPrice(product) }}</span>
              
              <div class="product-variants mt-1 text-muted small" v-if="product.selectedVariant">
                 <div v-if="product.selectedVariant.color">
                    Color: {{ product.selectedVariant.color.ColorName }}
                 </div>
                 <div v-if="product.selectedVariant.size">
                    Talla: {{ product.selectedVariant.size.SizeName }}
                 </div>
                 <div v-if="product.quantity">
                    Cant: {{ product.quantity }}
                 </div>
              </div>
            </div>
            <div class="cart-item-actions">
              <button class="btn-remove" @click="removeFromCart(index)">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="products_carrito.length > 0" class="sidebar-footer">
        <div class="cart-total mb-2 d-flex justify-content-between">
            <span>Total estimado:</span>
            <strong>S/{{ cartTotal }}</strong>
        </div>
        <button @click="handleCartAccess" class="btn btn-primary w-100" :disabled="processingAuth">
            <span v-if="processingAuth" class="spinner-border spinner-border-sm me-2"></span>
            {{ processingAuth ? 'Procesando...' : 'Ir a Pagar' }}
        </button>
      </div>
    </div>

    <div class="sidebar-overlay" :class="{ 'active': showFavoritesSidebar || showCartSidebar }" @click="closeAllSidebars"></div>

    <div class="modal fade" id="authModalCart" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center p-4">
            <i class="fas fa-lock fa-2x mb-3 text-muted"></i>
            <h5>Inicia sesión para comprar</h5>
            <p class="text-muted small mb-4">Necesitas una cuenta para procesar tu pedido.</p>
            <div class="d-grid gap-2">
               <a href="/user" class="btn btn-dark">Iniciar Sesión</a>
               <a href="/register" class="btn btn-outline-dark">Crear Cuenta</a>
               <button class="btn btn-link text-secondary" @click="closeModalAuthCart">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "TheHeader",
  props: {
    user: { type: Object, default: null }
  },
  data() {
    return {
      activeDropdown: null,
      showFavoritesSidebar: false,
      showCartSidebar: false,
      favorites: [],
      products_carrito: [],
      collections: [],
      collections_novias: [],
      scrolled: false,
      processingAuth: false
    };
  },
  computed: {
    cartCount() { return this.products_carrito.length; },
    favoritesCount() { return this.favorites.length; },
    
    cartTotal() {
      return this.products_carrito.reduce((total, p) => {
        const price = this.getCartItemPrice(p);
        const qty = p.quantity || 1;
        return total + (parseFloat(price) * qty);
      }, 0).toFixed(2);
    }
  },
  methods: {
    // --- Lógica de Interfaz ---
    showDropdown(type) { this.activeDropdown = type; },
    hideDropdown(type) { 
      setTimeout(() => { if (this.activeDropdown === type) this.activeDropdown = null; }, 150); 
    },
    toggleFavoritesSidebar() { this.showFavoritesSidebar = !this.showFavoritesSidebar; this.showCartSidebar = false; },
    closeFavoritesSidebar() { this.showFavoritesSidebar = false; },
    toggleCartSidebar() { this.showCartSidebar = !this.showCartSidebar; this.showFavoritesSidebar = false; },
    closeCartSidebar() { this.showCartSidebar = false; },
    closeAllSidebars() { this.showFavoritesSidebar = false; this.showCartSidebar = false; },
    
    // --- Lógica de Datos ---
    
    // Carga inicial de datos
    updateLocalData() {
        // Leer Carrito
        const storedCart = localStorage.getItem('products');
        this.products_carrito = storedCart ? JSON.parse(storedCart) : [];

        // Leer Favoritos
        const storedFavs = localStorage.getItem('favorites');
        this.favorites = storedFavs ? JSON.parse(storedFavs) : [];
    },

    // Helpers de visualización
    getUserInitial(name) { return name ? name.charAt(0).toUpperCase() : '?'; },
    
    getProductImage(product) {
        if (product.images && product.images.length > 0) return product.images[0].ImagePath;
        // Fallback si la estructura es diferente (ej. guardado simplificado en LS)
        return product.image || '/images/placeholder.jpg'; 
    },

    getCartItemPrice(product) {
        // Prioridad: Precio de variante -> Precio base
        if (product.selectedVariant && product.selectedVariant.Price) {
            return product.selectedVariant.Price;
        }
        return product.Price || 0;
    },

    generateCartKey(product, index) {
        // Clave única para v-for
        return `${product.ProductID}-${index}`;
    },

    // Acciones
    removeFavorite(product) {
        this.favorites = this.favorites.filter(f => f.ProductID !== product.ProductID);
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
        // Disparar evento para que otros componentes se actualicen
        window.dispatchEvent(new Event('favorites-updated')); 
    },

    removeFromCart(index) {
        // Usamos índice porque puede haber productos iguales con variantes distintas
        this.products_carrito.splice(index, 1);
        localStorage.setItem('products', JSON.stringify(this.products_carrito));
        // Disparar evento para que otros componentes se actualicen
        window.dispatchEvent(new Event('cart-updated'));
    },

    async getCollections() {
        try {
            const response = await axios.get('/get_collections');
            this.collections = response.data || [];
        } catch (e) { console.error("Error cargando menú:", e); }
    },

    async getCollectionsNovias() {
        try {
            const response = await axios.get('/get_collections_novias');
            this.collections_novias = response.data || [];
        } catch (e) { console.error("Error cargando menú:", e); }
    },

    // handleCartAccess() {
    //     this.processingAuth = true;
    //     // Simular pequeño delay
    //     setTimeout(() => {
    //         if (!this.user) {
    //             $('#authModalCart').modal('show');
    //         } else {
    //             window.location.href = '/pasarela'; // O tu ruta de checkout
    //         }
    //         this.processingAuth = false;
    //     }, 500);
    // },
    handleCartAccess() {
        this.processingAuth = true;
        setTimeout(() => {
            if (!this.user) {
                $('#authModalCart').modal('show');
            } else {
                // CAMBIO AQUÍ: Redirigir a la nueva ruta de checkout
                window.location.href = '/checkout'; 
            }
            this.processingAuth = false;
        }, 500);
    },
    
    closeModalAuthCart() { $('#authModalCart').modal('hide'); },

    handleScroll() {
        this.scrolled = window.scrollY > 50;
    }
  },
  mounted() {
    this.updateLocalData();
    this.getCollections();
    this.getCollectionsNovias();
    window.addEventListener('scroll', this.handleScroll);

    // ESCUCHAR EVENTOS PERSONALIZADOS
    // Esto permite que cuando ProductDetail actualice LS, el Header se entere.
    // NOTA: Debes agregar `window.dispatchEvent(new Event('cart-updated'))` 
    // en tu componente ProductDetail al agregar al carrito.
    
    // Listener para almacenamiento nativo (funciona entre pestañas)
    window.addEventListener('storage', this.updateLocalData);
    
    // Listener personalizado (funciona en la misma pestaña/app SPA)
    window.addEventListener('cart-updated', this.updateLocalData);
    window.addEventListener('favorites-updated', this.updateLocalData);
    
    // Intervalo de seguridad (opcional, por si los eventos fallan)
    this.polling = setInterval(() => {
        this.updateLocalData();
    }, 2000); 
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('storage', this.updateLocalData);
    window.removeEventListener('cart-updated', this.updateLocalData);
    window.removeEventListener('favorites-updated', this.updateLocalData);
    clearInterval(this.polling);
  }
};
</script>
<style scoped>
/* =========================================
   HEADER GENERAL
   ========================================= */
#main-header {
  background-color: #ffffff;
  /* Fondo blanco */
  padding: 15px 40px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.navbar-brand img {
  height: 22px;
  width: auto;
}

/* Enlaces Menú */
.nav-link {
  color: #333 !important;
  font-size: 0.95rem;
  font-weight: 500;
  padding: 10px 20px !important;
  text-transform: capitalize;
  transition: color 0.2s;
}

.nav-link:hover,
.nav-link.active {
  color: #666 !important;
}

/* Iconos */
.nav-icon-link {
  color: #333;
  transition: color 0.2s;
}

.nav-icon-link:hover {
  color: #666;
}

.favorites-badge {
  font-size: 0.6rem;
  padding: 3px 5px;
  min-width: 16px;
}

/* =========================================
   MEGA MENÚ (DROPDOWN GLAM)
   ========================================= */
.dropdown-menu.collections-dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100vw;
  /* Ancho completo */
  margin-left: calc(-50vw + 50%);
  /* Centrado full width */
  margin-top: 0;
  border: none;
  border-top: 1px solid #f0f0f0;
  background: white;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  display: block;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 999;
  border-radius: 0;
}

.collections-dropdown.show {
  opacity: 1;
  visibility: visible;
}

/* Elementos internos del Mega Menú */
.border-end {
  border-right: 1px solid #eee;
}

.dropdown-header {
  letter-spacing: 1px;
  font-size: 0.8rem;
}

.category-list li {
  margin-bottom: 8px;
}

.dropdown-item {
  padding: 0;
  color: #555;
  background: transparent;
  font-size: 0.95rem;
  transition: color 0.2s, padding-left 0.2s;
}

.dropdown-item:hover {
  color: #000;
  padding-left: 5px;
  background: transparent;
}

/* Imágenes Productos Destacados */
.product-preview-link {
  text-decoration: none;
  display: block;
  transition: opacity 0.2s;
}

.product-preview-link:hover {
  opacity: 0.8;
}

.img-wrapper {
  width: 100%;
  height: 180px;
  overflow: hidden;
  background-color: #f8f9fa;
  display: flex;
  align-items: center;
  justify-content: center;
}

.img-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.product-preview-link:hover img {
  transform: scale(1.05);
}


/* =========================================
   SIDEBARS (Estilos básicos)
   ========================================= */
.favorites-sidebar {
  position: fixed;
  top: 0;
  right: -420px; /* Un poco más ancho para mejor visualización */
  width: 420px;
  height: 100vh;
  background: #ffffff;
  z-index: 1060;
  box-shadow: -10px 0 30px rgba(0, 0, 0, 0.08); /* Sombra más suave y difusa */
  display: flex;
  flex-direction: column;
  transition: right 0.4s cubic-bezier(0.19, 1, 0.22, 1); /* Animación más "premium" */
}

.favorites-sidebar.active {
  right: 0;
}

.sidebar-header {
  padding: 25px 30px;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
}

.sidebar-header h5 {
  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: -0.5px;
  color: #1a1a1a;
  display: flex;
  align-items: center;
}

.sidebar-header h5 i {
  color: #e74c3c; /* Color rojo sutil para el corazón */
  font-size: 1rem;
}

.sidebar-content {
  flex: 1;
  overflow-y: auto;
  padding: 0; /* Quitamos padding general para que el hover ocupe todo el ancho */
  scrollbar-width: thin;
  scrollbar-color: #ddd transparent;
}

/* Scrollbar personalizado para Webkit (Chrome/Edge/Safari) */
.sidebar-content::-webkit-scrollbar {
  width: 6px;
}
.sidebar-content::-webkit-scrollbar-track {
  background: transparent;
}
.sidebar-content::-webkit-scrollbar-thumb {
  background-color: #ddd;
  border-radius: 10px;
}

.favorite-item {
  display: flex;
  padding: 20px 30px;
  border-bottom: 1px solid #f8f9fa;
  position: relative;
  transition: background-color 0.2s ease;
  gap: 20px;
}

.favorite-item:hover {
  background-color: #fcfcfc;
}

/* ******* */
/* Imagen del producto */
.favorite-image {
  width: 80px;
  height: 100px;
  flex-shrink: 0;
  background: #f4f4f4;
  border-radius: 4px;
  overflow: hidden;
}

.favorite-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.favorite-item:hover .favorite-image img {
  transform: scale(1.05);
}

/* Información del producto */
.favorite-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.product-name {
  font-size: 0.95rem;
  font-weight: 600;
  color: #111;
  margin-bottom: 5px;
  line-height: 1.3;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-price {
  font-size: 0.9rem;
  color: #666;
  margin-bottom: 8px;
  font-weight: 500;
}

.favorite-info .btn-link {
  font-size: 0.8rem;
  color: #000;
  text-decoration: underline;
  font-weight: 600;
  align-self: flex-start;
  padding: 0;
  transition: opacity 0.2s;
}

.favorite-info .btn-link:hover {
  opacity: 0.7;
}

.favorite-actions {
  display: flex;
  align-items: flex-start;
}

.btn-remove-favorite {
  background: transparent;
  border: none;
  color: #ccc; /* Gris claro por defecto para no ensuciar visualmente */
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  border-radius: 50%;
}

.btn-remove-favorite:hover {
  background-color: #fee2e2; /* Fondo rojo muy suave */
  color: #dc2626; /* Icono rojo */
}

/* =========================================
   ESTADO VACÍO (EMPTY STATE)
   ========================================= */
.empty-favorites {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  text-align: center;
  color: #999;
  padding: 40px;
}

.empty-icon {
  font-size: 3.5rem;
  margin-bottom: 20px;
  opacity: 0.3;
  color: #ccc;
}

.empty-favorites p {
  font-size: 1rem;
  font-weight: 500;
}

/* =========================================
   FOOTER DEL SIDEBAR
   ========================================= */
.sidebar-footer {
  padding: 25px 30px;
  border-top: 1px solid #f0f0f0;
  background: #fff;
}

.btn-primary.w-100 {
  padding: 14px;
  font-weight: 600;
  letter-spacing: 1px;
  font-size: 0.9rem;
  text-transform: uppercase;
  background: #000;
  border: 1px solid #000;
  transition: all 0.3s ease;
}

.btn-primary.w-100:hover {
  background: #fff;
  color: #000;
}



.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1050;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s;
}

.sidebar-overlay.active {
  opacity: 1;
  visibility: visible;
}

.cart-item {
  display: flex;
  gap: 20px;
  padding: 20px 30px;
  border-bottom: 1px solid #f8f9fa;
  background-color: #fff;
  transition: background-color 0.2s ease;
  align-items: flex-start; /* Alineación superior para variantes largas */
}

.product-title {
  font-size: 0.95rem;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 4px;
  line-height: 1.2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-variants {
  background-color: #f9f9f9;
  padding: 8px 10px;
  border-radius: 4px;
  font-size: 0.75rem;
  color: #666;
  line-height: 1.4;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.product-variants div {
  margin-right: 5px;
  position: relative;
}

/* Pequeño separador visual entre variantes (opcional) */
.product-variants div:not(:last-child)::after {
  content: "|";
  color: #ddd;
  margin-left: 8px;
}


.cart-item-actions {
  display: flex;
  align-items: flex-start;
  padding-top: 2px;
}



.btn-remove {
  background: transparent;
  border: none;
  color: #ccc; /* Gris claro por defecto para no ensuciar visualmente */
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  border-radius: 50%;
}

.btn-remove:hover {
  background-color: #fee2e2; /* Fondo rojo muy suave */
  color: #dc2626; /* Icono rojo */
}

/* =========================================
   FOOTER DEL CARRITO (TOTALES)
   ========================================= */
/* Ajuste específico para el footer cuando es carrito */
.sidebar-footer .cart-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #f0f0f0;
}

.cart-total span {
  font-size: 1rem;
  color: #666;
  font-weight: 500;
}

.cart-total strong {
  font-size: 1.2rem;
  color: #000;
  font-weight: 800;
  letter-spacing: -0.5px;
}

/* Botón de Pagar / Checkout */
.btn-primary:disabled {
  background-color: #ccc;
  border-color: #ccc;
  cursor: not-allowed;
}

/* Spinner dentro del botón */
.spinner-border-sm {
  width: 1rem;
  height: 1rem;
  border-width: 0.15em;
}

.cart-item:hover {
  background-color: #fcfcfc;
}

.cart-item-image {
  width: 70px;
  height: 90px;
  flex-shrink: 0;
  background: #f4f4f4;
  border-radius: 4px;
  overflow: hidden;
  position: relative;
}

.cart-item-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.cart-item-details {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.btn-remove{
  background: none;
  border: none;
  font-size: 1.1rem;
  color: #999;
}

.btn-remove:hover {
  color: red;
}

/* Botón de cerrar mejorado */
.btn-close-sidebar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #f8f9fa;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  cursor: pointer;
  color: #555;
}

.btn-close-sidebar:hover {
  background: #e9ecef;
  transform: rotate(90deg); /* Pequeña animación al interactuar */
  color: #000;
}

.btn-primary {
  background: #000;
  border: 1px solid #000;
  color: #fff;
  padding: 10px;
  border-radius: 0;
}

.btn-primary:hover {
  background: #333;

}

.user-avatar {
  width: 38px;
  height: 38px;
  background-color: #111;
  color: #fff;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  border: 2px solid #fff;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  user-select: none;
}

.nav-icon-link:hover .user-avatar {
  background-color: #444;
  transform: scale(1.1);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  border-color: #f0f0f0;
}

@media (max-width: 768px) {
 .navbar-brand img {
    height: 15px;
    width: auto;
  }

  .favorites-sidebar {
    width: 100%;
    right: -100%;
  }
  
  .favorite-item {
    padding: 15px 20px;
  }
  
  .favorite-image {
    width: 70px;
    height: 90px;
  }
}

@media (max-width: 991.98px) {
  #main-header {
    padding: 15px 20px;
  }

  .navbar-collapse {
    background: #fff;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    padding: 20px;
    border-top: 1px solid #eee;
    height: calc(100vh - 60px);
    overflow-y: auto;
  }

  .collections-dropdown {
    position: static;
    width: 100%;
    margin: 0;
    box-shadow: none;
    border: none;
    padding-left: 15px;
    visibility: visible;
    opacity: 1;
    display: none;
    /* Bootstrap handle toggling */
  }

  .collections-dropdown.show {
    display: block;
  }

  .border-end {
    border: none !important;
  }

  .col-lg-3 {
    margin-bottom: 20px;
    text-align: center;
  }

  .img-wrapper {
    height: 120px;
  }
}

@media (max-width: 576px) {
  .user-avatar {
    width: 30px;
    height: 30px;
    font-size: 12px;
  }

  .nav-link {
    padding: 10px 0 !important;
    font-size: 1.1rem;
  }

  .cart-item-image {
    width: 60px;
    height: 60px;
  }

  .favorites-sidebar {
    width: 100%;
    right: -100%;
  }
}
</style>