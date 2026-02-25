<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="content container-fluid my-5 skinly-font">

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="page-title fw-bold text-dark">Gestión de Colores</h1>
                <p class="text-muted mb-0">Administra la paleta de colores de tus productos.</p>
            </div>
        </div>

        <div v-if="vista === 'listado'" class="row">
            <div class="col-12">

                <div class="control-panel d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Buscar color..."
                            v-model="search" @input="getColors">
                    </div>
                    <button class="btn btn-primary-skinly px-4 py-2" @click="showCreateForm">
                        <i class="fas fa-plus me-2"></i> Nuevo Color
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
                                            Nombre</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Código</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Vista Previa</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(color, index) in colors" :key="color.ColorID" class="align-middle">
                                        <td class="ps-4">
                                            <span class="text-secondary text-xs font-weight-bold">{{ index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{
                                                        color.ColorName }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-skinly-light text-dark font-monospace">
                                                {{ color.HexCode }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="color-dot shadow-sm" :style="{ backgroundColor: color.HexCode }"
                                                data-bs-toggle="tooltip" :title="color.HexCode">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action text-secondary"
                                                    @click.prevent="viewColor(color)" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn-action text-primary mx-3"
                                                    @click.prevent="editColor(color)" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action text-danger"
                                                    @click.prevent="deleteColor(color.ColorID)" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="colors.length === 0">
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-swatchbook fa-3x mb-3 text-muted opacity-50"></i>
                                                <h6 class="text-muted">No hay colores registrados</h6>
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

                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination pagination-modern mb-0">
                                    <li class="page-item" :class="{ disabled: currentPage <= 1 }">
                                        <a class="page-link" href="#" @click.prevent="prevPage" aria-label="Anterior">
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
                                        <a class="page-link" href="#" @click.prevent="nextPage" aria-label="Siguiente">
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
            <div class="col-lg-6 col-md-8">
                <div class="card card-modern border-0 shadow-lg">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0">{{ isEditing ? 'Editar Color' : 'Crear Nuevo Color' }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="isEditing ? updateColor() : storeColor()">
                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Nombre</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0"
                                    v-model="color.ColorName" required placeholder="Ej. Azul Océano">
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Selector</label>
                                <div class="d-flex align-items-center p-3 rounded bg-light">
                                    <input type="color" class="form-control form-control-color border-0 me-3"
                                        v-model="color.HexCode" title="Elige un color">
                                    <span class="fw-bold text-dark">{{ color.HexCode }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-5">
                                <button type="button" class="btn btn-light px-4" @click="cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary-skinly px-4">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'ver_informacion'" class="row justify-content-center fade-in">
            <div class="col-md-5">
                <div class="card card-modern border-0 shadow-lg text-center overflow-hidden">
                    <div class="h-100px w-100" :style="{ backgroundColor: colorView.HexCode }"></div>
                    <div class="card-body position-relative pt-0">
                        <div class="color-avatar mx-auto shadow-lg" :style="{ backgroundColor: colorView.HexCode }">
                        </div>
                        <h3 class="mt-4 fw-bold text-dark">{{ colorView.ColorName }}</h3>
                        <p class="text-muted">{{ colorView.HexCode }}</p>
                        <div class="mt-4">
                            <button class="btn btn-outline-dark px-4 rounded-pill" @click="closeView">Regresar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
// (TU LÓGICA DE SCRIPT SE MANTIENE EXACTAMENTE IGUAL)
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: 'ColorCrud',
    data() {
        return {
            cargando: false,
            search: '',
            vista: 'listado',
            colors: [],
            color: { ColorID: null, ColorName: '', HexCode: '#007EAB' },
            colorView: {},
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
        await this.getColors();
        this.cargando = false;
    },
    methods: {
        // --- OBTENER DATOS (READ) ---
        async getColors() {
            this.cargando = true;
            try {
                // Ajusta la URL '/colors' según tu ruta de API real (ej: '/api/colors')
                const response = await axios.get('/colors', {
                    params: {
                        page: this.currentPage,
                        search: this.search,
                    },
                });
                const data = response.data;

                // Asignar datos de paginación de Laravel
                this.colors = data.data;
                this.from = data.from;
                this.to = data.to;
                this.total = data.total;
                this.currentPage = data.current_page;
                this.totalPages = data.last_page;
            } catch (error) {
                console.error('Error al obtener colores:', error);
                this.mostrarNotificacion('Error', 'No se pudieron cargar los colores', 'error');
            } finally {
                this.cargando = false;
            }
        },

        // --- PREPARAR FORMULARIO PARA CREAR ---
        showCreateForm() {
            this.resetForm();
            this.isEditing = false;
            this.vista = 'formulario';
        },

        // --- CREAR REGISTRO (CREATE) ---
        async storeColor() {
            // Validaciones básicas front-end
            if (!this.color.ColorName || !this.color.HexCode) {
                this.mostrarNotificacion('Atención', 'Todos los campos son obligatorios', 'warning');
                return;
            }

            this.cargando = true;
            try {
                // Asegurar formato mayúsculas para Hex
                this.color.HexCode = this.color.HexCode.toUpperCase();
                
                await axios.post('/colors', this.color);
                
                this.mostrarNotificacion('Éxito', 'Color creado correctamente', 'success');
                this.cancel(); // Vuelve al listado y limpia
                await this.getColors(); // Recarga la lista
            } catch (error) {
                console.error(error);
                let msg = 'Error al crear el registro';
                if(error.response && error.response.data && error.response.data.message) {
                    msg = error.response.data.message;
                }
                this.mostrarNotificacion('Error', msg, 'error');
            } finally {
                this.cargando = false;
            }
        },

        // --- PREPARAR FORMULARIO PARA EDITAR ---
        editColor(colorItem) {
            // Copiar el objeto para no modificar la lista directamente hasta guardar
            this.color = { ...colorItem }; 
            this.isEditing = true;
            this.vista = 'formulario';
        },

        // --- ACTUALIZAR REGISTRO (UPDATE) ---
        async updateColor() {
             if (!this.color.ColorName || !this.color.HexCode) {
                this.mostrarNotificacion('Atención', 'Todos los campos son obligatorios', 'warning');
                return;
            }

            this.cargando = true;
            try {
                this.color.HexCode = this.color.HexCode.toUpperCase();
                
                // Usualmente PUT o PATCH para actualizar
                await axios.put(`/colors/${this.color.ColorID}`, this.color);
                
                this.mostrarNotificacion('Éxito', 'Color actualizado correctamente', 'success');
                this.cancel();
                await this.getColors();
            } catch (error) {
                console.error(error);
                let msg = 'Error al actualizar el registro';
                if(error.response && error.response.data && error.response.data.message) {
                    msg = error.response.data.message;
                }
                this.mostrarNotificacion('Error', msg, 'error');
            } finally {
                this.cargando = false;
            }
        },

        // --- ELIMINAR REGISTRO (DELETE) ---
        deleteColor(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6699', // Tu color primario
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.cargando = true;
                    try {
                        await axios.delete(`/colors/${id}`);
                        this.mostrarNotificacion('Eliminado', 'El color ha sido eliminado', 'success');
                        await this.getColors();
                    } catch (error) {
                        console.error(error);
                        this.mostrarNotificacion('Error', 'No se pudo eliminar el registro', 'error');
                    } finally {
                        this.cargando = false;
                    }
                }
            });
        },

        // --- VISTA DETALLE ---
        viewColor(colorItem) {
            this.colorView = { ...colorItem };
            this.vista = 'ver_informacion';
        },

        closeView() {
            this.vista = 'listado';
            this.colorView = {};
        },

        // --- UTILIDADES ---
        cancel() {
            this.vista = 'listado';
            this.resetForm();
        },

        resetForm() {
            this.color = {
                ColorID: null,
                ColorName: '',
                HexCode: '#000000',
            };
            this.isEditing = false;
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

        // --- PAGINACIÓN ---
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.getColors();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.getColors();
            }
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.getColors();
            }
        },
    },
};
</script>

<style scoped>
/* =========================================
   ESTILOS GENERALES
   ========================================= */
.skinly-font {
    font-family: 'Public Sans', sans-serif;
    color: #4A4A4A;
}

.card-modern {
    border-radius: 16px;
    /* Bordes más redondeados */
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
    /* Redondeado tipo cápsula */
    border: 1px solid #e0e0e0;
    background-color: #f9f9f9;
    /* transition: all 0.3s ease; */
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
    /* transition: all 0.3s ease; */
}

.btn-primary-skinly:hover {
    background-color: #00658a;
    transform: translateY(-1px);
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
    /* transition: all 0.2s ease; */
    border-left: 3px solid transparent;
}

.skinly-table tbody tr:hover {
    background-color: #fcfcfc;
    /* transform: translateX(2px); */
    border-left: 3px solid #007EAB;
}

.badge-skinly-light {
    background-color: #f0f7fa;
    color: #007EAB;
    border: 1px solid #dbebf1;
    border-radius: 6px;
    padding: 5px 10px;
}

.color-dot {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-action {
    font-size: 1.1rem;
    /* transition: color 0.2s; */
}

.btn-action:hover {
    transform: scale(1.1);
}

/* =========================================
   PAGINACIÓN (LA ESTRELLA DEL SHOW)
   ========================================= */
.pagination-modern {
    display: flex;
    gap: 5px;
    /* Espacio entre bolitas */
}

.pagination-modern .page-item .page-link {
    border: none;
    border-radius: 50%;
    /* Círculos perfectos */
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4A4A4A;
    font-weight: 600;
    font-size: 0.9rem;
    background-color: transparent;
    /* transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); */
}

.pagination-modern .page-item .page-link:hover {
    background-color: #f0f0f0;
    color: #007EAB;
    transform: translateY(-2px);
    /* Pequeño salto al hover */
}

.pagination-modern .page-item.active .page-link {
    background-color: #007EAB;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 126, 171, 0.4);
    /* Sombra difusa azul */
    transform: scale(1.1);
    /* Ligeramente más grande */
}

.pagination-modern .page-item.disabled .page-link {
    color: #d1d1d1;
    background-color: transparent;
    cursor: not-allowed;
    transform: none;
}

/* =========================================
   EXTRAS (Detalle vista)
   ========================================= */
.h-100px {
    height: 100px;
}

.color-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid #fff;
    margin-top: -40px;
    /* Efecto flotante */
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
</style>