<template>
  <transition name="fade">
    <div v-if="show" class="ui-blocker-overlay">
      <div class="ui-blocker-content">
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <h4 class="mt-3 text-white fw-bold tracking-wide">{{ text }}</h4>
        <p class="text-white-50 small mt-1 mb-0">Por favor, no cierres ni actualices esta ventana.</p>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'UiBlocker',
  props: {
    show: {
      type: Boolean,
      default: false
    },
    text: {
      type: String,
      default: 'Procesando...'
    }
  }
}
</script>

<style scoped>
.ui-blocker-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.85);
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(4px);
}

.ui-blocker-content {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.tracking-wide {
  letter-spacing: 1px;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>