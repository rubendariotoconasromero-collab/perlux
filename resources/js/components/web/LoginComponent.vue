<template>
  <div>
    <TheHeader :user="user" />

    <SkinlyLoginComponent ref="login" @mensaje-login="onLoginMensaje" @login-success="loginSuccess"
      @login-error="loginError" />

  

    <TheFooter />

  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';
import SkinlyLoginComponent from './SkinlyLoginComponent.vue';

export default {
  name: 'Home', // Nombre sugerido para este componente
  components: {
    TheHeader,
    TheFooter,
    SkinlyLoginComponent
  },
  props: {
    user: {
      type: Object,
      required: false,
      default: null,
    }
  },
  data() {
    return {
      collections: [],
      collections_jeans: [],
    };
  },
  methods: {
    // --- LÓGICA DE LOGIN ---
    loginSuccess(data) {
      console.log('Login Exitoso:', data);
      
      // PROTECCIÓN: Verificamos si existe el usuario antes de leer .name
      const nombreUsuario = data.user ? data.user.name : 'Usuario';

      this.mostrarNotificacion('Bienvenido', `Hola ${nombreUsuario}`, 'success');
      
      // Manejo de redirección
      if (data.redirect_url && data.redirect_url !== 'inicio') {
        window.location.href = data.redirect_url; 
      } else {
         // Si el backend no devolvió el usuario, forzamos recarga
         // para que Laravel inyecte el usuario en la sesión nueva.
         window.location.reload(); 
      }
    },

    loginError(data) {
      this.mostrarNotificacion('Error', data.resp || 'Credenciales incorrectas', 'error');
    },

    onLoginMensaje(data) {
      console.log('Mensaje Login:', data.mensaje);
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

    // --- CARGA DE DATOS ---
    async getCollections() {
      try {
        const response = await axios.get('/get_collections');
        this.collections = response.data || [];
      } catch (error) {
        console.error('Error cargando colecciones:', error);
      }
    },
    async getCollectionsJeans() {
      try {
        const response = await axios.get('/get_collections_novias');
        this.collections_jeans = response.data || [];
      } catch (error) {
        console.error('Error cargando colecciones novias:', error);
      }
    }
  },
  async mounted() {
    await this.getCollections();
    await this.getCollectionsJeans();
    
    // Iniciar lógica del componente login si es necesario (ej: verificar token)
    if (this.$refs.login && this.$refs.login.holaMundo) {
        this.$refs.login.holaMundo();
    }
  }
};
</script>

<style scoped>
/* Estilos específicos de la Home */
.section-title {
    font-size: 2rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hero-placeholder {
    background-image: url('/images/site/resources/hero-bg.jpg'); /* Pon tu imagen de fondo real */
    background-size: cover;
    background-position: center;
    color: white; /* Texto blanco sobre el hero */
}

/* Ajustes globales para esta vista */
body {
    background-color: #ffffff;
}
</style>