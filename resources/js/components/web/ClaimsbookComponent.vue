<template>
  <div>
    <TheHeader :user="user" />

    <div class="claims-wrapper">
      <div class="container">
        <div class="claims-card">
          
          <div class="text-center mb-5">
            <h1 class="claims-title">Libro de reclamaciones</h1>
            <p class="claims-intro">
              ¡Hola! Sentimos que tu experiencia en Perlux no haya sido lo que esperabas. 
              Si necesitas presentar un reclamo o expresar alguna queja, puedes hacerlo fácilmente por este medio.
            </p>
            
            <div class="definitions-box text-start mx-auto">
              <p class="mb-2">
                <strong>RECLAMO:</strong> Si no quedaste satisfecha con los productos adquiridos.
              </p>
              <p class="mb-0">
                <strong>QUEJA:</strong> Si no estuviste conforme con el servicio o la atención recibida.
              </p>
            </div>
          </div>

          <form @submit.prevent="submitClaim" class="claims-form">
            <div class="row g-3">
              
              <div class="col-md-6">
                <label for="name" class="form-label">Nombre*</label>
                <input id="name" v-model="form.name" type="text" class="form-control form-input" required />
              </div>
              <div class="col-md-6">
                <label for="lastname" class="form-label">Apellidos*</label>
                <input id="lastname" v-model="form.lastname" type="text" class="form-control form-input" required />
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email*</label>
                <input id="email" v-model="form.email" type="email" class="form-control form-input" required />
              </div>

              <div class="col-md-6">
                <label for="dni" class="form-label">DNI o RUC*</label>
                <input id="dni" v-model="form.document" type="text" class="form-control form-input" required />
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label">Teléfono</label>
                <input id="phone" v-model="form.phone" type="tel" class="form-control form-input" />
              </div>

              <div class="col-12">
                <label for="address" class="form-label">Dirección*</label>
                <input id="address" v-model="form.address" type="text" class="form-control form-input" required />
              </div>

              <div class="col-12">
                <label for="department" class="form-label">Departamento*</label>
                <input id="department" v-model="form.department" type="text" class="form-control form-input" required />
              </div>

              <div class="col-md-6">
                <label for="province" class="form-label">Provincia*</label>
                <input id="province" v-model="form.province" type="text" class="form-control form-input" required />
              </div>
              <div class="col-md-6">
                <label for="district" class="form-label">Distrito*</label>
                <input id="district" v-model="form.district" type="text" class="form-control form-input" required />
              </div>

              <div class="col-12">
                <label for="product" class="form-label">Producto*</label>
                <input id="product" v-model="form.product" type="text" class="form-control form-input" placeholder="Nombre del producto o N° de pedido" required />
              </div>

              <div class="col-12">
                <label for="type" class="form-label">Tipo*</label>
                <select id="type" v-model="form.type" class="form-select form-input" required>
                  <option value="" disabled selected>Selecciona una opción</option>
                  <option value="Reclamo">Reclamo</option>
                  <option value="Queja">Queja</option>
                </select>
              </div>

              <div class="col-12">
                <label for="description" class="form-label">Descripción detallada*</label>
                <textarea id="description" v-model="form.description" class="form-control form-input" rows="5" required></textarea>
              </div>

              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-submit w-100">
                  Enviar
                </button>
              </div>

            </div>
          </form>

        </div>
      </div>
    </div>

    <TheFooter />
  </div>
</template>

<script>
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';
import Swal from 'sweetalert2';

export default {
  name: 'ClaimsBook',
  components: {
    TheHeader,
    TheFooter
  },
  props: {
    user: {
      type: Object,
      required: false,
      default: null
    }
  },
  data() {
    return {
      form: {
        name: '',
        lastname: '',
        email: '',
        document: '',
        phone: '',
        address: '',
        department: '',
        province: '',
        district: '',
        product: '',
        type: '',
        description: ''
      }
    };
  },
  methods: {
    submitClaim() {
      // Aquí iría la lógica para enviar a tu API con Axios
      // Por ahora simulamos el éxito
      
      console.log("Datos del reclamo:", this.form);

      Swal.fire({
        title: '¡Enviado!',
        text: 'Tu solicitud ha sido registrada correctamente. Te contactaremos pronto.',
        icon: 'success',
        confirmButtonColor: '#7b9cc9', // Color acorde al diseño
        confirmButtonText: 'Entendido'
      }).then((result) => {
        if (result.isConfirmed || result.isDismissed) {
          this.resetForm();
          // Opcional: Redirigir al inicio
          // window.location.href = '/'; 
        }
      });
    },
    resetForm() {
      this.form = {
        name: '', lastname: '', email: '', document: '', phone: '',
        address: '', department: '', province: '', district: '',
        product: '', type: '', description: ''
      };
    }
  }
};
</script>

<style scoped>
/* Layout General */
.claims-wrapper {
  padding-top: 160px; /* Espacio para el header fijo */
  padding-bottom: 80px;
  background-color: #f8f9fa; /* Fondo gris claro suave */
  min-height: 100vh;
}

.claims-card {
  background-color: #ffffff;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  max-width: 800px; /* Ancho máximo similar a un formulario de papel */
  margin: 0 auto;
}

/* Tipografía y Textos */
.claims-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 1rem;
  text-transform: uppercase; /* Opcional, para dar fuerza al título */
  letter-spacing: 1px;
}

.claims-intro {
  font-size: 1rem;
  color: #555;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.definitions-box {
  background-color: #afdbff; /* Fondo rosado muy suave */
  border: 1px solid #afdbff;
  padding: 20px;
  border-radius: 8px;
  max-width: 600px;
  font-size: 0.95rem;
  color: #444;
}

/* Estilos de Inputs (Coherentes con Registro/Perfil) */
.form-label {
  font-weight: 600;
  font-size: 0.9rem;
  color: #333;
  margin-bottom: 0.4rem;
}

.form-input {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 10px 15px;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  background-color: #fff;
}

.form-input:focus {
  border-color: #7b9cc9;
  box-shadow: 0 0 0 3px rgba(255, 102, 153, 0.1);
  outline: none;
}

textarea.form-input {
  resize: vertical; /* Permitir redimensionar solo verticalmente */
}

/* Botón Enviar */
.btn-submit {
  background-color: #7b9cc9;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 14px;
  font-size: 1rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-submit:hover {
  background-color: #7ba5e0; /* Un tono más oscuro al hover */
  transform: translateY(-2px);
  color: white;
}

.btn-submit:active {
  transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
  .claims-wrapper {
    padding-top: 130px;
    padding-left: 15px;
    padding-right: 15px;
  }
  
  .claims-card {
    padding: 25px;
  }

  .claims-title {
    font-size: 1.5rem;
  }
}
</style>