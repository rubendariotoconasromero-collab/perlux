<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1 class="welcome-title">Bienvenid@ de vuelta</h1>
        <p class="welcome-subtitle">Inicia sesión con tu cuenta</p>
      </div>

      <form @submit.prevent="login" class="login-form">
        <div class="form-group">
          <label for="email" class="form-label">Correo</label>
          <input id="email" v-model="form.email" type="email" class="form-input"
            placeholder="tucorreo@ejemplo.com" required />
        </div>

        <div class="form-group">
          <div class="password-header">
            <label for="password" class="form-label">Contraseña</label>
            <a href="#" class="forgot-password" @click.prevent="handleForgotPassword">
              ¿Olvidaste tu contraseña?
            </a>
          </div>
          <input id="password" v-model="form.password" type="password" class="form-input"
            placeholder="********" required />
        </div>

        <button type="submit" class="login-button">
          <span>Iniciar sesión</span>
        </button>

        <div class="divider">
          <span class="divider-text">o</span>
        </div>

        <a href="/auth/google/login" class="google-button">
          <svg class="google-icon" viewBox="0 0 24 24">
            <path fill="#4285F4"
              d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
            <path fill="#34A853"
              d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
            <path fill="#FBBC05"
              d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
            <path fill="#EA4335"
              d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
          </svg>
          Iniciar sesión con Google
        </a>

        <p class="signup-text">
          ¿Eres nuev@ en Perlux?
          <a href="/register" class="signup-link">Crea una cuenta</a>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue'
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'PerluxLogin',
  emits: ['mensaje-login', 'login-success', 'login-error'],
  setup(props, { emit }) {
     
    const form = reactive({
      email: '',
      password: ''
    })

    const handleGoogleLogin = () => {
      console.log('Google login clicked')
      // Redirección directa al backend si es necesario
      // window.location.href = '/auth/google/login'; 
    }

    const handleForgotPassword = () => {
      console.log('Forgot password clicked')
      Swal.fire('Recuperar contraseña', 'Te enviaremos un correo para restablecer tu contraseña.', 'info');
    }

    const handleSignup = () => {
      window.location.href = '/register';
    }

    const holaMundo = () => {
      console.log('Componente Login montado correctamente');
    }

    // const login = async () => {
    //   try {
    //     const token = document.querySelector('meta[name="csrf-token"]').content;
    //     if (!token) throw new Error('Token CSRF no encontrado');

    //     const response = await axios.post('/login', {
    //       email: form.email,
    //       password: form.password,
    //     }, {
    //       headers: { 'X-CSRF-TOKEN': token }
    //     });

    //     console.log('Emitiendo login-success:', response.data);
    //     emit('login-success', {
    //       resp: response.data.message || 'Bienvenido a Perlux',
    //       redirect_url: response.data.redirect_url,
    //       user: response.data.user // Asumiendo que el backend devuelve el usuario
    //     });

    //   } catch (error) {
    //     console.error('Error en login:', error);
    //     emit('login-error', {
    //       resp: error.response?.data?.message || 'Error al iniciar sesión'
    //     });
    //   }
    // };

    const login = async () => {
      try {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        if (!token) throw new Error('Token CSRF no encontrado');

        // 1. Agregamos header 'Accept' para asegurar JSON y evitar redirecciones HTML 
        const response = await axios.post('/login', {
          email: form.email,
          password: form.password,
        }, {
          headers: { 
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json' 
          }
        });

        console.log('Respuesta del servidor:', response);

        // 2. Prevenimos el error: Si el backend no manda 'user', enviamos null
        const userData = response.data.user || null; 

        // 3. Emitimos el evento de éxito
        emit('login-success', {
          resp: response.data.message || 'Bienvenido a Perlux',
          redirect_url: response.data.redirect_url || '/inicio', 
          user: userData // Ahora es seguro (objeto o null)
        });

      } catch (error) {
        console.error('Error capturado en login:', error);
        
        let mensajeError = 'Error al iniciar sesión';

        // 4. Diferenciamos errores de Backend vs errores de JavaScript
        if (error.response && error.response.data && error.response.data.message) {
             // Error que viene del backend (ej: credenciales inválidas)
             mensajeError = error.response.data.message;
        } else if (error.message) {
             // Error de JavaScript o de red
             mensajeError = error.message;
        }

        emit('login-error', {
          resp: mensajeError
        });
      }
    };

    return {
      form,
      login,
      handleGoogleLogin,
      handleForgotPassword,
      handleSignup,
      holaMundo,
    }
  }
}
</script>

<style scoped>
.login-container {
  /* min-height: 100svh; */
  margin-top: 5.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #ffffff;
  padding: 20px;
}

.login-card {
  background: white;
  border-radius: 16px;
  padding: 40px;
  width: 100%;
  max-width: 450px;
  /* box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); */
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.welcome-title {
  font-size: 24px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0 0 8px 0;
}

.welcome-subtitle {
  font-size: 14px;
  color: #1f1f1f;
  margin: 0;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  font-size: 14px;
  font-weight: 500;
  color: #333;
  margin-bottom: 8px;
}

.password-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}

.forgot-password {
  font-size: 12px;
  color: #666;
  text-decoration: underline;
  transition: color 0.2s ease;
}

.forgot-password:hover {
  color: #333;
}

.form-input {
  padding: 10px 16px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  background: #fff;
}

.form-input:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
}

.form-input::placeholder {
  color: #999;
}

.login-button {
  background: #000;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px 14px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
  margin-top: 8px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.login-button:hover:not(:disabled) {
  background: #333;
  transform: translateY(-1px);
}

.login-button:disabled {
  background: #666;
  cursor: not-allowed;
  transform: none;
}

.divider {
  position: relative;
  text-align: center;
  margin: 0px 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: #e1e5e9;
}

.divider-text {
  background: white;
  padding: 0 16px;
  color: #666;
  font-size: 14px;
  position: relative;
  z-index: 1;
}

.google-button {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  background: white;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 10px 12px;
  font-size: 14px;
  font-weight: 500;
  color: #333;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.1s ease;
}

.google-button:hover {
  background: #f8f9fa;
  border-color: #d1d5db;
  transform: translateY(-1px);
}

.google-icon {
  width: 18px;
  height: 18px;
}

.signup-text {
  text-align: center;
  font-size: 14px;
  color: #666;
  margin: 20px 0 0 0;
}

.signup-link {
  color: #000;
  text-decoration: underline;
  font-weight: 600;
  transition: color 0.2s ease;
}

.signup-link:hover {
  color: #333;
}

/* Responsive */
@media (max-width: 480px) {
  .login-card {
    padding: 24px;
    margin: 0 16px;
  }

  .welcome-title {
    font-size: 20px;
  }

  .form-input,
  .login-button,
  .google-button {
    padding: 14px 16px;
  }
}
</style>