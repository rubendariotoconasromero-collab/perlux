<template>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1 class="welcome-title">Crea tu cuenta</h1>
                <p class="welcome-subtitle">Completa tus datos para registrarte</p>
            </div>

            <form @submit.prevent="signup" class="register-form">

                <div class="row g-3">
                    <div class="col-md-6 form-group">
                        <label for="name" class="form-label">Nombre*</label>
                        <input id="name" v-model="form.name" type="text" 
                            class="form-input" :class="{ 'is-invalid': errors.name }"
                            placeholder="Tu nombre" required @input="clearError('name')" />
                        <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="lastname" class="form-label">Apellidos*</label>
                        <input id="lastname" v-model="form.lastname" type="text" 
                            class="form-input" :class="{ 'is-invalid': errors.last_name }"
                            placeholder="Tus apellidos" required @input="clearError('last_name')" />
                        <span v-if="errors.last_name" class="error-message">{{ errors.last_name }}</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="email" class="form-label">Correo*</label>
                        <input id="email" v-model="form.email" type="email" 
                            class="form-input" :class="{ 'is-invalid': errors.email }"
                            placeholder="tucorreo@email.com" required @input="clearError('email')" />
                        <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="phone" class="form-label">Celular*</label>
                        <div class="input-group document-group" :class="{ 'is-invalid-border': errors.phone }">
                            <span class="input-group-text border-0 bg-transparent text-muted fw-bold pe-1">+51</span>
                            <div class="vr my-2"></div>
                            <input id="phone" v-model="form.phone" type="tel" maxlength="9"
                                class="form-control border-0 bg-transparent ps-2" 
                                placeholder="999999999" required @input="clearError('phone')" />
                        </div>
                        <span v-if="errors.phone" class="error-message">{{ errors.phone }}</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="password" class="form-label">Contraseña*</label>
                        <div class="password-wrapper">
                            <input id="password" v-model="form.password" 
                                :type="showPassword ? 'text' : 'password'"
                                class="form-input" :class="{ 'is-invalid': errors.password }"
                                placeholder="********" required @input="clearError('password')" />
                            
                            <button type="button" class="toggle-password" @click="showPassword = !showPassword">
                                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            </button>
                        </div>
                        <span v-if="errors.password" class="error-message">{{ errors.password }}</span>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="confirmPassword" class="form-label">Confirmar*</label>
                        <div class="password-wrapper">
                            <input id="confirmPassword" v-model="form.confirmPassword" 
                                :type="showConfirmPassword ? 'text' : 'password'"
                                class="form-input" :class="{ 'is-invalid': errors.confirmPassword }"
                                placeholder="********" required @input="clearError('confirmPassword')" />
                            
                            <button type="button" class="toggle-password" @click="showConfirmPassword = !showConfirmPassword">
                                <svg v-if="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            </button>
                        </div>
                        <span v-if="errors.confirmPassword" class="error-message">{{ errors.confirmPassword }}</span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Documento de Identidad*</label>
                    <div class="input-group document-group" :class="{ 'is-invalid-border': errors.dni }">
                        <select v-model="form.documentType" class="form-select border-0 bg-transparent"
                            style="max-width: 80px;" required>
                            <option value="DNI">DNI</option>
                            <option value="CE">CE</option>
                        </select>
                        <div class="vr my-2"></div>
                        <input v-model="form.dni" type="text" class="form-control border-0 bg-transparent"
                            placeholder="Número de documento" required @input="clearError('dni')" />
                    </div>
                    <span v-if="errors.dni" class="error-message">{{ errors.dni }}</span>
                </div>

                <div class="address-section mt-4">
                    <label class="form-label fw-bold mb-1">Dirección de Envío*</label>
                    <p class="form-description text-muted small mb-3">
                        Necesaria para calcular costos de envío.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-4 form-group">
                            <label class="form-label small">Departamento</label>
                            <select v-model="form.department" @change="onDepartmentChange"
                                class="form-select form-input" required>
                                <option value="" disabled selected>Seleccionar</option>
                                <option v-for="dept in departmentsList" :key="dept" :value="dept">{{ dept }}</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="form-label small">Provincia</label>
                            <select v-model="form.province" @change="onProvinceChange" class="form-select form-input" :disabled="!form.department"
                                required>
                                <option value="" disabled selected>Seleccionar</option>
                                <option v-for="prov in provincesList" :key="prov" :value="prov">{{ prov }}</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="form-label small">Distrito</label>
                            <input v-model="form.district" type="text" class="form-input"
                                placeholder="Escribe tu distrito" required />
                        </div>

                        <div class="col-md-8 form-group">
                            <label class="form-label small">Calle / Av / Jr</label>
                            <input v-model="form.street" type="text" class="form-input" placeholder="Nombre de la vía" required />
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="form-label small">Número</label>
                            <input v-model="form.number" type="text" class="form-input" placeholder="N°" required />
                        </div>

                        <div class="col-12 form-group">
                            <label class="form-label small">Referencia / Interior (Opcional)</label>
                            <input v-model="form.details" type="text" class="form-input"
                                placeholder="Ej: Frente al parque, Int 201" />
                        </div>
                    </div>
                </div>

                <div class="actions mt-4 text-center">
                    <button type="submit" class="register-button w-100" :disabled="loading">
                        <span v-if="!loading">Crear Cuenta</span>
                        <span v-else>Procesando...</span>
                    </button>

                    <div class="divider my-3">
                        <span class="divider-text">o</span>
                    </div>

                    <a href="/auth/google" class="google-button w-100">
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
                        Registrarse con Google
                    </a>
                </div>

                <p class="login-text text-center mt-3">
                    ¿Ya tienes cuenta? <a href="/user" class="login-link">Inicia sesión</a>
                </p>

            </form>
        </div>
    </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios';
import Swal from 'sweetalert2';

// DATA REAL: DEPARTAMENTOS Y PROVINCIAS DE PERÚ
const ubigeoPeru = [
    { department: "Amazonas", provinces: ["Chachapoyas", "Bagua", "Bongará", "Condorcanqui", "Luya", "Rodríguez de Mendoza", "Utcubamba"] },
    { department: "Áncash", provinces: ["Huaraz", "Aija", "Antonio Raymondi", "Asunción", "Bolognesi", "Carhuaz", "Carlos Fermín Fitzcarrald", "Casma", "Corongo", "Huari", "Huarmey", "Huaylas", "Mariscal Luzuriaga", "Ocros", "Pallasca", "Pomabamba", "Recuay", "Santa", "Sihuas", "Yungay"] },
    { department: "Apurímac", provinces: ["Abancay", "Andahuaylas", "Antabamba", "Aymaraes", "Cotabambas", "Chincheros", "Grau"] },
    { department: "Arequipa", provinces: ["Arequipa", "Camaná", "Caravelí", "Castilla", "Caylloma", "Condesuyos", "Islay", "La Unión"] },
    { department: "Ayacucho", provinces: ["Huamanga", "Cangallo", "Huanca Sancos", "Huanta", "La Mar", "Lucanas", "Parinacochas", "Páucar del Sara Sara", "Sucre", "Víctor Fajardo", "Vilcas Huamán"] },
    { department: "Cajamarca", provinces: ["Cajamarca", "Cajabamba", "Celendín", "Chota", "Contumazá", "Cutervo", "Hualgayoc", "Jaén", "San Ignacio", "San Marcos", "San Miguel", "San Pablo", "Santa Cruz"] },
    { department: "Callao", provinces: ["Callao"] },
    { department: "Cusco", provinces: ["Cusco", "Acomayo", "Anta", "Calca", "Canas", "Canchis", "Chumbivilcas", "Espinar", "La Convención", "Paruro", "Paucartambo", "Quispicanchi", "Urubamba"] },
    { department: "Huancavelica", provinces: ["Huancavelica", "Acobamba", "Angaraes", "Castrovirreyna", "Churcampa", "Huaytará", "Tayacaja"] },
    { department: "Huánuco", provinces: ["Huánuco", "Ambo", "Dos de Mayo", "Huacaybamba", "Huamalíes", "Leoncio Prado", "Marañón", "Pachitea", "Puerto Inca", "Lauricocha", "Yarowilca"] },
    { department: "Ica", provinces: ["Ica", "Chincha", "Nazca", "Palpa", "Pisco"] },
    { department: "Junín", provinces: ["Huancayo", "Concepción", "Chanchamayo", "Jauja", "Junín", "Satipo", "Tarma", "Yauli", "Chupaca"] },
    { department: "La Libertad", provinces: ["Trujillo", "Ascope", "Bolívar", "Chepén", "Julcán", "Otuzco", "Pacasmayo", "Pataz", "Sánchez Carrión", "Santiago de Chuco", "Gran Chimú", "Virú"] },
    { department: "Lambayeque", provinces: ["Chiclayo", "Ferreñafe", "Lambayeque"] },
    { department: "Lima", provinces: ["Lima", "Barranca", "Cajatambo", "Canta", "Cañete", "Huaral", "Huarochirí", "Huaura", "Oyón", "Yauyos"] },
    { department: "Loreto", provinces: ["Maynas", "Alto Amazonas", "Loreto", "Mariscal Ramón Castilla", "Requena", "Ucayali", "Datem del Marañón", "Putumayo"] },
    { department: "Madre de Dios", provinces: ["Tambopata", "Manu", "Tahuamanu"] },
    { department: "Moquegua", provinces: ["Mariscal Nieto", "General Sánchez Cerro", "Ilo"] },
    { department: "Pasco", provinces: ["Pasco", "Daniel Alcides Carrión", "Oxapampa"] },
    { department: "Piura", provinces: ["Piura", "Ayabaca", "Huancabamba", "Morropón", "Paita", "Sullana", "Talara", "Sechura"] },
    { department: "Puno", provinces: ["Puno", "Azángaro", "Carabaya", "Chucuito", "El Collao", "Huancané", "Lampa", "Melgar", "Moho", "San Antonio de Putina", "San Román", "Sandia", "Yunguyo"] },
    { department: "San Martín", provinces: ["Moyobamba", "Bellavista", "El Dorado", "Huallaga", "Lamas", "Mariscal Cáceres", "Picota", "Rioja", "San Martín", "Tocache"] },
    { department: "Tacna", provinces: ["Tacna", "Candarave", "Jorge Basadre", "Tarata"] },
    { department: "Tumbes", provinces: ["Tumbes", "Contralmirante Villar", "Zarumilla"] },
    { department: "Ucayali", provinces: ["Coronel Portillo", "Atalaya", "Padre Abad", "Purús"] }
];

export default {
    name: 'PerluxRegister',
    emits: ['mensaje-login', 'login-success', 'login-error'],
    setup(props, { emit }) {
        const loading = ref(false);
        const showPassword = ref(false);
        const showConfirmPassword = ref(false);
        
        // Estado de errores
        const errors = reactive({});

        const form = reactive({
            email: '', phone: '', name: '', lastname: '',
            password: '', confirmPassword: '', documentType: 'DNI', dni:'',
            department: '', province: '', district: '', 
            street: '', number: '', details: ''
        });

        // Listas reactivas
        const departmentsList = ref([]);
        const provincesList = ref([]);

        onMounted(() => {
            departmentsList.value = ubigeoPeru.map(d => d.department);
        });

        const onDepartmentChange = () => {
            form.province = '';
            const selectedData = ubigeoPeru.find(d => d.department === form.department);
            if (selectedData) {
                provincesList.value = selectedData.provinces;
            } else {
                provincesList.value = [];
            }
        };

        const clearError = (field) => {
            if (errors[field]) {
                delete errors[field];
            }
        };

        const mostrarNotificacion = (titulo, texto, icono) => {
            Swal.fire({
                title: titulo, text: texto, icon: icono,
                toast: true, position: 'top-end', showConfirmButton: false, timer: 2000
            });
        }

        const signup = async () => {
            // Limpiar errores previos
            Object.keys(errors).forEach(key => delete errors[key]);

            if (form.password !== form.confirmPassword) {
                errors.confirmPassword = 'Las contraseñas no coinciden.';
                mostrarNotificacion('Error', 'Las contraseñas no coinciden', 'error');
                return;
            }

            let rawPhone = form.phone.replace(/\s+/g, '');
            let finalPhone = `+51${rawPhone}`;
            loading.value = true;
            try {
                const response = await axios.post('/register', {
                    email: form.email, phone: finalPhone, name: form.name, 
                    last_name: form.lastname, dni: form.dni, password: form.password,
                    document_type: form.documentType,
                    addresses: [{
                        department: form.department,
                        province: form.province,
                        district: form.district,
                        street: form.street,
                        number: form.number,
                        detail: form.details
                    }]
                });

                if (response.data.success) {
                    mostrarNotificacion('¡Éxito!', 'Cuenta creada correctamente', 'success');
                    emit('login-success', { resp: response.data.message, redirect_url: 'inicio' });
                } else {
                    mostrarNotificacion('Error', response.data.message || 'Error desconocido', 'error');
                    emit('login-error', { resp: response.data.message });
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errorData = error.response.data;
                    
                    // Asignar errores al objeto reactivo para mostrarlos en el UI
                    if (errorData.errors) {
                        for (const key in errorData.errors) {
                            errors[key] = errorData.errors[key][0]; // Toma el primer mensaje de error
                        }
                    }
                    
                    // Mostrar notificación general con el primer error encontrado
                    const firstError = errorData.message || 'Por favor revisa los campos.';
                    mostrarNotificacion('Error de validación', firstError, 'error');
                } else {
                    const errorMessage = error.response?.data?.message || 'Error al registrar el usuario';
                    mostrarNotificacion('Error', errorMessage, 'error');
                    emit('login-error', { resp: errorMessage });
                }
            } finally {
                loading.value = false;
            }
        }

        return { 
            form, 
            departmentsList, 
            provincesList, 
            onDepartmentChange, 
            signup, 
            loading,
            errors,
            clearError,
            showPassword,
            showConfirmPassword
        }
    }
}
</script>

<style scoped>
.register-container {
    margin-top: 0;
    padding-top: 20px;
    padding-bottom: 50px;
    display: flex;
    justify-content: center;
    background-color: #f8f9fa;
}

.register-card {
    background: white;
    border-radius: 16px;
    padding: 40px;
    width: 100%;
    max-width: 700px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.register-header {
    text-align: center;
    margin-bottom: 30px;
}

.welcome-title {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 5px;
}

.welcome-subtitle {
    font-size: 14px;
    color: #666;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

/* Estilos de Inputs */
.form-input,
.form-select {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
    background-color: #fff;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #000;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
}

/* Estilos de Validación */
.is-invalid {
    border-color: #dc3545 !important; /* Rojo bootstrap */
    background-image: none !important; /* Quitar ícono por defecto si molesta */
}

.is-invalid-border {
    border-color: #dc3545 !important;
}

.error-message {
    color: #dc3545;
    font-size: 0.75rem;
    margin-top: 4px;
    display: block;
    font-weight: 500;
}

/* Contenedor Contraseña (con ojo) */
.password-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-wrapper .form-input {
    padding-right: 40px; /* Espacio para el ojo */
}

.toggle-password {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    cursor: pointer;
    color: #666;
    padding: 0;
    display: flex;
    align-items: center;
}

.toggle-password:hover {
    color: #000;
}

/* Grupo input DNI */
.document-group {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 2px;
    background: #fff;
    display: flex;
    align-items: center;
    transition: border 0.2s;
}

.document-group:focus-within {
    border-color: #000;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
}

/* Botones */
.register-button {
    background: #000;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s;
    letter-spacing: 0.5px;
}

.register-button:hover:not(:disabled) {
    background: #333;
}

.register-button:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.google-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 10px;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    text-decoration: none;
    transition: all 0.2s;
}

.google-button:hover {
    background: #f8f9fa;
    border-color: #ccc;
}

.google-icon {
    width: 18px;
    height: 18px;
}

/* Divider */
.divider {
    position: relative;
    text-align: center;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e0e0e0;
}

.divider-text {
    background: white;
    padding: 0 10px;
    color: #999;
    font-size: 12px;
    position: relative;
}

/* Footer Login Link */
.login-link {
    color: #000;
    text-decoration: underline;
    font-weight: 600;
}

.login-text {
    font-size: 14px;
    color: #666;
}

/* Responsive */
@media (max-width: 576px) {
    .register-card {
        padding: 25px;
        border-radius: 0;
        box-shadow: none;
    }

    .register-container {
        padding: 0;
        background: white;
    }
}
</style>