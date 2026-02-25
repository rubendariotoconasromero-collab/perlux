<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="welcome-container">
        <div class="welcome-header">
            <div class="container">
                <h2 class="welcome-title text-start">¡Hola, {{ user.name ? user.name.split(' ')[0] : 'Admin' }}!</h2>
                <p class="welcome-subtitle text-start">Bienvenido al panel de administración de Perlux.</p>
            </div>
        </div>

        <div class="container content-wrapper">
            <div class="row g-4 justify-content-center">
                
                <div class="col-lg-5 col-md-6">
                    <div class="card profile-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4 d-flex align-items-center justify-content-center flex-column">
                            
                            <div class="profile-image-wrapper mb-3">
                                <img v-if="user.image" :src="user.image" class="profile-image" alt="User Image">
                                <div v-else class="profile-placeholder">
                                    {{ getUserInitials() }}
                                </div>
                            </div>

                            <h3 class="profile-name">{{ user.name || 'Usuario Perlux' }}</h3>
                            <p class="profile-email">{{ user.email || 'cargando...' }}</p>

                            <div class="profile-role mt-2">
                                <span class="badge role-badge">Administrador</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-6">
                    <div class="card info-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="info-title mb-4">
                                <i class="fas fa-info-circle me-2"></i>Estado del Sistema
                            </h4>

                            <div class="info-item mb-3">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Fecha actual</h5>
                                    <p>{{ currentDate }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Hora del servidor</h5>
                                    <p>{{ currentTime }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: 'WelcomeDashboard',
    data() {
        return {
            cargando: true,
            user: {
                name: '',
                email: '',
                image: null,
            },
            currentDate: '',
            currentTime: '',
            timeInterval: null,
        };
    },
    async mounted() {
        try {
            await this.getUserInfo();
            this.updateDateTime();
            this.timeInterval = setInterval(this.updateDateTime, 1000);
            
            setTimeout(() => {
                this.cargando = false;
            }, 800);
        } catch (error) {
            console.error(error);
            this.cargando = false;
        }
    },
    beforeUnmount() {
        if (this.timeInterval) clearInterval(this.timeInterval);
    },
    methods: {
        async getUserInfo() {
            try {
                // Asegúrate que esta ruta exista en tu backend
                const response = await axios.get('/get_user_info'); 
                this.user = response.data;
            } catch (error) {
                // Fallback silencioso o datos de prueba
                console.warn('No se pudo cargar usuario, usando datos demo o vacíos');
            }
        },
        updateDateTime() {
            const now = new Date();
            this.currentDate = now.toLocaleDateString('es-ES', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            });
            // Capitalizar la primera letra de la fecha
            this.currentDate = this.currentDate.charAt(0).toUpperCase() + this.currentDate.slice(1);
            
            this.currentTime = now.toLocaleTimeString('es-ES', {
                hour: '2-digit', minute: '2-digit', second: '2-digit',
            });
        },
        getUserInitials() {
            if (!this.user.name) return 'SK';
            const names = this.user.name.split(' ');
            return names.length >= 2 
                ? `${names[0].charAt(0)}${names[1].charAt(0)}`.toUpperCase() 
                : names[0].charAt(0).toUpperCase();
        }
    },
};
</script>

<style scoped>
/* =========================================
   VARIABLES & COLOR PALETTE (Skinly)
   ========================================= */
   :root {
    --skinly-blue: #007EAB;
    --skinly-dark: #4A4A4A;
    --skinly-light-bg: #f4f6f8;
    --skinly-white: #ffffff;
}

/* =========================================
   GENERAL LAYOUT
   ========================================= */
.welcome-container {
    min-height: 85vh; /* Ajuste para que no fuerce scroll innecesario */
    background-color: #f4f6f8;
    padding-bottom: 2rem;
    font-family: 'Public Sans', sans-serif; /* Asegurando la fuente */
}

/* Header estilizado */
.welcome-header {
    background: linear-gradient(135deg, #007EAB 0%, #005a7d 100%); /* Azul Skinly Degradado */
    color: white;
    padding: 3rem 0 5rem 0; /* Padding inferior extra para el efecto overlap */
    margin-bottom: -3rem; /* Efecto negativo para que las cards suban */
    box-shadow: 0 4px 20px rgba(0, 126, 171, 0.15);
}

.welcome-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 300;
}

/* Contenedor que sube sobre el header */
.content-wrapper {
    position: relative;
    z-index: 10;
}

/* =========================================
   CARDS DESIGN
   ========================================= */
.card {
    border-radius: 12px;
    background-color: #ffffff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important; /* Sombra muy suave */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none; /* Quitamos bordes default */
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 126, 171, 0.1) !important; /* Sombra azulada al hover */
}

/* Cards Headers/Borders */
.profile-card, .info-card {
    border-top: 4px solid #007EAB !important; /* Borde superior Azul Skinly */
}

/* =========================================
   PROFILE ELEMENTS
   ========================================= */
.profile-image-wrapper {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #fff; /* Borde blanco para separar del fondo */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    margin: 0 auto;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-placeholder {
    width: 100%;
    height: 100%;
    background-color: #e0f2f7; /* Azul muy claro */
    color: #007EAB;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 700;
}

.profile-name {
    font-weight: 700;
    font-size: 1.4rem;
    color: #4A4A4A; /* Gris Oscuro Skinly */
    margin-bottom: 0.2rem;
}

.profile-email {
    color: #888;
    font-size: 0.95rem;
    margin-bottom: 1rem;
}

.role-badge {
    background-color: #4A4A4A; /* Gris Oscuro */
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* =========================================
   INFO / STATS ELEMENTS
   ========================================= */
.info-title {
    color: #4A4A4A;
    font-weight: 700;
    font-size: 1.2rem;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 1rem;
}

.info-title i {
    color: #007EAB;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background-color: #ffffff;
    border-radius: 12px;
    border: 1px solid #f4f4f4; /* Borde casi invisible */
    transition: all 0.3s;
}

.info-item:hover {
    background-color: #fbfbfb;
    border-color: #e0e0e0;
}

.info-icon {
    width: 48px;
    height: 48px;
    background-color: #e0f2f7; /* Fondo azul claro Skinly */
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.2rem;
    color: #007EAB; /* Icono Azul Skinly */
    font-size: 1.4rem;
}

.info-content h5 {
    margin: 0;
    color: #4A4A4A;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.8;
}

.info-content p {
    margin: 0.2rem 0 0;
    color: #007EAB; /* Datos en azul para resaltar */
    font-size: 1.1rem;
    font-weight: 600;
}

/* =========================================
   PRELOADER
   ========================================= */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco semitransparente más limpio */
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    position: relative;
    animation: rotate 1s linear infinite;
}

.loader::before,
.loader::after {
    content: '';
    box-sizing: border-box;
    position: absolute;
    inset: 0px;
    border-radius: 50%;
    border: 4px solid transparent; /* Transparente base */
    animation: prixClipFix 2s linear infinite;
}

.loader::before {
    border-color: #4A4A4A; /* Gris */
}

.loader::after {
    border-color: #007EAB; /* Azul Skinly */
    animation-delay: -1s; /* Desfase para efecto doble color */
    transform: rotate3d(90, 90, 0, 180deg);
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes prixClipFix {
    0% { clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0); }
    50% { clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0); }
    75%, 100% { clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%); }
}
</style>