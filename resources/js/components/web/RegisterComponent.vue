<template>
  <div>
    <TheHeader :user="user" />

    <div class="register-wrapper">
      <SkinlyRegisterComponent 
        ref="login" 
        @mensaje-login="onLoginMensaje" 
        @login-success="loginSuccess"
        @login-error="loginError" 
      />
    </div>

    <TheFooter />

  </div>
</template>

<script>
// Importamos los componentes compartidos
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';
import SkinlyRegisterComponent from './SkinlyRegisterComponent.vue';
import Swal from 'sweetalert2';

export default {
  name: 'RegisterView',
  components: {
    TheHeader,
    TheFooter,
    SkinlyRegisterComponent
  },
  props: {
    user: {
      type: Object,
      required: false,
      default: null,
    },
    // Si necesitas productId aquí por alguna razón (venía en tu código original)
    productId: {
      type: String,
      required: false
    },
  },
  
  methods: {
    // --- LÓGICA DE REGISTRO ---
    
    loginSuccess(data) {
        console.log('Registro/Login Exitoso:', data);
        this.mostrarNotificacion('¡Bienvenido!', data.resp || 'Registro exitoso', 'success');
        
        // Redirigir a /user o al inicio después del registro exitoso
        setTimeout(() => {
            window.location.href = '/user'; // O '/' según prefieras
        }, 1500);
    },

    loginError(data){
        this.mostrarNotificacion('Error', data.resp || 'Hubo un problema con el registro', 'error');
    },

    onLoginMensaje(data){
        console.log('Mensaje:', data.mensaje);
    },

    mostrarNotificacion(titulo, texto, icono) {
        Swal.fire({
            title: titulo,
            text: texto,
            icon: icono,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    },
  },

  async mounted() {
    // Si tu componente de registro tiene algún método de inicialización
    if (this.$refs.login && this.$refs.login.holaMundo) {
        this.$refs.login.holaMundo();
    }
  }
};
</script>

<style scoped>
/* Solo necesitamos estilos para el contenedor del formulario de registro,
   ya que el Header y Footer traen sus propios estilos.
*/

.register-wrapper {
  /* Padding superior para compensar el Header Fijo (~100px - 140px) */
  padding-top: 140px; 
  /* Padding inferior para separar del Footer */
  padding-bottom: 80px;
  /* Fondo gris claro suave para toda la página de registro */
  background-color: #f8f9fa; 
  min-height: 100vh; /* Asegura que ocupe al menos toda la pantalla */
  display: flex;
  justify-content: center;
  align-items: flex-start; /* Alineado arriba (con padding) en lugar de centro vertical */
}

/* Ajustes responsive */
@media (max-width: 992px) {
  .register-wrapper {
    padding-top: 120px;
  }
}
</style>