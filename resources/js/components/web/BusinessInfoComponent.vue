<template>
  <div>
    <TheHeader :user="user" />

    <div class="business-container container">
      <div class="row">
        <div class="col-12 mb-5 text-center">
          <h1 class="text-uppercase fw-bold page-title">Políticas de la Tienda</h1>
          <p class="text-muted">Todo lo que necesitas saber sobre nuestros procesos y políticas.</p>
        </div>

        <div class="col-md-3 mb-5">
          <div class="list-group sticky-top" style="top: 160px; z-index: 1;">
            
            <a href="/libro-reclamaciones" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              <span><i class="fas fa-book me-2"></i> Libro de Reclamaciones</span>
              <i class="fas fa-external-link-alt small"></i>
            </a>

            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
              :class="{ 'active': activeSection === 'envios' }" @click="activeSection = 'envios'">
              <span><i class="fas fa-shipping-fast me-2"></i> Tiempos de Envío</span>
              <i class="fas fa-chevron-right"></i>
            </button>

            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
              :class="{ 'active': activeSection === 'cambios' }" @click="activeSection = 'cambios'">
              <span><i class="fas fa-exchange-alt me-2"></i> Cambios y Devoluciones</span>
              <i class="fas fa-chevron-right"></i>
            </button>

            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
              :class="{ 'active': activeSection === 'terminos' }" @click="activeSection = 'terminos'">
              <span><i class="fas fa-file-contract me-2"></i> Términos y Condiciones</span>
              <i class="fas fa-chevron-right"></i>
            </button>

            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
              :class="{ 'active': activeSection === 'privacidad' }" @click="activeSection = 'privacidad'">
              <span><i class="fas fa-user-shield me-2"></i> Políticas de Privacidad</span>
              <i class="fas fa-chevron-right"></i>
            </button>

            <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
              :class="{ 'active': activeSection === 'certificado' }" @click="activeSection = 'certificado'">
              <span><i class="fas fa-certificate me-2"></i> Certificado de Autenticidad</span>
              <i class="fas fa-chevron-right"></i>
            </button>

          </div>
        </div>

        <div class="col-md-9 content-area">
          
          <div v-if="activeSection === 'envios'" class="info-section fade-in">
            <h2 class="section-title">Política de Envío</h2>
            <p class="lead text-muted fst-italic mb-4">
              En PERLUX, cada entrega refleja nuestro compromiso con la excelencia. Comprendemos que cada pedido es más que una compra: es una expresión de estilo, cultura y confianza. Por eso cuidamos cada etapa del proceso, desde la confirmación hasta la entrega, para que tu experiencia gratificante.
            </p>

            <h4 class="fw-bold mt-4">Plazos de Entrega</h4>
            <ul class="custom-list">
              <li><strong>Para Lima Metropolitana y Callao:</strong> Una vez confirmada tu compra, el despacho se realiza en un plazo máximo de <strong>72 horas hábiles</strong>.</li>
              <li><strong>Para pedidos con recojo en showroom:</strong> Estarán listos en un máximo de <strong>48 horas hábiles</strong>.</li>
              <li><strong>Para envíos a provincias:</strong> El tiempo de llegada dependerá de la ubicación y del operador logístico asignado con la opción más segura y eficiente.</li>
              <li><strong>Pedidos personalizados:</strong> Si solicitaste un diseño hecho a medida, el tiempo estimado de producción y entrega será de una a dos semanas, dependiendo del modelo. Esta coordinación se realiza directamente con nuestro equipo.</li>
              <li>En campañas especiales o de alta demanda, los tiempos pueden extenderse ligeramente. Te mantendremos informada en todo momento.</li>
            </ul>

            <h4 class="fw-bold mt-4">Tarifas de Envío</h4>
            <ul class="custom-list">
              <li><strong>Envíos dentro de Lima Metropolitana:</strong> El envío es gratuito.</li>
              <li><strong>Envíos a provincias:</strong> El costo va desde <strong>S/20</strong>, ajustándose según el destino y el volumen del pedido.</li>
              <li><strong>Envíos internacionales:</strong> Los impuestos, aranceles y costos de transporte serán asumidos por el cliente. Coordinamos cada envío con especial cuidado.</li>
            </ul>

            <div class="alert alert-light border mt-4">
              <h5 class="alert-heading fw-bold"><i class="fas fa-info-circle me-2"></i>Consideraciones Importantes</h5>
              <ul class="mb-0 small">
                <li>Todos los plazos mencionados se cuentan en días hábiles.</li>
                <li>No realizamos despachos ni entregas los sábados, domingos ni feriados</li>
                <li>Una vez entregado el pedido al Courier, PERLUX no se responsabiliza por retrasos atribuibles al servicio de transporte.</li>
                <li>El Courier realizará hasta dos intentos. Si no se concreta, el pedido retornará a PERLUX y se aplicarán los costos correspondientes.</li>
                <li>Nos reservamos el derecho de variar tarifas o fechas de entrega, siempre con previa comunicación directa con el cliente.</li>
                <li>Al confirmar tu compra, aceptas que la entrega final está bajo responsabilidad del operador logístico asignado.</li>
              </ul>
            </div>
            <p class="text-end mt-4 fw-bold">Gracias por confiar en PERLUX Glam.</p>
          </div>

          <div v-if="activeSection === 'cambios'" class="info-section fade-in">
            <h2 class="section-title">Política de Cambios y Devoluciones</h2>
            
            <h4 class="fw-bold mt-4">Plazos y Condiciones Generales</h4>
            <ul class="custom-list">
              <li>Para compras realizadas en nuestro show room o web puedes solicitar un cambio o devolución dentro de los <strong>30 días</strong> 
                posteriores a la fecha de compra.</li>
              <li>El producto debe estar en estado impecable: sin uso, sin marcas en la suela, sin alteraciones y con su empaque original.</li>
              <li>Es indispensable presentar la boleta, factura o ticket de regalo.</li>
              <li>Esta política aplica únicamente para compras realizadas dentro del territorio peruano.</li>
              <li class="text-dark fw-bold">No hay devoluciones en caso de productos elaborados a pedido personalizado. Solo en caso de fallas de fabricación.</li>
            </ul>

            <hr class="my-4">

            <h4 class="fw-bold">Cambios</h4>
            <ul class="custom-list">
              <li>Puedes realizar un único cambio por talla o por otro modelo disponible.</li>
              <li>El producto será evaluado físicamente antes de confirmar el cambio. Una vez aprobado, podrás elegir otro artículo disponible en stock.</li>
              <li>El precio considerado será el registrado en el comprobante de pago. Si el nuevo producto tiene un valor superior, se deberá abonar la diferencia. 
                En caso de que el nuevo artículo tenga un valor menor, se emitirá una nota de crédito válida por 6 meses, utilizable en una sola compra.</li>
              <li><strong>Fuera de Lima:</strong> Escríbenos a <a href="mailto:atencionalcliente@perluxbyjd.com">atencionalcliente@perluxbyjd.com</a>. Los gastos de envío de retorno no están cubiertos.</li>
            </ul>

            <h4 class="fw-bold mt-4">Tiempos de Reembolso</h4>
            <p>Para solicitar devolución, escribe a nuestro correo. Una vez aprobado tras inspección:</p>
            <ul class="custom-list">
              <li>Podrás optar por el reembolso en el mismo medio de pago o por un crédito en la marca.</li>
              <li><strong>Importante:</strong> Los reembolsos están sujetos a una deducción del <strong>5%</strong> por gastos administrativos y comisiones bancarias.</li>
            </ul>

            <div class="bg-light p-4 rounded mt-4 text-center">
              <h5>¿Estás fuera de Lima?</h5>
              <p class="mb-0">No hay problema. Escríbenos a <a href="mailto:atencionalcliente@perluxbyjd.com" class="fw-bold text-dark">atencionalcliente@perluxbyjd.com</a> y te guiaremos. Recuerda que los costos de envío corren por cuenta del cliente.</p>
            </div>
          </div>

          <div v-if="activeSection === 'terminos'" class="info-section fade-in">
            <h2 class="section-title">Términos y Condiciones</h2>
            <p class="lead text-muted mb-4">
              Bienvenido(a) a PERLUX. Al acceder y realizar una compra a través de nuestro sitio web, redes sociales o showroom, aceptas los presentes Términos y Condiciones, los cuales regulan el uso de nuestros servicios y la relación comercial entre PERLUX y sus clientes.
            </p>

            <div class="terms-content">
              <h5 class="fw-bold mt-4">1. Identificación del titular</h5>
              <p>PERLUX es una marca comercial dedicada a la venta de calzado y accesorios de moda, operando dentro del territorio peruano bajo las disposiciones legales vigentes.</p>

              <h5 class="fw-bold mt-4">2. Uso del sitio web</h5>
              <p>El usuario se compromete a utilizar este sitio únicamente con fines lícitos y de manera responsable. PERLUX se reserva el derecho de restringir el acceso a usuarios que hagan uso indebido del contenido o de los servicios ofrecidos.</p>

              <h5 class="fw-bold mt-4">3. Productos y disponibilidad</h5>
              <p>Todos los productos exhibidos están sujetos a disponibilidad de stock. Las imágenes son referenciales y pueden presentar ligeras variaciones de color o textura debido a iluminación, pantalla o procesos de fabricación.</p>

              <h5 class="fw-bold mt-4">4. Precios y pagos</h5>
              <ul class="custom-list">
                <li>Los precios están expresados en soles peruanos (S/).</li>
                <li>Incluyen los impuestos de ley, salvo indicación expresa.</li>
                <li>PERLUX se reserva el derecho de modificar precios y promociones sin previo aviso.</li>
                <li>La compra se considera confirmada una vez acreditado el pago.</li>
              </ul>

              <h5 class="fw-bold mt-4">5. Envíos</h5>
              <p>Los envíos se rigen por la Política de Envíos publicada en nuestro sitio web, la cual forma parte integral de estos Términos y Condiciones.</p>

              <h5 class="fw-bold mt-4">6. Cambios y devoluciones</h5>
              <p>Los cambios y devoluciones se rigen por la Política de Cambios y Devoluciones, la cual el cliente acepta al realizar la compra.</p>

              <h5 class="fw-bold mt-4">7. Productos personalizados</h5>
              <p class="text-danger fw-bold">Los productos elaborados a pedido no admiten devolución ni cambio, salvo por fallas de fabricación debidamente verificadas por PERLUX.</p>

              <h5 class="fw-bold mt-4">8. Responsabilidad</h5>
              <p>PERLUX no se responsabiliza por:</p>
              <ul class="custom-list">
                <li>Retrasos atribuibles al operador logístico.</li>
                <li>Uso indebido del producto por parte del cliente.</li>
                <li>Daños ocasionados por causas externas o fuerza mayor.</li>
              </ul>

              <h5 class="fw-bold mt-4">9. Modificaciones</h5>
              <p>PERLUX podrá actualizar estos Términos y Condiciones en cualquier momento. Las modificaciones entrarán en vigencia desde su publicación en el sitio web.</p>

              <h5 class="fw-bold mt-4">10. Legislación aplicable</h5>
              <p>Estos Términos y Condiciones se rigen por las leyes de la República del Perú. Cualquier controversia será resuelta conforme a la normativa vigente.</p>
            </div>
          </div>

          <div v-if="activeSection === 'privacidad'" class="info-section fade-in">
            <h2 class="section-title">Políticas de Privacidad</h2>
            <p class="lead text-muted mb-4">
              En PERLUX, respetamos y protegemos la privacidad de nuestros clientes. Esta Política de Privacidad describe cómo recopilamos, usamos y protegemos tu información personal conforme a la <strong>Ley N.° 29733 – Ley de Protección de Datos Personales</strong> y su reglamento.
            </p>

            <h5 class="fw-bold mt-4">1. Información que recopilamos</h5>
            <p>Podemos recopilar la siguiente información:</p>
            <ul class="custom-list">
              <li>Nombre y apellidos</li>
              <li>Documento de identidad (cuando sea requerido)</li>
              <li>Dirección de entrega</li>
              <li>Teléfono y correo electrónico</li>
              <li>Información necesaria para procesar pagos</li>
              <li>Historial de compras</li>
            </ul>

            <h5 class="fw-bold mt-4">2. Finalidad del uso de datos</h5>
            <p>La información recopilada será utilizada para:</p>
            <ul class="custom-list">
              <li>Procesar y gestionar pedidos</li>
              <li>Coordinar envíos y cambios</li>
              <li>Atender consultas y reclamos</li>
              <li>Enviar información promocional (previo consentimiento)</li>
              <li>Mejorar la experiencia del cliente</li>
            </ul>

            <h5 class="fw-bold mt-4">3. Protección de la información</h5>
            <p>PERLUX implementa medidas de seguridad técnicas y organizativas para proteger los datos personales contra accesos no autorizados, pérdida o uso indebido.</p>

            <h5 class="fw-bold mt-4">4. Compartición de información</h5>
            <p>Tus datos podrán ser compartidos únicamente con:</p>
            <ul class="custom-list">
              <li>Operadores logísticos</li>
              <li>Pasarelas de pago</li>
              <li>Proveedores de servicios necesarios para completar la compra</li>
              <li>Siempre bajo estricta confidencialidad y solo para fines operativos.</li>
            </ul>


            <h5 class="fw-bold mt-4">5. Derechos del usuario</h5>
            <!-- <div class="alert alert-light border"> -->
              <p class="mb-2">El cliente puede ejercer sus derechos de <strong>Acceso, Rectificación, Cancelación y Oposición (ARCO)</strong> escribiendo a:</p>
              <a href="mailto:atencionalcliente@perluxbyjd.com" class="fw-bold text-dark h5">
                <i class="fas fa-envelope me-2"></i>atencionalcliente@perluxbyjd.com
              </a>
            <!-- </div> -->

            <h5 class="fw-bold mt-4">6. Conservación de datos</h5>
            <p>Los datos personales serán conservados solo durante el tiempo necesario para cumplir con las finalidades descritas o según lo exija la ley.</p>

            <h5 class="fw-bold mt-4">7. Modificaciones de la política</h5>
            <p>PERLUX se reserva el derecho de modificar esta Política de Privacidad. Cualquier cambio será comunicado a través de nuestros canales oficiales.</p>
          </div>

          <div v-if="activeSection === 'certificado'" class="info-section fade-in">
            <h2 class="section-title">Certificado de Autenticidad</h2>
            <p>Todos los productos PERLUX son elaborados con cuero genuino y materiales de alta calidad, garantizando la autenticidad y el lujo peruano...</p>
            <div class="text-center mt-4">
                <i class="fas fa-award fa-5x text-warning mb-3"></i>
                <p>Garantía de Calidad PERLUX</p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <TheFooter />
  </div>
</template>

<script>
import TheHeader from '../shared/TheHeader/TheHeader.vue';
import TheFooter from '../shared/TheFooter/TheFooter.vue';

export default {
  name: 'BusinessInfo',
  components: {
    TheHeader,
    TheFooter
  },
  props: {
    user: { type: Object, required: false, default: null }
  },
  data() {
    return {
      activeSection: 'envios' // Sección por defecto
    };
  },
  mounted() {
    // Detectar parámetro URL para abrir la sección correcta
    // Ejemplo: /informacion?seccion=cambios
    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get('section');
    if (section) {
        this.activeSection = section;
    }
  }
};
</script>

<style scoped>
.business-container {
  padding-top: 160px; /* Compensar Header Fijo */
  padding-bottom: 80px;
  min-height: 100vh;
  background-color: #ffffff;
}

.page-title {
  font-size: 2rem;
  letter-spacing: 2px;
}

/* Sidebar Navigation */
.list-group-item {
  border: 1px solid #eee;
  padding: 1rem 1.25rem;
  color: #555;
  font-weight: 500;
  transition: all 0.3s ease;
  border-radius: 0;
  margin-bottom: -1px;
  cursor: pointer;
  background: white;
}

.list-group-item:first-child { border-top-left-radius: 8px; border-top-right-radius: 8px; }
.list-group-item:last-child { border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }

.list-group-item:hover {
  background-color: #f8f9fa;
  color: #000;
  padding-left: 1.5rem; /* Efecto deslizamiento */
}

.list-group-item.active {
  background-color: #000;
  border-color: #000;
  color: #fff;
}

/* Content Area */
.content-area {
  padding-left: 2rem;
}

.section-title {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  border-bottom: 2px solid #3ca1db;
  padding-bottom: 10px;
  display: inline-block;
}

/* Listas personalizadas */
.custom-list {
  list-style: none;
  padding-left: 0;
}

.custom-list li {
  position: relative;
  padding-left: 1.5rem;
  margin-bottom: 0.8rem;
  line-height: 1.6;
}

.custom-list li::before {
  content: "•";
  color: #3ca1db; /* Color rosado de la marca */
  font-weight: bold;
  font-size: 1.2rem;
  position: absolute;
  left: 0;
  top: -2px;
}

a {
  color: #3ca1db;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}

/* Animación de entrada */
.fade-in {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
  .business-container { padding-top: 130px; }
  .content-area { padding-left: 0; margin-top: 30px; }
  .list-group { margin-bottom: 20px; }
}
</style>