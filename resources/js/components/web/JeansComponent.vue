<template>
  <div>
    <TheHeader :user="user" />

    <div class="collection-container container-fluid">
      <div class="row">

        <div class="col-lg-3 col-md-4 col-12 filters-sidebar">

          <div class="filter-group mb-4 w-100">
            <label class="filter-title">ORDENAR</label>
            <div class="custom-select-wrapper">
              <select class="form-select custom-select" v-model="selectedSort" @change="filterProducts(selectedSort)">
                <option value="">Lo más nuevo</option>
                <option value="2">Lo más viejo</option>
                <option value="3">Alfabéticamente A-Z</option>
                <option value="4">Alfabéticamente Z-A</option>
                <option value="5">Precio: Menor a Mayor</option>
                <option value="6">Precio: Mayor a Menor</option>
                <option value="7">Destacado</option>
              </select>
            </div>
          </div>

          <div class="mobile-filters-row">

            <div class="filter-group mb-4">
              <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2"
                @click="toggleSection('availability')">
                <label class="filter-title">DISPONIBILIDAD</label>
                <i class="fas fa-chevron-down" :class="{ 'rotated': !showSections.availability }"></i>
              </div>
              <transition name="slide-fade">
                <div v-if="showSections.availability" class="filter-options">
                  <div class="form-check">
                    <input class="form-check-input custom-checkbox" type="checkbox" id="stock"
                      :checked="filters.availability.includes('inStock')"
                      @change="updateAvailabilityFilter('inStock', $event)">
                    <label class="form-check-label" for="stock">En Stock</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input custom-checkbox" type="checkbox" id="preorder"
                      :checked="filters.availability.includes('outOfStock')"
                      @change="updateAvailabilityFilter('outOfStock', $event)">
                    <label class="form-check-label" for="preorder">Agotado</label>
                  </div>
                </div>
              </transition>
            </div>

            <div class="filter-group mb-4">
              <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2"
                @click="toggleSection('collections')">
                <label class="filter-title">CATEGORÍAS</label>
                <i class="fas fa-chevron-down" :class="{ 'rotated': !showSections.collections }"></i>
              </div>
              <transition name="slide-fade">
                <div v-if="showSections.collections" class="filter-options">
                  <div v-for="(col, index) in collections" :key="index" class="form-check">
                    <input class="form-check-input custom-checkbox" type="checkbox" :id="'col-' + index"
                      :checked="filters.collections.includes(col.CollectionID)"
                      @change="updateCollectionFilter(col.CollectionID, $event)">
                    <label class="form-check-label" :for="'col-' + index">{{ col.CollectionName }}</label>
                  </div>
                </div>
              </transition>
            </div>

            <div class="filter-group mb-4">
              <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2"
                @click="toggleSection('colors')">
                <label class="filter-title">COLOR</label>
                <i class="fas fa-chevron-down" :class="{ 'rotated': !showSections.colors }"></i>
              </div>
              <transition name="slide-fade">
                <div v-if="showSections.colors" class="filter-options mt-2">
                  <div v-for="(color, index) in colors" :key="index"
                    class="d-flex align-items-center mb-2 cursor-pointer color-filter-item"
                    @click="updateColorFilter(color.ColorID)">

                    <span class="color-swatch me-2" :style="{ backgroundColor: color.HexCode }">
                    </span>

                    <span class="color-name" :class="{ 'fw-bold': filters.colors.includes(color.ColorID) }">
                      {{ color.ColorName }}
                    </span>
                  </div>
                </div>
              </transition>
            </div>

          </div>

          <div class="filter-group mb-4 w-100">
            <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2"
              @click="toggleSection('sizes')">
              <label class="filter-title">TALLA</label>
              <i class="fas fa-chevron-down" :class="{ 'rotated': !showSections.sizes }"></i>
            </div>
            <transition name="slide-fade">
              <div v-if="showSections.sizes" class="filter-options d-flex flex-wrap gap-2">
                <button v-for="(size, index) in sizes" :key="index" class="btn btn-size"
                  :class="{ 'active': filters.sizes.includes(size.SizeName) }" @click="updateSizeFilter(size.SizeName)">
                  {{ size.SizeName }}
                </button>
              </div>
            </transition>
          </div>

        </div>

        <div class="col-lg-9 col-md-8 col-12 products-grid">
          <div class="row g-4">
            <div class="col-lg-4 col-md-6 col-12" v-for="(product, index) in filteredProducts" :key="product.ProductID">

              <div class="product-card h-100">
                <div class="product-image-wrapper">
                  <a :href="'/detail_novias?product_id=' + product.ProductID">
                    <img :src="product.images[0]?.ImagePath" :alt="product.Name" class="img-fluid product-img">
                  </a>
                </div>
                <div class="product-info mt-3">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h5 class="product-title">{{ product.Name }}</h5>
                      <p class="product-price">S/{{ product.Price }}</p>
                    </div>
                    <button class="btn-heart" @click="handleFavoriteClick(product)">
                      <i :class="product.isFavorite ? 'fas fa-heart' : 'far fa-heart'"></i>
                    </button>
                  </div>
                  
                  <button class="btn-buy w-100 mt-2" @click="comprar(product)">
                    COMPRAR AHORA
                  </button>

                  <button class="btn-whatsapp w-100 mt-2" @click="pedirPorWhatsapp(product)">
                    <i class="fab fa-whatsapp me-2"></i> PEDIR POR WHATSAPP
                  </button>

                </div>
              </div>

            </div>

            <div v-if="filteredProducts.length === 0" class="col-12 text-center py-5">
              <p class="text-muted">No se encontraron productos con los filtros seleccionados.</p>
            </div>
          </div>
        </div>

      </div>
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
import Swal from 'sweetalert2';

export default {
  components: { TheHeader, TheFooter },
  props: {
    collection: { type: Number, required: false },
    user: { type: Object, required: false, default: null }
  },
  data() {
    return {
      selectedSort: '',
      showSections: { availability: true, sizes: true, collections: true, colors: true },
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
      // 1. Filtrado
      let result = [...this.originalProducts];

      // Filtro Disponibilidad (Basado en la suma de stock de variantes)
      if (this.filters.availability.length > 0) {
        result = result.filter(p => {
          // Calcular stock total sumando todas las variantes
          const totalStock = p.variants ? p.variants.reduce((total, variant) => total + parseInt(variant.StockQuantity || 0), 0) : p.StockQuantity;
          const inStock = totalStock > 0;

          return (this.filters.availability.includes('inStock') && inStock) ||
            (this.filters.availability.includes('outOfStock') && !inStock);
        });
      }

      // Filtro Colecciones
      if (this.filters.collections.length > 0) {
        result = result.filter(p => this.filters.collections.includes(p.CollectionID));
      }

      // Filtro Tallas (Revisando variantes)
      if (this.filters.sizes.length > 0) {
        result = result.filter(p => {
          // Si tiene variantes, buscar si alguna coincide con la talla
          if (p.variants && p.variants.length > 0) {
            return p.variants.some(variant => {
              // Asumimos que la variante tiene el objeto size o el ID, 
              // aquí comparamos con SizeName porque el filtro guarda nombres.
              // Ajustar si variant.SizeID se usa en el filtro.
              // En tu lógica original guardas el SizeName en filters.sizes.
              // Necesitamos asegurar que variant tenga acceso al nombre o filtrar por ID.
              // Como el filtro usa nombres, buscaremos la coincidencia en el objeto sizes global o en la variante populada.
              const sizeObj = this.sizes.find(s => s.SizeID === variant.SizeID);
              return sizeObj && this.filters.sizes.includes(sizeObj.SizeName);
            });
          }
          return false;
        });
      }

      // Filtro Colores (Revisando variantes)
      if (this.filters.colors.length > 0) {
        result = result.filter(p => {
          if (p.variants && p.variants.length > 0) {
            return p.variants.some(variant => this.filters.colors.includes(variant.ColorID));
          }
          return false;
        });
      }

      // 2. Ordenamiento (Lógica traída del segundo componente)
      switch (this.selectedSort) {
        case '': // Lo más nuevo
          result.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
          break;
        case '2': // Lo más viejo
          result.sort((a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime());
          break;
        case '3': // A-Z
          result.sort((a, b) => a.Name.localeCompare(b.Name));
          break;
        case '4': // Z-A
          result.sort((a, b) => b.Name.localeCompare(a.Name));
          break;
        case '5': // Precio Menor a Mayor
          result.sort((a, b) => (parseFloat(a.Price) || 0) - (parseFloat(b.Price) || 0));
          break;
        case '6': // Precio Mayor a Menor
          result.sort((a, b) => (parseFloat(b.Price) || 0) - (parseFloat(a.Price) || 0));
          break;
        case '7': // Destacado
          result.sort((a, b) => {
            if (a.IsFeatured === true && b.IsFeatured === false) return -1;
            if (a.IsFeatured === false && b.IsFeatured === true) return 1;
            return 0;
          });
          break;
      }

      return result;
    }
  },
  methods: {
    pedirPorWhatsapp(product) {
      const phoneNumber = "51920775278"; // Tu número de WhatsApp (sin el +)
      const message = `Hola Perlux, estoy interesada en el producto: ${product.Name} (Precio: S/${product.Price}). ¿Tienen disponibilidad?`;
      
      // Codificar el mensaje para URL
      const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
      
      // Abrir en nueva pestaña
      window.open(url, '_blank');
    },
    async loadData() {
      try {
        const response = await axios.get('/load_data');
        this.sizes = response.data.sizes || [];
        this.colors = response.data.colors || [];
        // Mapear productos para asegurar que tienen la propiedad isFavorite
        this.products = (response.data.products.filter(item => item.Tipo === 'Novias') || []).map(p => ({
          ...p,
          isFavorite: false
        }));
        this.originalProducts = this.products;

        // Sincronizar favoritos después de cargar productos
        const savedFavorites = JSON.parse(localStorage.getItem('favorites')) || [];
        this.favorites = savedFavorites;
        this.products.forEach(p => {
          p.isFavorite = this.favorites.some(fav => fav.ProductID === p.ProductID);
        });

      } catch (e) { console.error(e); }
    },
    async getCollections() {
      try {
        const response = await axios.get('/get_collections_novias');
        this.collections = response.data || [];
      } catch (e) { console.error(e); }
    },

    toggleSection(sec) { this.showSections[sec] = !this.showSections[sec]; },

    // Update Filters logic
    updateAvailabilityFilter(val, e) {
      if (e.target.checked) this.filters.availability.push(val);
      else this.filters.availability = this.filters.availability.filter(v => v !== val);
    },
    updateCollectionFilter(val, e) {
      if (e.target.checked) this.filters.collections.push(val);
      else this.filters.collections = this.filters.collections.filter(v => v !== val);
    },
    updateSizeFilter(val) {
      if (this.filters.sizes.includes(val)) this.filters.sizes = this.filters.sizes.filter(v => v !== val);
      else this.filters.sizes.push(val);
    },
    updateColorFilter(val) {
      // En el diseño original usabas un div clickable, no un checkbox nativo visible a veces
      // Aquí adapto para que funcione si se llama desde el click del div o checkbox
      if (this.filters.colors.includes(val)) {
        this.filters.colors = this.filters.colors.filter(v => v !== val);
      } else {
        this.filters.colors.push(val);
      }
    },

    // Sort - Logic handled in computed property 'filteredProducts' based on selectedSort
    filterProducts(val) {
      this.selectedSort = val;
    },

    // Favorites Logic (Igual al componente de referencia)
    handleFavoriteClick(product) {
      if (!this.isLoggedIn) {
        $('#authModal').modal('show');
        return;
      }
      product.isFavorite = !product.isFavorite;
      this.updateFavorites(product);
    },

    updateFavorites(product) {
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

    closeAuthModal() { $('#authModal').modal('hide'); },

    comprar(product) {
      // Redireccionar al detalle para seleccionar variante antes de comprar
      window.location.href = '/detail_novias?product_id=' + product.ProductID;
    }
  },
  async mounted() {
    await this.loadData();
    await this.getCollections();

    // Si viene una colección por props, aplicarla al filtro
    if (this.collection) {
      this.filters.collections.push(parseInt(this.collection));
    }
  }
};
</script>

<style scoped>
/* =========================================
   LAYOUT GENERAL
   ========================================= */
.collection-container {
  padding-top: 140px;
  /* Espacio para el header fixed */
  padding-bottom: 80px;
  padding-left: 100px;
  padding-right: 100px;
  background-color: #ffffff;
}

/* =========================================
   SIDEBAR FILTROS (IZQUIERDA)
   ========================================= */
.filters-sidebar {
  padding-right: 40px;
}

.filter-title {
  font-size: 1rem;
  font-weight: 800;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: block;
}

/* Select "Ordenado por" estilo minimalista */
.custom-select {
  border: 1px solid #000;
  border-radius: 0;
  padding: 10px 15px;
  font-size: 0.95rem;
  color: #333;
  cursor: pointer;
  background-color: #fff;
}

.custom-select:focus {
  box-shadow: none;
  border-color: #000;
}

/* Estilos específicos para la lista de colores */
.color-filter-item {
  transition: opacity 0.2s ease;
}

.color-filter-item:hover {
  opacity: 0.8;
}

.color-swatch {
  width: 24px;
  /* Tamaño del círculo según la imagen */
  height: 24px;
  border-radius: 50%;
  /* Lo hace circular */
  display: inline-block;
  /* Borde sutil por si el color es muy claro (opcional) */
  box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
}

.color-name {
  font-size: 0.95rem;
  color: #333;
}

/* Checkboxes redondos grandes (Estilo imagen) */
.custom-checkbox {
  width: 1.2rem;
  height: 1.2rem;
  border: 1px solid #ccc;
  border-radius: 50%;
  /* Círculo */
  margin-right: 10px;
  cursor: pointer;
}

.custom-checkbox:checked {
  background-color: #999;
  /* Gris oscuro al seleccionar */
  border-color: #999;
}

.form-check-label {
  font-size: 0.95rem;
  color: #555;
  cursor: pointer;
  padding-top: 2px;
}

/* Botones de Talla (Cuadrados minimalistas) */
.btn-size {
  border: 1px solid #ddd;
  background: #fff;
  color: #333;
  width: 35px;
  height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.85rem;
  border-radius: 0;
  transition: all 0.2s;
}

.btn-size:hover {
  border-color: #999;
}

.btn-size.active {
  background-color: #333;
  color: #fff;
  border-color: #333;
}

/* Icono Accordion */
.fa-chevron-down {
  font-size: 0.8rem;
  transition: transform 0.3s;
}

.rotated {
  transform: rotate(180deg);
}

/* Transiciones */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* =========================================
   GRILLA PRODUCTOS (DERECHA)
   ========================================= */
.product-image-wrapper {
  position: relative;
  background-color: #000000; /* Fondo suave en lugar de blanco puro */
  height: 350px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.product-img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* CONTAIN para ver la imagen completa */
  object-position: center;
  transition: transform 0.3s ease;
}

/* Alternativa con COVER si prefieres llenar todo el espacio */
.product-img.cover-style {
  object-fit: cover;
  padding: 0;
}

/* Hover suave */
.product-card:hover .product-img {
  transform: scale(1.03); /* Reducido de 1.05 para evitar cortes */
}


.product-title {
  font-size: 1rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 2px;
}

.product-price {
  font-size: 0.95rem;
  color: #555;
  margin: 0;
}

/* Botón Corazón */
.btn-heart {
  background: none;
  border: none;
  font-size: 1.2rem;
  color: #555;
  transition: color 0.2s;
}

.btn-heart:hover,
.btn-heart i.fas {
  color: #ff6b9d;
  /* Color al hover */
}

/* Botón COMPRAR AHORA (Estilo Imagen) */
.btn-buy {
  background-color: #fff;
  border: 1px solid #000;
  color: #000;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 1px;
  padding: 10px 0;
  border-radius: 0;
  text-transform: uppercase;
  transition: all 0.1s ease;
}

/* Hover */
.btn-buy:hover {
  background-color: #5498cf;
  color: #fff;
  border-color: #8d8780;
}

/* =========================================
   RESPONSIVE
   ========================================= */
@media (max-width: 991.98px) {
  .collection-container {
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 100px;
  }

  .filters-sidebar {
    margin-bottom: 40px;
    padding-right: 0;
  }
}

/* =========================================
   RESPONSIVE (MÓVIL / TABLET PEQUEÑA)
   ========================================= */
@media (max-width: 768px) {
  .product-image-wrapper {
    height: 280px;
  }

  .collection-container {
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 100px;
    /* Ajuste para header fixed */
  }

  /* Contenedor de filtros en móvil */
  .mobile-filters-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: space-between;
  }

  .filters-sidebar {
    width: 100%;
    margin-bottom: 2rem;
    padding-right: 0;
  }

  /* "Ordenar por" full width arriba */
  .filter-group:first-child {
    width: 100%;
    margin-bottom: 20px;
  }

  /* Cada grupo de filtro en móvil se adapta */
  .filter-group {
    margin-bottom: 15px;
    flex: 1 1 auto;
    min-width: 45%;
  }

  /* Título de filtro más compacto en móvil */
  .filter-title {
    font-size: 0.9rem;
    margin-bottom: 5px;
  }

  /* Ajuste visual para los acordeones */
  .filter-options {
    padding-top: 5px;
  }

  /* Imágenes de productos más pequeñas para que entren 2 por fila cómodamente */
  .product-image-wrapper {
    height: 220px;
  }
}


/* NUEVOS ESTILOS PARA BOTÓN WHATSAPP */
.btn-whatsapp {
  background-color: #ffffff; /* Verde oficial de WhatsApp */
  border: 2px solid #2b8d4f;
  color: #2b8d4f;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 1px;
  padding: 10px 0;
  border-radius: 0;
  text-transform: uppercase;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-whatsapp:hover {
  background-color: #26b16b; /* Verde más oscuro al hover */
  border-color: #26b16b;
  color: #fff;
}

.btn-whatsapp i {
  font-size: 1.1rem;
}
</style>