<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="content container-fluid my-5 skinly-font">

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="page-title fw-bold text-dark">Gestión de Usuarios</h1>
                <p class="text-muted mb-0">Administra los accesos, roles y perfiles de los administradores.</p>
            </div>
        </div>

        <div v-if="vista === 'listado'" class="row">
            <div class="col-12">

                <div class="control-panel d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Buscar por nombre, email..."
                            v-model="search" @input="getUsers">
                    </div>
                    <button class="btn btn-primary-skinly px-4 py-2" @click="showCreateForm">
                        <i class="fas fa-user-plus me-2"></i> Nuevo Usuario
                    </button>
                </div>

                <div class="card card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 skinly-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th
                                            class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            #</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Usuario</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Contacto</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Documento</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Rol</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Estado</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users" :key="user.id" class="align-middle">
                                        <td class="ps-4">
                                            <span class="text-secondary text-xs font-weight-bold">{{ index + 1 }}</span>
                                        </td>

                                        <td>
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div class="avatar-circle me-3 bg-gradient-skinly text-white shadow-sm">
                                                    {{ getInitials(user.name, user.last_name) }}
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ user.name }}
                                                        {{ user.last_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ user.email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                <i class="fas fa-phone-alt me-1 text-xs"></i> {{ user.phone || 'N/A' }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark text-xs font-weight-bold">{{ user.dni || '-'
                                                    }}</span>
                                                <span class="text-xs text-muted">{{ user.document_type || 'DNI'
                                                    }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ user.role?.nombre || 'Sin Rol' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge"
                                                :class="user.estado === 'activo' ? 'bg-info-light text-info' : 'bg-danger-light text-danger'">
                                                <i class="fas fa-circle text-xxs me-1"></i> {{ user.estado }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action text-secondary"
                                                    @click.prevent="viewUser(user)" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn-action text-primary mx-3"
                                                    @click.prevent="editUser(user)" title="Editar">
                                                    <i class="fas fa-user-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action text-danger"
                                                    @click.prevent="deleteUser(user.id)" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="users.length === 0">
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-users-slash fa-3x mb-3 text-muted opacity-50"></i>
                                                <h6 class="text-muted">No hay usuarios registrados</h6>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 py-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="pagination-info text-muted small">
                                Mostrando <span class="fw-bold text-dark">{{ from }}</span> - <span
                                    class="fw-bold text-dark">{{ to }}</span> de <span class="fw-bold text-dark">{{
                                    total }}</span> resultados
                            </div>
                            <nav aria-label="Navegación">
                                <ul class="pagination pagination-modern mb-0">
                                    <li class="page-item" :class="{ disabled: currentPage <= 1 }">
                                        <a class="page-link" href="#" @click.prevent="prevPage"><i
                                                class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li v-for="p in totalPages" :key="p" class="page-item"
                                        :class="{ active: p === currentPage }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(p)">{{ p }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage >= totalPages }">
                                        <a class="page-link" href="#" @click.prevent="nextPage"><i
                                                class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'formulario'" class="row justify-content-center fade-in">
            <div class="col-lg-8 col-md-10">
                <div class="card card-modern border-0 shadow-lg">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">
                            {{ isEditing ? 'Editar Usuario' : 'Registrar Nuevo Usuario' }}
                        </h5>
                        <button class="btn btn-close" @click="cancel"></button>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="isEditing ? updateUser() : storeUser()">

                            <h6 class="text-uppercase text-muted text-xs font-weight-bolder mb-3 border-bottom pb-2">
                                Datos Personales</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Nombre</label>
                                    <input type="text" class="form-control bg-light border-0" v-model="user.name"
                                        required placeholder="Nombres">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Apellido</label>
                                    <input type="text" class="form-control bg-light border-0" v-model="user.last_name"
                                        placeholder="Apellidos">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Tipo Documento</label>
                                    <select class="form-select bg-light border-0" v-model="user.document_type">
                                        <option value="">Seleccionar</option>
                                        <option value="DNI">DNI</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                        <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Número Documento</label>
                                    <input type="text" class="form-control bg-light border-0" v-model="user.dni"
                                        maxlength="15" placeholder="Número">
                                </div>
                            </div>

                            <h6
                                class="text-uppercase text-muted text-xs font-weight-bolder mb-3 border-bottom pb-2 mt-4">
                                Cuenta y Acceso</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Email</label>
                                    <input type="email" class="form-control bg-light border-0" v-model="user.email"
                                        required placeholder="correo@ejemplo.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Teléfono</label>
                                    <input type="text" class="form-control bg-light border-0" v-model="user.phone"
                                        placeholder="+51 ...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Rol</label>
                                    <select class="form-select bg-light border-0" v-model="user.role_id" required>
                                        <option value="">Seleccionar Rol</option>
                                        <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.nombre }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Estado</label>
                                    <select class="form-select bg-light border-0" v-model="user.estado">
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <div v-if="!isEditing" class="row g-3 mb-2">
                                <div class="col-12">
                                    <div class="alert alert-info text-xs border-0 bg-info-light text-info"><i
                                            class="fas fa-lock me-1"></i> Establecer contraseña inicial</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Contraseña</label>
                                    <input type="password" class="form-control bg-light border-0"
                                        v-model="user.password" required minlength="6">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Confirmar Contraseña</label>
                                    <input type="password" class="form-control bg-light border-0"
                                        v-model="user.password_confirmation" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-5 border-top pt-4">
                                <button type="button" class="btn btn-light px-4" @click="cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary-skinly px-4">
                                    {{ isEditing ? 'Guardar Cambios' : 'Registrar Usuario' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'ver_informacion'" class="row justify-content-center fade-in">
            <div class="col-md-6">
                <div class="card card-modern border-0 shadow-lg overflow-hidden">
                    <div class="h-100px w-100 bg-gradient-skinly"></div>
                    <div class="card-body position-relative pt-0 text-center">

                        <div
                            class="user-avatar-large mx-auto shadow-lg d-flex align-items-center justify-content-center bg-white text-primary border border-4 border-white">
                            <img v-if="userView.photo_url" :src="userView.photo_url" class="w-100 h-100 rounded-circle"
                                style="object-fit: cover;">
                            <span v-else class="display-4 fw-bold">{{ getInitials(userView.name, userView.last_name)
                                }}</span>
                        </div>

                        <h3 class="mt-4 fw-bold text-dark">{{ userView.name }} {{ userView.last_name }}</h3>
                        <p class="text-muted">{{ userView.email }}</p>

                        <span class="badge px-3 py-2 mb-4"
                            :class="userView.estado === 'activo' ? 'bg-info-light text-info' : 'bg-danger-light text-danger'">
                            {{ userView.estado === 'activo' ? 'Cuenta Activa' : 'Cuenta Inactiva' }}
                        </span>

                        <div class="row mt-4 text-start px-4">
                            <div class="col-6 mb-3">
                                <small class="text-uppercase text-muted fw-bold text-xs d-block">Rol</small>
                                <span class="fw-bold text-dark">{{ userView.role?.nombre || 'Sin Rol' }}</span>
                            </div>
                            <div class="col-6 mb-3">
                                <small class="text-uppercase text-muted fw-bold text-xs d-block">Teléfono</small>
                                <span class="fw-bold text-dark">{{ userView.phone || '-' }}</span>
                            </div>
                            <div class="col-6 mb-3">
                                <small class="text-uppercase text-muted fw-bold text-xs d-block">Documento</small>
                                <span class="fw-bold text-dark">{{ userView.document_type }}: {{ userView.dni || '-'
                                    }}</span>
                            </div>
                            <div class="col-6 mb-3">
                                <small class="text-uppercase text-muted fw-bold text-xs d-block">Registro</small>
                                <span class="fw-bold text-dark">{{ formatDate(userView.created_at) }}</span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button class="btn btn-outline-dark px-4 rounded-pill" @click="closeView">Volver al
                                listado</button>
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
import moment from 'moment';

export default {
    name: 'UserCrud',
    data() {
        return {
            cargando: false,
            search: '',
            vista: 'listado',
            users: [],
            user: {
                id: null,
                name: '',
                last_name: '',
                email: '',
                phone: '',
                dni: '',
                document_type: '',
                role_id: '',
                estado: 'activo',
                password: '',
                password_confirmation: ''
            },
            userView: {},
            roles: [],
            isEditing: false,
            currentPage: 1,
            totalPages: 0,
            from: 0,
            to: 0,
            total: 0,
        };
    },
    async mounted() {
        this.cargando = true;
        await Promise.all([this.getUsers(), this.getRoles()]);
        this.cargando = false;
    },
    computed: {
        formatDate() {
            return (date) => date ? moment(date).format("DD/MM/YYYY") : '-';
        },
    },
    methods: {
        getInitials(name, lastName) {
            let initials = name ? name.charAt(0) : '';
            if (lastName) initials += lastName.charAt(0);
            return initials.toUpperCase() || 'U';
        },
        async getUsers() {
            try {
                const response = await axios.get('/users_admin_get', {
                    params: {
                        page: this.currentPage,
                        search: this.search,
                    },
                });
                const data = response.data;
                this.users = data.data;
                this.from = data.from;
                this.to = data.to;
                this.total = data.total;
                this.currentPage = data.current_page;
                this.totalPages = data.last_page;
            } catch (error) {
                console.error('Error al obtener usuarios:', error);
                this.mostrarNotificacion('Error', 'No se pudieron cargar los usuarios', 'error');
            }
        },
        async getRoles() {
            try {
                const response = await axios.get('/roles');
                this.roles = response.data.data;
            } catch (error) {
                console.error('Error al obtener roles:', error);
            }
        },
        showCreateForm() {
            this.vista = 'formulario';
            this.isEditing = false;
            this.resetForm();
        },
        async storeUser() {
            this.cargando = true;
            try {
                const response = await axios.post('/users_admin', this.user);
                await this.getUsers();
                this.mostrarNotificacion('Éxito', 'Usuario registrado exitosamente', 'success');
                this.cancel();
            } catch (error) {
                const errorMessage = error.response?.data?.message || error.response?.data?.errors || 'Error al registrar el usuario';
                this.mostrarNotificacion('Error', errorMessage, 'error');
            } finally {
                this.cargando = false;
            }
        },
        editUser(user) {
            this.resetForm();
            this.isEditing = true;
            this.vista = 'formulario';
            this.user = {
                ...user,
                password: '',
                password_confirmation: ''
            };
        },
        async updateUser() {
            this.cargando = true;
            try {
                const response = await axios.post(`/users_admin/${this.user.id}`, this.user);
                await this.getUsers();
                this.mostrarNotificacion('Éxito', 'Usuario actualizado exitosamente', 'success');
                this.cancel();
            } catch (error) {
                const errorMessage = error.response?.data?.message || error.response?.data?.errors || 'Error al actualizar el usuario';
                this.mostrarNotificacion('Error', errorMessage, 'error');
            } finally {
                this.cargando = false;
            }
        },
        async deleteUser(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007EAB',
                cancelButtonColor: '#4A4A4A',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.cargando = true;
                    try {
                        await axios.delete(`/users_admin/${id}`);
                        await this.getUsers();
                        this.mostrarNotificacion('Éxito', 'Usuario eliminado exitosamente', 'success');
                    } catch (error) {
                        this.mostrarNotificacion(
                            'Error',
                            error.response?.data.message || 'Error al eliminar el usuario',
                            'error'
                        );
                    } finally {
                        this.cargando = false;
                    }
                }
            });
        },
        viewUser(user) {
            this.vista = 'ver_informacion';
            this.userView = { ...user };
        },
        closeView() {
            this.vista = 'listado';
            this.userView = {};
        },
        cancel() {
            this.vista = 'listado';
            this.resetForm();
        },
        resetForm() {
            this.user = {
                id: null,
                name: '',
                last_name: '',
                email: '',
                phone: '',
                dni: '',
                document_type: '',
                role_id: '',
                estado: 'activo',
                password: '',
                password_confirmation: ''
            };
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
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.getUsers();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.getUsers();
            }
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.getUsers();
            }
        },
    },
};
</script>

<style scoped>
/* =========================================
   ESTILOS SKINLY PREMIUM
   ========================================= */
.skinly-font {
    font-family: 'Public Sans', sans-serif;
    color: #4A4A4A;
}

.text-primary {
    color: #007EAB !important;
}

.bg-primary {
    background-color: #007EAB !important;
}

.bg-gradient-skinly {
    background: linear-gradient(135deg, #007EAB 0%, #005a7d 100%);
}

/* Cards & Containers */
.card-modern {
    border-radius: 16px;
    background: #ffffff;
}

.page-title {
    font-size: 1.5rem;
    letter-spacing: -0.5px;
}

/* Buttons */
.btn-primary-skinly {
    background-color: #007EAB;
    border-color: #007EAB;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(0, 126, 171, 0.2);
    transition: all 0.3s ease;
}

.btn-primary-skinly:hover {
    background-color: #00658a;
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(0, 126, 171, 0.3);
}

.btn-action {
    font-size: 1.1rem;
    transition: transform 0.2s;
}

.btn-action:hover {
    transform: scale(1.1);
}

/* Table */
.skinly-table thead th {
    font-size: 0.75rem;
    letter-spacing: 1px;
    border-bottom: 1px solid #eee;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.skinly-table tbody tr {
    transition: all 0.2s;
    border-left: 3px solid transparent;
}

.skinly-table tbody tr:hover {
    background-color: #fcfcfc;
    border-left: 3px solid #007EAB;
}

/* Avatar Styles */
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.9rem;
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-top: -50px;
}

/* Badges */
.bg-success-light {
    background-color: #e8f5e9;
}

.bg-danger-light {
    background-color: #ffebee;
}

.bg-info-light {
    background-color: #e3f2fd;
}

.text-xxs {
    font-size: 0.6rem;
    vertical-align: middle;
}

/* Inputs */
.search-wrapper {
    position: relative;
    width: 100%;
    max-width: 300px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0a0a0;
    pointer-events: none;
}

.search-input {
    padding-left: 40px;
    border-radius: 50px;
    border: 1px solid #e0e0e0;
    background-color: #f9f9f9;
}

.search-input:focus {
    background-color: #fff;
    border-color: #007EAB;
    box-shadow: 0 0 0 4px rgba(0, 126, 171, 0.1);
}

/* Pagination */
.pagination-modern {
    display: flex;
    gap: 5px;
}

.pagination-modern .page-item .page-link {
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4A4A4A;
    font-weight: 600;
    font-size: 0.9rem;
    background-color: transparent;
    transition: all 0.3s;
}

.pagination-modern .page-item .page-link:hover {
    background-color: #f0f0f0;
    color: #007EAB;
    transform: translateY(-2px);
}

.pagination-modern .page-item.active .page-link {
    background-color: #007EAB;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 126, 171, 0.4);
    transform: scale(1.1);
}

.pagination-modern .page-item.disabled .page-link {
    color: #d1d1d1;
    cursor: not-allowed;
}

/* Extra */
.h-100px {
    height: 100px;
}

.fade-in {
    animation: fadeIn 0.4s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Preloader */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    z-index: 1050;
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
    border: 4px solid transparent;
    animation: prixClipFix 2s linear infinite;
}

.loader::before {
    border-color: #4A4A4A;
}

.loader::after {
    border-color: #007EAB;
    animation-delay: -1s;
    transform: rotate3d(90, 90, 0, 180deg);
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

@keyframes prixClipFix {
    0% {
        clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0);
    }

    50% {
        clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0);
    }

    75%,
    100% {
        clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%);
    }
}
</style>