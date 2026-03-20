<template>
  <div>
    <TheHeader :user="user" />
    <div class="checkout-page bg-light-custom pb-5">
      <div class="container">

        <div class="row mb-4">
          <div class="col-12 text-center text-md-start pt-3">
            <h2 class="fw-bold text-uppercase tracking-wide mb-2">Finalizar Compra</h2>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center justify-content-md-start">
                <li class="breadcrumb-item"><a href="/" class="text-muted text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Checkout</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row g-4 g-lg-5">
          <div class="col-lg-7">

            <div class="checkout-card mb-4">
              <div class="d-flex align-items-center mb-4">
                <span class="step-number">1</span>
                <h5 class="mb-0 fw-bold text-uppercase">Dirección de Envío</h5>
              </div>

              <form @submit.prevent>
                <div class="row g-3">
                  <div class="col-12 mb-2" v-if="user">
                    <div class="alert alert-secondary border-0 d-flex align-items-center rounded-0">
                      <i class="fas fa-user-circle fa-lg me-3 text-dark"></i>
                      <span>Comprando como: <strong>{{ user.name }} {{ user.last_name }}</strong> ({{ user.email
                        }})</span>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Departamento</label>
                    <input type="text" class="form-control custom-input" v-model="form.department"
                      placeholder="Ej: Lima">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Provincia</label>
                    <input type="text" class="form-control custom-input" v-model="form.province" placeholder="Ej: Lima">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Distrito</label>
                    <input type="text" class="form-control custom-input" v-model="form.district"
                      placeholder="Ej: Miraflores">
                  </div>

                  <div class="col-12 mt-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Dirección (Calle, Av.,
                      Jr.)</label>
                    <input type="text" class="form-control custom-input" v-model="form.street"
                      placeholder="Av. Larco 123">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Número / Dpto</label>
                    <input type="text" class="form-control custom-input" v-model="form.number" placeholder="Ej: 402">
                  </div>
                  <div class="col-md-8">
                    <label class="form-label small fw-bold text-muted text-uppercase">Referencia (Opcional)</label>
                    <input type="text" class="form-control custom-input" v-model="form.detail"
                      placeholder="Frente al parque...">
                  </div>

                  <div class="col-md-6 mt-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Celular de contacto</label>
                    <input type="tel" class="form-control custom-input" v-model="form.phone" placeholder="999 999 999">
                  </div>
                </div>
              </form>
            </div>

            <div class="checkout-card">
              <div class="d-flex align-items-center mb-4">
                <span class="step-number">2</span>
                <h5 class="mb-0 fw-bold text-uppercase">Forma de Pago</h5>
              </div>

            <div class="payment-options">

                <div class="payment-option-card mb-3" :class="{ 'selected': paymentMethod === 'online' }"
                  @click="paymentMethod = 'online'">
                  <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center">
                      <div class="me-3">
                        <input class="form-check-input custom-radio" type="radio" name="payment" id="pay_online"
                          value="online" v-model="paymentMethod">
                      </div>
                      <div>
                        <label class="form-check-label fw-bold text-dark d-block" for="pay_online"
                          style="cursor:pointer;">
                          Tarjeta / Yape
                        </label>
                        <small class="text-muted">Pago seguro.</small>
                      </div>
                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">
                      <img src="/images/site/resources/visa.png" alt="Visa" class="payment-logo">
                      <img src="/images/site/resources/mastercard.png" alt="Mastercard" class="payment-logo">
                      <img src="/images/site/resources/yape.png" alt="Yape" class="payment-logo">
                    </div>
                  </div>
                </div>

                <div class="payment-option-card" :class="{ 'selected': paymentMethod === 'contraentrega' }"
                  @click="paymentMethod = 'contraentrega'">
                  <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center">
                      <div class="me-3">
                        <input class="form-check-input custom-radio" type="radio" name="payment" id="pay_cod"
                          value="contraentrega" v-model="paymentMethod">
                      </div>
                      <div>
                        <label class="form-check-label fw-bold text-dark d-block" for="pay_cod" style="cursor:pointer;">
                          Pago Contraentrega
                        </label>
                        <small class="text-muted">Pagas en efectivo al recibir.</small>
                      </div>
                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">
                      <i class="fas fa-money-bill"></i>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <div class="col-lg-5">
            <div class="card border-0 shadow-sm sticky-top rounded-0" style="top: 100px; z-index: 1;">
              <div class="card-header bg-white py-4 border-bottom-0">
                <h5 class="mb-0 fw-bold text-uppercase tracking-wide">Resumen del Pedido</h5>
              </div>
              <div class="card-body bg-white pt-0">

                <ul class="list-group list-group-flush mb-4">
                  <li v-for="(item, index) in cart" :key="index" class="list-group-item px-0 py-3 border-light">
                    <div class="d-flex justify-content-between">
                      <div class="d-flex flex-grow-1">
                        <div class="cart-img-wrapper">
                          <img :src="getProductImage(item)" :alt="item.Name">
                        </div>
                        <div class="ms-3 d-flex flex-column justify-content-center">
                          <h6 class="my-0 fw-bold text-uppercase" style="font-size: 0.85rem;">{{ item.Name }}</h6>
                          <small class="text-muted mt-1" v-if="item.selectedVariant">
                            {{ item.selectedVariant.color.ColorName }} | Talla {{ item.selectedVariant.size.SizeName }}
                          </small>

                          <div class="d-flex align-items-center mt-2">
                            <div class="quantity-control">
                              <button type="button" @click="updateQuantity(index, -1)"
                                :disabled="item.quantity <= 1">-</button>
                              <span>{{ item.quantity }}</span>
                              <button type="button" @click="updateQuantity(index, 1)">+</button>
                            </div>
                            <button type="button" class="btn btn-link text-danger ms-3 p-0"
                              @click="removeProduct(index)" title="Eliminar">
                              <i class="far fa-trash-alt"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="text-end">
                        <span class="fw-bold">S/ {{ (getCartItemPrice(item) * item.quantity).toFixed(2) }}</span>
                      </div>
                    </div>

                    <div v-if="stockErrors[index]"
                      class="mt-2 alert alert-danger py-2 px-3 small mb-0 d-flex align-items-center rounded-0 border-0">
                      <i class="fas fa-exclamation-circle me-2"></i> {{ stockErrors[index] }}
                    </div>
                  </li>
                </ul>

                <div class="totals-section bg-light p-3 rounded mb-4">
                  <div class="d-flex justify-content-between mb-2 text-muted">
                    <span>Subtotal</span>
                    <span>S/ {{ totalAmount }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Envío</span>
                    <span class="text-success fw-bold">GRATIS</span>
                  </div>
                  <div class="d-flex justify-content-between pt-2 border-top border-dark">
                    <span class="h5 fw-bold mb-0">Total</span>
                    <strong class="h5 fw-bold mb-0">S/ {{ totalAmount }}</strong>
                  </div>
                </div>

                <div v-if="errorMsg" class="alert alert-danger small rounded-0 border-0 mb-3">
                  <i class="fas fa-info-circle me-2"></i>{{ errorMsg }}
                </div>

                <button @click="processOrder" class="btn btn-dark w-100 py-3 fw-bold text-uppercase tracking-wide"
                  :disabled="processing || cart.length === 0">
                  <span v-if="processing" class="spinner-border spinner-border-sm me-2"></span>
                  {{ btnText }}
                </button>

                <p class="text-center text-muted small mt-3 mb-0">
                  <i class="fas fa-lock me-1"></i> Transacción segura y encriptada
                </p>

              </div>
            </div>
          </div>

        </div>
      </div>
        <UiBlocker 
          :show="processing" 
          text="Procesando tu pedido..." 
        />
    </div>
    <TheFooter />
  </div>
</template>

<script>
import axios from 'axios';
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';
import Swal from 'sweetalert2';
import UiBlocker from '../shared/UiBlocker.vue';

export default {
  components: { TheHeader, TheFooter, UiBlocker },
  name: "CheckoutComponent",
  props: {
    user: { type: Object, default: null }
  },
  data() {
    return {
      stockErrors: {},
      cart: [],
      paymentMethod: 'online', // Empezamos con 'online' por defecto (mejor conversión)
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
      return this.paymentMethod === 'online' ? 'PAGAR DE FORMA SEGURA' : 'CONFIRMAR PEDIDO';
    }
  },
  mounted() {
    this.loadCart();
    this.prefillUserData();

    // INYECCIÓN DEL SCRIPT DE CULQI
    const script = document.createElement('script');
    script.src = "https://checkout.culqi.com/js/v4";
    document.head.appendChild(script);

    // Conectamos la respuesta de Culqi con nuestra función en Vue
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
      if (newQuantity >= 1) {
        this.cart[index].quantity = newQuantity;
        this.saveCart();
      }
    },
    removeProduct(index) {
      this.cart.splice(index, 1);
      this.saveCart();
      if (this.cart.length === 0) window.location.href = '/';
    },
    saveCart() {
      localStorage.setItem('products', JSON.stringify(this.cart));
      this.stockErrors = {};
      this.errorMsg = '';
      window.dispatchEvent(new Event('cart-updated')); // Avisa al header
    },
    prefillUserData() {
      if (this.user) {
        this.form.phone = this.user.phone || '';
        if (this.user.addresses && this.user.addresses.length > 0) {
          const lastAddr = this.user.addresses[0];
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
      if (!this.form.street || !this.form.phone || !this.form.district || !this.form.department || !this.form.province) {
        this.errorMsg = "Por favor completa todos los campos obligatorios de envío.";
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
      }
      return true;
    },

    async processOrder() {
      this.errorMsg = '';
      this.stockErrors = {};

      if (!this.validateForm()) return;

      this.processing = true;

      try {
        const itemsToSend = this.cart.map(item => {
          return { ...item, Image: this.getProductImage(item) };
        });

        // 1. Guardar orden pendiente en Laravel
        const response = await axios.post('/checkout/process', {
          items: itemsToSend,
          shipping_address: this.form,
          payment_method: this.paymentMethod,
          customer_phone: this.form.phone,
          total_amount: this.totalAmount
        });

        const orderData = response.data;
        this.currentOrderReference = orderData.external_reference;

        // 2. Evaluar el método
        if (this.paymentMethod === 'contraentrega') {
          this.finishPurchase();
        } else {
          // Abrimos Culqi si es pago online
          this.openCulqi(orderData);
        }

      } catch (error) {
        console.error(error);
        this.processing = false;

        if (error.response && error.response.status === 422 && error.response.data.stock_errors) {
          this.stockErrors = error.response.data.stock_errors;
          this.errorMsg = "Algunos productos ya no tienen stock disponible. Revisa tu carrito.";
        } else {
          this.errorMsg = error.response?.data?.error || "Ocurrió un error inesperado al procesar tu orden.";
        }
      }
    },

    openCulqi(orderData) {
      // Validamos que haya llave pública
      if (!orderData.culqi_public_key) {
        Swal.fire('Error de Configuración', 'No se ha configurado la llave pública de Culqi en el servidor.', 'error');
        this.processing = false;
        return;
      }

      if (window.Culqi) {
        // Asignamos la llave que vino desde Laravel
        window.Culqi.publicKey = orderData.culqi_public_key;

        window.Culqi.settings({
          title: 'Perlux',
          currency: 'PEN',
          amount: Math.round(parseFloat(this.totalAmount) * 100),
        });

        window.Culqi.options({
          lang: "auto",
          installments: false,
          paymentMethods: {
            tarjeta: true,
            yape: true,
            billetera: true
          }
        });

        // Abrir Modal
        window.Culqi.open();
      } else {
        this.errorMsg = "El sistema de pagos no ha cargado correctamente. Refresca la página.";
        this.processing = false;
      }
    },

    async culqiCallback() {
      if (window.Culqi.token) {
        // Tenemos el token de la tarjeta/yape
        const token = window.Culqi.token.id;
        const email = window.Culqi.token.email || (this.user ? this.user.email : 'cliente@perlux.com');

        try {
          // Avisamos a Laravel para que realice el cargo
          await axios.post('/checkout/confirm-payment', {
            token: token,
            order_number: this.currentOrderReference,
            email: email,
            amount: Math.round(parseFloat(this.totalAmount) * 100)
          });

          this.finishPurchase();

        } catch (error) {
          console.error(error);
          this.errorMsg = error.response?.data?.message || "Pago autorizado por el banco, pero hubo un error al registrarlo.";
          this.processing = false;
          window.scrollTo({ top: 0, behavior: 'smooth' });
        }
      } else if (window.Culqi.error) {
        // Tarjeta sin fondos, cerrada por el usuario, etc.
        this.errorMsg = window.Culqi.error.user_message;
        this.processing = false;
      } else {
        // En caso de que se cierre el modal sin acción
        this.processing = false;
      }
    },

    async simulateSuccess(orderRef) {
      this.processing = true;
      try {
        await axios.post('/checkout/confirm-payment', {
          token: 'tok_test_SIMULADO',
          order_number: orderRef,
          email: 'test@simulado.com',
          amount: Math.round(parseFloat(this.totalAmount) * 100)
        });
        this.finishPurchase();
      } catch (e) {
        console.error(e);
        this.errorMsg = "Error en simulación";
        this.processing = false;
      }
    },

    finishPurchase() {
      localStorage.removeItem('products');
      window.dispatchEvent(new Event('cart-updated')); // Actualiza header
      window.location.href = `/thank-you?order=${this.currentOrderReference}`;
    }
  }
};
</script>

<style scoped>
/* =========================================
   DISEÑO PREMIUM CHECKOUT
   ========================================= */
.bg-light-custom {
  background-color: #fcfcfc;
}

.checkout-page {
  padding-top: 7rem;
  min-height: 100vh;
}

.tracking-wide {
  letter-spacing: 1px;
}

/* Tarjetas de sección (Envío / Pagos) */
.checkout-card {
  background: #fff;
  padding: 30px;
  border: 1px solid #f0f0f0;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
}

.step-number {
  background: #000;
  color: #fff;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  margin-right: 15px;
}

/* Inputs Minimalistas */
.custom-input {
  border-radius: 0;
  border: 1px solid #ddd;
  padding: 12px 15px;
  font-size: 0.95rem;
  background-color: #fff;
  transition: all 0.2s;
}

.custom-input:focus {
  border-color: #000;
  box-shadow: none;
  background-color: #fdfdfd;
}

/* Opciones de Pago */
.payment-option-card {
  border: 1px solid #e0e0e0;
  padding: 20px;
  cursor: pointer;
  transition: all 0.2s ease;
  background: #fff;
  position: relative;
}

.payment-option-card:hover {
  border-color: #aaa;
  background-color: #fafafa;
}

.payment-option-card.selected {
  border: 2px solid #000;
  background-color: #fff;
}

.custom-radio {
  width: 1.2rem;
  height: 1.2rem;
  cursor: pointer;
}

.custom-radio:checked {
  background-color: #000;
  border-color: #000;
}

/* Resumen del Pedido */
.cart-img-wrapper {
  width: 70px;
  height: 90px;
  background: #f4f4f4;
  overflow: hidden;
  flex-shrink: 0;
}

.cart-img-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.quantity-control {
  display: flex;
  align-items: center;
  border: 1px solid #ddd;
}

.quantity-control button {
  background: transparent;
  border: none;
  padding: 2px 10px;
  font-weight: bold;
  color: #555;
  transition: color 0.2s;
}

.quantity-control button:hover {
  color: #000;
}

.quantity-control span {
  font-size: 0.85rem;
  font-weight: 600;
  padding: 0 10px;
}

.btn-dark {
  background-color: #000;
  border: 1px solid #000;
  transition: all 0.3s;
}

.btn-dark:hover {
  background-color: #333;
}

.btn-dark:disabled {
  background-color: #777;
  border-color: #777;
}

@media (max-width: 991.98px) {
  .checkout-page {
    padding-top: 6rem;
  }
}

@media (max-width: 768px) {
  .checkout-card {
    padding: 20px;
  }
}

.payment-logo {
  height: 26px;
  width: auto;
  object-fit: contain;
  background-color: #fff;
  border-radius: 4px;
  border: 1px solid #eee;
  padding: 3px 6px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  transition: transform 0.2s ease;
}

.payment-option-card:hover .payment-logo {
  transform: scale(1.05);
}
</style>