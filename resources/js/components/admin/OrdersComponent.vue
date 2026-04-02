<template>
    <div v-if="cargando" class="preloader">
        <div class="loader-container">
            <span class="loader"></span>
        </div>
    </div>

    <div class="content container-fluid my-5 skinly-font">

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="page-title fw-bold text-dark">Gestión de Pedidos</h1>
                <!-- <p class="text-muted mb-0">Supervisa y gestiona las ventas de tu tienda.</p> -->
            </div>
        </div>

        <div v-if="vista === 'listado'" class="row fade-in">
            <div class="col-12">

                <div class="control-panel d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="form-control search-input"
                                placeholder="Buscar por referencia o cliente..." v-model="filters.search"
                                @input="debouncedGetOrders">
                        </div>

                        <div class="search-wrapper" style="max-width: 200px;">
                            <select class="form-control search-input form-select" v-model="filters.status"
                                @change="getOrders">
                                <option value="">Todos los estados</option>
                                <option value="paid">Pagados</option>
                                <option value="pending">Pendientes</option>
                                <option value="cancelled">Cancelados</option>
                            </select>
                        </div>
                    </div>

                    <!-- <button class="btn btn-outline-dark px-4 py-2 rounded-pill" @click="exportOrders">
                        <i class="fas fa-download me-2"></i> Exportar
                    </button> -->
                </div>

                <div class="card card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 skinly-table table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th
                                            class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Referencia</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Cliente</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Fecha</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Estado</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Total</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in orders" :key="order.OrderID">
                                        <td class="ps-4">
                                            <div class="d-flex flex-column">
                                                <span class="text-dark font-weight-bold text-sm">#{{
                                                    order.external_reference }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm text-dark">{{ order.customer_name }}</h6>
                                                <span class="text-xs text-secondary">{{ order.customer_email }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">{{
                                                formatDate(order.created_at) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-status"
                                                :class="getStatusBadgeClass(order.payment_status)">
                                                {{ getStatusLabel(order.payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-dark text-sm font-weight-bold">S/ {{ order.total_amount
                                                }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="#" class="btn-action text-secondary"
                                                    @click.prevent="viewOrder(order)" title="Ver Detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="orders.length === 0">
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-shopping-basket fa-3x mb-3 text-muted opacity-50"></i>
                                                <h6 class="text-muted">No se encontraron pedidos</h6>
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
                                    total }}</span> pedidos
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

        <div v-if="vista === 'detalle'" class="row justify-content-center fade-in">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-outline-dark px-4 rounded-pill" @click="closeView">
                        <i class="fas fa-arrow-left me-2"></i> Regresar
                    </button>
                    <div>
                        <button class="btn btn-primary-skinly px-4" @click="updateOrderStatus">
                            Actualizar Estado
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card card-modern border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-0 py-2 px-4">
                                <h6 class="fw-bold text-dark my-2">Información del Cliente</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="text-secondary text-xs text-uppercase fw-bold">Nombre</label>
                                    <p class="text-dark font-weight-bold mb-0">{{ orderView.customer_name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-secondary text-xs text-uppercase fw-bold">Contacto</label>
                                    <p class="mb-0 text-sm"><i class="far fa-envelope me-2"></i> {{
                                        orderView.customer_email }}</p>
                                    <p class="mb-0 text-sm"><i class="fas fa-phone me-2"></i> {{
                                        orderView.customer_phone }}</p>
                                </div>
                                <hr class="border-light my-3">
                                <div class="mb-3">
                                    <label class="text-secondary text-xs text-uppercase fw-bold">Dirección de
                                        Envío</label>
                                    <p class="text-dark text-sm mb-0">{{ orderView.shipping_address }}</p>
                                </div>
                                <div class="mb-0">
                                    <label class="text-secondary text-xs text-uppercase fw-bold">Método de Pago</label>
                                    <p class="text-dark text-sm mb-0 text-uppercase">{{ orderView.additional_info }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mb-4">
                        <div class="card card-modern border-0 shadow-sm">
                            <div
                                class="card-header bg-transparent border-0 py-2 px-4 d-flex justify-content-between">
                                <h6 class="fw-bold text-dark my-2">Detalle del Pedido #{{ orderView.external_reference
                                    }}</h6>
                                <span class="badge badge-status my-2" :class="getStatusBadgeClass(orderView.payment_status)">
                                    {{ getStatusLabel(orderView.payment_status) }}
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <!-- <table class="table align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-secondary text-xs font-weight-bolder opacity-7 ps-3">
                                                    Producto</th>
                                                <th
                                                    class="text-center text-secondary text-xs font-weight-bolder opacity-7">
                                                    Cant.</th>
                                                <th
                                                    class="text-end text-secondary text-xs font-weight-bolder opacity-7 pe-3">
                                                    Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="detail in orderView.order_details" :key="detail.OrderDetailID">
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded me-3 bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 48px; height: 48px; overflow: hidden;">
                                                            <img :src="getImage(detail)" class="img-fluid"
                                                                style="object-fit: cover; width: 100%; height: 100%;">
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-dark text-sm font-weight-bold">
                                                                {{ detail.product_name }}
                                                            </span>
                                                            <span class="text-xs text-secondary" v-if="detail.product_snapshot">
                                                                {{ detail.product_snapshot.color }} / {{ detail.product_snapshot.size }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center text-sm">{{ detail.quantity }}</td>
                                                <td class="text-end text-sm font-weight-bold pe-3">S/ {{ detail.subtotal }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="border-top">
                                            <tr>
                                                <td colspan="2" class="text-end pt-4"><span
                                                        class="text-secondary text-sm">Subtotal:</span></td>
                                                <td class="text-end pt-4 pe-3"><span
                                                        class="text-dark font-weight-bold">S/ {{ orderView.total_amount
                                                        }}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end border-0"><span
                                                        class="text-secondary text-sm">Envío:</span></td>
                                                <td class="text-end border-0 pe-3"><span
                                                        class="text-primary text-sm fw-bold">Gratis</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end border-0 pt-3"><span
                                                        class="text-dark h6 font-weight-bold">Total General:</span></td>
                                                <td class="text-end border-0 pt-3 pe-3"><span
                                                        class="text-primary-skinly h5 font-weight-bold">S/ {{
                                                        orderView.total_amount }}</span></td>
                                            </tr>
                                        </tfoot>
                                    </table> -->
                                    <table class="table align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-secondary text-xs font-weight-bolder opacity-7 ps-3">Producto</th>
                                                <th class="text-center text-secondary text-xs font-weight-bolder opacity-7">Cant.</th>
                                                <th class="text-center text-secondary text-xs font-weight-bolder opacity-7">Códigos / Certificados</th>
                                                <th class="text-end text-secondary text-xs font-weight-bolder opacity-7 pe-3">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="detail in orderView.order_details" :key="detail.OrderDetailID">
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded me-3 bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 48px; height: 48px; overflow: hidden;">
                                                            <img :src="getImage(detail)" class="img-fluid"
                                                                style="object-fit: cover; width: 100%; height: 100%;">
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-dark text-sm font-weight-bold">
                                                                {{ detail.product_name }}
                                                            </span>
                                                            <span class="text-xs text-secondary" v-if="detail.product_snapshot">
                                                                {{ detail.product_snapshot.color }} / {{ detail.product_snapshot.size }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center text-sm">{{ detail.quantity }}</td>
                                                
                                                <td class="text-center">
                                                    <button v-if="detail.certificates && detail.certificates.length > 0" 
                                                            class="btn btn-sm rounded-pill px-3" style="background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;"
                                                            @click="openCertModal(detail)">
                                                        <i class="fas fa-check-circle me-1"></i> Ver/Editar Códigos
                                                    </button>

                                                    <button v-else-if="orderView.payment_status === 'paid'" 
                                                            class="btn btn-sm btn-outline-dark rounded-pill px-3" 
                                                            @click="openCertModal(detail)">
                                                        <i class="fas fa-barcode me-1"></i> Asignar Códigos
                                                    </button>

                                                    <span v-else class="text-muted" style="font-size: 0.75rem;">
                                                        <i class="fas fa-lock me-1"></i> Requiere pago
                                                    </span>
                                                </td>
                                                
                                                <td class="text-end text-sm font-weight-bold pe-3">S/ {{ detail.subtotal }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="border-top">
                                            <tr>
                                                <td colspan="3" class="text-end pt-4"><span class="text-secondary text-sm">Subtotal:</span></td>
                                                <td class="text-end pt-4 pe-3"><span class="text-dark font-weight-bold">S/ {{ orderView.total_amount }}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end border-0"><span class="text-secondary text-sm">Envío:</span></td>
                                                <td class="text-end border-0 pe-3"><span class="text-primary text-sm fw-bold">Gratis</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end border-0 pt-3"><span class="text-dark h6 font-weight-bold">Total General:</span></td>
                                                <td class="text-end border-0 pt-3 pe-3"><span class="text-primary-skinly h5 font-weight-bold">S/ {{ orderView.total_amount }}</span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCertificados" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
          <div class="modal-header border-bottom-0 pb-0">
            <h5 class="modal-title fw-bold text-dark">Certificados de Autenticidad</h5>
            <button type="button" class="btn-close" @click="closeCertModal"></button>
          </div>
          <div class="modal-body p-4">
            
            <div v-if="currentDetailForCert" class="d-flex align-items-center bg-light border p-3 rounded-3 mb-4 shadow-sm">
                
                <div class="me-3 border" style="width: 70px; height: 70px; border-radius: 8px; overflow: hidden; background: #fff; flex-shrink: 0;">
                    <img :src="getImage(currentDetailForCert)" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Producto">
                </div>

                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">{{ currentDetailForCert.product_name }}</h6>
                    
                    <div class="text-secondary small mb-2" v-if="currentDetailForCert.product_snapshot">
                        <span class="me-3" title="Color">
                            <i class="fas fa-palette text-muted me-1"></i> {{ currentDetailForCert.product_snapshot.color || 'N/A' }}
                        </span>
                        <span title="Talla">
                            <i class="fas fa-ruler text-muted me-1"></i> {{ currentDetailForCert.product_snapshot.size || 'N/A' }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="text-dark small fw-bold me-2">Cantidad a certificar:</span>
                        <span class="badge bg-dark px-2 py-1" style="font-size: 0.8rem;">
                            {{ currentDetailForCert.quantity }} {{ currentDetailForCert.quantity > 1 ? 'unidades' : 'unidad' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="certificates-list">
                <div v-for="(code, index) in certificateCodes" :key="index" class="mb-3">
                    <label class="form-label small fw-bold text-muted">Código para el Ítem #{{ index + 1 }}</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" 
                               v-model="certificateCodes[index]" 
                               placeholder="Ej: PRX-9823749823"
                               style="font-family: monospace; font-size: 1rem; letter-spacing: 1px;">
                    </div>
                </div>
            </div>

          </div>
          <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
            <button type="button" class="btn btn-light px-4 rounded-pill" @click="closeCertModal">Cancelar</button>
            <button type="button" class="btn btn-dark px-4 rounded-pill" @click="saveCerts" :disabled="isSavingCerts">
              <span v-if="isSavingCerts" class="spinner-border spinner-border-sm me-2"></span>
              {{ isSavingCerts ? 'Guardando...' : 'Guardar Códigos' }}
            </button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import _ from 'lodash'; // Necesario para el debounce, o implementa uno manual

export default {
    name: 'AdminOrders',
    data() {
        return {
            cargando: false,
            vista: 'listado',
            filters: {
                search: '',
                status: ''
            },
            orders: [],
            orderView: {}, // Pedido seleccionado para ver detalle

            // Paginación
            currentPage: 1,
            totalPages: 0,
            from: 0,
            to: 0,
            total: 0,

            currentDetailForCert: null,
            certificateCodes: [],
            isSavingCerts: false,
        };
    },
    async mounted() {
        await this.getOrders();
    },
    methods: {
        openCertModal(detail) {
            this.currentDetailForCert = detail;
            this.certificateCodes = [];
            
            // Si el detalle ya tiene certificados guardados, los usamos.
            // Si no, iniciamos con arrays vacíos.
            let existingCerts = detail.certificates || [];
            
            // Creamos un input por cada unidad comprada (detail.quantity)
            for (let i = 0; i < detail.quantity; i++) {
                if (existingCerts[i]) {
                    this.certificateCodes.push(existingCerts[i].code);
                } else {
                    this.certificateCodes.push(''); // Input vacío
                }
            }
            
            $('#modalCertificados').modal('show');
        },

        closeCertModal() {
            $('#modalCertificados').modal('hide');
            setTimeout(() => {
                this.currentDetailForCert = null;
                this.certificateCodes = [];
            }, 300);
        },

        async saveCerts() {
            this.isSavingCerts = true;
            try {
                // Hacemos el POST a la nueva ruta
                const response = await axios.post(`/admin/order-details/${this.currentDetailForCert.OrderDetailID}/certificates`, {
                    codes: this.certificateCodes
                });

                if (response.data.status === 'success') {
                    // Actualizamos el estado local para que el botón cambie a "Ver/Editar Códigos"
                    this.currentDetailForCert.certificates = response.data.certificates;
                    
                    this.mostrarNotificacion('Éxito', 'Códigos de autenticidad guardados.', 'success');
                    this.closeCertModal();
                }
            } catch (error) {
                console.error("Error guardando certificados:", error);
                this.mostrarNotificacion('Error', 'No se pudieron guardar los códigos', 'error');
            } finally {
                this.isSavingCerts = false;
            }
        },
        // --- API & DATA ---
        async getOrders() {
            this.cargando = true;
            try {
                // Asumiendo que crearás esta ruta en Laravel para Admins
                // Route: /api/admin/orders
                const response = await axios.get('/admin/orders', {
                    params: {
                        page: this.currentPage,
                        search: this.filters.search,
                        status: this.filters.status
                    }
                });

                const data = response.data;
                this.orders = data.data;

                // Paginación
                this.from = data.from;
                this.to = data.to;
                this.total = data.total;
                this.currentPage = data.current_page;
                this.totalPages = data.last_page;

            } catch (error) {
                console.error("Error cargando pedidos:", error);
                this.mostrarNotificacion('Error', 'No se pudieron cargar los pedidos', 'error');
            } finally {
                this.cargando = false;
            }
        },

        // Debounce para búsqueda (espera que el usuario deje de escribir)
        debouncedGetOrders: _.debounce(function () {
            this.currentPage = 1; // Resetear a pag 1 al buscar
            this.getOrders();
        }, 500),

        // --- ACCIONES ---
        viewOrder(order) {
            this.orderView = order;
            this.vista = 'detalle';
            window.scrollTo(0, 0);
        },

        closeView() {
            this.vista = 'listado';
            this.orderView = {};
        },

        async updateOrderStatus() {
            // Ejemplo de cambio de estado manual por admin
            const { value: newStatus } = await Swal.fire({
                title: 'Actualizar Estado',
                input: 'select',
                inputOptions: {
                    'pending': 'Pendiente',
                    'paid': 'Pagado',
                    'shipped': 'Enviado',
                    'delivered': 'Entregado',
                    'cancelled': 'Cancelado'
                },
                inputPlaceholder: 'Selecciona un estado',
                showCancelButton: true,
                inputValue: this.orderView.payment_status
            });

            if (newStatus) {
                this.cargando = true;
                try {
                    await axios.put(`/admin/orders/${this.orderView.OrderID}/status`, { status: newStatus });
                    this.orderView.payment_status = newStatus; // Actualizar vista local
                    this.mostrarNotificacion('Éxito', 'Estado actualizado', 'success');
                    this.getOrders(); // Actualizar lista en background
                } catch (e) {
                    this.mostrarNotificacion('Error', 'No se pudo actualizar', 'error');
                } finally {
                    this.cargando = false;
                }
            }
        },

        exportOrders() {
            // Lógica para descargar Excel/PDF
            window.open('/admin/orders/export', '_blank');
        },

        // --- HELPERS VISUALES ---
        formatDate(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleDateString('es-PE', {
                year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });
        },

        getStatusLabel(status) {
            const labels = {
                'paid': 'Pagado',
                'pending': 'Pendiente',
                'cancelled': 'Cancelado',
                'shipped': 'Enviado',
                'delivered': 'Entregado'
            };
            return labels[status] || status;
        },

        getStatusBadgeClass(status) {
            const classes = {
                'paid': 'bg-success-light text-success',
                'pending': 'bg-warning-light text-warning',
                'cancelled': 'bg-danger-light text-danger',
                'shipped': 'bg-info-light text-info',
                'delivered': 'bg-primary-skinly text-white' // Entregado usa el color corporativo
            };
            return classes[status] || 'bg-light text-secondary';
        },

        getImage(detail) {
            // Reutilizamos tu lógica robusta de imágenes
            let snapshot = detail.product_snapshot;
            if (typeof snapshot === 'string') {
                try { snapshot = JSON.parse(snapshot); } catch (e) { }
            }
            if (snapshot && snapshot.image) {
                let img = snapshot.image;
                if (!img.startsWith('/') && !img.startsWith('http')) img = '/' + img;
                return img;
            }
            return '/images/placeholder.jpg';
        },

        mostrarNotificacion(title, text, icon) {
            Swal.fire({ title, text, icon, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        },

        // --- PAGINACIÓN ---
        prevPage() { if (this.currentPage > 1) { this.currentPage--; this.getOrders(); } },
        nextPage() { if (this.currentPage < this.totalPages) { this.currentPage++; this.getOrders(); } },
        goToPage(p) { if (p >= 1 && p <= this.totalPages) { this.currentPage = p; this.getOrders(); } }
    }
};
</script>

<style scoped>
/* =========================================
   ESTILOS GENERALES (HEREDADOS DE SKINLY)
   ========================================= */
.skinly-font {
    font-family: 'Public Sans', sans-serif;
    color: #4A4A4A;
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
   CONTROLES Y BUSCADOR
   ========================================= */
.search-wrapper {
    position: relative;
    width: 100%;
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
    height: 45px;
    /* Altura uniforme */
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
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(0, 126, 171, 0.3);
}

.text-primary-skinly {
    color: #007EAB !important;
}

/* =========================================
   TABLA Y BADGES
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
    transition: background-color 0.2s;
}

.skinly-table tbody tr:hover {
    background-color: #fcfcfc;
    border-left: 3px solid #007EAB;
}

.btn-action {
    font-size: 1.1rem;
    transition: transform 0.2s;
}

.btn-action:hover {
    transform: scale(1.1);
}

/* Badges de Estado Personalizados */
.badge-status {
    padding: 6px 12px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bg-success-light {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.bg-warning-light {
    background-color: #fff8e1;
    color: #f57f17;
}

.bg-danger-light {
    background-color: #ffebee;
    color: #c62828;
}

.bg-info-light {
    background-color: #e3f2fd;
    color: #1565c0;
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
    background: transparent;
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
    transform: none;
}

/* =========================================
   ANIMACIONES Y EXTRAS
   ========================================= */
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

/* Preloader simple (para que no falle si no tienes el global) */
.preloader {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 100;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader {
    width: 48px;
    height: 48px;
    border: 5px solid #007EAB;
    border-bottom-color: transparent;
    border-radius: 50%;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>