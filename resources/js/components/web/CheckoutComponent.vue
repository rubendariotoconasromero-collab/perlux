<template>
  <TheHeader :user="user" />
  <div class="checkout-page bg-light">
    <div class="container">

      <div class="row mb-4">
        <div class="col-12">
          <h2 class="fw-bold">Finalizar Compra</h2>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/" class="text-dark">Inicio</a></li>
              <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="row g-5">

        <div class="col-lg-7">

          <div class="card border-0 shadow-sm p-4 mb-4">
            <h5 class="mb-4 fw-bold">1. Dirección de Envío</h5>
            <form @submit.prevent>
              <div class="row g-3">
                <div class="col-12 mb-2" v-if="user">
                  <div class="alert alert-light border d-flex align-items-center">
                    <i class="fas fa-user-circle fa-lg me-2"></i>
                    <span>Comprando como: <strong>{{ user.name }} {{ user.last_name }}</strong></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Departamento</label>
                  <input type="text" class="form-control" v-model="form.department" placeholder="Ej: Lima">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Provincia</label>
                  <input type="text" class="form-control" v-model="form.province" placeholder="Ej: Lima">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Distrito</label>
                  <input type="text" class="form-control" v-model="form.district" placeholder="Ej: Miraflores">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Celular de contacto</label>
                  <input type="text" class="form-control" v-model="form.phone" placeholder="999 999 999">
                </div>
                <div class="col-12">
                  <label class="form-label">Dirección (Calle, Av., Jr.)</label>
                  <input type="text" class="form-control" v-model="form.street" placeholder="Av. Larco 123">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Número / Dpto</label>
                  <input type="text" class="form-control" v-model="form.number">
                </div>
                <div class="col-md-8">
                  <label class="form-label">Referencia (Opcional)</label>
                  <input type="text" class="form-control" v-model="form.detail">
                </div>
              </div>
            </form>
          </div>

          <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-4 fw-bold">2. Forma de Pago</h5>

            <div class="payment-options">

              <div class="payment-option-card" :class="{ 'selected': paymentMethod === 'contraentrega' }"
                @click="paymentMethod = 'contraentrega'">

                <div class="d-flex align-items-center">
                  <div class="me-3">
                    <input class="form-check-input" type="radio" name="payment" id="pay_cod" value="contraentrega"
                      v-model="paymentMethod">
                  </div>
                  <div>
                    <label class="form-check-label fw-bold text-dark d-block" for="pay_cod" style="cursor:pointer;">
                      Pago Contraentrega
                    </label>
                    <small class="text-muted">Pagas en efectivo al recibir en tu domicilio.</small>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1;">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0 fw-bold">Resumen del Pedido</h5>
            </div>
            <div class="card-body">

              <ul class="list-group list-group-flush mb-3">
                <li v-for="(item, index) in cart" :key="index" class="list-group-item px-0">

                  <div class="d-flex justify-content-between lh-sm">
                    <div class="d-flex">
                      <div
                        style="width: 50px; height: 50px; background: #eee; margin-right: 10px; border-radius: 4px; overflow: hidden;">
                        <img :src="getProductImage(item)" style="width:100%; height:100%; object-fit:cover;">
                      </div>
                      <div>
                        <h6 class="my-0 small fw-bold">{{ item.Name }}</h6>
                        <small class="text-muted" v-if="item.selectedVariant">
                          {{ item.selectedVariant.color.ColorName }} / {{ item.selectedVariant.size.SizeName }}
                        </small>
                        <br>
                        <!-- <small class="text-muted">Cant: {{ item.quantity }}</small> -->
                        <div class="d-flex align-items-center mt-1">
                          <small class="text-muted me-2">Cant:</small>
                          <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                            @click="updateQuantity(index, -1)" :disabled="item.quantity <= 1">
                            -
                          </button>

                          <span class="mx-2 small fw-bold">{{ item.quantity }}</span>

                          <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                            @click="updateQuantity(index, 1)">
                            +
                          </button>

                          <button type="button" class="btn btn-sm btn-link text-danger ms-auto py-0 ps-5"
                            @click="removeProduct(index)">
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted">S/ {{ (getCartItemPrice(item) * item.quantity).toFixed(2) }}</span>
                  </div>

                  <div v-if="stockErrors[index]"
                    class="mt-2 alert alert-danger py-1 px-2 small mb-0 d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ stockErrors[index] }}
                  </div>

                </li>
              </ul>

              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <strong>S/ {{ totalAmount }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-4">
                <span>Envío</span>
                <span class="text-success">Gratis</span>
              </div>
              <div class="d-flex justify-content-between border-top pt-3">
                <span class="h5">Total a Pagar</span>
                <strong class="h5">S/ {{ totalAmount }}</strong>
              </div>

              <button @click="processOrder" class="btn btn-dark w-100 py-3 mt-3 fw-bold"
                :disabled="processing || cart.length === 0">
                <span v-if="processing" class="spinner-border spinner-border-sm me-2"></span>
                {{ btnText }}
              </button>

              <div v-if="errorMsg" class="alert alert-danger mt-3 small">
                {{ errorMsg }}
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <TheFooter />

</template>

<script>
import axios from 'axios';
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';
export default {
  components: { TheHeader, TheFooter },
  name: "CheckoutComponent",
  props: {
    user: { type: Object, default: null } // Recibimos el usuario desde Laravel
  },
  data() {
    return {
      stockErrors: {},
      cart: [],
      paymentMethod: 'contraentrega',
      processing: false,
      errorMsg: '',
      form: {
        department: '', province: '', district: '',
        street: '', number: '', detail: '', phone: ''
      },
      currentOrderReference: null
    };
  },
  computed: {
    totalAmount() {
      return this.cart.reduce((total, p) => {
        const price = this.getCartItemPrice(p);
        const qty = p.quantity || 1;
        return total + (parseFloat(price) * qty);
      }, 0).toFixed(2);
    },
    btnText() {
      if (this.processing) return 'Procesando...';
      return this.paymentMethod === 'online' ? 'Ir a Pagar' : 'Confirmar Pedido';
    }
  },
  mounted() {
    this.loadCart();
    this.prefillUserData();
    // Hook global para respuesta de Culqi
    window.culqi = this.culqiCallback;
  },
  methods: {
    loadCart() {
      const storedCart = localStorage.getItem('products');
      this.cart = storedCart ? JSON.parse(storedCart) : [];
      if (this.cart.length === 0) window.location.href = '/';
    },
    updateQuantity(index, change) {
      const newQuantity = this.cart[index].quantity + change;
      
      // Validamos que la cantidad nunca sea menor a 1
      if (newQuantity >= 1) {
        this.cart[index].quantity = newQuantity;
        this.saveCart(); // Guardamos los cambios en localStorage
      }
    },

    // Nuevo método (Opcional): Elimina el producto del carrito
    removeProduct(index) {
      this.cart.splice(index, 1);
      this.saveCart();
      
      // Si el carrito se queda vacío, redirigimos al inicio
      if (this.cart.length === 0) {
        window.location.href = '/';
      }
    },

    // Nuevo método: Sincroniza el carrito actual con localStorage
    saveCart() {
      localStorage.setItem('products', JSON.stringify(this.cart));
      // Limpiamos errores de stock si el usuario modifica el carrito
      this.stockErrors = {}; 
      this.errorMsg = '';
    },
    prefillUserData() {
      if (this.user) {
        this.form.phone = this.user.phone || '';
        // Si tienes direcciones guardadas en addresses, podrías tomar la última
        if (this.user.addresses && this.user.addresses.length > 0) {
          const lastAddr = this.user.addresses[0]; // Ejemplo simple
          this.form.department = lastAddr.department;
          this.form.province = lastAddr.province;
          this.form.district = lastAddr.district;
          this.form.street = lastAddr.street;
          this.form.number = lastAddr.number;
        }
      }
    },
    getProductImage(product) {
      if (product.images && product.images.length > 0) return product.images[0].ImagePath;
      return product.image || '/images/placeholder.jpg';
    },
    getCartItemPrice(product) {
      return (product.selectedVariant && product.selectedVariant.Price)
        ? product.selectedVariant.Price
        : (product.Price || 0);
    },

    validateForm() {
      if (!this.form.street || !this.form.phone || !this.form.district) {
        this.errorMsg = "Por favor completa los campos obligatorios de envío.";
        return false;
      }
      return true;
    },

    async processOrder() {
      this.errorMsg = '';
      this.stockErrors = {}; // Limpiamos errores previos al intentar de nuevo

      if (!this.validateForm()) return;

      this.processing = true;

      try {
        const itemsToSend = this.cart.map(item => {
          return {
            ...item, // Mantenemos el resto de datos (ID, cantidad, variantes)
            Image: this.getProductImage(item) // Forzamos el envío de la URL correcta
          };
        });
        const response = await axios.post('/checkout/process', {
          items: itemsToSend,
          shipping_address: this.form,
          payment_method: this.paymentMethod,
          customer_phone: this.form.phone
        });

        // Si todo va bien...
        const orderData = response.data;
        this.currentOrderReference = orderData.external_reference;

        if (this.paymentMethod === 'contraentrega') {
          this.finishPurchase();
        } else {
          this.openCulqi(orderData);
        }

      } catch (error) {
        console.error(error);
        this.processing = false;

        // MANEJO DE ERRORES DE STOCK (422)
        if (error.response && error.response.status === 422 && error.response.data.stock_errors) {
          // Asignamos los errores específicos devueltos por Laravel
          this.stockErrors = error.response.data.stock_errors;

          // Mensaje general
          this.errorMsg = "Algunos productos ya no tienen stock disponible. Revisa tu carrito.";

          // Opcional: Scroll hacia arriba para que vea los errores
          window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
          // Error genérico (500 u otro)
          this.errorMsg = error.response?.data?.error || "Ocurrió un error inesperado.";
        }
      }
    },

    openCulqi(orderData) {
      // 1. MODO DESARROLLO / SIN CLAVES
      if (orderData.mode === 'dev' || orderData.culqi_public_key === 'pk_test_DEMO_MODE_NO_KEY') {
        // Simulamos el proceso visualmente
        alert("[MODO DEV] Claves de Culqi no configuradas. Simulando pago exitoso...");

        // Llamamos directamente a la confirmación simulada
        this.simulateSuccess(orderData.external_reference);
        return;
      }

      // 2. MODO REAL (Código existente)
      if (window.Culqi) {
        window.Culqi.publicKey = orderData.culqi_public_key;
        // ... resto de tu config ...
        window.Culqi.open();
      }
    },

    // Método auxiliar para simular el éxito
    async simulateSuccess(orderRef) {
      this.processing = true;
      try {
        await axios.post('/checkout/confirm-payment', {
          token: 'tok_test_SIMULADO', // Token falso
          order_number: orderRef,
          email: 'test@simulado.com'
        });
        this.finishPurchase();
      } catch (e) {
        console.error(e);
        this.errorMsg = "Error en simulación";
        this.processing = false;
      }
    },

    async culqiCallback() {
      if (window.Culqi.token) {
        const token = window.Culqi.token.id;
        const email = window.Culqi.token.email;
        try {
          await axios.post('/checkout/confirm-payment', {
            token: token,
            order_number: this.currentOrderReference,
            email: email
          });
          this.finishPurchase();
        } catch (error) {
          this.errorMsg = "Pago autorizado pero error al confirmar. Contacta soporte.";
          this.processing = false;
        }
      } else {
        console.log(window.Culqi.error);
        this.errorMsg = window.Culqi.error.user_message;
        this.processing = false;
      }
    },

    finishPurchase() {
      localStorage.removeItem('products');
      window.location.href = `/thank-you?order=${this.currentOrderReference}`; // Crea esta vista después
    }
  }
};
</script>

<style scoped>
.checkout-page {
  padding-top: 6rem;
}

.form-control:focus {
  border-color: #000;
  box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
}

.payment-option-card {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 15px;
  cursor: pointer;
  transition: all 0.2s ease;
  background: #fff;
}

.payment-option-card:hover {
  border-color: #999;
  background-color: #fcfcfc;
}

.payment-option-card.selected {
  border: 2px solid #000;
  background-color: #fff;
}

.form-check-input:checked {
  background-color: #000;
  border-color: #000;
}

@media (max-width: 991.98px) {
  .collection-container {
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 5rem;
  }
}

@media (max-width: 768px) {
  .checkout-page {
    padding-top: 5rem;
  }
}
</style>