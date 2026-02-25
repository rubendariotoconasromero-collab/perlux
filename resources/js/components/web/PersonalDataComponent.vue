<template>
    <div>
        <TheHeader :user="user" />

        <div class="container profile-container">
            <div class="row">
                <h4 class="text-uppercase mb-5 fw-bold">hola {{ user.name }}</h4>

                <div class="col-md-3">
                    <div class="list-group">
                        <a href="/user?section=datos" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        :class="{ 'active': activeSection === 'datos' }" 
                        @click.prevent="changeSection('datos')"> <span><i class="far fa-user me-2"></i> Datos Personales</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="/user?section=direcciones" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        :class="{ 'active': activeSection === 'direcciones' }"
                        @click.prevent="changeSection('direcciones')">
                            <span><i class="fas fa-map-marker-alt me-2"></i> Direcciones</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="/user?section=favoritos" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        :class="{ 'active': activeSection === 'favoritos' }"
                        @click.prevent="changeSection('favoritos')">
                            <span><i class="far fa-heart me-2"></i> Mis Favoritos</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="/user?section=pedidos" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        :class="{ 'active': activeSection === 'pedidos' }"
                        @click.prevent="changeSection('pedidos')">
                            <span><i class="fa fa-shopping-bag me-2"></i> Mis Compras</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="/user?section=cuenta" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        :class="{ 'active': activeSection === 'cuenta' }" 
                        @click.prevent="changeSection('cuenta')">
                            <span><i class="fa fa-lock me-2"></i> Mi Cuenta</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="/user?section=help" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        :class="{ 'active': activeSection === 'help' }" 
                        @click.prevent="changeSection('help')">
                            <span><i class="far fa-question-circle me-2"></i> Ayuda</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="#"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-dark fw-bold"
                            @click.prevent="logout">
                            <span>
                                <i class="fa fa-power-off me-2"></i> Cerrar Sesión
                            </span>
                        </a> 
                        

                    </div>
                </div>



                <div class="col-md-9 content-area">

                    <div v-if="activeSection === 'datos'">
                        <h2>Datos Personales</h2>
                        <form @submit.prevent="saveUserData">
                            <div class="mb-3">
                                <label class="form-label">Correo*</label>
                                <input type="email" class="form-control" v-model="userForm.email" disabled required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nombre*</label>
                                <input type="text" class="form-control" v-model="userForm.name"
                                    :disabled="!isEditingUser" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Apellidos*</label>
                                <input type="text" class="form-control" v-model="userForm.last_name"
                                    :disabled="!isEditingUser" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Celular*</label>
                                <input type="tel" class="form-control" v-model="userForm.phone"
                                    :disabled="!isEditingUser" required>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo Doc.*</label>
                                    <select v-model="userForm.document_type" class="form-select form-control"
                                        :disabled="!isEditingUser">
                                        <option value="DNI">DNI</option>
                                        <option value="CE">CE</option>
                                    </select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Número Doc.*</label>
                                    <input type="text" class="form-control" v-model="userForm.dni"
                                        :disabled="!isEditingUser" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="d-flex gap-2">
                                        <button v-if="!isEditingUser" type="button" class="btn btn-primary"
                                            @click="isEditingUser = true">
                                            Editar Datos
                                        </button>
                                        <template v-else>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            <button type="button" class="btn btn-secondary"
                                                @click="cancelEditUser">Cancelar</button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div v-if="activeSection === 'direcciones'">
                        <h2>Direcciones</h2>

                        <div v-if="userAddresses.length > 0" class="mb-4">
                            <h5 class="mb-3 title-directions">Tus direcciones guardadas:</h5>
                            <div v-for="address in userAddresses" :key="address.id" class="mb-3">
                                <div class="address-card border rounded">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-3 my-0">
                                                <input class="form-check-input" type="radio"
                                                    :id="'address_' + address.id" :value="address.id"
                                                    v-model="selectedAddressId">
                                                <label class="form-check-label my-0" :for="'address_' + address.id">
                                                    <span class="visually-hidden">Seleccionar</span>
                                                </label>
                                            </div>
                                            <div>
                                                <div>
                                                    <span>{{ address.street }} {{ address.number }}, </span>
                                                    <span v-if="address.detail"> {{ address.detail }}, </span>
                                                    <span class="text-muted my-0 small">
                                                        {{ address.district }}, {{ address.province }}, {{
                                                        address.department }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 buttons-adresses my-0">
                                            <button class="btn btn-sm btn-outline-primary my-0"
                                                @click="editAddress(address)">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger my-0"
                                                @click="deleteAddress(address.id)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-muted">No tienes direcciones guardadas.</p>
                        </div>

                        <a href="#" @click.prevent="toggleAddressForm" class="title-directions-link">
                            <div class="d-flex align-items-center justify-content-start mt-4">
                                <h5 class="my-0 title-directions">{{ editingAddress ? 'Editar dirección' : 'Agrega una dirección' }}</h5>
                                <i class="fas fa-chevron-down my-0 py-0 icon-rotate ms-3"
                                    :class="{ 'rotate': showAddressForm }"></i>
                            </div>
                        </a>
                        <p style="font-weight: 300; margin-bottom:10px;" class="small text-muted">
                            Ingresa tu ubicación y te mostraremos los productos disponibles.
                        </p>

                        <transition name="slide-fade">
                            <div v-if="showAddressForm" class="section-new-direction">
                                <form @submit.prevent="saveAddress" class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Departamento</label>
                                        <select class="form-control form-select" v-model="newAddress.department"
                                            @change="onDepartmentChange" required>
                                            <option value="" disabled>Selecciona</option>
                                            <option v-for="dept in departmentsList" :key="dept" :value="dept">{{ dept }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Provincia</label>
                                        <select class="form-control form-select" v-model="newAddress.province"
                                            @change="onProvinceChange" :disabled="!newAddress.department" required>
                                            <option value="" disabled>Selecciona</option>
                                            <option v-for="prov in provincesList" :key="prov" :value="prov">{{ prov }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Distrito</label>
                                        <input type="text" class="form-control" v-model="newAddress.district"
                                            placeholder="Escribe tu distrito" :disabled="!newAddress.province" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Calle / Av / Jr</label>
                                        <input type="text" class="form-control" v-model="newAddress.street"
                                            placeholder="Nombre de la vía" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Número</label>
                                        <input type="text" class="form-control" v-model="newAddress.number"
                                            placeholder="N°" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Referencia / Interior</label>
                                        <input type="text" class="form-control" v-model="newAddress.detail"
                                            placeholder="Opcional">
                                    </div>

                                    <div class="col-12 d-flex gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            {{ editingAddress ? 'Actualizar' : 'Agregar' }}
                                        </button>
                                        <button type="button" class="btn btn-secondary" @click="cancelAddressForm"
                                            v-if="showAddressForm">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </transition>
                    </div>

                    <div v-if="activeSection === 'favoritos'">
                        <h2>Mis Favoritos</h2>
                        <div v-if="favorites.length === 0" class="text-center py-5 bg-light rounded">
                            <i class="far fa-heart fa-3x mb-3 text-muted"></i>
                            <p class="text-muted">Aún no tienes favoritos.</p>
                            <a href="/glam" class="btn btn-outline-dark">Ir a comprar</a>
                        </div>
                        <div v-else class="row">
                            <div class="col-md-4 mb-4" v-for="item in favorites" :key="item.ProductID">
                                <div class="card h-100 shadow-sm product-card border-0">
                                    <img :src="item.images[0]?.ImagePath" class="card-img-top img-fluid"
                                        style="height: 300px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-size: 1rem;">{{ item.Name }}</h5>
                                        <p class="card-text fw-bold">S/{{ item.Price }}</p>
                                        <button class="btn btn-outline-danger btn-sm w-100"
                                            @click="removeFavoriteFromProfile(item)">
                                            Quitar de favoritos
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'pedidos'">
                        <h2 class="mb-4">Mis Compras</h2>

                        <div v-if="purchases.length === 0" class="text-center py-5 bg-light rounded">
                            <i class="fa fa-shopping-bag fa-3x mb-3 text-muted opacity-50"></i>
                            <p class="text-muted">No tienes compras registradas aún.</p>
                            <a href="/glam" class="btn btn-dark px-4 mt-2">Ir a la tienda</a>
                        </div>

                        <!-- <div v-else class="orders-list">
                            <div v-for="order in purchases" :key="order.OrderID" class="card border-0 shadow-sm mb-4 order-card">
                                
                                <div class="card-header bg-white border-bottom p-3 d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <span class="text-uppercase small text-muted fw-bold">Pedido #{{ order.external_reference }}</span>
                                        <span class="small text-muted">{{ formatDate(order.created_at) }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge rounded-pill mb-1" :class="getStatusClass(order.payment_status)">
                                            {{ getStatusText(order.payment_status) }}
                                        </span>
                                        <div class="fw-bold text-dark">Total: S/ {{ order.total_amount }}</div>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <div v-for="detail in order.order_details" :key="detail.OrderDetailID" class="list-group-item p-3 border-0 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 order-img-wrapper bg-light rounded overflow-hidden">
                                                    <img :src="getOrderImage(detail)" alt="Producto" class="img-fluid">
                                                </div>
                                                
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 product-title-order">{{ detail.product_name }}</h6>
                                                    
                                                    <div class="small text-muted mb-1" v-if="detail.product_snapshot">
                                                        <span v-if="detail.product_snapshot.color">
                                                            Color: {{ detail.product_snapshot.color }}
                                                        </span>
                                                        <span v-if="detail.product_snapshot.size" class="ms-2 border-start ps-2">
                                                            Talla: {{ detail.product_snapshot.size }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <span class="small bg-light px-2 py-1 rounded text-dark">
                                                            Cant: {{ detail.quantity }}
                                                        </span>
                                                        <span class="fw-bold small">S/ {{ detail.unit_price }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-0 p-3 text-end">
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Ver Factura</button>
                                </div>
                            </div>
                        </div> -->
                        <div v-else class="orders-list">
                            <div v-for="order in purchases" :key="order.OrderID" class="card border-0 shadow-sm mb-3">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        
                                        <div class="col-3 col-md-2">
                                            <div class="bg-light rounded overflow-hidden d-flex align-items-center justify-content-center" style="height: 80px; width: 80px;">
                                                <img :src="getOrderThumbnail(order)" class="img-fluid" style="height:100%; width:100%; object-fit:cover;">
                                            </div>
                                        </div>

                                        <div class="col-9 col-md-6">
                                            <h6 class="mb-1 fw-bold text-dark">Pedido N° {{ order.external_reference }}</h6>
                                            <p class="text-muted small mb-1">
                                                Realizado el {{ formatDate(order.created_at) }}
                                            </p>
                                            <div class="d-md-none fw-bold mt-2">S/ {{ order.total_amount }}</div> </div>

                                        <div class="col-md-2 d-none d-md-block text-center">
                                            <h5 class="fw-bold m-0">S/ {{ order.total_amount }}</h5>
                                        </div>

                                        <div class="col-12 col-md-2 mt-3 mt-md-0 d-flex flex-column gap-2">
                                            <button class="btn btn-dark btn-sm w-100" @click="openOrderDetail(order)">
                                                Revisar detalle
                                            </button>
                                            <button class="btn btn-outline-dark btn-sm w-100" @click="buyAgain(order)">
                                                Compra de nuevo
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'cuenta'">
                        <h2>Mi Cuenta</h2>
                        <form @submit.prevent="updatePassword" style="max-width: 500px;">
                            <div class="mb-3">
                                <label class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" v-model="passwordForm.password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" v-model="passwordForm.newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar Nueva</label>
                                <input type="password" class="form-control" v-model="passwordForm.confirmPassword"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                        </form>
                    </div>

                    <div v-if="activeSection === 'help'">
                        <h2>Ayuda</h2>
                        <p>Contáctanos en <a href="mailto:contacto@perlux.com">contacto@perlux.com</a>.</p>
                    </div>

                </div>
            </div>
        </div>

        <TheFooter />
    </div>

    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold" v-if="selectedOrder">Pedido #{{ selectedOrder.external_reference }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4" v-if="selectedOrder">
                
                <div class="d-flex justify-content-between align-items-center mb-4 bg-light p-3 rounded">
                    <div>
                        <small class="text-muted d-block">Estado</small>
                        <span class="badge" :class="getStatusClass(selectedOrder.payment_status)">
                            {{ getStatusText(selectedOrder.payment_status) }}
                        </span>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Total Pagado</small>
                        <span class="h5 fw-bold m-0">S/ {{ selectedOrder.total_amount }}</span>
                    </div>
                </div>

                <h6 class="fw-bold mb-3">Productos comprados:</h6>
                <div class="list-group">
                    <div v-for="detail in selectedOrder.order_details" :key="detail.OrderDetailID" class="list-group-item border-0 border-bottom px-0 py-3">
                        <div class="d-flex align-items-center">
                            <div style="width: 60px; height: 60px;" class="bg-light rounded overflow-hidden me-3">
                                <img :src="getOrderImage(detail)" class="img-fluid w-100 h-100" style="object-fit:cover;">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-0">{{ detail.product_name }}</h6>
                                    <span class="fw-bold">S/ {{ detail.subtotal }}</span>
                                </div>
                                <small class="text-muted d-block">
                                    Cant: {{ detail.quantity }} x S/ {{ detail.unit_price }}
                                </small>
                                <div class="small text-muted" v-if="detail.product_snapshot">
                                    <span v-if="detail.product_snapshot.color">Color: {{ detail.product_snapshot.color }}</span>
                                    <span v-if="detail.product_snapshot.size" class="ms-2">| Talla: {{ detail.product_snapshot.size }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold">Dirección de Envío</h6>
                    <p class="text-muted small mb-0">{{ selectedOrder.shipping_address }}</p>
                    <p class="text-muted small">Tel: {{ selectedOrder.customer_phone }}</p>
                </div>

            </div>
            
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';
import { ref, reactive, onMounted } from 'vue';

// DATA REAL: DEPARTAMENTOS Y PROVINCIAS (Mismo que en Registro)
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
    components: { TheHeader, TheFooter },
    props: {
        user: { type: Object, required: true },
        initialSection: { type: String, default: 'datos' }
    },
    data() {
        return {
            selectedOrder: null,
            activeSection: 'datos',
            isEditingUser: false,
            userForm: {},

            // Direcciones
            userAddresses: [],
            showAddressForm: false,
            editingAddress: null,
            selectedAddressId: null,
            newAddress: { department: '', province: '', district: '', street: '', number: '', detail: '' },

            // Ubigeo Lists
            departmentsList: [],
            provincesList: [],

            // Favoritos y Compras
            favorites: [],
            purchases: [],

            // Password
            passwordForm: { password: '', newPassword: '', confirmPassword: '' }
        };
    },
    watch: {
        initialSection(newVal) {
            if (newVal) this.activeSection = newVal;
        }
    },
    methods: {
        getOrderThumbnail(order) {
            if (order.order_details && order.order_details.length > 0) {
                // Reutilizamos tu función getOrderImage pasándole el primer detalle
                return this.getOrderImage(order.order_details[0]);
            }
            return '/images/placeholder.jpg';
        },

        // 2. Abrir Modal
        openOrderDetail(order) {
            this.selectedOrder = order;
            // Abrir modal de Bootstrap mediante JS (asegúrate de tener bootstrap.js cargado)
            const modalEl = document.getElementById('orderDetailModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        },

        // 3. Comprar de nuevo (Recargar Carrito)
        buyAgain(order) {
            Swal.fire({
                title: '¿Repetir pedido?',
                text: "Esto agregará todos los productos de este pedido a tu carrito actual.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar al carrito',
                confirmButtonColor: '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    // Obtenemos el carrito actual
                    let currentCart = JSON.parse(localStorage.getItem('products')) || [];

                    // Recorremos los items del pedido antiguo
                    order.order_details.forEach(detail => {
                        // Reconstruimos el objeto producto para el carrito
                        // NOTA: Aquí asumimos que el producto sigue existiendo.
                        // Idealmente deberías validar stock antes, pero esto es un atajo rápido.
                        
                        let snapshot = detail.product_snapshot;
                        if (typeof snapshot === 'string') {
                            try { snapshot = JSON.parse(snapshot); } catch (e) {}
                        }

                        const itemToAdd = {
                            ProductID: detail.ProductID,
                            Name: detail.product_name,
                            Price: detail.unit_price,
                            quantity: detail.quantity,
                            image: this.getOrderImage(detail), // Usamos la imagen guardada
                            // Reconstruir estructura de variantes para que el Checkout la entienda
                            selectedVariant: {
                                color: { ColorName: snapshot?.color || 'N/A' },
                                size: { SizeName: snapshot?.size || 'N/A', SizeID: detail.SizeID } 
                                // OJO: Necesitas guardar SizeID y ColorID en snapshot si quieres exactitud total al re-comprar, 
                                // o confiar en que el backend valida por texto.
                            }
                        };
                        
                        currentCart.push(itemToAdd);
                    });

                    // Guardar y notificar
                    localStorage.setItem('products', JSON.stringify(currentCart));
                    window.dispatchEvent(new Event('cart-updated')); // Actualiza el header
                    
                    Swal.fire('¡Listo!', 'Productos agregados al carrito', 'success');
                    // Opcional: Redirigir al checkout
                    // window.location.href = '/checkout';
                }
            });
        },
        // 1. Cargar Compras desde Laravel
        async loadPurchases() {
            try {
                const response = await axios.get('/user/orders');
                this.purchases = response.data;
            } catch (error) {
                console.error("Error cargando pedidos:", error);
            }
        },

        // 2. Helpers Visuales
        formatDate(dateString) {
            if (!dateString) return '';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('es-PE', options);
        },

        getStatusClass(status) {
            switch (status) {
                case 'paid': return 'bg-success';      // Verde
                case 'pending': return 'bg-warning text-dark'; // Amarillo
                case 'cancelled': return 'bg-danger';  // Rojo
                default: return 'bg-secondary';
            }
        },

        getStatusText(status) {
            switch (status) {
                case 'paid': return 'Pagado';
                case 'pending': return 'Pendiente';
                case 'cancelled': return 'Cancelado';
                default: return status;
            }
        },

        getOrderImage(detail) {
            // Intentamos sacar la imagen del snapshot guardado al comprar
            if (detail.product_snapshot && detail.product_snapshot.image) {
                return detail.product_snapshot.image;
            }
            // Fallback
            return '/images/default-image.png';
        },
        changeSection(sectionName) {
            this.activeSection = sectionName;
            
            // Actualiza la URL visualmente (ej: /user?section=pedidos)
            const newUrl = `${window.location.pathname}?section=${sectionName}`;
            window.history.pushState({ path: newUrl }, '', newUrl);
        },
        // --- USUARIO ---
        loadUserData() {
            if (this.user) {
                this.userForm = JSON.parse(JSON.stringify(this.user)); // Copia profunda
                // Cargar direcciones iniciales si vienen en el user
                if (this.user.addresses) this.userAddresses = this.user.addresses;
                else this.loadUserAddresses(); // Si no, intentar cargarlas por API
            }
        },
        cancelEditUser() {
            this.isEditingUser = false;
            this.loadUserData();
        },
        async saveUserData() {
            try {
                const response = await axios.put('/user/profile', this.userForm);
                if (response.data.success) {
                    this.mostrarNotificacion('¡Listo!', 'Datos actualizados', 'success');
                    this.isEditingUser = false;
                }
            } catch (error) {
                this.mostrarNotificacion('Error', 'No se pudieron guardar los cambios', 'error');
            }
        },

        // --- DIRECCIONES & UBIGEO ---
        loadDepartments() {
            this.departmentsList = ubigeoPeru.map(d => d.department);
        },
        onDepartmentChange() {
            this.newAddress.province = '';
            const selected = ubigeoPeru.find(d => d.department === this.newAddress.department);
            this.provincesList = selected ? selected.provinces : [];
        },
        onProvinceChange() {
            // Nada especial, el distrito es texto libre
        },
        async loadUserAddresses() {
            try {
                const response = await axios.get('/user/addresses');
                this.userAddresses = response.data;
            } catch (error) { console.error(error); }
        },
        toggleAddressForm() {
            this.showAddressForm = !this.showAddressForm;
            if (!this.showAddressForm) this.resetAddressForm();
        },
        editAddress(address) {
            this.editingAddress = address;
            this.newAddress = { ...address }; // Copia
            // Cargar provincias para el departamento de la dirección a editar
            const selectedDept = ubigeoPeru.find(d => d.department === address.department);
            this.provincesList = selectedDept ? selectedDept.provinces : [];

            this.showAddressForm = true;
        },
        resetAddressForm() {
            this.newAddress = { department: '', province: '', district: '', street: '', number: '', detail: '' };
            this.editingAddress = null;
            this.provincesList = [];
        },
        cancelAddressForm() {
            this.showAddressForm = false;
            this.resetAddressForm();
        },
        async saveAddress() {
            try {
                let res;
                if (this.editingAddress) {
                    res = await axios.put(`/user/addresses/${this.editingAddress.id}`, this.newAddress);
                } else {
                    res = await axios.post('/user/addresses', this.newAddress);
                }
                if (res.data.success) {
                    this.mostrarNotificacion('¡Éxito!', 'Dirección guardada', 'success');
                    await this.loadUserAddresses();
                    this.cancelAddressForm();
                }
            } catch (error) {
                this.mostrarNotificacion('Error', 'No se pudo guardar la dirección', 'error');
            }
        },
        async deleteAddress(id) {
            Swal.fire({
                title: '¿Eliminar?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Sí, eliminar', confirmButtonColor: '#000'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.delete(`/user/addresses/${id}`);
                        this.loadUserAddresses();
                        this.mostrarNotificacion('Eliminado', 'Dirección eliminada', 'success');
                    } catch (e) { this.mostrarNotificacion('Error', 'No se pudo eliminar', 'error'); }
                }
            });
        },

        // --- FAVORITOS ---
        loadFavorites() {
            const saved = localStorage.getItem('favorites');
            this.favorites = saved ? JSON.parse(saved) : [];
        },
        removeFavoriteFromProfile(item) {
            this.favorites = this.favorites.filter(f => f.ProductID !== item.ProductID);
            localStorage.setItem('favorites', JSON.stringify(this.favorites));
            window.dispatchEvent(new Event('favorites-updated'));
        },

        // --- CUENTA ---
        async updatePassword() {
            if (this.passwordForm.newPassword !== this.passwordForm.confirmPassword) {
                this.mostrarNotificacion('Error', 'Las contraseñas no coinciden', 'error');
                return;
            }
            try {
                const res = await axios.put('/user/password', this.passwordForm);
                this.mostrarNotificacion('¡Éxito!', 'Contraseña actualizada', 'success');
                this.passwordForm = { password: '', newPassword: '', confirmPassword: '' };
            } catch (e) {
                this.mostrarNotificacion('Error', e.response?.data?.message || 'Error al actualizar', 'error');
            }
        },

        // --- LOGOUT ---
        logout() {
            Swal.fire({
                title: '¿Cerrar sesión?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Sí, salir', confirmButtonColor: '#000'
            }).then(async (res) => {
                if (res.isConfirmed) {
                    await axios.post('/logout');
                    localStorage.removeItem('favorites'); // Limpiar favoritos locales al salir
                    window.location.href = '/';
                }
            });
        },

        mostrarNotificacion(title, text, icon) {
            Swal.fire({ title, text, icon, toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
        }
    },
    mounted() {
        // [LÓGICA NUEVA] Detectar parámetro en la URL al cargar
        this.loadPurchases();
        const urlParams = new URLSearchParams(window.location.search);
        const sectionParam = urlParams.get('section');

        // Si hay parámetro en URL lo usamos, si no, usamos el valor por defecto
        if (sectionParam) {
            this.activeSection = sectionParam;
        } else {
            this.activeSection = this.initialSection || 'datos';
        }
        this.loadUserData();
        this.loadDepartments(); // Cargar ubigeo
        this.loadFavorites();
        if (!this.userAddresses.length) this.loadUserAddresses();
    }
};
</script>

<style scoped>
/* =========================================
   ESTILOS GENERALES (DISEÑO ORIGINAL)
   ========================================= */
.profile-container {
    padding-top: 140px;
    /* Header fijo compensación */
    padding-bottom: 80px;
    min-height: 80vh;
    background-color: #fff;
}

/* Sidebar Menu */
.list-group-item {
    border: 1px solid #ececec;
    padding: 1.2rem 1.25rem;
    background-color: transparent;
    color: #000;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border-radius: 0;
    margin-bottom: -1px;
    /* Colapsar bordes dobles */
}

.list-group-item:hover {
    background-color: #bebebe;
    color: #000;
    border-color: #bebebe;
}

.list-group-item.active {
    background-color: #000;
    border-color: #000;
    color: #fff;
}

/* Content Area */
.content-area {
    padding-left: 4rem;
    /* Padding original */
}

h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #000;
}

/* Formularios */
.form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.25rem;
}

.form-control,
.form-select {
    border: 1px solid #000;
    border-radius: 0.6rem;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    color: #333;
}

.form-control:focus,
.form-select:focus {
    border-color: #4586bb;
    box-shadow: 0 0 5px #4586bb;
    outline: none;
}

/* Botones */
.btn-primary {
    background-color: #fff;
    color: #000;
    border: 1px solid #000;
    padding: 0.5rem 1.5rem;
    font-size: 1rem;
    border-radius: 0.6rem;
    font-weight: 700;
    transition: background-color 0.3s ease;
    width: 100%;
}

.btn-primary:hover {
    background-color: #000;
    color: #fff;
}

.btn-secondary {
    background-color: #494949;
    color: #fff;
    border: 1px solid #494949;
    border-radius: 0.6rem;
    width: 100%;
}

/* Direcciones Cards */
.address-card {
    padding: 5px 15px;
    border: 1px solid #e0e0e0;
}

.title-directions-link {
    text-decoration: none;
    color: inherit;
}

.title-directions {
    color: #000;
    font-size: 1.1rem;
    font-weight: 600;
}

/* Icon rotation */
.icon-rotate {
    transition: transform 0.3s ease;
}

.icon-rotate.rotate {
    transform: rotate(180deg);
}

/* Animation */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* Buttons inside address card */
.btn-outline-primary,
.btn-outline-danger {
    border: none;
    background: transparent;
    padding: 5px;
}

.btn-outline-primary {
    color: #000;
}

.btn-outline-danger {
    color: #000;
}

.btn-outline-primary:hover,
.btn-outline-danger:hover {
    background: #f0f0f0;
}

/* Estilos para la sección de pedidos */
.order-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.order-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
}

.order-img-wrapper {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.order-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-title-order {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

/* Colores de estado personalizados si Bootstrap no te convence */
.bg-success { background-color: #198754 !important; } /* Verde Pagado */
.bg-warning { background-color: #ffc107 !important; } /* Amarillo Pendiente */
.bg-danger { background-color: #dc3545 !important; }  /* Rojo Cancelado */

/* Responsive */
@media (max-width: 991px) {
    .profile-container {
        padding-top: 120px;
    }

    .content-area {
        padding-left: 0;
        margin-top: 2rem;
    }

    .col-md-9 {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>