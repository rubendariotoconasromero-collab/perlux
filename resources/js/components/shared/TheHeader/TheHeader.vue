<template>
  <div>
    <header id="main-header" class="fixed-top"
      :class="{ 'header-scrolled': activeDropdown === 'bodys' || activeDropdown === 'jeans' || scrolled }">
      <div class="container-fluid px-lg-4 px-2">
        <nav class="navbar navbar-expand-lg p-0 w-100 d-flex align-items-center">
          
          <button class="navbar-toggler border-0 p-0 order-1 d-lg-none custom-toggler" type="button" @click="toggleMobileMenu" aria-label="Menu">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>

          <a href="/" class="navbar-brand order-2 order-lg-1 brand-center-mobile">
            <img src="/images/site/resources/logo_perlux.svg" alt="Perlux Logo" class="logo-img" loading="lazy"/>
          </a>

          <div class="nav-icons-wrapper d-flex align-items-center order-3 ms-auto ms-lg-0">
            <a href="/user" class="nav-icon-link me-3" id="user-nav-link" aria-label="Usuario">
              <template v-if="!user">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              </template>
              <template v-else>
                <div class="user-avatar" :title="user.name">
                  {{ getUserInitial(user.name) }}
                </div>
              </template>
            </a>
            
            <a href="#" class="nav-icon-link position-relative me-3" @click.prevent="toggleFavoritesSidebar" aria-label="Favoritos">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
              <span v-if="favoritesCount > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill custom-badge">
                {{ favoritesCount }}
              </span>
            </a>

            <a href="#" class="nav-icon-link position-relative" @click.prevent="toggleCartSidebar" aria-label="Carrito">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
              <span v-if="cartCount > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill custom-badge">
                {{ cartCount }}
              </span>
            </a>
          </div>

          <div class="collapse navbar-collapse order-4 order-lg-2 justify-content-center d-none d-lg-flex" id="navbarNavDesktop">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="/">Inicio</a>
              </li>
              
              <li class="nav-item dropdown position-static" @mouseenter="showDropdown('bodys')" @mouseleave="hideDropdown('bodys')">
                <div class="d-flex align-items-center justify-content-between w-100">
                  <a class="nav-link" href="/glam" :class="{ active: activeDropdown === 'bodys' }">Glam</a>
                </div>
                
                <div class="dropdown-menu collections-dropdown shadow-sm" :class="{ 'show': activeDropdown === 'bodys' }">
                  <div class="container py-lg-4 py-2"> 
                    <div class="row align-items-center">
                      <div class="col-lg-3 d-none d-lg-flex justify-content-center border-end pe-4">
                          <img src="/images/site/resources/glam-plomo.svg" alt="Perlux Glam" class="img-fluid" style="max-width: 140px;">
                      </div>
                      <div class="col-lg-3 ps-lg-5 mb-4 mb-lg-0">
                        <h6 class="dropdown-header text-dark fw-bold mb-3 d-none d-lg-block">CATEGORÍAS</h6>
                        <ul class="list-unstyled category-list m-0">
                          <li v-for="cat in collections.slice(0,4)" :key="cat.CollectionID">
                              <a :href="'/glam?CollectionID='+cat.CollectionID" class="dropdown-item">{{ cat.CollectionName }}</a>
                          </li>
                          <li class="mt-3"><a href="/glam" class="dropdown-item fw-bold text-decoration-underline">Ver todo</a></li>
                        </ul>
                      </div>

                      <div class="col-lg-6 d-none d-lg-block">
                        <div class="row g-3">
                          <div class="col-4 text-center" v-for="collection in collections.slice(-3)" :key="collection.CollectionID">
                            <a :href="'/glam?CollectionID=' + collection.CollectionID" class="product-preview-link">
                              <div class="img-wrapper mb-2 rounded shadow-sm">
                                <img :src="collection.Image" :alt="collection.CollectionName" class="img-fluid">
                              </div>
                              <span class="fw-bold text-dark small text-uppercase">{{ collection.CollectionName }}</span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item dropdown position-static" @mouseenter="showDropdown('jeans')" @mouseleave="hideDropdown('jeans')">
                <div class="d-flex align-items-center justify-content-between w-100">
                  <a class="nav-link" href="/novias" :class="{ active: activeDropdown === 'jeans' }">Novias</a>
                </div>

                <div class="dropdown-menu collections-dropdown shadow-sm" :class="{ 'show': activeDropdown === 'jeans' }">
                  <div class="container py-lg-4 py-2"> 
                    <div class="row align-items-center">
                      <div class="col-lg-3 d-none d-lg-flex justify-content-center border-end pe-4">
                          <img src="/images/site/resources/novias-negro.svg" alt="Perlux Novias" class="img-fluid" style="max-width: 140px;">
                      </div>
                      <div class="col-lg-3 ps-lg-5 mb-4 mb-lg-0">
                        <h6 class="dropdown-header text-dark fw-bold mb-3 d-none d-lg-block">CATEGORÍAS</h6>
                        <ul class="list-unstyled category-list m-0">
                          <li v-for="cat in collections_novias.slice(0,4)" :key="cat.CollectionID">
                              <a :href="'/novias?CollectionID='+cat.CollectionID" class="dropdown-item">{{ cat.CollectionName }}</a>
                          </li>
                          <li class="mt-3"><a href="/novias" class="dropdown-item fw-bold text-decoration-underline">Ver todo</a></li>
                        </ul>
                      </div>

                      <div class="col-lg-6 d-none d-lg-block">
                        <div class="row g-3">
                          <div class="col-4 text-center" v-for="collection in collections_novias.slice(-3)" :key="collection.CollectionID">
                            <a :href="'/novias?CollectionID=' + collection.CollectionID" class="product-preview-link">
                              <div class="img-wrapper mb-2 rounded shadow-sm">
                                <img :src="collection.Image" :alt="collection.CollectionName" class="img-fluid">
                              </div>
                              <span class="fw-bold text-dark small text-uppercase">{{ collection.CollectionName }}</span>
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

    <div class="mobile-menu-sidebar d-lg-none" :class="{ 'active': isMobileMenuOpen }">
      <div class="mobile-menu-header">
        <button class="btn-close-menu" @click="closeMobileMenu" aria-label="Cerrar Menú">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>
      
      <div class="mobile-menu-content">
        <ul class="mobile-nav-list">
          <li><a href="/">Inicio</a></li>
          <li><a href="/glam">Glam</a></li>
          <li><a href="/novias">Novias</a></li>
          <li><a href="/nosotros">Nosotros</a></li>
        </ul>
      </div>

      <div class="mobile-menu-footer">
        <a href="/user" class="btn btn-dark w-100 py-3 fw-bold mb-2 text-uppercase">Mi Cuenta</a>
      </div>
    </div>

    <div class="favorites-sidebar" :class="{ 'active': showFavoritesSidebar }">
      <div class="sidebar-header">
        <h5 class="mb-0 fw-bold">
          <i class="far fa-heart me-2 text-dark"></i> Mis Favoritos ({{ favoritesCount }})
        </h5>
        <button class="btn-close-sidebar" @click="closeFavoritesSidebar" aria-label="Cerrar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="sidebar-content">
        <div v-if="favorites.length === 0" class="empty-state">
          <i class="far fa-heart empty-icon"></i>
          <p>Tu lista de deseos está vacía.</p>
          <a href="/" class="btn btn-outline-dark mt-2" @click="closeFavoritesSidebar">Descubrir productos</a>
        </div>
        <div v-else class="favorites-list">
          <div v-for="product in favorites" :key="product.ProductID" class="favorite-item">
            <div class="favorite-image">
              <img :src="getProductImage(product)" :alt="product.Name" loading="lazy">
            </div>
            <div class="favorite-info">
              <h6 class="product-name" :title="product.Name">{{ product.Name }}</h6>
              <p class="product-price">S/{{ product.Price }}</p>
              <a :href="'/detail_glam?product_id='+product.ProductID" class="link-view">Ver detalles</a>
            </div>
            <button class="btn-remove" @click="removeFavorite(product)" title="Eliminar">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      </div>
      <div v-if="favorites.length > 0" class="sidebar-footer">
        <a href="/user?section=favoritos" class="btn btn-dark w-100 fw-bold py-3">VER TODOS MIS FAVORITOS</a>
      </div>
    </div>
    
    <div class="favorites-sidebar" :class="{ 'active': showCartSidebar }">
      <div class="sidebar-header">
        <h5 class="mb-0 fw-bold">
          <i class="fas fa-shopping-bag me-2 text-dark"></i> Mi Carrito ({{ cartCount }})
        </h5>
        <button class="btn-close-sidebar" @click="closeCartSidebar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="sidebar-content">
        <div v-if="products_carrito.length === 0" class="empty-state">
          <i class="fas fa-shopping-bag empty-icon"></i>
          <p>Tu carrito de compras está vacío.</p>
          <a href="/" class="btn btn-outline-dark mt-2" @click="closeCartSidebar">Ir a la tienda</a>
        </div>
        <div v-else class="favorites-list">
          <div v-for="(product, index) in products_carrito" :key="generateCartKey(product, index)" class="cart-item">
            <div class="cart-item-image">
              <img :src="getProductImage(product)" :alt="product.Name" loading="lazy">
            </div>
            <div class="cart-item-details">
              <h6 class="product-title" :title="product.Name">{{ product.Name }}</h6>
              <span class="product-price fw-bold">S/ {{ getCartItemPrice(product) }}</span>
              
              <div class="product-variants mt-2" v-if="product.selectedVariant">
                 <span v-if="product.selectedVariant.color">Color: <strong>{{ product.selectedVariant.color.ColorName }}</strong></span>
                 <span v-if="product.selectedVariant.size">Talla: <strong>{{ product.selectedVariant.size.SizeName }}</strong></span>
                 <span v-if="product.quantity">Cant: <strong>{{ product.quantity }}</strong></span>
              </div>
            </div>
            <button class="btn-remove" @click="removeFromCart(index)" title="Eliminar">
              <i class="fas fa-trash-alt" style="font-size:0.9rem;"></i>
            </button>
          </div>
        </div>
      </div>

      <div v-if="products_carrito.length > 0" class="sidebar-footer">
        <div class="cart-total d-flex justify-content-between align-items-end mb-3">
            <span class="text-muted text-uppercase" style="font-size:0.8rem; letter-spacing:1px;">Subtotal estimado</span>
            <strong class="fs-4">S/{{ cartTotal }}</strong>
        </div>
        <button @click="handleCartAccess" class="btn btn-dark w-100 fw-bold py-3" :disabled="processingAuth">
            <span v-if="processingAuth" class="spinner-border spinner-border-sm me-2"></span>
            {{ processingAuth ? 'PROCESANDO...' : 'PROCEDER AL PAGO' }}
        </button>
      </div>
    </div>

    <div class="sidebar-overlay" :class="{ 'active': showFavoritesSidebar || showCartSidebar }" @click="closeAllSidebars"></div>

    <div class="modal fade" id="authModalCart" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow">
          <div class="modal-body text-center p-5">
            <i class="fas fa-lock fa-3x mb-3 text-muted"></i>
            <h4 class="fw-bold text-uppercase mb-2">Inicia Sesión</h4>
            <p class="text-muted small mb-4">Para procesar tu pago de forma segura y rastrear tu pedido, por favor accede a tu cuenta.</p>
            <div class="d-flex flex-column gap-2">
               <a href="/user" class="btn btn-dark rounded-0 py-2 fw-bold">INICIAR SESIÓN</a>
               <a href="/register" class="btn btn-outline-dark rounded-0 py-2 fw-bold">CREAR CUENTA NUEVA</a>
               <button class="btn btn-link text-muted mt-2 text-decoration-none small" @click="closeModalAuthCart">Continuar comprando</button>
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
      isMobileMenuOpen: false,
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
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen;
      this.showFavoritesSidebar = false;
      this.showCartSidebar = false;
    },
    closeMobileMenu() {
      this.isMobileMenuOpen = false;
    },

    toggleFavoritesSidebar() { 
      this.showFavoritesSidebar = !this.showFavoritesSidebar; 
      this.showCartSidebar = false; 
      this.isMobileMenuOpen = false;
    },
    toggleCartSidebar() { 
      this.showCartSidebar = !this.showCartSidebar; 
      this.showFavoritesSidebar = false; 
      this.isMobileMenuOpen = false;
    },
    closeAllSidebars() { 
      this.showFavoritesSidebar = false; 
      this.showCartSidebar = false; 
      this.isMobileMenuOpen = false;
    },
    showDropdown(type) { 
      if(window.innerWidth > 991) this.activeDropdown = type; 
    },
    hideDropdown(type) { 
      if(window.innerWidth > 991) {
        setTimeout(() => { if (this.activeDropdown === type) this.activeDropdown = null; }, 150); 
      }
    },

    toggleMobileDropdown(type) {
      this.activeDropdown = this.activeDropdown === type ? null : type;
    },
    toggleFavoritesSidebar() { this.showFavoritesSidebar = !this.showFavoritesSidebar; this.showCartSidebar = false; },
    closeFavoritesSidebar() { this.showFavoritesSidebar = false; },
    toggleCartSidebar() { this.showCartSidebar = !this.showCartSidebar; this.showFavoritesSidebar = false; },
    closeCartSidebar() { this.showCartSidebar = false; },
    closeAllSidebars() { this.showFavoritesSidebar = false; this.showCartSidebar = false; },
    
    updateLocalData() {
        const storedCart = localStorage.getItem('products');
        this.products_carrito = storedCart ? JSON.parse(storedCart) : [];
        const storedFavs = localStorage.getItem('favorites');
        this.favorites = storedFavs ? JSON.parse(storedFavs) : [];
    },

    getUserInitial(name) { return name ? name.charAt(0).toUpperCase() : '?'; },
    
    getProductImage(product) {
        if (product.images && product.images.length > 0) return product.images[0].ImagePath;
        return product.image || '/images/placeholder.jpg'; 
    },

    getCartItemPrice(product) {
        if (product.selectedVariant && product.selectedVariant.Price) {
            return product.selectedVariant.Price;
        }
        return product.Price || 0;
    },

    generateCartKey(product, index) { return `${product.ProductID}-${index}`; },

    removeFavorite(product) {
        this.favorites = this.favorites.filter(f => f.ProductID !== product.ProductID);
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
        window.dispatchEvent(new Event('favorites-updated')); 
    },

    removeFromCart(index) {
        this.products_carrito.splice(index, 1);
        localStorage.setItem('products', JSON.stringify(this.products_carrito));
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

    handleCartAccess() {
        this.processingAuth = true;
        setTimeout(() => {
            if (!this.user) {
                $('#authModalCart').modal('show');
            } else {
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
    window.addEventListener('storage', this.updateLocalData);
    window.addEventListener('cart-updated', this.updateLocalData);
    window.addEventListener('favorites-updated', this.updateLocalData);
    
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

#main-header {
  background-color: #ffffff;
  padding: 15px 0;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
  transition: all 0.3s ease;
  z-index: 1040;
}

.logo-img {
  height: 28px;
  width: auto;
  transition: height 0.3s ease;
}

.nav-link {
  color: #1a1a1a !important;
  font-size: 0.95rem;
  font-weight: 600;
  padding: 10px 20px !important;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: color 0.2s;
}

.nav-link:hover, .nav-link.active {
  color: #7a7a7a !important;
}

.nav-icons-wrapper {
  gap: 10px;
  margin-right:5rem;
}

.nav-icon-link {
  color: #1a1a1a;
  transition: color 0.2s, transform 0.2s;
  display: flex;
  align-items: center;
  text-decoration: none;
}

.nav-icon-link:hover {
  color: #7a7a7a;
  transform: translateY(-2px);
}

.custom-badge {
  font-size: 0.65rem;
  padding: 4px 6px;
  min-width: 18px;
  background-color: #5498cf;
  color: #fff;
  border: 1px solid #fff;
  top: 5px !important;
}

.user-avatar {
  width: 32px;
  height: 32px;
  background-color: #5498cf;
  color: #fff;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 13px;
  font-weight: 700;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}
.nav-icon-link:hover .user-avatar {
  background-color: #333;
}

.dropdown-menu.collections-dropdown {
  position: absolute;
  top: 100%;
  left: -10%;   /* Ajusta para centrar el dropdown respecto al enlace */
  right: 0;       /* Ancla al borde derecho */
  width: 120%;    /* Ocupa el 100% exacto de la pantalla */
  margin: 0;      /* Quitamos el margin-left que tenías */
  border: none;
  border-top: 1px solid #f5f5f5;
  background: white;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
  display: block;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: -1;
  border-radius: 0;
  padding: 0;
}

.collections-dropdown.show {
  opacity: 1;
  visibility: visible;
  z-index: 1000;
}

.dropdown-header { letter-spacing: 1px; font-size: 0.8rem; color: #999; }
.category-list li { margin-bottom: 8px; }
.dropdown-item {
  padding: 5px 0;
  color: #444;
  font-size: 0.95rem;
  background: transparent !important;
  transition: color 0.2s, padding-left 0.2s;
}
.dropdown-item:hover { color: #000; padding-left: 8px; font-weight: 600; }

.img-wrapper {
  width: 100%;
  height: 200px;
  overflow: hidden;
  background-color: #f9f9f9;
}
.img-wrapper img {
  width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;
}
.product-preview-link { text-decoration: none; display: block; }
.product-preview-link:hover img { transform: scale(1.08); }
.product-preview-link span { display: block; margin-top: 10px; font-size: 0.85rem; letter-spacing: 0.5px; }

.favorites-sidebar {
  position: fixed;
  top: 0;
  right: -450px;
  width: 420px;
  max-width: 100vw;
  height: 100vh;
  background: #ffffff;
  z-index: 1060;
  box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  transition: right 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.favorites-sidebar.active { right: 0; }

.sidebar-header {
  padding: 25px;
  border-bottom: 1px solid #f0f0f0;
  display: flex; justify-content: space-between; align-items: center;
}
.btn-close-sidebar {
  background: transparent; border: none; font-size: 1.2rem; color: #999;
  transition: transform 0.3s, color 0.3s; cursor: pointer;
}
.btn-close-sidebar:hover { color: #000; transform: rotate(90deg); }

.sidebar-content {
  flex: 1; overflow-y: auto; padding: 0;
}
.sidebar-content::-webkit-scrollbar { width: 5px; }
.sidebar-content::-webkit-scrollbar-thumb { background-color: #e0e0e0; border-radius: 10px; }

.empty-state {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  height: 100%; text-align: center; color: #666; padding: 40px;
}
.empty-icon { font-size: 3.5rem; margin-bottom: 15px; color: #eaeaea; }

.cart-item, .favorite-item {
  display: flex; gap: 20px; padding: 20px 25px;
  border-bottom: 1px solid #f8f9fa; position: relative;
}
.cart-item-image, .favorite-image {
  width: 80px; height: 100px; flex-shrink: 0; background: #f9f9f9; overflow: hidden;
}
.cart-item-image img, .favorite-image img {
  width: 100%; height: 100%; object-fit: cover;
}

.cart-item-details, .favorite-info { flex: 1; display: flex; flex-direction: column; justify-content: center; }
.product-title, .product-name { font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 5px; line-height: 1.3; }
.product-price { font-size: 0.9rem; color: #555; }
.link-view { font-size: 0.8rem; color: #7a7a7a; text-decoration: underline; margin-top: 5px; }
.link-view:hover { color: #000; }

.product-variants { display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.75rem; color: #666; }
.product-variants span strong { color: #000; }

.btn-remove {
  background: transparent; border: none; color: #ccc;
  cursor: pointer; transition: color 0.2s; padding: 0; margin-left: auto;
}
.btn-remove:hover { color: #dc3545; }

.sidebar-footer { padding: 25px; border-top: 1px solid #f0f0f0; background: #fff; }
.sidebar-overlay {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.4); z-index: 1050; opacity: 0; visibility: hidden; transition: all 0.3s;
}
.sidebar-overlay.active { opacity: 1; visibility: visible; }

.brand-center-mobile{
  margin-left:5rem;
}

@media (max-width: 991.98px) {
  #main-header { padding: 15px 10px; }

  .navbar { position: relative; justify-content: space-between; }
  .brand-center-mobile {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    margin: 0 !important;
    z-index: 10;
  }
  
  .logo-img { height: 22px; }
  
  .custom-toggler { color: #000; padding: 5px !important; z-index: 15; }
  .nav-icons-wrapper { gap: 0px; z-index: 15; margin-right: 0px;}

  .navbar-collapse {
    background: #fff;
    position: fixed;
    top: 60px;
    left: 0;
    width: 100vw;
    height: calc(100vh - 60px);
    padding: 0;
    border-top: 1px solid #f0f0f0;
    overflow-y: auto;
    z-index: 900;
  }
  
  .navbar-nav { padding: 20px; }
  
  .nav-item { border-bottom: 1px solid #f5f5f5; }
  
  .nav-link {
    padding: 18px 0 !important;
    font-size: 1.1rem;
    font-weight: 700;
  }

  .transition-icon { transition: transform 0.3s ease; }
  .transition-icon.rotated { transform: rotate(180deg); }

  .collections-dropdown {
    position: static !important;
    width: 100%;
    margin: 0 !important;
    box-shadow: none !important;
    border: none !important;
    padding: 0 0 15px 15px !important;
    background-color: #fafafa;
    display: none;
  }
  .collections-dropdown.show { display: block; }
  
  .category-list a { padding: 10px 0; font-size: 1rem; border-bottom: 1px solid #eee; display: block; }
  .category-list li:last-child a { border: none; }
}

@media (max-width: 576px) {
  .logo-img { height: 18px; margin-right: 30px; }
  .user-avatar { width: 28px; height: 28px; font-size: 11px; }
  .cart-item-image, .favorite-image { width: 70px; height: 90px; }
  .cart-item, .favorite-item { padding: 15px; }
}



.mobile-menu-sidebar {
  position: fixed;
  top: 0;
  left: -100%;
  width: 85%;
  max-width: 300px;
  height: 100vh;
  background-color: #ffffff;
  z-index: 1060;
  box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  transition: left 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.mobile-menu-sidebar.active {
  left: 0;
}

.mobile-menu-header {
  padding: 20px 25px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  border-bottom: 1px solid #f0f0f0;
}

.btn-close-menu {
  background: transparent;
  border: none;
  color: #000;
  padding: 5px;
  cursor: pointer;
  transition: transform 0.2s;
}
.btn-close-menu:hover {
  transform: rotate(90deg);
}

.mobile-menu-content {
  flex: 1;
  padding: 30px 25px;
  overflow-y: auto;
}

.mobile-nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.mobile-nav-list li {
  margin-bottom: 25px;
}

.mobile-nav-list a {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1a1a1a;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: block;
}

.mobile-menu-footer {
  padding: 25px;
  background-color: #fff;
  border-top: 1px solid #f0f0f0;
}


@media (max-width: 991.98px) {
  #main-header { padding: 15px 10px; }

  .navbar { position: relative; justify-content: space-between; }
  
  .brand-center-mobile {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    margin: 0 !important;
    z-index: 10;
  }
  
  .logo-img { height: 22px; }
  
  .custom-toggler { color: #000; padding: 5px !important; z-index: 15; outline: none; }
  .nav-icons-wrapper { gap: 0px; z-index: 15; margin-right: 0px;}
}

@media (max-width: 576px) {
  .logo-img { height: 18px; margin-right: 30px; }
  .user-avatar { width: 28px; height: 28px; font-size: 11px; }
  .cart-item-image, .favorite-image { width: 70px; height: 90px; }
  .cart-item, .favorite-item { padding: 15px; }
}
</style>