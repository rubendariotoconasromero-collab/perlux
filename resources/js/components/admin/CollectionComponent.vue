<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="content container-fluid my-5 skinly-font">

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="page-title fw-bold text-dark">Gestión de Categorías</h1>
                <p class="text-muted mb-0">Organiza tus productos mediante categorías y colecciones.</p>
            </div>
        </div>

        <div v-if="vista === 'listado'" class="row">
            <div class="col-12">
                <div class="control-panel d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Buscar categoría..."
                            v-model="search" @input="getCollections">
                    </div>
                    <button class="btn btn-primary-skinly px-4 py-2" @click="showCreateForm">
                        <i class="fas fa-plus me-2"></i> Nueva Categoría
                    </button>
                </div>

                <div class="card card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 skinly-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4" style="width: 5%;">#</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(collection, index) in collections" :key="collection.CollectionID">
                                        <td class="ps-4 fw-bold text-secondary">{{ index + 1 }}</td>
                                        <td>
                                            <div class="avatar avatar-md rounded shadow-sm border overflow-hidden">
                                                <img v-if="collection.Image" :src="'/' + collection.Image"
                                                    class="w-100 h-100 object-fit-cover">
                                                <div v-else
                                                    class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm font-weight-bold text-dark">{{
                                                collection.CollectionName }}</h6>
                                        </td>
                                        <td><span class="badge bg-light text-dark border text-uppercase">{{
                                                collection.Tipo || 'General' }}</span></td>
                                        <td><span class="text-secondary text-xs">{{ collection.Description || '-'
                                                }}</span></td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action text-secondary"
                                                    @click.prevent="viewCollection(collection)"><i
                                                        class="fas fa-eye"></i></a>
                                                <a href="#" class="btn-action text-primary mx-3"
                                                    @click.prevent="editCollection(collection)"><i
                                                        class="fas fa-edit"></i></a>
                                                <a href="#" class="btn-action text-danger"
                                                    @click.prevent="deleteCollection(collection.CollectionID)"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 py-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="pagination-info text-muted small">Mostrando {{ from }} - {{ to }} de {{ total }}
                                resultados</div>
                            <nav>
                                <ul class="pagination pagination-modern mb-0">
                                    <li class="page-item" :class="{ disabled: currentPage <= 1 }"><a class="page-link"
                                            href="#" @click.prevent="prevPage"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage >= totalPages }"><a
                                            class="page-link" href="#" @click.prevent="nextPage"><i
                                                class="fas fa-chevron-right"></i></a></li>
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
                        <h5 class="fw-bold text-dark mb-0">{{ isEditing ? 'Editar Categoría' : 'Crear Nueva Categoría'
                            }}</h5>
                        <button class="btn-close" @click="cancel"></button>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="isEditing ? updateCollection() : storeCollection()">
                            <div class="row g-4">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-bold">Nombre</label>
                                        <input type="text" class="form-control form-control-lg bg-light border-0"
                                            v-model="collection.CollectionName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-bold">Tipo</label>
                                        <select class="form-select bg-light border-0" v-model="collection.Tipo">
                                            <option value="">Seleccionar tipo</option>
                                            <option value="glam">Glam</option>
                                            <option value="novias">Novias</option>
                                            <option value="carteras">Carteras</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-secondary small fw-bold">Descripción</label>
                                        <textarea class="form-control bg-light border-0" rows="4"
                                            v-model="collection.Description"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label text-secondary small fw-bold">Imagen de Portada</label>

                                    <div class="upload-area position-relative" @click="triggerFileInput">

                                        <div v-if="imagePreview" class="preview-box">
                                            <img :src="imagePreview" class="img-fluid rounded border">
                                            <div class="overlay">
                                                <span class="text-white small"><i class="fas fa-pen me-1"></i>
                                                    Cambiar</span>
                                            </div>
                                            <button type="button" class="btn-remove-img" @click.stop="removeImage">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <div v-else-if="isEditing && collection.Image" class="preview-box">
                                            <img :src="'/' + collection.Image" class="img-fluid rounded border">
                                            <div class="overlay">
                                                <span class="text-white small"><i class="fas fa-pen me-1"></i> Cambiar
                                                    imagen actual</span>
                                            </div>
                                        </div>

                                        <div v-else class="upload-placeholder border rounded bg-light p-5 text-center">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                            <p class="text-muted small mb-0">Subir imagen</p>
                                        </div>

                                        <input type="file" ref="fileInput" class="d-none" accept="image/*"
                                            @change="handleImageUpload">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                                <button type="button" class="btn btn-light px-4" @click="cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary-skinly px-4">{{ isEditing ? 'Guardar Cambios' : 'Crear' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'ver_informacion'" class="row justify-content-center fade-in">
            <div class="col-lg-6 col-md-8">
                <div class="card card-modern border-0 shadow-lg text-center overflow-hidden">
                    <div class="position-relative bg-dark" style="height: 250px;">
                        <img v-if="collectionView.Image" :src="'/' + collectionView.Image"
                            class="w-100 h-100 object-fit-cover opacity-75">
                        <div v-else class="w-100 h-100 bg-gradient-skinly"></div>
                        <div class="position-absolute bottom-0 start-0 p-4 w-100 text-white text-start">
                            <span class="badge bg-white text-dark mb-2 text-uppercase">{{ collectionView.Tipo }}</span>
                            <h2 class="fw-bold mb-0">{{ collectionView.CollectionName }}</h2>
                        </div>
                    </div>
                    <div class="card-body p-4 text-start">
                        <p class="text-dark bg-light p-3 rounded mb-4">{{ collectionView.Description || 'Sin descripción' }}</p>
                        <div class="text-center">
                            <button class="btn btn-outline-dark px-4 rounded-pill" @click="closeView">Volver</button>
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
    name: 'CollectionCrud',
    data() {
        return {
            cargando: false,
            search: '',
            vista: 'listado',
            collections: [],
            collection: { CollectionID: null, CollectionName: '', Description: '', Tipo: '', Image: null },
            newImageFile: null,
            imagePreview: null,
            collectionView: {},
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
        await this.getCollections();
        this.cargando = false;
    },
    methods: {
        // --- LÓGICA DE IMAGENES CORREGIDA ---
        triggerFileInput() {
            // Simula click en el input file oculto
            this.$refs.fileInput.click();
        },

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    this.mostrarNotificacion('Error', 'La imagen es muy pesada (Máx 2MB)', 'warning');
                    return;
                }
                // Guardamos el archivo y creamos la previsualización
                this.newImageFile = file;
                this.imagePreview = URL.createObjectURL(file);
            }
        },

        removeImage() {
            // 1. Limpiar variables de nueva imagen
            this.newImageFile = null;
            this.imagePreview = null;

            // 2. Resetear el valor del input file HTML para permitir volver a subir el mismo archivo si se desea
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
            // Nota: Al limpiar esto, la vista volverá automáticamente a mostrar 'collection.Image' (la de la DB) si existe, gracias al v-else-if
        },

        // --- CRUD ---
        async getCollections() {
            try {
                const response = await axios.get('/collections', { params: { page: this.currentPage, search: this.search } });
                this.collections = response.data.data;
                this.from = response.data.from;
                this.to = response.data.to;
                this.total = response.data.total;
                this.currentPage = response.data.current_page;
                this.totalPages = response.data.last_page;
            } catch (error) { console.error(error); }
        },

        showCreateForm() {
            this.vista = 'formulario';
            this.isEditing = false;
            this.resetForm();
        },

        async storeCollection() {
            this.cargando = true;
            try {
                const formData = new FormData();
                formData.append('CollectionName', this.collection.CollectionName);
                formData.append('Description', this.collection.Description || '');
                formData.append('Tipo', this.collection.Tipo || '');
                if (this.newImageFile) formData.append('Image', this.newImageFile);

                await axios.post('/collections', formData, { headers: { 'Content-Type': 'multipart/form-data' } });
                await this.getCollections();
                this.mostrarNotificacion('Éxito', 'Categoría creada', 'success');
                this.cancel();
            } catch (error) { this.mostrarNotificacion('Error', 'Error al guardar', 'error'); }
            finally { this.cargando = false; }
        },

        editCollection(item) {
            this.resetForm();
            this.isEditing = true;
            this.vista = 'formulario';
            this.collection = { ...item }; // Copia los datos, incluyendo la ruta de la imagen existente
        },

        async updateCollection() {
            this.cargando = true;
            try {
                const formData = new FormData();
                formData.append('CollectionName', this.collection.CollectionName);
                formData.append('Description', this.collection.Description || '');
                formData.append('Tipo', this.collection.Tipo || '');

                if (this.newImageFile) {
                    formData.append('Image', this.newImageFile);
                }

                // Truco para Laravel PUT con archivos
                formData.append('_method', 'PUT');

                await axios.post(`/collections/${this.collection.CollectionID}`, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                await this.getCollections();
                this.mostrarNotificacion('Éxito', 'Categoría actualizada', 'success');
                this.cancel();
            } catch (error) { this.mostrarNotificacion('Error', 'Error al actualizar', 'error'); }
            finally { this.cargando = false; }
        },

        async deleteCollection(id) {
            Swal.fire({
                title: '¿Eliminar?', text: "No podrás revertir esto", icon: 'warning', showCancelButton: true, confirmButtonColor: '#007EAB', cancelButtonColor: '#4A4A4A', confirmButtonText: 'Sí, eliminar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.cargando = true;
                    try {
                        await axios.delete(`/collections/${id}`);
                        await this.getCollections();
                        this.mostrarNotificacion('Eliminado', 'Categoría eliminada', 'success');
                    } catch (e) { this.mostrarNotificacion('Error', 'Error al eliminar', 'error'); }
                    finally { this.cargando = false; }
                }
            })
        },

        viewCollection(item) { this.vista = 'ver_informacion'; this.collectionView = { ...item }; },
        closeView() { this.vista = 'listado'; this.collectionView = {}; },
        cancel() { this.vista = 'listado'; this.resetForm(); },

        resetForm() {
            this.collection = { CollectionID: null, CollectionName: '', Description: '', Tipo: '', Image: null };
            this.newImageFile = null;
            this.imagePreview = null;
            if (this.$refs.fileInput) this.$refs.fileInput.value = '';
        },
        mostrarNotificacion(t, msg, icon) { Swal.fire({ title: t, text: msg, icon: icon, toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 }); },
        prevPage() { if (this.currentPage > 1) { this.currentPage--; this.getCollections(); } },
        nextPage() { if (this.currentPage < this.totalPages) { this.currentPage++; this.getCollections(); } }
    }
};
</script>

<style scoped>
/* ESTILOS SKINLY */

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
    background: #fff;
}

/* Botones */
.btn-primary-skinly {
    background-color: #007EAB;
    border-color: #007EAB;
    color: white;
    border-radius: 50px;
    font-weight: 600;
}

.btn-primary-skinly:hover {
    background-color: #00658a;
    box-shadow: 0 6px 12px rgba(0, 126, 171, 0.3);
}

/* UPLOAD AREA */
.upload-area {
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-placeholder {
    border-style: dashed !important;
    transition: 0.3s;
}

.upload-placeholder:hover {
    background-color: #e9ecef !important;
    border-color: #007EAB !important;
}

/* Preview Box (Contenedor de imagen) */
.preview-box {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.preview-box:hover .overlay {
    opacity: 1;
}

/* Overlay para editar */
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s;
    pointer-events: none;
    /* Deja pasar clicks al div padre */
}

/* Botón X para cancelar nueva imagen */
.btn-remove-img {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    border: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
    z-index: 10;
    transition: transform 0.2s;
}

.btn-remove-img:hover {
    transform: scale(1.1);
}

/* Helpers */
.avatar-md {
    width: 50px;
    height: 50px;
}

.object-fit-cover {
    object-fit: cover;
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
    background: rgba(255, 255, 255, 0.9);
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

</style>