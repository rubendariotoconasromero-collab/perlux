<template>
  <header id="main-header" class="fixed-top header-scrolled">
    <!-- <header id="main-header" class="fixed-top bg-transparent" :class="{ 'header-scrolled': activeDropdown === 'bodys' ||  activeDropdown === 'jeans'}"> -->
    <div class="container-fluid">
      <!-- Navbar responsive -->
      <nav class="navbar navbar-expand-lg p-0">
        <!-- Botón hamburguesa (solo visible en móvil) -->
        <button class="navbar-toggler order-1 d-lg-none" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
              <img src="/images/site/svg/icon_user.svg" alt="Perfil" class="img-fluid nav-icon" loading="lazy" />
            </template>
            <template v-else>
              <div class="user-avatar" :title="user.name">
                {{ getUserInitial(user.name) }}
              </div>
            </template>
          </a>

          <a href="#" class="me-3 position-relative" @click.prevent="toggleFavoritesSidebar">
            <img src="/images/site/svg/icon_heart.svg" alt="Lista de deseos" class="img-fluid nav-icon" />
            <span v-if="favoritesCount > 0"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger favorites-badge">
              {{ favoritesCount }}
            </span>
          </a>

          <a href="/cart" class="me-3 position-relative" @click.prevent="toggleCartSidebar">
            <img src="/images/site/svg/icon_cart.svg" alt="Carrito" class="img-fluid nav-icon" loading="lazy" />
            <span v-if="cartCount > 0"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger favorites-badge">
              {{ cartCount }}
            </span>
          </a>
        </div>

        <!-- Menú de navegación (colapsa en móvil) -->
        <div class="collapse navbar-collapse order-4 order-lg-2" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Inicio</a>
            </li>
            <li class="nav-item dropdown" @mouseenter="showDropdown('bodys')" @mouseleave="hideDropdown('bodys')">
              <a class="nav-link dropdown-toggle" href="/glam" role="button"
                :class="{ active: activeDropdown === 'bodys' }">
                Bodys
              </a>
              <div class="dropdown-menu collections-dropdown" :class="{ show: activeDropdown === 'bodys' }">
                <!-- <template v-if="scrolled"> -->
                <hr>
                <!-- </template> -->
                <div class="dropdown-content">
                  <div class="collections-section">
                    <h5 class="dropdown-title">COLECCIONES</h5>
                    <div class="collections-list">
                      <template v-for="(collection, index) in collections.slice(-3)" :key="collection.CollectionID">
                        <a :href="'/glam?CollectionID='+collection.CollectionID" class="dropdown-item">{{
                          collection.CollectionName }}</a>
                      </template>
                    </div>
                  </div>
                  <div class="collections-images">

                    <div class="collection-item" v-for="(collection, index) in collections.slice(-3)"
                      :key="collection.CollectionID">
                      <a :href="'/glam?CollectionID='+collection.CollectionID" style="text-decoration: none;">
                        <img :src="collection.Image" alt="Verano" class="collection-img" loading="lazy">
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
              <a class="nav-link dropdown-toggle" href="/novias" role="button"
                :class="{ active: activeDropdown === 'jeans' }">
                Jeans Rat
              </a>
              <div class="dropdown-menu collections-dropdown" :class="{ show: activeDropdown === 'jeans' }">
                <!-- <template v-if="scrolled"> -->
                <hr>
                <!-- </template> -->
                <div class="dropdown-content-jeans">
                  <div class="collections-section">
                    <h5 class="dropdown-title">COLECCIONES</h5>
                    <div class="collections-list">
                      <template v-for="(collection, index) in collections_jeans.slice(-3)"
                        :key="collection.CollectionID">
                        <a :href="'/novias?CollectionID='+collection.CollectionID" class="dropdown-item">{{
                          collection.CollectionName }}</a>
                      </template>
                    </div>
                  </div>
                  <div class="collections-images">
                    <div class="collection-item" v-for="(collection, index) in collections_jeans.slice(-3)"
                      :key="collection.CollectionID">
                      <a :href="'/novias?CollectionID='+collection.CollectionID" style="text-decoration: none;">
                        <img :src="collection.Image" alt="Verano" class="collection-img" loading="lazy">
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
            <p class="product-price">S/{{ product.Price }}</p>
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


  <!-- Sidebar de carrito -->
  <div class="favorites-sidebar" :class="{ 'active': showCartSidebar }">
    <div class="sidebar-header">
      <h5 class="mb-0">
        <i class="fas fa-shopping-cart me-2"></i>
        Mi Carrito ({{ cartCount }})
      </h5>
      <button class="btn-close-sidebar" @click="closeCartSidebar">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="sidebar-content">
      <div v-if="products_carrito.length === 0" class="empty-favorites">
        <i class="fas fa-shopping-cart empty-icon"></i>
        <p>No tienes productos en el carrito aún</p>
        <small class="text-muted">Agrega productos para verlos aquí</small>
      </div>

      <div v-else class="favorites-list">
        <div 
            v-for="product in products_carrito" 
            :key="`${product.ProductID}-${product.selectedSize}-${product.selectedColor}`" 
            class="cart-item"
          >           
            <!-- Imagen del producto -->
            <div class="cart-item-image">
              <img :src="product.images[0]?.ImagePath" :alt="product.Name" class="product-image">
            </div>
            
            <!-- Información del producto -->
            <div class="cart-item-details">
              <div class="product-header">
                <h6 class="product-title">{{ product.Name }}</h6>
                <span class="product-price">S/ {{ getVariantPrice(product) }}</span>
              </div>
              
              <!-- Variantes seleccionadas -->
              <div class="product-variants">
                <!-- Color seleccionado -->
                <div v-if="product.selectedVariant?.color" class="variant-item color-variant">
                  <div class="variant-label">
                    <div 
                      class="color-indicator"
                      :style="{
                        backgroundColor: product.selectedVariant.color.HexCode || '#CCCCCC'
                      }"
                      :title="product.selectedVariant.color.ColorName"
                    ></div>
                    <span class="variant-text">{{ product.selectedVariant.color.ColorName }}</span>
                  </div>
                </div>
                
                <!-- Talla seleccionada -->
                <div v-if="product.selectedVariant?.size" class="variant-item size-variant">
                  <div class="variant-label">
                    <span class="variant-text">{{ 'Talla: ' }}</span>
                    <span class="variant-text">{{ product.selectedVariant.size.SizeName }}</span>
                  </div>
                </div>
                
                <!-- Cantidad -->
                <div v-if="product.quantity" class="variant-item quantity-variant">
                  <div class="variant-label">
                    <span class="variant-text">{{ 'Cant.: ' }}</span>
                    <span class="variant-text">{{ product.quantity }}</span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Acción de eliminar -->
            <div class="cart-item-actions">
              <button 
                class="btn-remove" 
                @click="removeFromCart(product)" 
                title="Quitar del carrito"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
        </div>
      </div>

    </div>

    <div v-if="products_carrito.length > 0" class="sidebar-footer">
      <div class="cart-total mb-2">
        <strong>Total: S/{{ cartTotal }}</strong>
      </div>
      <a href="/pasarela" class="btn btn-primary w-100">Ver carrito completo</a>
    </div>
  </div>

  <!-- Overlay para cerrar sidebar -->
  <div class="sidebar-overlay" :class="{ 'active': showCartSidebar }" @click="closeCartSidebar"></div>


  <footer class="text-center">
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

      <div class="col-md-4 section-middle">
        <img src="/images/site/svg/skinly_logo.svg" alt="logo Perlux" loading="lazy">
        <h5>MANTENTE INFORMADA</h5>
        <p>Sé la primera en descubrir nuestras colecciones, ofertas especiales y todas nuestras novedades</p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Tu Correo" v-model="email">
          <button class="btn btn-dark rounded" type="button" @click="subscribe"><i
              class="fa-solid fa-angle-right"></i></button>
        </div>
        <small>
          A enviar tu correo electrónico, aceptas recibir mensajes de marketing recurrentes y automatizados
          de Perlux. Consulta nuestros <a href="#">Términos y Condiciones</a> | <a href="#">Política de Privacidad</a>.
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
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
  props:{
    collection: {
      type: Number,
      required: false,
    },
    user: {
      type: Object,
      required: false,
      default:null,
    }

  },
  data() {
        return {
            products_carrito:[],
            showFavoritesSidebar: false,
            filters: {
              availability: [],
              collections: [], 
              colors: [], 
              sizes: [], 
            },
            selectedSize: null, // Talla seleccionada (para el estilo del botón)
            selectedFilterText: '', // Texto del filtro seleccionado
            ruta : window.location.pathname,
            showSections: {
              availability: true,
              sizes: true,
              collections: true,
              colors: true
            },
            showAvailability: false, // Controla si el bloque está visible
            selectedOptions: [], // Almacena las opciones seleccionadas
            collections: [],
            collections_jeans: [],
            last3Colors:[],
            sizes: [],
            colors: [],
            products: [],
            activeDropdown: null,
            items: [
                { id: 1, image: "/images/site/obs1.jpg", title: "Fuerte", description: "Descripción de la característica" },
                { id: 2, image: "/images/site/obs2.jpg", title: "Elegante", description: "Descripción de la característica" },
                { id: 3, image: "/images/site/obs3.jpg", title: "Sensual", description: "Descripción de la característica" },
                { id: 4, image: "/images/site/obs4.jpg", title: "Segura", description: "Descripción de la característica" },
                { id: 5, image: "/images/site/obs5.jpg", title: "Flexible", description: "Descripción de la característica" },
                { id: 6, image: "/images/site/obs6.jpg", title: "Cómoda", description: "Descripción de la característica" },
            ],
            scrolled: false,
            favorites:[],
            originalProducts:[],
            email: '',
            showCartSidebar: false,

        };
    },

    computed: {
      cartCount() {
        return this.products_carrito.length;
      },
      
      cartTotal() {
          return this.products_carrito.reduce((total, product) => {
              // Usar el precio de la variante seleccionada
              const price = this.getSelectedVariantPrice(product);
              const quantity = product.quantity || 1; // Asumir 1 si no hay cantidad
              return total + (parseFloat(price) * quantity);
          }, 0).toFixed(2);
      },

      favoritesCount() {
        return this.favorites.length;
      },
      isLoggedIn() {
          return !!this.user; 
      },

      filteredProducts() {
          let filtered = [...this.originalProducts];
          
          // Filtro por disponibilidad (ahora basado en variantes)
          if (this.filters.availability.length > 0) {
              filtered = filtered.filter((product) => {
                  // Calcular stock total de todas las variantes
                  const totalStock = product.variants.reduce((total, variant) => 
                      total + parseInt(variant.StockQuantity || 0), 0
                  );
                  const inStock = totalStock > 0;
                  
                  return (
                      (this.filters.availability.includes('inStock') && inStock) ||
                      (this.filters.availability.includes('outOfStock') && !inStock)
                  );
              });
          }
          
          // Filtro por colecciones
          if (this.filters.collections.length > 0) {
              filtered = filtered.filter((product) =>
                  this.filters.collections.includes(product.CollectionID)
              );
          }

          // Filtro por colores (ahora desde variantes)
          if (this.filters.colors.length > 0) {
              filtered = filtered.filter((product) => {
                  // Verificar si alguna variante tiene el color seleccionado
                  return product.variants.some(variant => 
                      this.filters.colors.includes(variant.ColorID)
                  );
              });
          }

          // Filtro por tallas (ahora desde variantes)
          if (this.filters.sizes.length > 0) {
              filtered = filtered.filter((product) => {
                  // Verificar si alguna variante tiene la talla seleccionada
                  return product.variants.some(variant => 
                      this.filters.sizes.includes(variant.SizeID)
                  );
              });
          }
          
          return filtered;
      }
    },

    methods: {
        getSelectedVariantPrice(product) {
            if (product.selectedVariant && product.selectedVariant.Price !== undefined && product.selectedVariant.Price !== null) {
                return parseFloat(product.selectedVariant.Price).toFixed(2);
            }
            // Si no hay variante o precio de variante, usar precio base del producto
            return parseFloat(product.Price || 0).toFixed(2);
        },

        // Obtener colores únicos disponibles en las variantes
        getAvailableColors() {
          if (this.product.variants && this.product.variants.length > 0) {
            const uniqueColorIds = [...new Set(this.product.variants.map(v => v.ColorID))];
            return uniqueColorIds;
          }
          return [];
        },
        
        // Obtener tallas disponibles para el color seleccionado
        getAvailableSizesForSelectedColor() {
          if (this.selectedColor && this.product.variants && this.product.variants.length > 0) {
            const sizes = this.product.variants
              .filter(variant => variant.ColorID === this.selectedColor && variant.StockQuantity > 0)
              .map(variant => variant.SizeID);
            return [...new Set(sizes)]; // Eliminar duplicados
          }
          return [];
        },
        
        // Obtener el nombre del color por ID
        getColorName(colorId) {
          const color = this.colors.find(c => c.ColorID === colorId);
          return color ? color.ColorName : 'Color desconocido';
        },
        getVariantPrice(product) {
          if (product.selectedVariant && product.selectedVariant.Price) {
            return parseFloat(product.selectedVariant.Price).toFixed(2);
          }
          return parseFloat(product.Price || 0).toFixed(2);
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
        
        toggleCartSidebar() {
          this.showCartSidebar = !this.showCartSidebar;
        },
        closeCartSidebar() {
          this.showCartSidebar = false;
        },
        
        removeFromCart(product) {
          this.products_carrito = this.products_carrito.filter(item => item.ProductID !== product.ProductID);
          localStorage.setItem('products', JSON.stringify(this.products_carrito));
        },
        
      
        getSizeName(sizeId) {
          const size = this.sizes.find(s => s.SizeID === sizeId);
          return size ? size.SizeName : 'Talla desconocida';
        },

        updateCarrito(product) {
          if(!this.selectedSize){
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'warning',
              title: 'Debe seleccionar una talla primero!',
              showConfirmButton: false,
              timer: 3000
            });
            return ;
          }

          // Verificar si el producto ya existe en el carrito
          const existingProductIndex = this.products_carrito.findIndex(item => item.ProductID === product.ProductID);
          
          if (existingProductIndex !== -1) {
            // Si ya existe, mostrar alerta y no agregar duplicado
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: 'El producto ya está en el carrito',
              showConfirmButton: false,
              timer: 3000
            });

            return;
          }
          
          // Si no existe, agregar al carrito
          const productToAdd = {
            ...product,
            selectedSize: this.selectedSize // Agregar la talla seleccionada
          };
          
          this.products_carrito.push(productToAdd);
          
          // Guardar en localStorage
          localStorage.setItem('products', JSON.stringify(this.products_carrito));
          
          // Mostrar alerta de éxito
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Producto agregado al carrito',
            showConfirmButton: false,
            timer: 3000
          });
          
          console.log('Products:', this.products_carrito);
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
        toggleFavoritesSidebar() {
          this.showFavoritesSidebar = !this.showFavoritesSidebar;
        },

        closeFavoritesSidebar() {
          this.showFavoritesSidebar = false;
        },

        removeFavorite(product) {
          // Encontrar el producto en la lista original y cambiar su estado
          const originalProduct = this.products.find(p => p.ProductID === product.ProductID);
          if (originalProduct) {
            originalProduct.isFavorite = false;
          }
          
          // Remover de favoritos
          this.favorites = this.favorites.filter(fav => fav.ProductID !== product.ProductID);
          
          // Actualizar localStorage
          localStorage.setItem('favorites', JSON.stringify(this.favorites));
        },


        updateAvailabilityFilter(value, event) {
          if (event.target.checked) {
            this.filters.availability.push(value);
          } else {
            this.filters.availability = this.filters.availability.filter(
              (item) => item !== value
            );
          }
        },
        updateCollectionFilter(collectionID, event) {
          if (event.target.checked) {
            this.filters.collections.push(collectionID);
          } else {
            this.filters.collections = this.filters.collections.filter(
              (item) => item !== collectionID
            );
          }
          console.log('filtro por colecciones:', this.filters.collections);
        },
        updateColorFilter(colorID, event) {
          if (event.target.checked) {
            this.filters.colors.push(colorID);
          } else {
            this.filters.colors = this.filters.colors.filter(
              (item) => item !== colorID
            );
          }
        },

        updateSizeFilter(sizeName) {
          if (this.filters.sizes.includes(sizeName)) {
            // Remove size if already selected
            this.filters.sizes = this.filters.sizes.filter((size) => size !== sizeName);
          } else {
            // Add size if not selected
            this.filters.sizes.push(sizeName);
          }
        },

        filterProducts(filterValue) {
            // Actualizar el texto del filtro seleccionado
            const filterOptions = {
                '': 'Lo más nuevo',
                '2': 'Lo más viejo',
                '3': 'Alfabéticamente A-Z',
                '4': 'Alfabéticamente Z-A',
                '5': 'Precio de menor a mayor',
                '6': 'Precio de mayor a menor',
                '7': 'Destacado',
            };
            this.selectedFilterText = filterOptions[filterValue];

            // Aplicar el filtrado/ordenamiento según el valor
            switch (filterValue) {
                case '': // Lo más nuevo primero
                    this.filteredProducts.sort(
                        (a, b) =>
                            new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
                    );
                    break;
                case '2': // Lo más viejo primero
                    this.filteredProducts.sort(
                        (a, b) =>
                            new Date(a.created_at).getTime() - new Date(b.created_at).getTime()
                    );
                    break;
                case '3': // Alfabéticamente A-Z
                    this.filteredProducts.sort((a, b) => a.Name.localeCompare(b.Name));
                    break;
                case '4': // Alfabéticamente Z-A
                    this.filteredProducts.sort((a, b) => b.Name.localeCompare(a.Name));
                    break;
                case '5': // Precio de menor a mayor
                    this.filteredProducts.sort((a, b) => {
                        // Usar precio base o precio de la primera variante
                        const priceA = parseFloat(a.Price) || 0;
                        const priceB = parseFloat(b.Price) || 0;
                        return priceA - priceB;
                    });
                    break;
                case '6': // Precio de mayor a menor
                    this.filteredProducts.sort((a, b) => {
                        // Usar precio base o precio de la primera variante
                        const priceA = parseFloat(a.Price) || 0;
                        const priceB = parseFloat(b.Price) || 0;
                        return priceB - priceA;
                    });
                    break;
                case '7': // Destacado
                    this.filteredProducts.sort((a, b) => {
                        if (a.IsFeatured === true && b.IsFeatured === false) {
                            return -1; // `a` va primero
                        }
                        if (a.IsFeatured === false && b.IsFeatured === true) {
                            return 1; // `b` va primero
                        }
                        return 0; // sin cambio
                    });
                    break;
                default:
                    // Si no hay filtro, usar el orden original
                    this.filteredProducts = [...this.originalProducts];
            }
        },

        handleFavoriteClick(product) {
          if (!this.isLoggedIn) {
            // Abre el modal (usando reactividad, no jQuery)
            $('#authModal').modal('show');
            return;
          }

          // Si está logueado, alterna el estado
          product.isFavorite = !product.isFavorite;
          this.updateFavorites(product);
        },


        updateFavorites(product) {
          if (product.isFavorite) {
            // Agregar el objeto completo del producto a favoritos
            this.favorites.push({...product});
          } else {
            // Remover el producto de favoritos
            this.favorites = this.favorites.filter(fav => fav.ProductID !== product.ProductID);
          }
          
          // Guardar en localStorage
          localStorage.setItem('favorites', JSON.stringify(this.favorites));
          console.log('Favorites:', this.favorites);
        },

        
        // Cierra el modal
        showAuthModal() {
          $('#authModal').modal('show');
        },
        // Cierra el modal
        closeAuthModal() {
          $('#authModal').modal('hide');
        },
        
        toggleSection(section) {
          this.showSections[section] = !this.showSections[section];
        },
        toggleVisibility() {
            this.showAvailability = !this.showAvailability; // Alterna visibilidad
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
                this.last3Colors=this.colors.slice(-3);
                console.log('SIZES:', this.sizes);

                this.originalProducts = this.products; // Guardar copia original
                
            } catch (error) {
                console.log('Error al obtener los datos: ', error.message);
            } finally {

            }
        },

        async getCollectionsJeans() {
            try {
                const response = await axios.get('/get_collections_jeans');
                this.collections_jeans = response.data;
                console.log('COLLECTIONS:', this.collections);
            } catch (error) {
                console.log('Error al obtener las colecciones: ', error.message);
            } finally {

            }
        },

        // Métodos del slider
        async getCollectionsJeans() {
            try {
                const response = await axios.get('/get_collections_jeans');
                this.collections_jeans = response.data;
                console.log('COLLECTIONS:', this.collections);
            } catch (error) {
                console.log('Error al obtener las colecciones: ', error.message);
            } finally {

            }
        },
        async getCollections() {
            try {
                const response = await axios.get('/get_collections');
                this.collections = response.data;
                console.log('COLLECTIONS:', this.collections);
            } catch (error) {
                console.log('Error al obtener las colecciones: ', error.message);
            } finally {

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
            }, 150);
        },

        mountedHeader() {
            const header = document.getElementById("main-header");
            const toggler = document.querySelector(".navbar-toggler-icon");
            let lastScrollY = window.scrollY;
            const scrollThreshold = 100;

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
        }
    },

  async mounted() {
    this.products_carrito = JSON.parse(localStorage.getItem('products')) || []; // Load from localStorage
    this.mountedHeader();
    await this.getCollections();
    await this.getCollectionsJeans();
    await this.loadData();

    const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];
    this.favorites = savedFavorites;
    
    // Sincronizar estado de favoritos con productos
    this.products.forEach(product => {
      product.isFavorite = this.favorites.some(fav => fav.ProductID === product.ProductID);
    });

    this.filterProducts('');
    // Sincronizar checkbox de colección si this.collection está definido
    if (this.collection !='' && this.collection !== null && this.collection !== undefined && this.collection) {
        this.filters.collections.push(parseInt(this.collection));
    }
  },

 
};
</script>

<style scoped>
.cart-item {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  padding: 20px;
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e8ecef;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.cart-item:hover {
  border-color: #dee2e6;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transform: translateY(-1px);
}

.cart-item-image {
  flex-shrink: 0;
  width: 80px;
  height: 80px;
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.cart-item:hover .product-image {
  transform: scale(1.05);
}

.cart-item-details {
  flex: 1;
  min-width: 0;
}

.product-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 12px;
  gap: 12px;
}

.product-title {
  font-size: 16px;
  font-weight: 600;
  color: #212529;
  margin: 0;
  line-height: 1.3;
  flex: 1;
}

.cart-items .product-price {
  font-size: 18px;
  font-weight: 700;
  color: #353535;
  white-space: nowrap;
}

.product-variants {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}

.variant-item {
  display: inline-flex;
  align-items: center;
}

.variant-label {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 4px 8px;
  background: #f8f9fa;
  border-radius: 6px;
  border: 1px solid #e9ecef;
}

.color-indicator {
  width: 14px;
  height: 14px;
  border-radius: 50%;
  border: 1px solid rgba(0, 0, 0, 0.1);
  flex-shrink: 0;
}

.variant-icon {
  font-size: 12px;
  color: #6c757d;
}

.variant-text {
  font-size: 13px;
  color: #495057;
  font-weight: 500;
}

.cart-item-actions {
  flex-shrink: 0;
}

.btn-remove {
  width: 32px;
  height: 32px;
  border: none;
  background: #f8f9fa;
  color: #6c757d;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 14px;
}

.btn-remove:hover {
  background: #dc3545;
  color: white;
  transform: scale(1.1);
}

.btn-remove:active {
  transform: scale(0.95);
}

/* Responsive design */
@media (max-width: 576px) {
  .cart-item {
    padding: 16px;
    gap: 12px;
  }
  
  .cart-item-image {
    width: 60px;
    height: 60px;
  }
  
  .product-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .product-title {
    font-size: 14px;
  }
  
  .product-price {
    font-size: 16px;
  }
  
  .product-variants {
    gap: 8px;
  }
  
  .variant-text {
    font-size: 12px;
  }
}
</style>
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


.header-scrolled .user-avatar {
  background-color: #000;
  color: #fff;
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
    color: #000000;
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
}
</style>

<style scoped>

/* *{
  border:1px solid red;
} */
.cursor-pointer {
  cursor: pointer;
}

.fade-enter-active, .fade-leave-active {
  transition: all 0.1s ease-out;
}

.fade-enter-from {
  opacity: 0;
  max-height: 0;
}

.fade-leave-to {
  opacity: 0;
  max-height: 0;
}


.rotated {
  transform: rotate(180deg);
  transition: transform 0.1s ease;
}
</style>

<style scoped>
/* Estilos base */
#main-header{
  padding-left: 100px;
  padding-right: 100px;
  padding-top: 30px;
  padding-bottom: 30px;
  margin-left:0px;
  margin-right:0px;
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
  background-color: white !important;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
  height: 15rem;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;

}

.collection-img img{
  width: 100%;
  height: auto;

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

.third-section-container{
  padding-top:7rem;
  padding-left:0;
  padding-right:0;
  padding-bottom:0;
}
/* Tercera sección */
.third-section .third-section-title{
  
  padding-bottom:2rem;
  padding-top:2rem;
  background-image: url('/images/site/obs4_new.jpg');
  background-size: cover;
  background-position: center;
}

.third-section .third-section-title .col-title1{
  display:flex;
  justify-content: center;
}

.third-section .third-section-title .col-title2{
  display:flex;
  justify-content: center;
}

.third-section .third-section-title .title1{
  font-size: 2rem;
  color:#ffffff;
  width:70%;
  text-align: end;
}

.third-section .third-section-title .title1 span{
  font-size: 5rem;
  color:#ffffff;
  width:70%;
  text-align: end;
}

.third-section .third-section-title .title2{
  font-size: 2rem;
  color:#ffffff;
  width:70%;
  text-align: start;
}

.third-section .third-section-title .title2 span{
  font-size: 5rem;
  color:#ffffff;
  width:70%;
  text-align: start;
}

/* Cuarta sección */
.fourth-section .fourth-section-filters{
    padding-left:6rem;
    padding-right:6rem;
    padding-top:1rem;
}

.fourth-section .fourth-section-filters .content-filter{
    padding-left:0rem;
    padding-right:2rem;
}


.fourth-section .fourth-section-filters .fa-chevron-down{
    font-size:1.3rem;
    /* font-weight: 700; */
    margin-top:2rem !important;
    
}

.fourth-section .fourth-section-filters .check-filter{
    appearance: none;
    width: 2rem;
    height: 2rem;
    background-color: transparent;
    border: 1px solid #000000;
    border-radius: 7px;
    position: relative;
}

.fourth-section .check-filter:checked {
    background-color: #ff69b4; /* Color rosa claro */
    border-color: #ff69b4;
}

.fourth-section .fourth-section-filters .check-label{
    font-size:1.1rem;
    padding-left:10px;
    margin-top:auto;
    margin-bottom:auto;

}


.check-filter-color {
    appearance: none;
    width: 2rem;
    height: 2rem;
    background-color: var(--color-hex, #ccc); /* Usamos la variable con fallback */
    border: 1px solid var(--color-hex, #ccc); /* Usamos la variable con fallback */
    border-radius: 7px;
    position: relative;
}

.check-filter-color:checked {
    /* background-color: #ffffff;  */
    background-color: var(--color-hex, #ccc); 
    /* border: 4px solid #363636;  */
    border-radius: 50%;
    /* width: 2.3rem;
    height: 2.3rem; */

}

.fourth-section .fourth-section-filters .check-content{
    margin-top:15px;

}

.fourth-section .fourth-section-filters .title-filter{
    font-size:1.3rem;
    font-weight: 700;
    margin-top:2rem !important;
}

/* seccion select filtros */

.size-btn {
  width: 2rem;      /* Ancho fijo */
  height: 2rem;     /* Alto fijo */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;       /* Elimina el padding de Bootstrap para control total */
  font-size: 0.9rem; /* Ajusta tamaño de fuente si es necesario */
  line-height: 1;
  border-radius: 8px; /* Bordes ligeramente redondeados (opcional) */
  transition: all 0.2s ease;
  font-weight: 800;
}

/* Opcional: Efecto hover */
.size-btn:hover {
  background-color: #ff6699;
  border-color: #ffffff;
  transform: scale(1.05);
}

.size-btn.selected {
  background-color: #ff6699;
  border-color: #ffffff;
  color: #fff;
}





.form-select-filter {
  border-radius: 0;
  font-size: 1.2rem;
  font-weight: 500;
  padding: 0.3rem 1rem;
  background-color: white;
  transition: all 0.2s ease;
  margin-left: auto;
  margin-right: auto;
  padding-left: auto;
  padding-right: auto;
  width: 100%;
  text-align:left;
  border:none;
}

.form-select-filter:focus {
  border:none;
}

.dropdown-item-select {
  font-size: 1.2rem;
  font-weight: 500;
  padding: 0.5rem 1.5rem;
  color: rgb(0, 0, 0) !important;
  transition: background-color 0.2s ease, color 0.2s ease;
}

.dropdown-item-select:hover {
  background-color: #ff6699;
  color: white !important;
}




/* .card-images{
  height:600px;
  margin-top:2rem;
  padding-left:5px;
  padding-right:5px;
  margin-left:0px;
  margin-right:0px;
} */

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
    padding: 1rem;
}

.card-images {
    width: 100%;
    margin-top: 1rem;
}

.card-images .image-product{
  width:100%;
  height:500px;
  max-height:450px;
  object-fit: cover;
  margin-left:auto;
  margin-right:auto;
}

.card-images .image-product-details{
  width:100%;
  margin-left:auto;
  margin-right:auto;
  padding-left:15px;
  padding-right:15px;
  margin-top:15px;
}


.btn-color-card{
  width: 1.7rem;      /* Ancho fijo */
  height: 1.7rem;     /* Alto fijo */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;       /* Elimina el padding de Bootstrap para control total */
  font-size: 0.9rem; /* Ajusta tamaño de fuente si es necesario */
  line-height: 1;
  border-radius: 8px; /* Bordes ligeramente redondeados (opcional) */
  /* transition: all 0.2s ease; */
  font-weight: 800;
  background-color: var(--color-card-hex, #ccc);
}

/* estilos del check corazon */

.heart-checkbox input[type="checkbox"] {
  opacity: 0;
  z-index: -1;
}

.heart-checkbox .heart {
  position: relative;
  width: 30px;
  height: 30px;
  cursor: pointer;
  transition: all 0.3s ease;
  /* border: 1px solid #ff4d8a; */
  margin-top:0px;
  padding-top:0px;
  /* margin-bottom:auto; */
}

.heart-checkbox .heart:before,
.heart-checkbox .heart:after {
  content: '';
  width: 15px;
  height: 24px;
  position: absolute;
  left: 15px;
  transform: rotate(-45deg);
  background: rgb(165, 165, 165);
  border-radius: 15px 15px 0 0;
  transform-origin: 0 100%;
  transition: all 0.3s ease;
  margin-top:2px;
}

.heart-checkbox .heart:after {
  left: 0;
  transform: rotate(45deg);
  transform-origin: 100% 100%;
}

/* Estado checked */
.heart-checkbox input[type="checkbox"]:checked+.heart:before,
.heart-checkbox input[type="checkbox"]:checked+.heart:after {
  background: #ff6699;
  /* animation: heartbeat 0.6s ease; */
}

/* Estado hover */
.heart-checkbox .heart:hover:before,
.heart-checkbox .heart:hover:after {
  background: #ffb3cc;
}

.heart-checkbox input[type="checkbox"]:checked+.heart:hover:before,
.heart-checkbox input[type="checkbox"]:checked+.heart:hover:after {
  background: #ff4d8a;
}


.heart-checkbox .heart:after {
  animation-delay: 0.1s;
}
/* fin estilos del check corazon */


.card-images .product-name{
  font-size:1.2rem;
  font-weight: 700;
  margin-bottom:0px;
  margin-top:0px;
}

.card-images .product-price{
  font-size:1.2rem;
  /* margin-bottom:5px; */
  margin-top:0px;
  margin-bottom:0px;
  /* font-weight: 700; */
}

/* Footer */
.footer-section{
    background-color:#000;
    padding-top:5rem;
    padding-bottom:5rem;
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

.navbar-nav .dropdown {
  /* position: static !important; */
  position: relative;
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



@media (max-width: 991.98px) {
  .fourth-section-filters{
    flex-direction: column;
  }

  .content-card-images{
    margin-right:1rem;
  }

  .content-filter{
    flex-direction: row !important;
    flex-wrap: wrap !important;
    justify-content: space-between !important;
    width:100% !important;
    
  }

  .fourth-section .fourth-section-filters .content-filter{
    padding-left:0rem;
    padding-right:2rem;
  }
  .fourth-section-filters .filter-group1{
    margin-left:10px;
    margin-right:10px;
    width:95%;
  }

 
  .fourth-section-filters .filter-group2{
    margin-left:10px;
    margin-right:10px;
    width:20%;
  }



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
    background-color: rgba(255, 255, 255, 0.98);
  }

  .header-scrolled .nav-link {
    color: #000 !important;
  }


  .collections-dropdown {
    display: none;
  }

  .dropdown-content{
    padding:20px 2rem;
  }

  .collections-section{
    min-width:100px;
    width:100px;
  }

  .collections-images{
    gap:30px;
  }

  .collection-img {
    height: 120px;
  }

  
  .img-fluid {
    max-height: 150px;
  }

  .third-section-container{
    padding-top:5rem;
    padding-left:0;
    padding-right:0;
    padding-bottom:0;
  }

  .third-section .third-section-title .title1{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title1 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  /* Cuarta sección */
  .fourth-section .fourth-section-filters{
      padding-left:2rem;
      padding-right:0rem !important;
      margin-left:0px !important;
      margin-right:0px !important;
      padding-top:1rem;
  }

 


  .fourth-section .fourth-section-filters .fa-chevron-down{
    font-size:1rem;
  }

  .fourth-section .fourth-section-filters .check-filter{
      appearance: none;
      width: 2rem;
      height: 2rem;
      background-color: transparent;
      border: 1px solid #000000;
      border-radius: 7px;
      position: relative;
  }

  .fourth-section .check-filter:checked {
      background-color: #ff69b4; /* Color rosa claro */
      border-color: #ff69b4;
  }

  .fourth-section .fourth-section-filters .check-label{
      font-size:1rem;
      padding-left:10px;
      margin-top:auto;
      margin-bottom:auto;

  }

.check-filter-color {
    appearance: none;
    width: 2rem;
    height: 2rem;
    background-color: var(--color-hex, #ccc); /* Usamos la variable con fallback */
    border: 1px solid var(--color-hex, #ccc); /* Usamos la variable con fallback */
    border-radius: 7px;
    position: relative;
}

.check-filter-color:checked {
    background-color: #ffffff; /* Usamos la variable con fallback */
    border: 2px solid var(--color-hex, #ccc); /* Usamos la variable con fallback */

}

.fourth-section .fourth-section-filters .check-content{
    margin-top:15px;

}

.fourth-section .fourth-section-filters .title-filter{
    font-size:1rem;
    font-weight: 700;
    margin-top:1.8rem !important;

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

  .img-fluid {
    max-height: 150px;
  }

  .content-card-images{
    margin-right:1rem;
  }

  .third-section-container{
    padding-top:3rem;
    padding-left:0;
    padding-right:0;
    padding-bottom:0;
  }

  .fourth-section-filters .filter-group2{
    margin-left:10px;
    margin-right:10px;
    width:40%;
  }

   .fourth-section-filters .filter-group1{
    margin-left:10px;
    margin-right:10px;
    width:95%;
  }

  .third-section .third-section-title .title1{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title1 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  /* Cuarta sección */
  .fourth-section .fourth-section-filters{
      padding-left:2rem;
      padding-right:2rem;
      padding-top:1rem;

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

  .img-fluid {
    max-height: 100px;
  }

  .third-section .third-section-title .title1{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title1 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
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

  #main-header {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 12px;
    padding-bottom: 12px;
  }
}

@media (max-width: 1400px) and (min-width: 993px) {


  .collections-section{
    min-width:300px;
    padding-left:5rem;
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