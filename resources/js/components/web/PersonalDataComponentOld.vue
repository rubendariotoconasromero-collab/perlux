<template>
  <div class="dashboard-container">
    <div class="sidebar">
      <h1 class="greeting">HOLA JESSICA</h1>
      <ul class="menu">
        <li :class="{ active: activeSection === 'personal' }" @click="setSection('personal')">
          <i class="icon-user"></i> Datos Personales <i class="arrow">></i>
        </li>
        <li :class="{ active: activeSection === 'addresses' }" @click="setSection('addresses')">
          <i class="icon-location"></i> Direcciones <i class="arrow">></i>
        </li>
        <li :class="{ active: activeSection === 'payments' }" @click="setSection('payments')">
          <i class="icon-card"></i> Medios de Pago <i class="arrow">></i>
        </li>
        <li :class="{ active: activeSection === 'favorites' }" @click="setSection('favorites')">
          <i class="icon-heart"></i> Mis favoritos <i class="arrow">></i>
        </li>
        <li :class="{ active: activeSection === 'purchases' }" @click="setSection('purchases')">
          <i class="icon-box"></i> Mis compras <i class="arrow">></i>
        </li>
        <li :class="{ active: activeSection === 'account' }" @click="setSection('account')">
          <i class="icon-account"></i> Mi cuenta <i class="arrow">></i>
        </li>
        <li @click="setSection('help')">
          <i class="icon-help"></i> Ayuda <i class="arrow">></i>
        </li>
        <li @click="logout">
          <i class="icon-logout"></i> Cerrar sesión <i class="arrow">></i>
        </li>
        <li class="gift-card" @click="setSection('giftcard')">
          <i class="icon-gift"></i> Gift Card <i class="arrow">></i>
        </li>
      </ul>
    </div>
    <div class="content">
      <div v-if="activeSection === 'personal'">
        <h2>Datos Personales</h2>
        <form>
          <div class="form-group">
            <label>Correo*</label>
            <input type="email" placeholder="Tu Correo @email" />
          </div>
          <div class="form-group">
            <label>Nombre*</label>
            <input type="text" placeholder="Ingresa tu nombre" />
          </div>
          <div class="form-group">
            <label>Apellidos*</label>
            <input type="text" placeholder="Ingresa apellidos" />
          </div>
          <div class="form-group">
            <label>Celular*</label>
            <input type="tel" placeholder="+51 0000000000" />
          </div>
          <div class="form-group">
            <label>Tipo de documento*</label>
            <select>
              <option>DNI / Documento de identidad</option>
            </select>
          </div>
          <button class="save-btn">Guardar</button>
        </form>
      </div>
      <div v-if="activeSection === 'addresses'">
        <h2>Direcciones</h2>
        <div class="address-list">
          <div class="address-item default">
            <span class="dot default-dot"></span> Dpto., Número, Avenida, Distrito, Provincia, Departamento <span class="remove">X</span>
          </div>
          <div class="address-item">
            <span class="dot"></span> Dpto., Número, Avenida, Distrito, Provincia, Departamento <span class="remove">X</span>
          </div>
        </div>
        <div class="add-address">
          <h3>Agrega una dirección ▼</h3>
          <p>Ingresa tu ubicación y te mostraremos los productos disponibles con tiempos y costos de entrega precisos.</p>
          <div class="form-row">
            <div class="form-group half">
              <label>Departamento</label>
              <select>
                <option>Selecciona tu departamento</option>
              </select>
            </div>
            <div class="form-group half">
              <label>Provincia</label>
              <select>
                <option>Selecciona una provincia</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group half">
              <label>Distrito</label>
              <select>
                <option>Selecciona un distrito</option>
              </select>
            </div>
            <div class="form-group half">
              <label>Avenida / Calle / Jirón</label>
              <input type="text" placeholder="Ingresa el nombre de la calle" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group half">
              <label>Número</label>
              <input type="text" placeholder="Ingresa el número de la calle" />
            </div>
            <div class="form-group half">
              <label>Dpto / Interior / Piso / Lote (Opcional)</label>
              <input type="text" placeholder="Ejm. Casa3, dpto 101" />
            </div>
          </div>
          <button class="add-btn">Agregar</button>
        </div>
      </div>
      <div v-if="activeSection === 'favorites'">
        <h2>Mis favoritos</h2>
        <div class="product-grid">
          <div class="product-card">
            <img src="placeholder-shoe1.jpg" alt="Zapato Perlux" />
            <p>Zapato Perlux</p>
            <p>S/1000</p>
            <button>COMPRAR AHORA</button>
          </div>
          <div class="product-card">
            <img src="placeholder-shoe2.jpg" alt="Zapato Perlux" />
            <p>Zapato Perlux</p>
            <p>S/1000</p>
            <button>COMPRAR AHORA</button>
          </div>
          <div class="product-card">
            <img src="placeholder-shoe3.jpg" alt="Zapato Perlux" />
            <p>Zapato Perlux</p>
            <p>S/1000</p>
            <button>COMPRAR AHORA</button>
          </div>
        </div>
      </div>
      <div v-if="activeSection === 'purchases'">
        <h2>Mis compras</h2>
        <p>1 de octubre del 2025</p>
        <div class="order-item">
          <img src="placeholder-shoe4.jpg" alt="Shoe" />
          <div>
            <p>Compras N° 2602539237</p>
            <p>Entregado el viernes 11 de octubre.</p>
            <p>S/100</p>
            <button class="review-btn">Revisar detalle</button>
            <button class="rebuy-btn">Compra de nuevo</button>
          </div>
        </div>
        <div class="order-item">
          <img src="placeholder-shoe5.jpg" alt="Shoe" />
          <div>
            <p>Compras N° 2602539237</p>
            <p>Entregado el viernes 11 de octubre.</p>
            <p>S/100</p>
            <button class="review-btn">Revisar detalle</button>
            <button class="rebuy-btn">Compra de nuevo</button>
          </div>
        </div>
      </div>
      <div v-if="activeSection === 'account'">
        <h2>Mi cuenta</h2>
        <form>
          <div class="form-group">
            <label>Tu contraseña*</label>
            <input type="password" placeholder="Ingresa tu contraseña" />
          </div>
          <div class="form-group">
            <label>Nueva contraseña*</label>
            <input type="password" placeholder="Ingresa una contraseña" />
          </div>
          <div class="form-group">
            <label>Confirmar contraseña*</label>
            <input type="password" placeholder="Repite la contraseña" />
          </div>
          <button class="save-btn">Guardar</button>
        </form>
      </div>
      <!-- Placeholder for other sections -->
      <div v-if="activeSection === 'payments'">
        <h2>Medios de Pago</h2>
        <!-- Add payment methods form/content here -->
      </div>
      <div v-if="activeSection === 'help'">
        <h2>Ayuda</h2>
        <!-- Add help content here -->
      </div>
      <div v-if="activeSection === 'giftcard'">
        <h2>Gift Card</h2>
        <!-- Add gift card content here -->
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'UserDashboard',
  setup() {
    const activeSection = ref('personal');

    const setSection = (section) => {
      activeSection.value = section;
    };

    const logout = () => {
      // Handle logout logic
      console.log('Logging out');
    };

    return { activeSection, setSection, logout };
  }
};
</script>

<style scoped>
.dashboard-container {
  display: flex;
  min-height: 100vh;
  background: #fff;
}

.sidebar {
  width: 250px;
  padding: 20px;
  border-right: 1px solid #eee;
}

.greeting {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.menu {
  list-style: none;
  padding: 0;
}

.menu li {
  display: flex;
  align-items: center;
  padding: 10px;
  cursor: pointer;
  border-radius: 4px;
  margin-bottom: 5px;
}

.menu li.active {
  background: #000;
  color: #fff;
}

.icon-user::before { content: '👤'; margin-right: 10px; }
.icon-location::before { content: '📍'; margin-right: 10px; }
.icon-card::before { content: '💳'; margin-right: 10px; }
.icon-heart::before { content: '❤️'; margin-right: 10px; }
.icon-box::before { content: '📦'; margin-right: 10px; }
.icon-account::before { content: '⚙️'; margin-right: 10px; }
.icon-help::before { content: '?'; margin-right: 10px; }
.icon-logout::before { content: '⏻'; margin-right: 10px; }
.icon-gift::before { content: '🎁'; margin-right: 10px; }

.arrow {
  margin-left: auto;
}

.gift-card {
  color: #007bff;
  border: 1px solid #007bff;
  border-radius: 4px;
}

.content {
  flex: 1;
  padding: 40px;
}

h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  font-size: 14px;
  margin-bottom: 5px;
}

input, select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 20px;
}

.save-btn, .add-btn {
  background: #fff;
  border: 1px solid #000;
  padding: 10px 20px;
  border-radius: 20px;
  cursor: pointer;
  font-weight: bold;
}

.save-btn:hover, .add-btn:hover {
  background: #f8f8f8;
}

.address-list {
  margin-bottom: 30px;
}

.address-item {
  display: flex;
  align-items: center;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 10px;
}

.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #ccc;
  margin-right: 10px;
}

.default-dot {
  background: #000;
}

.remove {
  margin-left: auto;
  cursor: pointer;
}

.add-address h3 {
  font-size: 16px;
  margin-bottom: 10px;
}

.add-address p {
  font-size: 12px;
  color: #666;
  margin-bottom: 20px;
}

.form-row {
  display: flex;
  gap: 20px;
}

.half {
  flex: 1;
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.product-card {
  text-align: center;
}

.product-card img {
  width: 100%;
  height: auto;
}

.product-card p {
  margin: 5px 0;
}

.product-card button {
  background: #fff;
  border: 1px solid #000;
  padding: 10px;
  width: 100%;
  font-weight: bold;
}

.order-item {
  display: flex;
  margin-bottom: 20px;
  border-bottom: 1px solid #eee;
  padding-bottom: 20px;
}

.order-item img {
  width: 100px;
  height: auto;
  margin-right: 20px;
}

.order-item div {
  flex: 1;
}

.review-btn {
  background: #000;
  color: #fff;
  border: none;
  padding: 10px 20px;
  margin-right: 10px;
}

.rebuy-btn {
  background: #fff;
  border: 1px solid #000;
  padding: 10px 20px;
}
</style>