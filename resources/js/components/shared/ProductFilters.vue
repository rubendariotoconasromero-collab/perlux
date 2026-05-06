<template>
  <div class="product-filters-component">
    
    <div class="d-flex justify-content-between align-items-center d-md-none mb-4 pb-3 border-bottom">
      <h5 class="mb-0 fw-bold">FILTROS</h5>
      <button class="btn-close" @click="$emit('close')"></button>
    </div>

    <div class="filter-group mb-4 w-100">
      <label class="filter-title">ORDENAR</label>
      <div class="custom-select-wrapper">
        <select class="form-select custom-select" :value="selectedSort" @change="$emit('update:selectedSort', $event.target.value)">
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
        <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2" @click="toggleSection('availability')">
          <label class="filter-title">DISPONIBILIDAD</label>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="toggle-icon" :class="{ 'rotated': !showSections.availability }">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
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
        <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2" @click="toggleSection('collections')">
          <label class="filter-title">CATEGORÍAS</label>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="toggle-icon" :class="{ 'rotated': !showSections.collections }">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
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
        <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2" @click="toggleSection('colors')">
          <label class="filter-title">COLOR</label>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="toggle-icon" :class="{ 'rotated': !showSections.colors }">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </div>
        <transition name="slide-fade">
          <div v-if="showSections.colors" class="filter-options mt-2">
            <div v-for="(color, index) in colors" :key="index"
              class="d-flex align-items-center mb-2 cursor-pointer color-filter-item"
              @click="updateColorFilter(color.ColorID)">
              <span class="color-swatch me-2" :style="{ backgroundColor: color.HexCode }"></span>
              <span class="color-name" :class="{ 'fw-bold': filters.colors.includes(color.ColorID) }">
                {{ color.ColorName }}
              </span>
            </div>
          </div>
        </transition>
      </div>

      <div class="filter-group mb-4 w-100">
        <div class="d-flex justify-content-between align-items-center cursor-pointer mb-2" @click="toggleSection('sizes')">
          <label class="filter-title">TALLA</label>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="toggle-icon" :class="{ 'rotated': !showSections.sizes }">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
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

  </div>
</template>

<script>
export default {
  name: 'ProductFilters',
  props: {
    selectedSort: { type: String, required: true },
    filters: { type: Object, required: true },
    collections: { type: Array, required: true },
    colors: { type: Array, required: true },
    sizes: { type: Array, required: true }
  },
  data() {
    return {
      showSections: { availability: false, sizes: false, collections: false, colors: false }
    };
  },
  methods: {
    toggleSection(sec) {
      this.showSections[sec] = !this.showSections[sec];
    },
    updateAvailabilityFilter(val, e) {
      if (e.target.checked) this.filters.availability.push(val);
      else {
        const index = this.filters.availability.indexOf(val);
        if (index > -1) this.filters.availability.splice(index, 1);
      }
    },
    updateCollectionFilter(val, e) {
      if (e.target.checked) this.filters.collections.push(val);
      else {
        const index = this.filters.collections.indexOf(val);
        if (index > -1) this.filters.collections.splice(index, 1);
      }
    },
    updateSizeFilter(val) {
      const index = this.filters.sizes.indexOf(val);
      if (index > -1) this.filters.sizes.splice(index, 1);
      else this.filters.sizes.push(val);
    },
    updateColorFilter(val) {
      const index = this.filters.colors.indexOf(val);
      if (index > -1) this.filters.colors.splice(index, 1);
      else this.filters.colors.push(val);
    }
  },
  mounted() {
    if (window.innerWidth > 768) {
      this.showSections = { availability: true, sizes: true, collections: true, colors: true };
    }
  }
};
</script>

<style scoped>
.filter-title { font-size: 0.85rem; font-weight: 800; letter-spacing: 1.5px; }
.custom-select { border: 1px solid #000; border-radius: 0; padding: 12px; font-size: 0.9rem; }
.custom-checkbox { width: 1.1rem; height: 1.1rem; border-radius: 50%; border: 1px solid #ccc; cursor: pointer; }
.custom-checkbox:checked { background-color: #999; border-color: #999; }
.color-swatch { width: 20px; height: 20px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); }
.color-filter-item { transition: opacity 0.2s ease; }
.color-filter-item:hover { opacity: 0.8; }
.btn-size { border: 1px solid #eee; min-width: 40px; height: 40px; border-radius: 0; font-size: 0.75rem; font-weight: 600; }
.btn-size.active { background: #000; color: #fff; }
.toggle-icon { transition: transform 0.3s ease; color: #666; }
.rotated { transform: rotate(-180deg); }
.cursor-pointer { cursor: pointer; }
.slide-fade-enter-active, .slide-fade-leave-active { transition: all 0.15s ease; }
.slide-fade-enter-from, .slide-fade-leave-to { opacity: 0; transform: translateY(-10px); }

@media (max-width: 576px) {
  .mobile-filters-row { display: flex; flex-direction: column; gap: 15px; }
}
</style>
