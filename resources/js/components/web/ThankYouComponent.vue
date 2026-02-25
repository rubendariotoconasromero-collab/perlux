<template>
  <div class="thank-you-page d-flex align-items-center justify-content-center">
    <div class="container text-center">
      
      <div class="card border-0 shadow-sm mx-auto p-5" style="max-width: 600px;">
        
        <div class="success-checkmark mb-4">
          <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
          </div>
        </div>

        <h2 class="fw-bold mb-3">¡Gracias por tu compra!</h2>
        <p class="text-muted mb-4">
          Tu pedido ha sido procesado exitosamente. Hemos enviado un correo electrónico con los detalles de tu compra.
        </p>

        <div class="bg-light p-3 rounded mb-4 border border-dashed">
          <span class="d-block text-uppercase text-muted small fw-bold mb-1">Código de Pedido</span>
          <span class="h4 fw-bold text-dark m-0">{{ orderReference }}</span>
        </div>

        <div class="d-grid gap-2 d-sm-flex justify-content-center">
          <a href="/" class="btn btn-dark px-4 py-2">
            Seguir Comprando
          </a>
          <a href="/user?section=pedidos" class="btn btn-outline-dark px-4 py-2">
            Ver mis Pedidos
          </a>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ThankYouComponent",
  props: {
    orderReference: {
      type: String,
      default: '---'
    }
  },
  mounted() {
      // Limpieza de seguridad extra por si acaso quedó algo
      localStorage.removeItem('products');
  }
};
</script>

<style scoped>
.thank-you-page {
  min-height: 80vh; /* Para centrarlo verticalmente */
  background-color: #f8f9fa;
}

.border-dashed {
    border-style: dashed !important;
}

/* --- Animación del Checkmark (CSS Puro) --- */
.success-checkmark {
    height: 80px;
    width: 80px;
    margin: 0 auto;
}

.check-icon {
    width: 80px;
    height: 80px;
    position: relative;
    border-radius: 50%;
    box-sizing: content-box;
    border: 4px solid #4CAF50;
}

.check-icon::before {
    top: 3px;
    left: -2px;
    width: 30px;
    transform-origin: 100% 50%;
    border-radius: 100px 0 0 100px;
}

.check-icon::after {
    top: 0;
    left: 30px;
    width: 60px;
    transform-origin: 0 50%;
    border-radius: 0 100px 100px 0;
    animation: rotate-circle 4.25s ease-in;
}

.check-icon::before, .check-icon::after {
    content: '';
    height: 100px;
    position: absolute;
    background: #FFFFFF; /* Debe coincidir con el fondo de la tarjeta */
    transform: rotate(-45deg);
}

.icon-line {
    height: 5px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 10;
}

.icon-line.line-tip {
    top: 46px;
    left: 14px;
    width: 25px;
    transform: rotate(45deg);
    animation: icon-line-tip 0.75s;
}

.icon-line.line-long {
    top: 38px;
    right: 8px;
    width: 47px;
    transform: rotate(-45deg);
    animation: icon-line-long 0.75s;
}

.icon-circle {
    top: -4px;
    left: -4px;
    z-index: 10;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    position: absolute;
    box-sizing: content-box;
    border: 4px solid rgba(76, 175, 80, .5);
}

.icon-fix {
    top: 8px;
    width: 5px;
    left: 26px;
    z-index: 1;
    height: 85px;
    position: absolute;
    transform: rotate(-45deg);
    background-color: #FFFFFF;
}

@keyframes icon-line-tip {
    0% { width: 0; left: 1px; top: 19px; }
    54% { width: 0; left: 1px; top: 19px; }
    70% { width: 50px; left: -8px; top: 37px; }
    84% { width: 17px; left: 21px; top: 48px; }
    100% { width: 25px; left: 14px; top: 46px; }
}

@keyframes icon-line-long {
    0% { width: 0; right: 46px; top: 54px; }
    65% { width: 0; right: 46px; top: 54px; }
    84% { width: 55px; right: 0px; top: 35px; }
    100% { width: 47px; right: 8px; top: 38px; }
}
</style>