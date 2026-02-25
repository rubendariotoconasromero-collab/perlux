<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="content container-fluid my-5 skinly-font">

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="page-title fw-bold text-dark">Gestión de Tallas</h1>
                <p class="text-muted mb-0">Administra el catálogo de tallas disponibles.</p>
            </div>
        </div>

        <div v-if="vista === 'listado'" class="row">
            <div class="col-12">

                <div class="control-panel d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Buscar talla..."
                            v-model="search" @input="getSizes">
                    </div>
                    <button class="btn btn-primary-skinly px-4 py-2" @click="showCreateForm">
                        <i class="fas fa-plus me-2"></i> Nueva Talla
                    </button>
                </div>

                <div class="card card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 skinly-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10%;">#</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nombre de Talla</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 20%;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(size, index) in sizes" :key="size.SizeID" class="align-middle">
                                        <td class="ps-4">
                                            <span class="text-secondary text-xs font-weight-bold">{{ index + 1 }}</span>
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="icon-shape icon-sm me-3 bg-gradient-skinly shadow text-center rounded-circle">
                                                    <i class="fas fa-ruler-vertical text-white opacity-10"></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ size.SizeName }}</h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action text-secondary"
                                                    @click.prevent="viewSize(size)" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn-action text-primary mx-3"
                                                    @click.prevent="editSize(size)" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action text-danger"
                                                    @click.prevent="deleteSize(size.SizeID)" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="sizes.length === 0">
                                        <td colspan="3" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-ruler-combined fa-3x mb-3 text-muted opacity-50"></i>
                                                <h6 class="text-muted">No hay tallas registradas</h6>
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
                                        <a class="page-link" href="#" @click.prevent="prevPage">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                    <li v-for="p in totalPages" :key="p" class="page-item"
                                        :class="{ active: p === currentPage }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(p)">
                                            {{ p }}
                                        </a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage >= totalPages }">
                                        <a class="page-link" href="#" @click.prevent="nextPage">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'formulario'" class="row justify-content-center fade-in">
            <div class="col-lg-6 col-md-8"> <div class="card card-modern border-0 shadow-lg">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0">
                            {{ isEditing ? 'Editar Talla' : 'Crear Nueva Talla' }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="isEditing ? updateSize() : storeSize()">
                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Nombre de Talla</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0"
                                    v-model="size.SizeName" required placeholder="36/37, 37/38" autocomplete="off">
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-5">
                                <button type="button" class="btn btn-light px-4" @click="cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary-skinly px-4">Guardar Talla</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'ver_informacion'" class="row justify-content-center fade-in">
            <div class="col-md-5"> <div class="card card-modern border-0 shadow-lg text-center overflow-hidden">
                    <div class="h-100px w-100 bg-gradient-skinly"></div>
                    <div class="card-body position-relative pt-0">
                        <div class="size-avatar mx-auto shadow-lg d-flex align-items-center justify-content-center bg-white">
                            <span class="display-4 fw-bold text-primary">{{ sizeView.SizeName }}</span>
                        </div>

                        <h3 class="mt-4 fw-bold text-dark">Información de Talla</h3>
                        <p class="text-muted mb-4">ID de sistema: #{{ sizeView.SizeID }}</p>

                        <div class="mt-4">
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

export default {
    name: 'SizeCrud',
    data() {
        return {
            cargando: false,
            search: '',
            vista: 'listado',
            sizes: [],
            size: {
                SizeID: null,
                SizeName: '',
                // Eliminados Bust, Waist, Hips
            },
            sizeView: {},
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
        await this.getSizes();
        this.cargando = false;
    },
    methods: {
        async getSizes() {
            try {
                const response = await axios.get('/sizes', {
                    params: {
                        page: this.currentPage,
                        search: this.search,
                    },
                });
                const data = response.data;
                this.sizes = data.data;
                this.from = data.from;
                this.to = data.to;
                this.total = data.total;
                this.currentPage = data.current_page;
                this.totalPages = data.last_page;
            } catch (error) {
                console.error('Error al obtener tallas:', error);
                this.mostrarNotificacion('Error', 'No se pudieron cargar las tallas', 'error');
            }
        },
        showCreateForm() {
            this.vista = 'formulario';
            this.isEditing = false;
            this.resetForm();
        },
        async storeSize() {
            this.cargando = true;
            try {
                await axios.post('/sizes', this.size);
                await this.getSizes();
                this.mostrarNotificacion('Éxito', 'Talla registrada exitosamente', 'success');
                this.cancel();
            } catch (error) {
                this.mostrarNotificacion('Error', error.response?.data.message || 'Error al registrar', 'error');
            } finally {
                this.cargando = false;
            }
        },
        editSize(size) {
            this.resetForm();
            this.isEditing = true;
            this.vista = 'formulario';
            this.size = { ...size };
        },
        async updateSize() {
            this.cargando = true;
            try {
                await axios.post(`/sizes/${this.size.SizeID}`, this.size);
                await this.getSizes();
                this.mostrarNotificacion('Éxito', 'Talla actualizada exitosamente', 'success');
                this.cancel();
            } catch (error) {
                this.mostrarNotificacion('Error', error.response?.data.message || 'Error al actualizar', 'error');
            } finally {
                this.cargando = false;
            }
        },
        async deleteSize(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
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
                        await axios.delete(`/sizes/${id}`);
                        await this.getSizes();
                        this.mostrarNotificacion('Eliminado', 'La talla ha sido eliminada.', 'success');
                    } catch (error) {
                        this.mostrarNotificacion('Error', 'Error al eliminar', 'error');
                    } finally {
                        this.cargando = false;
                    }
                }
            })
        },
        viewSize(size) {
            this.vista = 'ver_informacion';
            this.sizeView = { ...size };
        },
        closeView() {
            this.vista = 'listado';
            this.sizeView = {};
        },
        cancel() {
            this.vista = 'listado';
            this.resetForm();
        },
        resetForm() {
            this.size = { SizeID: null, SizeName: '' };
        },
        mostrarNotificacion(titulo, texto, icono) {
            Swal.fire({
                title: titulo,
                text: texto,
                icon: icono,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        },
        prevPage() { if (this.currentPage > 1) { this.currentPage--; this.getSizes(); } },
        nextPage() { if (this.currentPage < this.totalPages) { this.currentPage++; this.getSizes(); } },
        goToPage(page) { if (page >= 1 && page <= this.totalPages) { this.currentPage = page; this.getSizes(); } },
    },
};
</script>

<style scoped>
/* =========================================
   ESTILOS SKINLY (MODERNOS & PREMIUM)
   ========================================= */
.skinly-font {
    font-family: 'Public Sans', sans-serif;
    color: #4A4A4A;
}

.text-primary {
    color: #007EAB !important;
}

.bg-gradient-skinly {
    background: linear-gradient(135deg, #007EAB 0%, #005a7d 100%);
}

.card-modern {
    border-radius: 16px;
    background: #ffffff;
}

.page-title {
    font-size: 1.5rem;
    letter-spacing: -0.5px;
}

/* =========================================
   BUSCADOR Y BOTONES
   ========================================= */
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

.btn-primary-skinly {
    background-color: #007EAB;
    border-color: #007EAB;
    color: white;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(0, 126, 171, 0.2);
}

.btn-primary-skinly:hover {
    background-color: #00658a;
    box-shadow: 0 6px 12px rgba(0, 126, 171, 0.3);
}

/* =========================================
   TABLA
   ========================================= */
.skinly-table thead th {
    font-size: 0.75rem;
    letter-spacing: 1px;
    border-bottom: 1px solid #eee;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.skinly-table tbody tr {
    border-left: 3px solid transparent;
}

.skinly-table tbody tr:hover {
    background-color: #fcfcfc;
    border-left: 3px solid #007EAB;
}

.icon-shape {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-action {
    font-size: 1.1rem;
}

/* =========================================
   PAGINACIÓN
   ========================================= */
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
}

.pagination-modern .page-item .page-link:hover {
    background-color: #f0f0f0;
    color: #007EAB;
}

.pagination-modern .page-item.active .page-link {
    background-color: #007EAB;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 126, 171, 0.4);
}

.pagination-modern .page-item.disabled .page-link {
    color: #d1d1d1;
    cursor: not-allowed;
}

/* =========================================
   DETALLES & PRELOADER
   ========================================= */
.h-100px {
    height: 100px;
}

.size-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid #fff;
    margin-top: -40px;
}

.fade-in {
    animation: fadeIn 0.4s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

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

.loader::before { border-color: #4A4A4A; }
.loader::after {
    border-color: #007EAB;
    animation-delay: -1s;
    transform: rotate3d(90, 90, 0, 180deg);
}

@keyframes rotate { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
@keyframes prixClipFix {
    0% { clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0); }
    50% { clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0); }
    75%, 100% { clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%); }
}
</style>