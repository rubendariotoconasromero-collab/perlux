<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="content container-fluid my-5 skinly-font">

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="page-title fw-bold text-dark">Gestión de Productos</h1>
                <p class="text-muted mb-0">Administra inventario, variantes y características de tus productos.</p>
            </div>
        </div>

        <div v-if="vista === 'listado'" class="row">
            <div class="col-12">

                <div class="control-panel d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Buscar producto..."
                            v-model="search" @input="getProducts">
                    </div>
                    <button class="btn btn-primary-skinly px-4 py-2" @click="showCreateForm">
                        <i class="fas fa-plus me-2"></i> Nuevo Producto
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
                                            Producto</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Tipo</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Precio</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Stock Total</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Estado</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products" :key="product.ProductID"
                                        class="align-middle">
                                        <td class="ps-4">
                                            <span class="text-secondary text-xs font-weight-bold">{{ index + 1 }}</span>
                                        </td>

                                        <td>
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div class="me-3">
                                                    <img v-if="product.images && product.images.length > 0"
                                                        :src="product.images[0].ImagePath"
                                                        class="avatar avatar-sm rounded shadow-sm border" alt="prod">
                                                    <div v-else
                                                        class="avatar avatar-sm rounded bg-light d-flex align-items-center justify-content-center text-muted border">
                                                        <i class="fas fa-camera"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ product.Name
                                                        }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ product.collection ?
                                                        product.collection.CollectionName : 'Sin categoria' }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="badge bg-light text-dark border">{{ product.Tipo }}</span>
                                        </td>

                                        <td>
                                            <span class="text-dark text-sm font-weight-bold">
                                                ${{ product.Price }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge"
                                                :class="calcularStockTotal(product) > 0 ? 'bg-info-light text-info' : 'bg-danger-light text-danger'">
                                                {{ calcularStockTotal(product) }} u.
                                            </span>
                                        </td>

                                        <td>
                                            <span v-if="product.IsFeatured"
                                                class="badge bg-gold-light text-gold border-gold">
                                                <i class="fas fa-star me-1"></i> Destacado
                                            </span>
                                            <span v-else class="text-secondary text-xs">Normal</span>
                                        </td>

                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action text-secondary"
                                                    @click.prevent="viewProduct(product)" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn-action text-primary mx-3"
                                                    @click.prevent="editProduct(product)" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn-action text-danger"
                                                    @click.prevent="deleteProduct(product.ProductID)" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="products.length === 0">
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open fa-3x mb-3 text-muted opacity-50"></i>
                                                <h6 class="text-muted">No hay productos registrados</h6>
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
            <div class="col-lg-10">
                <div class="card card-modern border-0 shadow-lg">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">
                            {{ isEditing ? 'Editar Producto' : 'Crear Nuevo Producto' }}
                        </h5>
                        <button class="btn btn-close" @click="cancel"></button>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="isEditing ? updateProduct() : storeProduct()"
                            enctype="multipart/form-data">

                            <h6 class="text-uppercase text-muted text-xs font-weight-bolder mb-3 border-bottom pb-2">
                                Información General</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Nombre</label>
                                    <input type="text" class="form-control bg-light border-0" v-model="product.Name"
                                        required placeholder="Ej. Zapato Perlux">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-secondary fw-bold">Tipo</label>
                                    <select class="form-select bg-light border-0" v-model="product.Tipo">
                                        <option :value="'Glam'">Glam</option>
                                        <option :value="'Novias'">Novias</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-secondary fw-bold">Categoria</label>
                                    <select class="form-select bg-light border-0" v-model="product.CollectionID">
                                        <option :value="null">Sin Categoria</option>
                                        <option v-for="c in collections" :key="c.CollectionID" :value="c.CollectionID">
                                            {{ c.CollectionName }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Precio Base ($)</label>
                                    <input type="number" class="form-control bg-light border-0" v-model="product.Price"
                                        required step="0.01" min="0">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Destacado</label>
                                    <select class="form-select bg-light border-0" v-model="product.IsFeatured">
                                        <option :value="1">Sí</option>
                                        <option :value="0">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Detalles / Material</label>
                                    <input type="text" class="form-control bg-light border-0" v-model="product.Fabric"
                                        placeholder="Ej. Algodón 100%">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-secondary fw-bold">Política de
                                        Devolución</label>
                                    <input type="text" class="form-control bg-light border-0"
                                        v-model="product.ReturnPolicy" placeholder="Ej. 30 días">
                                </div>
                            </div>

                            <h6
                                class="text-uppercase text-muted text-xs font-weight-bolder mb-3 border-bottom pb-2 mt-4">
                                Galería</h6>
                            <div class="mb-4">
                                <div class="upload-box p-4 border border-2 border-dashed rounded text-center bg-light">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-secondary mb-2"></i>
                                    <p class="text-sm text-muted mb-2">Arrastra imágenes aquí o haz clic para subir</p>
                                    <input type="file" class="form-control d-none" id="inputImages" accept="image/*"
                                        multiple @change="handleImageChange">
                                    <label for="inputImages" class="btn btn-sm btn-outline-primary">Seleccionar
                                        Archivos</label>
                                </div>

                                <div class="d-flex flex-wrap gap-3 mt-3">
                                    <div v-for="(preview, index) in imagePreviews" :key="'preview-' + index"
                                        class="position-relative">
                                        <img :src="preview" class="img-preview rounded shadow-sm border">
                                        <button type="button"
                                            class="btn btn-icon btn-danger btn-xs position-absolute top-0 end-0 m-1"
                                            @click="removeImagePreview(index)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <span
                                            class="badge bg-info position-absolute bottom-0 start-0 m-1 text-xs">Nueva</span>
                                    </div>
                                    <div v-for="image in product.images" :key="'existing-' + image.ImageID"
                                        class="position-relative">
                                        <img :src="image.ImagePath" class="img-preview rounded shadow-sm border">
                                        <button type="button"
                                            class="btn btn-icon btn-danger btn-xs position-absolute top-0 end-0 m-1"
                                            @click="deleteImage(image.ImageID)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <h6
                                class="text-uppercase text-muted text-xs font-weight-bolder mb-3 border-bottom pb-2 mt-4">
                                Variantes (Tallas y Colores)</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-striped align-middle text-sm mb-0 table-sm">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="fw-bold" style="width: 20%">Talla</th>
                                            <th class="fw-bold" style="width: 20%">Color</th>
                                            <th class="fw-bold" style="width: 15%">Stock</th>
                                            <th class="fw-bold" style="width: 15%">Precio (Opcional)</th>
                                            <th class="fw-bold" style="width: 20%">SKU</th>
                                            <th class="text-center" style="width: 10%"><i class="fas fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(variant, index) in product.Variants" :key="index">
                                            <td>
                                                <select class="form-select form-select-sm border-0 bg-light"
                                                    v-model="variant.SizeID" required>
                                                    <option value="">Seleccionar</option>
                                                    <option v-for="size in sizes" :key="size.SizeID"
                                                        :value="size.SizeID">{{ size.SizeName }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm border-0 bg-light"
                                                    v-model="variant.ColorID" required>
                                                    <option value="">Seleccionar</option>
                                                    <option v-for="color in colors" :key="color.ColorID"
                                                        :value="color.ColorID">{{ color.ColorName }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control form-control-sm border-0 bg-light"
                                                    v-model="variant.StockQuantity" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control form-control-sm border-0 bg-light"
                                                    v-model="variant.Price" step="0.01" min="0" placeholder="Base">
                                            </td>
                                            <td>
                                                <input type="text"
                                                    class="form-control form-control-sm border-0 bg-light"
                                                    v-model="variant.SKU" placeholder="Código">
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-icon btn-white text-danger btn-sm shadow-none border-0"
                                                    @click="removeVariant(index)"
                                                    :disabled="product.Variants.length <= 1">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" @click="addVariant">
                                    <i class="fas fa-plus me-1"></i> Agregar Variante
                                </button>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="card bg-gray-50 border-0 h-100">
                                        <div class="card-body p-3">
                                            <h6 class="text-uppercase text-muted text-xs fw-bold mb-3">Detalles Técnicos
                                            </h6>
                                            <div v-for="(detail, index) in product.Details" :key="'detail-' + index"
                                                class="input-group mb-2">
                                                <input type="text" class="form-control form-control-sm border-0"
                                                    placeholder="Atributo" v-model="detail.DetailName">
                                                <input type="text" class="form-control form-control-sm border-0"
                                                    placeholder="Valor" v-model="detail.DetailValue">
                                                <button type="button" class="btn btn-white text-danger btn-sm"
                                                    @click="removeDetail(index)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-link text-primary text-decoration-none px-0"
                                                @click="addDetail">
                                                <i class="fas fa-plus-circle me-1"></i> Agregar fila
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card bg-gray-50 border-0 h-100">
                                        <div class="card-body p-3">
                                            <h6 class="text-uppercase text-muted text-xs fw-bold mb-3">Ajustes</h6>
                                            <div v-for="(setting, index) in product.Settings" :key="'setting-' + index"
                                                class="input-group mb-2">
                                                <input type="text" class="form-control form-control-sm border-0"
                                                    placeholder="Nombre" v-model="setting.SettingName">
                                                <input type="text" class="form-control form-control-sm border-0"
                                                    placeholder="Valor" v-model="setting.SettingValue">
                                                <button type="button" class="btn btn-white text-danger btn-sm"
                                                    @click="removeSetting(index)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-link text-primary text-decoration-none px-0"
                                                @click="addSetting">
                                                <i class="fas fa-plus-circle me-1"></i> Agregar ajuste
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card bg-gray-50 border-0 h-100">
                                        <div class="card-body p-3">
                                            <h6 class="text-uppercase text-muted text-xs fw-bold mb-3">Políticas</h6>
                                            <div v-for="(policy, index) in product.Policies" :key="'policy-' + index"
                                                class="input-group mb-2">
                                                <input type="text" class="form-control form-control-sm border-0"
                                                    placeholder="Nombre" v-model="policy.PolicyName">
                                                <input type="text" class="form-control form-control-sm border-0"
                                                    placeholder="Descripción" v-model="policy.PolicyValue">
                                                <button type="button" class="btn btn-white text-danger btn-sm"
                                                    @click="removePolicy(index)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-link text-primary text-decoration-none px-0"
                                                @click="addPolicy">
                                                <i class="fas fa-plus-circle me-1"></i> Agregar política
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-5 border-top pt-4">
                                <button type="button" class="btn btn-light px-4" @click="cancel">Cancelar</button>
                                <button type="submit" class="btn btn-primary-skinly px-4">
                                    {{ isEditing ? 'Guardar Cambios' : 'Crear Producto' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="vista === 'ver_informacion'" class="row justify-content-center fade-in">
            <div class="col-lg-10">
                <div class="card card-modern border-0 shadow-lg overflow-hidden">
                    <div class="position-relative bg-light" style="min-height: 200px;">
                        <div v-if="productView.images && productView.images.length > 0"
                            class="w-100 h-100 position-absolute top-0 start-0"
                            :style="{ backgroundImage: 'url(' + productView.images[0].ImagePath + ')', backgroundSize: 'cover', backgroundPosition: 'center', filter: 'blur(20px)', opacity: 0.3 }">
                        </div>
                        <div class="position-relative z-index-1 p-5 text-center">
                            <img v-if="productView.images && productView.images.length > 0"
                                :src="productView.images[0].ImagePath"
                                class="rounded shadow-lg border border-white border-4"
                                style="height: 180px; width: 180px; object-fit: cover;">
                            <div v-else
                                class="rounded shadow-lg border border-white border-4 bg-white d-inline-flex align-items-center justify-content-center"
                                style="height: 180px; width: 180px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                            <h2 class="mt-3 fw-bold text-dark">{{ productView.Name }}</h2>
                            <p class="text-primary fw-bold fs-4">${{ productView.Price }}</p>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="text-uppercase text-secondary text-xs fw-bold mb-3">Información General</h6>
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <span class="d-block text-muted text-xs">Categoría</span>
                                        <span class="fw-bold text-dark">{{ productView.collection ?
                                            productView.collection.CollectionName : '-' }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="d-block text-muted text-xs">Tipo</span>
                                        <span class="fw-bold text-dark">{{ productView.Tipo }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="d-block text-muted text-xs">Stock Global</span>
                                        <span class="fw-bold text-dark">{{ calcularStockTotal(productView) }}
                                            unidades</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="d-block text-muted text-xs">Detalles / Material</span>
                                        <span class="fw-bold text-dark">{{ productView.Fabric || '-' }}</span>
                                    </div>
                                </div>

                                <h6 class="text-uppercase text-secondary text-xs fw-bold mb-3">Variantes Disponibles
                                </h6>
                                <div class="table-responsive mb-4"
                                    v-if="productView.variants && productView.variants.length > 0">
                                    <table class="table table-sm align-middle text-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Talla</th>
                                                <th>Color</th>
                                                <th>Stock</th>
                                                <th>Precio</th>
                                                <th>SKU</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="v in productView.variants" :key="v.VariantID">
                                                <td class="fw-bold">{{ v.size ? v.size.SizeName : '-' }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">{{ v.color ?
                                                        v.color.ColorName : '-' }}</span>
                                                </td>
                                                <td>{{ v.StockQuantity }}</td>
                                                <td>${{ v.Price || productView.Price }}</td>
                                                <td class="text-muted text-xs">{{ v.SKU || '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p v-else class="text-muted text-sm">No hay variantes registradas.</p>

                                <div v-if="productView.details && productView.details.length > 0" class="mt-4">
                                    <h6 class="text-uppercase text-secondary text-xs fw-bold mb-2">Detalles Técnicos
                                    </h6>
                                    <ul class="list-group list-group-flush mb-4">
                                        <li v-for="d in productView.details" :key="d.DetailID"
                                            class="list-group-item px-0 d-flex justify-content-between bg-transparent">
                                            <span class="text-muted">{{ d.DetailName }}</span>
                                            <span class="fw-bold text-dark">{{ d.DetailValue }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4 border-start">
                                <h6 class="text-uppercase text-secondary text-xs fw-bold mb-3">Galería</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <img v-for="img in productView.images" :key="img.ImageID" :src="img.ImagePath"
                                        class="rounded border shadow-sm cursor-pointer"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                </div>

                                <div v-if="productView.policies && productView.policies.length > 0" class="mt-4">
                                    <h6 class="text-uppercase text-secondary text-xs fw-bold mb-3">Políticas</h6>
                                    <div v-for="p in productView.policies" :key="p.PolicyID" class="mb-2">
                                        <small class="d-block fw-bold">{{ p.PolicyName }}</small>
                                        <small class="text-muted">{{ p.PolicyValue }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
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
    name: 'ProductCrud',
    data() {
        return {
            cargando: false,
            search: '',
            vista: 'listado',
            products: [],
            product: {
                ProductID: null,
                CollectionID: null,
                Name: '',
                Tipo: 'Glam',
                Description: '',
                Price: '',
                StockQuantity: 0,
                IsFeatured: false,
                Fabric: '', // Visualmente será "Detalles / Material"
                ReturnPolicy: '',
                images: [],
                newImages: [],
                Details: [],
                Settings: [],
                Policies: [],
                Variants: [
                    {
                        SizeID: '',
                        ColorID: '',
                        StockQuantity: 0,
                        Price: '',
                        SKU: ''
                    }
                ],
            },
            imagePreviews: [],
            productView: {},
            collections: [],
            colors: [],
            sizes: [],
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
        await Promise.all([this.getProducts(), this.getCollections(), this.getColors(), this.getSizes()]);
        this.cargando = false;
    },
    methods: {
        calcularStockTotal(product) {
            if (product.variants && product.variants.length > 0) {
                return product.variants.reduce((total, variant) => total + parseInt(variant.StockQuantity || 0), 0);
            }
            return product.StockQuantity || 0; // Fallback al stock simple si no hay variantes
        },
        async getProducts() {
            try {
                const response = await axios.get('/products', {
                    params: {
                        page: this.currentPage,
                        search: this.search,
                    },
                });
                const data = response.data;
                this.products = data.data;
                this.from = data.from;
                this.to = data.to;
                this.total = data.total;
                this.currentPage = data.current_page;
                this.totalPages = data.last_page;
            } catch (error) {
                console.error('Error al obtener productos:', error);
                this.mostrarNotificacion('Error', 'No se pudieron cargar los productos', 'error');
            }
        },
        async getCollections() {
            try {
                const response = await axios.get('/collections');
                this.collections = response.data.data;
            } catch (error) {
                console.error('Error al obtener colecciones:', error);
            }
        },
        async getColors() {
            try {
                const response = await axios.get('/colors');
                this.colors = response.data.data;
            } catch (error) {
                console.error('Error al obtener colores:', error);
            }
        },
        async getSizes() {
            try {
                const response = await axios.get('/sizes');
                this.sizes = response.data.data;
            } catch (error) {
                console.error('Error al obtener tallas:', error);
            }
        },
        showCreateForm() {
            this.vista = 'formulario';
            this.isEditing = false;
            this.resetForm();
        },
        handleImageChange(event) {
            const files = Array.from(event.target.files);
            this.product.newImages = files;
            this.imagePreviews = files.map(file => URL.createObjectURL(file));
        },
        removeImagePreview(index) {
            this.product.newImages.splice(index, 1);
            this.imagePreviews.splice(index, 1);
        },
        async deleteImage(imageId) {
            try {
                await axios.delete(`/product-images/${imageId}`);
                this.product.images = this.product.images.filter(image => image.ImageID !== imageId);
                this.mostrarNotificacion('Éxito', 'Imagen eliminada exitosamente', 'success');
            } catch (error) {
                this.mostrarNotificacion('Error', error.response?.data.message || 'Error al eliminar la imagen', 'error');
            }
        },
        // Métodos para manejar variantes
        addVariant() {
            this.product.Variants.push({
                SizeID: '',
                ColorID: '',
                StockQuantity: 0,
                Price: '',
                SKU: ''
            });
        },
        removeVariant(index) {
            if (this.product.Variants.length > 1) {
                this.product.Variants.splice(index, 1);
            }
        },
        addDetail() {
            this.product.Details.push({ DetailName: '', DetailValue: '' });
        },
        removeDetail(index) {
            this.product.Details.splice(index, 1);
        },
        addSetting() {
            this.product.Settings.push({ SettingName: '', SettingValue: '' });
        },
        removeSetting(index) {
            this.product.Settings.splice(index, 1);
        },
        addPolicy() {
            this.product.Policies.push({ PolicyName: '', PolicyValue: '' });
        },
        removePolicy(index) {
            this.product.Policies.splice(index, 1);
        },
        async storeProduct() {
            this.cargando = true;
            try {
                const formData = new FormData();
                formData.append('Name', this.product.Name);
                formData.append('Description', this.product.Description || '');
                formData.append('Tipo', this.product.Tipo || '');
                formData.append('Price', this.product.Price);
                formData.append('StockQuantity', this.product.StockQuantity);
                formData.append('IsFeatured', this.product.IsFeatured ? 1 : 0);
                formData.append('CollectionID', this.product.CollectionID || '');
                formData.append('Fabric', this.product.Fabric || '');
                formData.append('ReturnPolicy', this.product.ReturnPolicy || '');

                // Agregar variantes
                this.product.Variants.forEach((variant, index) => {
                    formData.append(`Variants[${index}][SizeID]`, variant.SizeID || '');
                    formData.append(`Variants[${index}][ColorID]`, variant.ColorID || '');
                    formData.append(`Variants[${index}][StockQuantity]`, variant.StockQuantity);
                    formData.append(`Variants[${index}][Price]`, variant.Price || '');
                    formData.append(`Variants[${index}][SKU]`, variant.SKU || '');
                });

                // Agregar imágenes
                this.product.newImages.forEach(image => formData.append('Images[]', image));

                // Agregar detalles
                this.product.Details.forEach((detail, index) => {
                    formData.append(`Details[${index}][DetailName]`, detail.DetailName || '');
                    formData.append(`Details[${index}][DetailValue]`, detail.DetailValue || '');
                });

                // Agregar ajustes
                this.product.Settings.forEach((setting, index) => {
                    formData.append(`Settings[${index}][SettingName]`, setting.SettingName || '');
                    formData.append(`Settings[${index}][SettingValue]`, setting.SettingValue || '');
                });

                // Agregar políticas
                this.product.Policies.forEach((policy, index) => {
                    formData.append(`Policies[${index}][PolicyName]`, policy.PolicyName || '');
                    formData.append(`Policies[${index}][PolicyValue]`, policy.PolicyValue || '');
                });

                const response = await axios.post('/products', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });
                await this.getProducts();
                this.mostrarNotificacion('Éxito', 'Producto registrado exitosamente', 'success');
                this.cancel();
            } catch (error) {
                this.mostrarNotificacion(
                    'Error',
                    error.response?.data.message || 'Error al registrar el producto',
                    'error'
                );
            } finally {
                this.cargando = false;
            }
        },
        editProduct(product) {
            this.resetForm();
            this.isEditing = true;
            this.vista = 'formulario';
            this.product = {
                ...product,
                images: product.images || [],
                newImages: [],
                Details: product.details || [],
                Settings: product.settings || [],
                Policies: product.policies || [],
                Variants: product.variants && product.variants.length > 0 ?
                    product.variants.map(variant => ({
                        SizeID: variant.SizeID,
                        ColorID: variant.ColorID,
                        StockQuantity: variant.StockQuantity,
                        Price: variant.Price || '',
                        SKU: variant.SKU || ''
                    })) :
                    [{
                        SizeID: '',
                        ColorID: '',
                        StockQuantity: 0,
                        Price: '',
                        SKU: ''
                    }]
            };
            this.imagePreviews = [];
        },
        async updateProduct() {
            this.cargando = true;
            try {
                const formData = new FormData();
                formData.append('Name', this.product.Name);
                formData.append('Description', this.product.Description || '');
                formData.append('Tipo', this.product.Tipo || '');
                formData.append('Price', this.product.Price);
                formData.append('StockQuantity', this.product.StockQuantity);
                formData.append('IsFeatured', this.product.IsFeatured ? 1 : 0);
                formData.append('CollectionID', this.product.CollectionID || '');
                formData.append('Fabric', this.product.Fabric || '');
                formData.append('ReturnPolicy', this.product.ReturnPolicy || '');

                // Agregar variantes
                this.product.Variants.forEach((variant, index) => {
                    formData.append(`Variants[${index}][SizeID]`, variant.SizeID || '');
                    formData.append(`Variants[${index}][ColorID]`, variant.ColorID || '');
                    formData.append(`Variants[${index}][StockQuantity]`, variant.StockQuantity);
                    formData.append(`Variants[${index}][Price]`, variant.Price || '');
                    formData.append(`Variants[${index}][SKU]`, variant.SKU || '');
                });

                // Agregar nuevas imágenes
                this.product.newImages.forEach(image => formData.append('Images[]', image));

                // Agregar detalles
                this.product.Details.forEach((detail, index) => {
                    formData.append(`Details[${index}][DetailName]`, detail.DetailName || '');
                    formData.append(`Details[${index}][DetailValue]`, detail.DetailValue || '');
                });

                // Agregar ajustes
                this.product.Settings.forEach((setting, index) => {
                    formData.append(`Settings[${index}][SettingName]`, setting.SettingName || '');
                    formData.append(`Settings[${index}][SettingValue]`, setting.SettingValue || '');
                });

                // Agregar políticas
                this.product.Policies.forEach((policy, index) => {
                    formData.append(`Policies[${index}][PolicyName]`, policy.PolicyName || '');
                    formData.append(`Policies[${index}][PolicyValue]`, policy.PolicyValue || '');
                });

                formData.append('_method', 'POST'); // Laravel trick for PUT with files

                const response = await axios.post(`/products/${this.product.ProductID}`, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });
                await this.getProducts();
                this.mostrarNotificacion('Éxito', 'Producto actualizado exitosamente', 'success');
                this.cancel();
            } catch (error) {
                this.mostrarNotificacion(
                    'Error',
                    error.response?.data.message || 'Error al actualizar el producto',
                    'error'
                );
            } finally {
                this.cargando = false;
            }
        },
        async deleteProduct(id) {
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
                        await axios.delete(`/products/${id}`);
                        await this.getProducts();
                        this.mostrarNotificacion('Éxito', 'Producto eliminado exitosamente', 'success');
                    } catch (error) {
                        this.mostrarNotificacion(
                            'Error',
                            error.response?.data.message || 'Error al eliminar el producto',
                            'error'
                        );
                    } finally {
                        this.cargando = false;
                    }
                }
            })
        },
        viewProduct(product) {
            this.vista = 'ver_informacion';
            this.productView = { ...product };
        },
        closeView() {
            this.vista = 'listado';
            this.productView = {};
        },
        cancel() {
            this.vista = 'listado';
            this.resetForm();
        },
        resetForm() {
            this.product = {
                ProductID: null,
                CollectionID: null,
                Name: '',
                Tipo: 'Glam',
                Description: '',
                Price: '',
                StockQuantity: 0,
                IsFeatured: false,
                Fabric: '',
                ReturnPolicy: '',
                images: [],
                newImages: [],
                Details: [],
                Settings: [],
                Policies: [],
                Variants: [{ // Reiniciar con una variante vacía
                    SizeID: '',
                    ColorID: '',
                    StockQuantity: 0,
                    Price: '',
                    SKU: ''
                }],
            };
            this.imagePreviews = [];
        },
        mostrarNotificacion(titulo, texto, icono) {
            Swal.fire({
                title: titulo,
                text: texto,
                icon: icono,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            });
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.getProducts();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.getProducts();
            }
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                this.getProducts();
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

/* Cards & Containers */
.card-modern {
    border-radius: 16px;
    background: #ffffff;
}

.bg-gray-50 {
    background-color: #f9fafb;
}

/* Buttons */

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
    transition: all 0.3s ease;
}

.btn-primary-skinly:hover {
    background-color: #00658a;
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(0, 126, 171, 0.3);
}

.btn-icon {
    width: 24px;
    height: 24px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
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

.avatar {
    object-fit: cover;
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

/* Badges */
.bg-success-light {
    background-color: #e8f5e9;
}

.bg-danger-light {
    background-color: #ffebee;
}

.bg-gold-light {
    background-color: #fff8e1;
}

.text-gold {
    color: #f57f17;
}

.border-gold {
    border: 1px solid #ffecb3;
}

/* Images */
.img-preview {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.upload-box {
    border-style: dashed !important;
    cursor: pointer;
    transition: background 0.3s;
}

.upload-box:hover {
    background-color: #eef2f5 !important;
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