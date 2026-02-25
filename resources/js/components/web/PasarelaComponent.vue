<template>
  <header id="main-header" class="fixed-top header-scrolled" style="">
  <!-- <header id="main-header" class="fixed-top bg-transparent" :class="{ 'header-scrolled': activeDropdown === 'bodys' ||  activeDropdown === 'jeans'}"> -->
    <div class="container-fluid">
      <!-- Navbar responsive -->
      <nav class="navbar navbar-expand-lg p-0">
        <!-- Botón hamburguesa (solo visible en móvil) -->
        <button class="navbar-toggler order-1 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo (centrado en móvil, izquierda en desktop) -->
        <a href="/" class="navbar-brand order-2 order-lg-1">
          <img src="/images/site/svg/skinly_logo.svg" alt="Perlux Logo" class="img-fluid" />
        </a>

        <!-- Iconos (derecha en móvil y desktop) -->
        <div class="d-flex align-items-center order-3 order-lg-3">
          <!-- <a href="/user" class="me-3">
            <img src="/images/site/svg/icon_user.svg" alt="Perfil" class="img-fluid nav-icon" />
          </a> -->
          <a href="/user" class="me-3" id="user-nav-link" style="text-decoration:none">
              <template v-if="!user">
                  <img src="/images/site/svg/icon_user.svg" alt="Perfil" class="img-fluid nav-icon" loading="lazy"/>
              </template>
              <template v-else>
                  <div class="user-avatar" :title="user.name">
                      {{ getUserInitial(user.name) }}
                  </div>
              </template>
          </a>
          <!-- <a href="/wishlist" class="me-3">
            <img src="/images/site/svg/icon_heart.svg" alt="Lista de deseos" class="img-fluid nav-icon" />
          </a> -->
          <a href="#" class="me-3 position-relative" @click.prevent="toggleFavoritesSidebar">
            <img src="/images/site/svg/icon_heart.svg" alt="Lista de deseos" class="img-fluid nav-icon" />
            <span v-if="favoritesCount > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger favorites-badge">
              {{ favoritesCount }}
            </span>
          </a>

          <a href="/cart" class="me-3">
            <img src="/images/site/svg/icon_cart.svg" alt="Carrito" class="img-fluid nav-icon" />
          </a>
        </div>

        <!-- Menú de navegación (colapsa en móvil) -->
        <div class="collapse navbar-collapse order-4 order-lg-2" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Inicio</a>
            </li>
            <li class="nav-item dropdown" @mouseenter="showDropdown('bodys')" @mouseleave="hideDropdown('bodys')">
              <a class="nav-link dropdown-toggle" href="/glam" role="button" :class="{ active: activeDropdown === 'bodys' }">
                Bodys
              </a>
              <div class="dropdown-menu collections-dropdown" :class="{ show: activeDropdown === 'bodys' }">
                <hr>
                <div class="dropdown-content">
                  <div class="collections-section">
                    <h5 class="dropdown-title">COLECCIONES</h5>
                    <div class="collections-list">
                      <template v-for="(collection, index) in collections.slice(-3)" :key="collection.CollectionID">
                        <a :href="'/glam?CollectionID='+collection.CollectionID" class="dropdown-item">{{ collection.CollectionName }}</a>
                      </template>
                    </div>
                  </div>
                  <div class="collections-images">
                    
                    <div class="collection-item" v-for="(collection, index) in collections.slice(-3)" :key="collection.CollectionID">
                      <a :href="'/glam?CollectionID='+collection.CollectionID" style="text-decoration: none;">
                        <img :src="collection.Image" alt="Verano" class="collection-img">
                        <div class="collection-info">
                          <h6 class="text-start">{{ collection.CollectionName }}</h6>
                          <p class="text-start">{{ collection.Description }}</p>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            
            <li class="nav-item dropdown" @mouseenter="showDropdown('jeans')" @mouseleave="hideDropdown('jeans')">
              <a class="nav-link dropdown-toggle" href="/novias" role="button" :class="{ active: activeDropdown === 'jeans' }">
                Jeans Rat
              </a>
              <div class="dropdown-menu collections-dropdown" :class="{ show: activeDropdown === 'jeans' }">
                <hr>
                <div class="dropdown-content-jeans">
                  <div class="collections-section">
                    <h5 class="dropdown-title">COLECCIONES</h5>
                    <div class="collections-list">
                      <template v-for="(collection, index) in collections_jeans.slice(-3)" :key="collection.CollectionID">
                        <a :href="'/novias?CollectionID='+collection.CollectionID" class="dropdown-item">{{ collection.CollectionName }}</a>
                      </template>
                    </div>
                  </div>
                  <div class="collections-images">
                    <div class="collection-item" v-for="(collection, index) in collections_jeans.slice(-3)" :key="collection.CollectionID">
                      <a :href="'/novias?CollectionID='+collection.CollectionID" style="text-decoration: none;">
                        <img :src="collection.Image" alt="Verano" class="collection-img">
                        <div class="collection-info">
                          <h6 class="text-start">{{ collection.CollectionName }}</h6>
                          <p class="text-start">{{ collection.Description }}</p>
                        </div>
                      </a>
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

  <!-- Sidebar de favoritos -->
  <div class="favorites-sidebar" :class="{ 'active': showFavoritesSidebar }">
    <div class="sidebar-header">
      <h5 class="mb-0">
        <i class="fas fa-heart me-2"></i>
        Mis Favoritos ({{ favoritesCount }})
      </h5>
      <button class="btn-close-sidebar" @click="closeFavoritesSidebar">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <div class="sidebar-content">
      <div v-if="favorites.length === 0" class="empty-favorites">
        <i class="fas fa-heart-broken empty-icon"></i>
        <p>No tienes productos en favoritos aún</p>
        <small class="text-muted">Agrega productos que te gusten para verlos aquí</small>
      </div>

      <div v-else class="favorites-list">
        <div v-for="product in favorites" :key="product.ProductID" class="favorite-item">
          <div class="favorite-image">
            <img :src="product.images[0]?.ImagePath" :alt="product.Name" class="img-fluid">
          </div>
          <div class="favorite-info">
            <h6 class="product-name">{{ product.Name }}</h6>
            <p class="product-price">S/{{ getVariantPrice(product) }}</p>
            <!-- Mostrar colores únicos de las variantes -->
            <div class="product-colors">
              <span v-for="colorId in getUniqueColors(product)" :key="colorId" class="color-dot"
                :style="{ backgroundColor: getColorHex(colorId) }"></span>
            </div>
            <!-- Mostrar stock disponible -->
            <p class="product-stock" :class="{ 'out-of-stock': calculateTotalStock(product) === 0 }">
              <i class="fas fa-box" v-if="calculateTotalStock(product) > 0"></i>
              <i class="fas fa-exclamation-triangle" v-else></i>
              {{ calculateTotalStock(product) > 0 ? `Stock: ${calculateTotalStock(product)}` : 'Agotado' }}
            </p>
          </div>
          <div class="favorite-actions">
            <button class="btn-remove-favorite" @click="removeFavorite(product)" title="Quitar de favoritos">
              <i class="fas fa-heart-broken"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="favorites.length > 0" class="sidebar-footer">
      <a href="/user?section=favoritos" class="btn btn-primary w-100">Ver todos mis favoritos</a>
    </div>
  </div>

  <!-- Overlay para cerrar sidebar -->
  <div class="sidebar-overlay" :class="{ 'active': showFavoritesSidebar }" @click="closeFavoritesSidebar"></div>

  
  <div class="cart-page">
    <div class="container">

      <div class="row">
        <div class="col-lg-8">
          <h2>
            <i class="fas fa-shopping-cart me-2"></i>
            Mi Carrito ({{ cartCount }} productos)
          </h2>

          <!-- Productos en el carrito -->
          <div v-if="products_carrito.length === 0" class="empty-cart text-center py-5">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <h4>Tu carrito está vacío</h4>
            <p class="text-muted">Agrega productos para comenzar tu compra</p>
            <a href="/" class="btn btn-dark">Seguir comprando</a>
          </div>

          <div v-else>
            <div v-for="(product, index) in products_carrito" :key="product.ProductID" class="cart-item card mb-3">
              
              <div class="card-body position-relative">
                 <!-- Botón de eliminar en la esquina superior derecha -->
                <button @click="removeFromCart(product)" class="btn btn-sm btn-outline-danger position-absolute" 
                        style="top: 10px; right: 10px;" title="Eliminar">
                  <i class="fas fa-times"></i>
                </button>

                <div class="row align-items-center">
                  <div class="col-md-2">
                    <img :src="getProductImage(product)" :alt="product.Name" class="rounded card-image">
                  </div>
                  <div class="col-md-4">
                    <h5>{{ product.Name }}</h5>
                    <p class="text-muted mb-1">S/{{ getVariantPrice(product) }}</p>
                    <!-- <div v-if="product.selectedSize" class="size-info">
                      <small class="text-muted">Talla: {{ getSizeName(product.selectedSize, product.sizes) }}</small>
                    </div> -->

                    <div v-if="product.selectedVariant" class="variant-info mt-2">
                      <!-- Mostrar color con muestra visual -->
                      <div v-if="product.selectedVariant.color" class="d-flex align-items-center mb-1">
                        <div class="color-swatch me-2" :style="{
                          backgroundColor: product.selectedVariant.color.HexCode || '#CCCCCC',
                          width: '15px',
                          height: '15px',
                          borderRadius: '50%',
                          border: '1px solid #ddd'
                        }" :title="product.selectedVariant.color.ColorName"></div>
                        <small class="text-muted">Color: {{ product.selectedVariant.color.ColorName }}</small>
                      </div>
                      <!-- Mostrar talla -->
                      <div v-if="product.selectedVariant.size">
                        <small class="text-muted">Talla: <strong>{{ product.selectedVariant.size.SizeName
                            }}</strong></small>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-3">
                    <div class="quantity-controls d-flex align-items-center">
                      <button @click="updateQuantity(product, -1)" class="btn btn-sm btn-outline-secondary">-</button>
                      <span class="mx-2">{{ product.quantity || 1 }}</span>
                      <button @click="updateQuantity(product, 1)" class="btn btn-sm btn-outline-secondary">+</button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <strong>S/{{ getItemSubtotal(product) }}</strong>
                  </div>
                  <!-- <div class="col-md-1">
                    <button @click="removeFromCart(product)" class="btn btn-sm btn-outline-secondary" title="Eliminar">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card card-resume">
            <div class="card-header card-resume-header">
              <h5>Resumen del pedido</h5>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span>S/{{ cartSubtotal }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Envío:</span>
                <span>Gratis</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-3">
                <strong>Total:</strong>
                <strong class="text-dark">S/{{ cartTotal }}</strong>
              </div>

              <!-- Formulario de datos del cliente -->
              <div class="customer-info mb-3">
                <h6>Datos del cliente</h6>
                <div class="mb-2">
                  <input v-model="customerData.name" type="text" class="form-control form-control-sm"
                    placeholder="Nombre completo" required>
                </div>
                <div class="mb-2">
                  <input v-model="customerData.email" type="email" class="form-control form-control-sm"
                    placeholder="Email" required>
                </div>
                <div class="mb-2">
                  <input v-model="customerData.phone" type="text" class="form-control form-control-sm"
                    placeholder="Teléfono" required>
                </div>
                <div class="mb-2">
                  <input v-model="customerData.address" type="text" class="form-control form-control-sm"
                    placeholder="Dirección de entrega" required>
                </div>
                <div class="mb-2">
                  <input v-model="customerData.dni" type="text" class="form-control form-control-sm" placeholder="DNI"
                    required>
                </div>
              </div>

              <button @click="initiatePayment" class="btn btn-success btn-lg w-100 btn-pagar" :disabled="loading || !isFormValid">
                <span v-if="loading">
                  <span class="spinner-border spinner-border-sm me-2"></span>
                  Procesando...
                </span>
                <span v-else>
                  <i class="fas fa-credit-card me-2"></i>
                  Pagar con MercadoPago
                </span>
              </button>

              <div class="mt-2">
                <a href="/" class="btn btn-outline-dark btn-sm w-100">
                  <i class="fas fa-arrow-left me-1"></i>
                  Seguir comprando
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <footer class="text-center">
    <div class="footer-section">
      <p class="siguenos">Síguenos en <span> <br>NUESTRAS REDES</span></p>
      
      <div class="d-flex justify-content-center mb-3">
        <a href="https://facebook.com" target="_blank" class="">
            <img src="images/site/svg/facebook.svg" alt="Facebook" class="social-icon">
        </a>
        <a href="https://instagram.com" target="_blank" class="mx-5">
            <img src="images/site/svg/instagram.svg" alt="Instagram" class="social-icon">
        </a>
        <a href="https://tiktok.com" target="_blank" class="">
            <img src="images/site/svg/tiktok.svg" alt="TikTok" class="social-icon">
        </a>
      </div>
      <p class="link-footer">@skinly_peru</p>
    </div>

    <div class="row footer-section-contact">
        <div class="col-md-4">
            <h5>Navegación</h5>
            <ul class="list-unstyled">
                <li><a href="/" class="">Inicio</a></li>
                <li><a href="/glam" class="">Bodys</a></li>
                <li><a href="/novias" class="">Jeans Rat</a></li>
                <li><a href="/nosotros" class="">Nosotros</a></li>
                <li><a href="/user" class="">Usuario</a></li>
                <li><a href="/cart" class="">Carrito de Compras</a></li>
            </ul>
        </div>
        <!-- <div class="col-md-4 section-middle">
            <img src="/images/site/svg/skinly_logo.svg" alt="logo Perlux">
            <h5>MANTENTE INFORMADA</h5>
            <p>Sé la primera en descubrir nuestras colecciones, ofertas especiales y todas nuestras novedades</p>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Tu Correo">
                <button class="btn btn-dark rounded" type="button"><i class="fa-solid fa-angle-right"></i></button>
            </div>
            <small>
              A enviar tu correo electrónico, aceptas recibir mensajes de marketing recurrentes y automatizados
              de Perlux. Consulta nuestros <a href="#" >Términos y Condiciones</a> | <a href="#">Política de Privacidad</a>.
            </small>
        </div> -->
        <div class="col-md-4 section-middle">
            <img src="/images/site/svg/skinly_logo.svg" alt="logo Perlux" loading="lazy">
            <h5>MANTENTE INFORMADA</h5>
            <p>Sé la primera en descubrir nuestras colecciones, ofertas especiales y todas nuestras novedades</p>
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Tu Correo" v-model="email">
                <button class="btn btn-dark rounded" type="button" @click="subscribe"><i class="fa-solid fa-angle-right"></i></button>
            </div>
            <small>
              A enviar tu correo electrónico, aceptas recibir mensajes de marketing recurrentes y automatizados
              de Perlux. Consulta nuestros <a href="#" >Términos y Condiciones</a> | <a href="#">Política de Privacidad</a>.
            </small>
        </div>
        <div class="col-md-4 section-contact">
            <h5>Contacto</h5>
            <p>Correo: <a href="mailto:contacto@skinlyperu.com" class="">contacto@skinlyperu.com</a></p>
            <p>Teléfono: +51 955 705 137</p>
            <h5 class="ayuda">Ayuda</h5>
            <ul class="list-unstyled">
                <li><a href="#" class="">Libro de reclamaciones</a></li>
                <li><a href="#" class="">Términos y condiciones</a></li>
            </ul>
        </div>
    </div>

    <!-- Botón flotante de WhatsApp -->
    <a class="whatsapp-float" href="https://wa.me/51920775278" target="_blank">
        <img src="images/site/whatsapp.webp" alt="WhatsApp" class="float-icon">
    </a>

    <!-- Botón flecha hacia arriba -->
    <a class="arrow-top" href="#top">
        <img src="images/site/svg/arrow-top.svg" alt="Ir arriba" class="float-icon">
    </a>
  </footer>
</template>

<script>
import { loadMercadoPago } from '@mercadopago/sdk-js';
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
  props: {
    user: {
      type: Object,
      required: true
    },
  },
  name: 'CartPage',
  data() {
    return {
      last3Colors:[],
      sizes: [],
      colors: [],
      products: [],
      email: '',
      showFavoritesSidebar: false,
      ruta : window.location.pathname,
      collections:[],
      collections_jeans:[],
      activeDropdown: null,
      scrolled: 0,
      favorites:[],
      items: [
        { id: 1, image: "/images/site/obs1.jpg", title: "Fuerte", description: "Descripción de la característica" },
        { id: 2, image: "/images/site/obs2.jpg", title: "Elegante", description: "Descripción de la característica" },
        { id: 3, image: "/images/site/obs3.jpg", title: "Sensual", description: "Descripción de la característica" },
        { id: 4, image: "/images/site/obs4.jpg", title: "Segura", description: "Descripción de la característica" },
        { id: 5, image: "/images/site/obs5.jpg", title: "Flexible", description: "Descripción de la característica" },
        { id: 6, image: "/images/site/obs6.jpg", title: "Cómoda", description: "Descripción de la característica" },
      ],


      products_carrito: [],
      loading: false,
      mp: null,
      customerData: {
        name: '',
        email: '',
        phone: '',
        address: '',
        dni: ''
      }
    }
  },
  watch: {
    user: {
      handler(newUser) {
        if (newUser) {
          this.fillCustomerData(newUser);
        }
      },
      immediate: true
    }
  },
  computed: {
    cartCount() {
      return this.products_carrito.reduce((total, product) => total + (product.quantity || 1), 0);
    },
    
    cartSubtotal() {
      return this.products_carrito.reduce((total, product) => {
        const price = this.getVariantPrice(product); // Usar precio de variante
        const quantity = product.quantity || 1;
        return total + (parseFloat(price) * quantity);
      }, 0).toFixed(2);
    },
    
    cartTotal() {
      return this.cartSubtotal; // Puedes agregar impuestos aquí si es necesario
    },
    
    isFormValid() {
      return this.customerData.name && 
             this.customerData.email && 
             this.customerData.phone && 
             this.customerData.address && 
             this.customerData.dni;
    }
  },
  
  async mounted() {
    this.loadCartFromStorage();
    // Cargar datos del usuario si está logueado
    this.loadUserData();
    this.mountedHeader();

    await this.getCollections();
    await this.getCollectionsJeans();
    await this.loadData();
    // await this.loadFavorites();
  },
  
  methods: {
    fillCustomerData(userData) {
      this.customerData.name = userData.name || '';
      if (userData.last_name) {
        this.customerData.name += ' ' + userData.last_name;
      }
      this.customerData.email = userData.email || '';
      this.customerData.phone = userData.phone || '';
      this.customerData.dni = userData.dni || '';
      
      // Si necesitas una dirección específica, ajusta según tu estructura
      if (userData.addresses && userData.addresses.length > 0) {
        this.customerData.address = userData.addresses[0].address || '';
      }
    },
    // Obtener colores únicos de las variantes
    getUniqueColors(product) {
      if (product.variants && product.variants.length > 0) {
        const uniqueColorIds = [...new Set(product.variants.map(v => v.ColorID))];
        return uniqueColorIds.slice(0, 3); // Limitar a 3 colores como antes
      }
      return [];
    },

    // Obtener el código hexadecimal del color por ID
    getColorHex(colorId) {
      const color = this.colors.find(c => c.ColorID === colorId);
      return color ? color.HexCode : '#CCCCCC';
    },

    // Calcular stock total de todas las variantes
    calculateTotalStock(product) {
      if (product.variants && product.variants.length > 0) {
        return product.variants.reduce((total, variant) =>
          total + parseInt(variant.StockQuantity || 0), 0
        );
      }
      return 0;
    },

    // Verificar si el producto está disponible
    isProductAvailable(product) {
      return this.calculateTotalStock(product) > 0;
    },
    async loadData() {
      try {
        const response = await axios.get('/load_data');
        this.sizes = response.data.sizes;
        this.colors = response.data.colors;
        // this.products = response.data.products;
        this.products = response.data.products.map(product => ({
          ...product,
          isFavorite: product.isFavorite || false // Default to false if not present
        }));
        this.last3Colors = this.colors.slice(-3);
        console.log('SIZES:', this.sizes);

        this.originalProducts = this.products; // Guardar copia original

      } catch (error) {
        console.log('Error al obtener los datos: ', error.message);
      } finally {

      }
    },
    
    getUserInitial(fullName) {
      if (!fullName) return '?';
      return fullName.trim().charAt(0).toUpperCase();
    },
    async subscribe() {
      if (!this.email) {
        Swal.fire({
          icon: 'warning',
          title: 'Correo requerido',
          text: 'Por favor, ingresa tu correo electrónico.',
          confirmButtonText: 'Entendido',
          confirmButtonColor: '#3085d6'
        });
        return;
      }

      try {
        const response = await axios.post('/subscribe', { email: this.email }, {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        });

        // Éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.data.message,
          confirmButtonText: 'Cerrar',
          confirmButtonColor: '#3085d6'
        });

        // Limpiar el campo
        this.email = '';

      } catch (error) {
        let message = 'Error al suscribir. Intenta nuevamente.';

        if (error.response && error.response.data) {
          if (error.response.data.message) {
            message = error.response.data.message;
          } else if (error.response.data.errors) {
            message = Object.values(error.response.data.errors).flat().join(' ');
          }
        } else if (error.message) {
          message = error.message;
        }

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: message,
          confirmButtonText: 'Cerrar',
          confirmButtonColor: '#d33'
        });
      }
    },
    async loadFavorites() {
      // Cargar favoritos desde localStorage o desde el servidor
      const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];
      this.favorites = savedFavorites;
    },
    toggleFavoritesSidebar() {
      this.showFavoritesSidebar = !this.showFavoritesSidebar;
    },

    closeFavoritesSidebar() {
      this.showFavoritesSidebar = false;
    },

    removeFavorite(product) {

      // Remover de favoritos
      this.favorites = this.favorites.filter(fav => fav.ProductID !== product.ProductID);

      // Actualizar localStorage
      localStorage.setItem('favorites', JSON.stringify(this.favorites));
    },
    // Métodos del slider
    async getCollectionsJeans(){
      try{
        const response = await axios.get('/get_collections_jeans');
        this.collections_jeans=response.data;
        console.log('COLLECTIONS:', this.collections);
      }catch(error){
        console.log('Error al obtener las colecciones: ', error.message);
      }finally{

      }
    },
    async getCollections(){
      try{
        const response = await axios.get('/get_collections');
        this.collections=response.data;
        console.log('COLLECTIONS:', this.collections);
      }catch(error){
        console.log('Error al obtener las colecciones: ', error.message);
      }finally{

      }
    },
    showDropdown(type) {
      this.activeDropdown = type;

    },

    hideDropdown(type) {
      // Añadir un pequeño delay para mejor UX
      setTimeout(() => {
        if (this.activeDropdown === type) {
          this.activeDropdown = null;
        }
      }, 100);
    },

    mountedHeader() {
      const header = document.getElementById("main-header");
      const toggler = document.querySelector(".navbar-toggler-icon");
      let lastScrollY = window.scrollY;
      const scrollThreshold = 100;
      // this.scrolled=scrollThreshold;

      if (window.scrollY > scrollThreshold) {
        header.classList.add("header-scrolled");
      }

      window.addEventListener("scroll", () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > scrollThreshold && currentScrollY > lastScrollY) {
          header.classList.add("hidden");
        } else if (currentScrollY <= scrollThreshold || currentScrollY < lastScrollY) {
          header.classList.remove("hidden");
        }

        lastScrollY = currentScrollY;
      });
    },
    // Obtener el precio de la variante seleccionada
    getVariantPrice(product) {
      // Si el producto tiene una variante seleccionada y esa variante tiene un precio
      if (product.selectedVariant && product.selectedVariant.Price !== undefined && product.selectedVariant.Price !== null) {
        return parseFloat(product.selectedVariant.Price).toFixed(2);
      }
      // Si no hay variante seleccionada o no tiene precio, usar el precio base del producto
      return parseFloat(product.Price || 0).toFixed(2);
    },

    getItemSubtotal(product) {
      const price = this.getVariantPrice(product); // Usar precio de variante
      const quantity = product.quantity || 1;
      return (parseFloat(price) * quantity).toFixed(2);
    },
    loadCartFromStorage() {
      const storedCart = localStorage.getItem('products');
      if (storedCart) {
        this.products_carrito = JSON.parse(storedCart);
      }
    },
    
    loadUserData() {
      // Si tienes autenticación, cargar datos del usuario
      const user = JSON.parse(localStorage.getItem('user') || '{}');
      if (user.name) {
        this.customerData.name = user.name + (user.last_name ? ' ' + user.last_name : '');
      }
      if (user.email) {
        this.customerData.email = user.email;
      }
    },
    
    getProductImage(product) {
      if (product.images && product.images.length > 0) {
        return product.images[0].ImagePath || '/images/placeholder.jpg';
      }
      return '/images/placeholder.jpg';
    },
    
    getSizeName(sizeId, sizes) {
      const size = sizes.find(s => s.SizeID === sizeId);
      return size ? size.SizeName : '';
    },
    
   
    
    updateQuantity(product, change) {
      const currentIndex = this.products_carrito.findIndex(p => p.ProductID === product.ProductID);
      if (currentIndex !== -1) {
        const currentQuantity = this.products_carrito[currentIndex].quantity || 1;
        const newQuantity = currentQuantity + change;
        
        if (newQuantity > 0) {
          this.products_carrito[currentIndex].quantity = newQuantity;
        } else {
          this.removeFromCart(product);
        }
        
        localStorage.setItem('products', JSON.stringify(this.products_carrito));
      }
    },
    
    removeFromCart(product) {
      this.products_carrito = this.products_carrito.filter(item => item.ProductID !== product.ProductID);
      localStorage.setItem('products', JSON.stringify(this.products_carrito));
    },
    
    async initiatePayment() {
      if (!this.isFormValid) {
        alert('Por favor complete todos los datos del cliente');
        return;
      }
      
      this.loading = true;
      
      try {
        // Preparar items para MercadoPago
        // const items = this.products_carrito.map((product, index) => ({
        //   id: product.ProductID.toString(),
        //   title: product.Name,
        //   description: product.Description || 'Producto',
        //   picture_url: this.getProductImage(product),
        //   category_id: 'others',
        //   quantity: product.quantity || 1,
        //   currency_id: 'PEN',
        //   unit_price: parseFloat(product.Price)
        // }));
        const items = this.products_carrito.map((product, index) => {
          const price = this.getVariantPrice(product); // Usar precio de variante
          return {
            id: `${product.ProductID}-${product.selectedSize || 0}-${product.selectedColor || 0}`, // ID único de variante
            title: product.Name,
            description: `Talla: ${product.selectedVariant?.size?.SizeName || 'N/A'}, Color: ${product.selectedVariant?.color?.ColorName || 'N/A'}`,
            picture_url: this.getProductImage(product),
            category_id: 'others',
            quantity: product.quantity || 1,
            currency_id: 'PEN',
            unit_price: parseFloat(price)
          };
        });
        
        // Datos del comprador
        const payer = {
          name: this.customerData.name.split(' ')[0] || 'Cliente',
          surname: this.customerData.name.split(' ').slice(1).join(' ') || 'Sin apellido',
          email: this.customerData.email,
          phone: {
            area_code: '01', // Código de área de Perú
            number: this.customerData.phone.replace(/\D/g, '')
          },
          identification: {
            type: 'DNI',
            number: this.customerData.dni
          },
          address: {
            street_name: this.customerData.address,
            street_number: '',
            zip_code: '15001' // Código postal de ejemplo
          }
        };
        
        // Crear preferencia de pago
        const preference = {
          items: items,
          payer: payer,
          back_urls: {
            success: `${window.location.origin}/pago-exitoso`,
            failure: `${window.location.origin}/pago-fallido`,
            pending: `${window.location.origin}/pago-pendiente`
          },
          auto_return: 'approved',
          external_reference: this.generateOrderReference(),
          notification_url: `${window.location.origin}/mercadopago/webhook`,
          statement_descriptor: 'PERLUX',
          additional_info: `Pedido de ${this.customerData.name}`
        };
        
        // Guardar el pedido en la base de datos
        await this.saveOrder(preference);
        
        // Crear la preferencia en MercadoPago
        const response = await this.createPreference(preference);
        
        if (response.init_point) {
          // Redirigir a MercadoPago
          window.location.href = response.init_point;
        }
        
      } catch (error) {
        console.error('Error al iniciar el pago:', error);
        alert('Error al procesar el pago. Por favor, inténtalo nuevamente.');
      } finally {
        this.loading = false;
      }
    },
    
    async createPreference(preferenceData) {
      try {
        const response = await fetch('/mercadopago/create-preference', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          },
          body: JSON.stringify(preferenceData)
        });
        
        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Error al crear la preferencia de pago');
        }
        
        return await response.json();
      } catch (error) {
        console.error('Error al crear preferencia:', error);
        throw error;
      }
    },
    
    async saveOrder(preferenceData) {
      try {
        // Preparar los datos del pedido
        const orderData = {
          external_reference: preferenceData.external_reference,
          total_amount: this.cartTotal,
          currency: 'PEN',
          customer_name: this.customerData.name,
          customer_email: this.customerData.email,
          customer_phone: this.customerData.phone,
          shipping_address: this.customerData.address,
          additional_info: `DNI: ${this.customerData.dni}`,
          payer_info: preferenceData.payer,
          // items: this.products_carrito.map(product => ({
          //   product_id: product.ProductID,
          //   title: product.Name,
          //   quantity: product.quantity || 1,
          //   unit_price: parseFloat(product.Price),
          //   size_id: product.selectedSize || null
          // }))
          items: this.products_carrito.map(product => ({
            product_id: product.ProductID,
            title: product.Name,
            quantity: product.quantity || 1,
            unit_price: parseFloat(this.getVariantPrice(product)), // Usar precio de variante
            size_id: product.selectedVariant?.size?.SizeID || null,
            color_id: product.selectedVariant?.color?.ColorID || null,
            variant_id: product.selectedVariant?.VariantID || null // Si necesitas el ID de la variante
          }))
        };

        // Guardar el pedido en la base de datos
        const response = await fetch('/mercadopago/save-order', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          },
          body: JSON.stringify(orderData)
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Error al guardar el pedido');
        }

        const result = await response.json();
        console.log('Pedido guardado:', result);

      } catch (error) {
        console.error('Error al guardar el pedido:', error);
        throw error;
      }
    },
    
    generateOrderReference() {
      return 'ORD-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    }
  }
}
</script>

<style scoped>
.user-avatar {
    width: 33px;
    height: 33px;
   
    background-color: #fff;
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
    cursor: pointer;
    /* box-shadow: 0 2px 4px rgba(0,0,0,0.1); */
}

.card-image{
  max-width: 100%;
  height: auto;
}


.header-scrolled .user-avatar {
  background-color: #000;
  color: #fff;
  border: 1px solid gray;
}

/* Para pantallas pequeñas */
@media (max-width: 576px) {
    .user-avatar {
        width: 25px;
        height: 25px;
        font-size: 12px;
    }

    .nav-icon {
        width: 25px;
        height: 25px;
    }
}
/* Estilos del sidebar de favoritos */
.favorites-sidebar {
  position: fixed;
  top: 0;
  right: -400px;
  width: 400px;
  height: 100vh;
  background: white;
  z-index: 1060;
  box-shadow: -3px 0 15px rgba(0, 0, 0, 0.1);
  transition: right 0.3s ease;
  display: flex;
  flex-direction: column;
}

.favorites-sidebar.active {
  right: 0;
}

.sidebar-header {
  padding: 20px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: between;
  align-items: center;
  background: #f8f9fa;
}

.sidebar-header h5 {
  color: #333;
  font-weight: 600;
}

.btn-close-sidebar {
  background: none;
  border: none;
  font-size: 1.2rem;
  color: #666;
  cursor: pointer;
  padding: 5px;
  margin-left: auto;
}

.btn-close-sidebar:hover {
  color: #ff6699;
}

.sidebar-content {
  flex: 1;
  overflow-y: auto;
  padding: 0;
}

.empty-favorites {
  text-align: center;
  padding: 60px 20px;
  color: #666;
}

.empty-icon {
  font-size: 3rem;
  color: #ddd;
  margin-bottom: 20px;
}

.favorites-list {
  padding: 0;
}

.favorite-item {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.2s;
}

.favorite-item:hover {
  background-color: #f8f9fa;
}

.favorite-image {
  width: 60px;
  height: 75px;
  margin-right: 15px;
  flex-shrink: 0;
}

.favorite-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 5px;
}

.favorite-info {
  flex: 1;
}

.favorite-info .product-name {
  font-size: 0.9rem;
  font-weight: 600;
  margin: 0 0 5px 0;
  color: #333;
}

.favorite-info .product-price {
  font-size: 0.9rem;
  color: #666;
  margin: 0 0 8px 0;
}

.product-colors {
  display: flex;
  gap: 4px;
}

.color-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 1px solid #ddd;
}

.favorite-actions {
  margin-left: 10px;
}

.btn-remove-favorite {
  background: none;
  border: none;
  color: #ff6699;
  font-size: 1.1rem;
  cursor: pointer;
  padding: 5px;
}

.btn-remove-favorite:hover {
  color: #ff4d8a;
  transform: scale(1.1);
}

.sidebar-footer {
  padding: 20px;
  border-top: 1px solid #eee;
  background: #f8f9fa;
}

.sidebar-footer .btn-primary {
    background-color: #ffffff;
    color: #000000 !important;
    border: 1px solid #000;
    padding: 0.5rem 1.5rem;
    font-size: 1rem;
    border-radius: 0.6rem;
    transition: background-color 0.3s ease;
    width:100%;
    margin-top:1rem;
}

.sidebar-footer .btn-primary:hover {
    background-color: #000000;
    color: #ffffff;

}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1055;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.sidebar-overlay.active {
  opacity: 1;
  visibility: visible;
}

.favorites-badge {
  font-size: 0.7rem;
  padding: 2px 5px;
  min-width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Responsive para el sidebar */
@media (max-width: 768px) {
  .favorites-sidebar {
    width: 100vw;
    right: -100vw;
  }
  .cart-page {
    padding-top:5rem !important;
  }

  .card-image{
    margin-top: 2rem;
  }
}
</style>
<style scoped>


/* Estilos base */

/* seccion nuestra esencia */
.contenido-nosotros{
    padding-top:5rem;
}

.nuestra-esencia{
    
    height: auto;
    background-image: url('/images/site/svg/fondo_nosotros.svg');
    margin-left:0px !important;
    margin-right:0px !important;
    margin-top:0px !important;
    margin-bottom:0px !important;
    padding-top:0px !important;
    padding-bottom:0px !important;
    padding-left:auto;
    padding-right:auto;
    object-fit: cover;
    background-size:cover;
    border:1px solid red;
}



.nuestra-esencia-texto{
    padding-top:5rem;
    padding-bottom:5rem;
    padding-left:6rem;
    padding-right:6rem;
    display:flex;
    flex-direction: column;
    justify-content: center;
    margin-left:auto;
    margin-right:auto;
    /* background-color: #000; */
}

.nuestra-esencia-texto h2{
    font-size:4.0rem;
    color:#fff;
    font-weight: 800;
}

.nuestra-esencia-texto p{
    font-size:1.7rem;
    color:#fff;
    text-align:justify;
}

.nuestra-esencia-imagen{

    padding-top:5rem;
    padding-bottom:5rem;
    padding-left:1rem;
    padding-right:3rem;
    display:flex;
    justify-content:center;
    align-items:center;
}

.nuestra-esencia-imagen img{
    height:35rem;
    width:auto;
}

/* seccion filosofía */

.contenido-filosofia{
    height: 50vh;
    background-image: url('/images/site/fondo_filosofia.jpg');
    padding:8rem;
    object-fit: cover;
    background-size:cover;
    
}

.contenido-filosofia h2{
    font-size:2rem;
    font-weight:700;
    color:#fff;
}

.contenido-filosofia p{
    font-size:1.7rem;
    color:#fff;
    margin-top:1.5rem;
    margin-left:7rem !important;
    margin-right:7rem !important;
}


.contenido-empoderamiento{
    height: 50vh;
    /* background-image: url('/images/site/svg/fondo_filosofia.svg'); */
    background-color:#fff;
    padding:8rem;

}

.contenido-empoderamiento h2{
    font-size:1.9rem;
    font-weight:700;
    color:#ff6699;
}

.contenido-empoderamiento p{
    font-size:1.7rem;
    color:#000;
    margin-top:1.5rem;
    margin-left:10rem !important;
    margin-right:10rem !important;
    /* border:1px solid red; */
}

.contenido-empoderamiento img{
    height:3.2rem;
    margin-left:1rem;
    width:auto;
      filter: 
        brightness(0) 
        saturate(100%) 
        invert(59%) 
        sepia(39%) 
        saturate(4445%) 
        hue-rotate(299deg) 
        brightness(97%) 
        contrast(101%) !important;
}



.contenido-empoderamiento p{
    font-size:1.7rem;
    color:#000;
    margin-top:1.5rem;
    margin-left:3rem;
    margin-right:3rem;
}

#main-header{
  padding-left: 100px;
  padding-right: 100px;
  padding-top: 30px;
  padding-bottom: 30px;
  margin-left:0px;
  margin-right:0px;
  /* border: 1px solid gray; */
  transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

header {
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.nav-link:hover {
  color: #ff6699 !important;
  background-color: transparent;
}

.header-scrolled {
  background-color: #ffffff !important;
  background: rgb(255, 255, 255);

 /* border: 1px solid gray; */

  /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
}

.navbar-brand img{
  height: 40px;
}

.header-scrolled .navbar-brand img,
.header-scrolled .me-3 img {
  filter: invert(0%) brightness(0%);
}

.header-scrolled .nav-link {
  color: #000 !important;
  transition: color 0.3s ease;
}

.header-scrolled .nav-link:hover {
  color: #ff6699 !important;
  background-color: transparent;
}

.header-scrolled .me-3 img:hover,
.header-scrolled .navbar-brand:hover {
  filter: 
    brightness(0) 
    saturate(100%) 
    invert(59%) 
    sepia(39%) 
    saturate(4445%) 
    hue-rotate(299deg) 
    brightness(97%) 
    contrast(101%) !important;
}

header.hidden {
  transform: translateY(-100%);
}

.nav-link {
  color: #ffffff;
  font-size:1.3rem;
}

.bg-pink .nav-link {
  color: #343a40;
}

.bg-pink .nav-link:hover {
  color: #ff6699;
}

/* Estilos del dropdown */
.dropdown {
  position: relative;
}

.dropdown-toggle::after {
  display: none; /* Ocultar la flecha por defecto de Bootstrap */
}

.collections-dropdown {
  position: absolute;
  top: 90%;
  left: 0;
  right: 0;
  background: rgb(255, 255, 255);
  padding: 0;
  margin-top: 0px;
  width: 120vw;
  margin-left: calc(-50vw + 50%);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 1000;
  box-shadow: none !important;
  border: none !important;
  outline: none !important;
}  


.collections-dropdown.show {
  opacity: 1;
  visibility: visible;
}


.dropdown-content {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  justify-content: center;
  padding-left: 15rem;
  padding-right: auto;
  gap: 10px;
  max-width: 100vw;
  margin: 0 auto;
  width: 100% !important;
  box-sizing: border-box;
}


.dropdown-content-jeans {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  justify-content: center;
  padding-left: 10rem;
  padding-right: auto;
  gap: 10px;
  max-width: 100vw;
  margin: 0 auto;
  width: 100% !important;
  box-sizing: border-box;
}

.collections-section {
  flex: 1;
  min-width: 400px;
  display:flex;
  flex-direction: column;
}

.dropdown-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 25px;
  letter-spacing: 1px;
  padding-left:8rem;
}

.collections-list {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 18px;
  padding-left:8rem;

}

.dropdown-item {
  color: rgb(0, 0, 0);
  text-decoration: none;
  font-size: 1.1rem;
  padding: 0px 0;
  border: none;
  background: none;
  transition: color 0.3s ease;
}

.dropdown-item:hover {
  color: #ff6699;
  background: none;
}

.dropdown-item.active-item {
  color: #ff6699;
  font-weight: 600;
}

.collections-images {
  flex: 4;
  display: flex;
  flex-wrap: wrap;
  /* background-color:red ; */
  gap: 20px;
  width:100%;
}

.collection-item {
  /* flex: 1; */
  /* border:1px solid red; */
  width:10rem !important;
  height: auto !important;
  
}

.collection-img {
  width: 100%;
  height: 18rem;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;
  /* border:1px solid red; */
}

.collection-img img{
  width: 100%;
  height: auto;
  /* border:1px solid red; */
}

.collection-info h6 {
  font-size: 1rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 8px;
}

.collection-info p {
  font-size: 0.85rem;
  color: #000000;
  line-height: 1.4;
  margin: 0;
}

/* Estilos para cuando el header está scrolled */
.header-scrolled .collections-dropdown {
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

/* Primera sección */
.first-section{
  height: 100vh;
}

.first-section .section-new-woman{
  padding-left:100px;
  padding-right:100px;
  top: 80%; left: 22%; transform: translateY(-50%); text-align: left;
}

.btn-lista{
  border-radius:0px;
  font-size:2rem;
  padding-top:0px;
  padding-bottom:0px;
  font-weight: 600;
}

.btn-lista:hover{
  color:#ff6699;
}

img {
  max-width: 100%;
}

.display-4{
  font-size: 5rem;
  font-weight: 900;
  margin-bottom: 0px !important;
  padding-bottom: 0px !important;
}

.lead {
  font-size: 2rem;
  margin-top: 0px;
  padding-top: 0px;
}

/* Footer */
.footer-section{
    background-color:#000;
    padding-top:5rem;
    padding-bottom:5rem;
}

.footer-section .siguenos{
    color:#ffffff;
    font-size:2.2rem;
    line-height: 1.1;
}

.footer-section span{
    color:#ffffff;
    font-size:2.8rem;
    font-weight: 700;
}

.footer-section .link-footer{
    color:#ffffff;
    font-size:2.7rem;
    font-weight: 400;
}

.footer-section a img:hover{
    filter: 
    brightness(0) 
    saturate(100%) 
    invert(59%) 
    sepia(39%) 
    saturate(4445%) 
    hue-rotate(299deg) 
    brightness(97%) 
    contrast(101%) !important;
}


.footer-section{
    background-color:#000;
    padding-top:5rem;
    padding-bottom:5rem;
}

.social-icon {
    width: 55px;
    height: 55px;
    object-fit: contain;
    margin-top:10px;
    margin-bottom:10px;
    transition: transform 0.1s ease;
}

.social-icon:hover {
    transform: scale(1.1);
}

.footer-section-contact{
  margin:6rem;
}

.footer-section-contact .section-middle{
  padding-left:0px;
  padding-right:0px;
  display:flex;
  justify-content: center;
  flex-direction:column;
}

.footer-section-contact .section-middle p{
  font-weight: 500;
  margin-top:20px;
}

.footer-section-contact .section-middle .input-group{
  width: 70%;
  display:flex !important;
  justify-content:center !important;
  margin-left: auto;
  margin-right: auto;
}

.footer-section-contact .section-middle .input-group button{
  margin-left: 10px !important;
  border-radius: 12px !important;
  background-color:#000;
  font-size:1.4rem !important;
  padding-top:5px;
  padding-bottom:5px;
  padding-left:15px;
  padding-right:15px;
}

.footer-section-contact .section-middle .input-group button:hover{
  background-color:#ff6699;
  border:1px solid #ff6699;
}

.footer-section-contact .section-middle .input-group button i{
    font-size:1.4rem !important;
}

.footer-section-contact .section-middle .input-group input[type="email"] {
  margin-left: 10px !important;
  border-radius:10px !important;
  border: 1px solid #000;
  font-size:1.3rem !important;
}

.footer-section-contact .section-middle small{
  font-size:0.9rem;
  text-align: center;
  color:#000;
}

.footer-section-contact .section-middle small a{
  text-decoration: none;
  color:#000;
}

.footer-section-contact h5{
  color:#000;
  font-size:1.9rem;
  font-weight: 700;
}

.footer-section-contact ul li a{
  color:#000;
  font-size:1.2rem;
  text-decoration: none;
}

.footer-section-contact ul li a:hover{
  color:#ff6699;
}

.footer-section-contact ul li{
  margin-top: 1rem;
}

.footer-section-contact img{
  height:4rem;
  width:auto;
  filter: brightness(0);
  margin-bottom:2rem;
}

.footer-section-contact p{
  font-size:1.2rem;
  line-height: 1.2;
}

.footer-section-contact .section-contact .ayuda{
  margin-top:2.5rem;
}

.footer-section-contact .section-contact a{
  text-decoration: none;
  color:#000;
}

.footer-section-contact .section-contact li a:hover{
  color:#ff6699;
}

/* Botones flotantes */
.arrow-top {
  position: fixed;
  z-index: 1000;
  border-radius: 50%;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  width: 45px;
  height: auto;
}

.whatsapp-float {
  position: fixed;
  z-index: 1000;
  border-radius: 50%;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  width: 65px;
  height: auto;
}

.whatsapp-float:hover,
.arrow-top:hover {
  transform: translateY(-3px) scale(1.1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.float-icon {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.whatsapp-float {
  bottom: 20px;
  right: 20px;
}

.arrow-top {
  bottom: 100px;
  right: 30px;
}

/* Estilos del navbar responsivo */
.navbar {
  width: 100%;
}

.navbar-brand {
  margin: 0;
}

.nav-icon {
  width: 30px;
  height: 30px;
  transition: all 0.3s ease;
}

.navbar-toggler {
  border: none;
  padding: 0;
  background: none;
  width: 30px;
  height: 30px;
}

.navbar-toggler:focus {
  box-shadow: none;
}

.navbar-toggler-icon {
  background-image: none;
  width: 25px;
  height: 2px;
  background-color: #ffffff;
  position: relative;
  transition: all 0.3s ease;
}

.navbar-toggler-icon::before,
.navbar-toggler-icon::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 2px;
  background-color: #ffffff;
  transition: all 0.3s ease;
}

.navbar-toggler-icon::before {
  top: -8px;
}

.navbar-toggler-icon::after {
  top: 8px;
}

.navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
  background-color: transparent;
}

.navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
  transform: rotate(45deg);
  top: 0;
}

.navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
  transform: rotate(-45deg);
  top: 0;
}

.header-scrolled .navbar-toggler-icon,
.header-scrolled .navbar-toggler-icon::before,
.header-scrolled .navbar-toggler-icon::after {
  background-color: #000000;
}

/* Media queries para responsive */
@media (max-width: 991.98px) {
 .lead {
    font-size: 1rem;
  }
  .img-fluid {
    max-height: 150px;
  }


  /* nueva seccion */
  .navbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
  }

  .navbar-brand {
    /* padding-top: 0px !important; */
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    top: 15px;
    z-index: 1050;
  }

 
  .navbar-collapse {
    flex-basis: 100%;
    margin-top: 2rem;
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    backdrop-filter: blur(10px);
    margin-left: calc(-50px) !important;
    margin-right: calc(-50px) !important;
    width: calc(100% + 20px);
    border-radius: 0px;
    color:#000;
  }

  .navbar-collapse  .nav-link {
    color: #000 !important;
  }

  .navbar-nav {
    text-align: center;
  }

  .nav-item {
    margin: 10px 0;
  }

  .nav-link {
    font-size: 1.1rem;
    padding: 10px 20px;
    border-radius: 5px;
  }

  .nav-link:hover {
    background-color: rgba(255, 102, 153, 0.1);
  }

  .header-scrolled .navbar-collapse {
    background-color: rgb(255, 255, 255);
  }

  .header-scrolled .nav-link {
    color: #000 !important;
  }

  /* fin nueva seccion */



  .contenido-nosotros{
    padding-top:2rem;
  }

  .nuestra-esencia{
    height:auto;
    padding-top:10rem;

  }

  .nuestra-esencia-texto{
    padding-top:8rem;
    padding-bottom:2rem;
    padding-left:2rem;
    padding-right:2rem;
  }

  .nuestra-esencia-texto h2{
    font-size:3rem;
  }

  .nuestra-esencia-texto p{
    font-size:1.3rem;
  }

  .nuestra-esencia-imagen{
    padding-top:8rem;
    padding-left:2rem;
    padding-right:2rem;
  }

  .nuestra-esencia-imagen img{
    width:100%;
    height:auto;
  }

  .contenido-filosofia{
    height:auto;
    padding:2rem;
  }

  .contenido-filosofia p{
    font-size:1.3rem;
    margin-left: 2rem !important;
    margin-right: 2rem !important;
  }

  .contenido-empoderamiento{
    height:auto;
    padding:2rem;
  }

  .contenido-empoderamiento p{
    font-size:1.3rem;
    margin-left:2rem !important;
    margin-right:2rem !important;
  }

  

  .footer-section-contact .section-middle{
    margin-top:4rem;
    margin-bottom:4rem;
  }

  .footer-section-contact .section-middle .input-group{
    width: 100%;
  }

  .footer-section-contact{
    margin-top:4rem;
    margin-bottom:4rem;
    margin-left:1.5rem;
    margin-right:1.5rem;
  }

  .arrow-top {
      width: 45px;
      height: auto;
      bottom: 110px;
  }

  .whatsapp-float {
      width: 60px;
      height: auto;
      bottom: 40px;
  }
}

@media (max-width: 768px) {
  .lead {
    font-size: 1rem;
  }
  .img-fluid {
    max-height: 150px;
  }

  

  .nuestra-esencia{
    height:auto;
    padding-top:10rem;

  }

  .nuestra-esencia-texto{
    padding-top:8rem;
    padding-bottom:2rem;
    padding-left:2rem;
    padding-right:2rem;
  }

  .nuestra-esencia-texto h2{
    font-size:3rem;
  }

  .nuestra-esencia-texto p{
    font-size:1.3rem;
  }

  .nuestra-esencia-imagen{
    padding-top:8rem;
    padding-left:2rem;
    padding-right:2rem;
  }

  .nuestra-esencia-imagen img{
    width:100%;
    height:auto;
  }

  .contenido-filosofia{
    height:auto;
    padding:2rem;
  }

  .contenido-filosofia p{
    font-size:1.3rem;
    margin-left: 2rem !important;
    margin-right: 2rem !important;
  }

  .contenido-empoderamiento{
    height:auto;
    padding:2rem;
  }

  .contenido-empoderamiento p{
    font-size:1.3rem;
    margin-left:2rem !important;
    margin-right:2rem !important;
  }

  

  .footer-section-contact .section-middle{
    margin-top:4rem;
    margin-bottom:4rem;
  }

  .footer-section-contact .section-middle .input-group{
    width: 100%;
  }

  .footer-section-contact{
    margin-top:4rem;
    margin-bottom:4rem;
    margin-left:1.5rem;
    margin-right:1.5rem;
  }

  .arrow-top {
      width: 45px;
      height: auto;
      bottom: 110px;
  }

  .whatsapp-float {
      width: 60px;
      height: auto;
      bottom: 40px;
  }
}

@media (max-width: 576px) {
  .display-4 {
    font-size: 2rem;
  }
  .lead {
    font-size: 0.9rem;
  }
  .img-fluid {
    max-height: 100px;
  }

  

  .nuestra-esencia{
    height:auto;
    padding-top:10rem;

  }

  .nuestra-esencia-texto{
    padding-top:4rem;
    padding-bottom:2rem;
    padding-left:2rem;
    padding-right:2rem;
  }

  .nuestra-esencia-texto h2{
    font-size:3rem;
  }

  .nuestra-esencia-texto p{
    font-size:1.3rem;
  }

  .nuestra-esencia-imagen{
    padding:2rem;
    padding-top:0px;
    margin-bottom:2rem;
  }

  .nuestra-esencia-imagen img{
    width:100%;
    height:auto;
  }

  .contenido-filosofia{
    height:auto;
    padding:2rem;
  }

  .contenido-filosofia p{
    font-size:1.3rem;
    margin-left: 2rem !important;
    margin-right: 2rem !important;
  }

  .contenido-empoderamiento{
    height:auto;
    padding:2rem;
  }

  .contenido-empoderamiento p{
    font-size:1.3rem;
    margin-left:2rem !important;
    margin-right:2rem !important;
  }


  .footer-section-contact{
    margin-top:4rem;
    margin-bottom:4rem;
    margin-left:1.5rem;
    margin-right:1.5rem;
  }

  .footer-section-contact .section-middle{
    margin-top:4rem;
    margin-bottom:4rem;
  }

  .footer-section-contact .section-middle .input-group{
    width: 100%;
  }

  .arrow-top {
      width: 45px;
      height: auto;
      bottom: 110px;
  }
    
  .whatsapp-float {
      width: 60px;
      height: auto;
      bottom: 40px;
  }

  #main-header {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 12px;
    padding-bottom: 12px;
  }

  .navbar-brand img {
    height: 30px;
    margin-top:auto;
    margin-bottom:auto;
  }

  .navbar-brand {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    padding-top:0px;
  }

  .nav-icon {
    width: 25px;
    height: 25px;
  }

  .me-3 {
    margin-right: 0.75rem !important;
  }
}

@media (max-width: 1400px) and (min-width: 993px) {
  

  .collections-section{
    min-width:300px;
    padding-left:5rem;
    /* width:100px; */
  }

  .collections-images{
    gap:30px;
  }

  .dropdown-title {

    padding-left:1rem;
  }

  .collections-list {

    padding-left:1rem;

  }


}

/* Animaciones adicionales */
.navbar-collapse.collapsing,
.navbar-collapse.show {
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

</style>
<style scoped>
.card-resume-header{
  background-color: #ff6699;
  color:white;
}

.btn-pagar{
  background-color: #ff6699;
  border: 1px solid #ff6699;
  color: white;;
}

.btn-pagar:hover{
  background-color: #ff6699;
  color: white;;
}

.cart-page {
  padding: 20px 0;
  padding-top:10rem;
}

.cart-page .btn-primary{
  color: #000000 !important;
}

.cart-page h2 {
  color:#ff6699;
}

.cart-item {
  border: 1px solid #dee2e6;
}

.quantity-controls {
  display: flex;
  align-items: center;
  justify-content: center;
}

.quantity-controls button {
  min-width: 30px;
  height: 30px;
  padding: 0;
}

.quantity-controls span {
  min-width: 40px;
  text-align: center;
}

.customer-info input {
  margin-bottom: 8px;
}

.empty-cart i {
  color: #6c757d;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>