<template>
  <header id="main-header" class="fixed-top bg-transparent">
    <div class="container-fluid">
      <!-- Navbar responsive -->
      <nav class="navbar navbar-expand-lg p-0">
        <!-- Botón hamburguesa (solo visible en móvil) -->
        <button class="navbar-toggler order-1 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo (centrado en móvil, izquierda en desktop) -->
        <a href="/inicio" class="navbar-brand order-2 order-lg-1">
          <img src="/images/site/svg/skinly_logo.svg" alt="Perlux Logo" class="img-fluid" />
        </a>

        <!-- Iconos (derecha en móvil y desktop) -->
        <div class="d-flex align-items-center order-3 order-lg-3">
          <a href="/user" class="me-3">
            <img src="/images/site/svg/icon_user.svg" alt="Perfil" class="img-fluid nav-icon" />
          </a>
          <a href="/wishlist" class="me-3">
            <img src="/images/site/svg/icon_heart.svg" alt="Lista de deseos" class="img-fluid nav-icon" />
          </a>
          <a href="/cart" class="me-3">
            <img src="/images/site/svg/icon_cart.svg" alt="Carrito" class="img-fluid nav-icon" />
          </a>
        </div>

        <!-- Menú de navegación (colapsa en móvil) -->
        <div class="collapse navbar-collapse order-4 order-lg-2" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="/inicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/glam">Bodys</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/novias">Jeans Rat</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/nosotros">Nosotros</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
  

  <div class="container-fluid p-0">

    <div class="first-section d-flex justify-content-start">
      <img src="/images/site/new-woman-bg.jpg" alt="New Woman" class="w-100" style="object-fit: cover;height: 100vh;" />
      <div class="section-new-woman position-absolute translate-middle text-white">
        <h1 class="display-4">NEW WOMAN</h1>
        <h3 class="lead">Renueva y date la oportunidad de <br>verte con amor.</h3>
        <a href="#" class="btn btn-outline-light btn-lista">Estoy lista</a>
      </div>
      
    </div>

    <div class="text-center second-section">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <p class="lead">Sé tú misma en un mundo 
          <br>
          <strong>
            que siempre está...
          </strong>
        </p>
        <h2 class="">OBSERVAND<span>O</span></h2>
      </div>
      <div class="row justify-content-center">
        <div v-for="item in items" :key="item.id" class="col-6 col-md-2 mb-4">
          <img :src="item.image" :alt="item.title" class="img-fluid"/>
          <h5 class="title-item">{{ item.title }}</h5>
          <p class="text-description">{{ item.description }}</p>
        </div>
      </div>
    </div>

    <div class="third-section text-center">

      <div class="third-section-title">
        <div class="row h-100 mx-0">
          <div class="col-md-5 my-auto col-title1">
              <h2 class="title1"><span>¿CANSADA</span><br>de las miradas?</h2>
          </div>
          <div class="col-md-2 mx-auto my-auto">
            <a href="#" class="btn btn-outline-light btn-lista">Hazlo tuyo</a>
          </div>
          <div class="col-md-5 my-auto col-title2">
            <h2 class="title2"><span>¡PIDE YA</span><br>tu segunda piel!</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="fourth-section">
      <img src="/images/site/svg/skinly_medida.svg" alt="Perlux a tu medida">
      <p>
        Cada cuerpo es único, y por eso, nuestros bodys están diseñados para ser una segunda piel. <br>
        No se trata de disfrazar, sino de realzar lo que ya tienes. A continuación, te presentamos <br>
        una guía de medidas recomendadas para encontrar tu ajuste perfecto
      </p>
      <table class="table" style="max-width: 45%">
        <thead>
          <tr>
            <th class="th1">Talla</th>
            <th>Busto (cm)</th>
            <th>Cintura (cm)</th>
            <th>Caderas (cm)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="td1">XS</td>
            <td>78-83</td>
            <td>62-67</td>
            <td>82-87</td>
          </tr>
          <tr>
            <td class="td1">S</td>
            <td>83-88</td>
            <td>68-73</td>
            <td>88-93</td>
          </tr>
          <tr>
            <td class="td1">M</td>
            <td>91-96</td>
            <td>76-81</td>
            <td>96-101</td>
          </tr>
          <tr>
            <td class="td1">L</td>
            <td>99-104</td>
            <td>83-88</td>
            <td>104-109</td>
          </tr>
          <tr>
            <td class="td1">XL</td>
            <td>108-112</td>
            <td>92-94</td>
            <td>110-114</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <footer class="text-center">
        <div class="footer-section">
          <p class="siguenos">Síguenos en <span> <br>NUESTRAS REDES</span></p>
          
          <div class="d-flex justify-content-center mb-3">
            <a href="https://facebook.com" target="_blank" class="">
                <img src="images/site/svg/facebook.svg" alt="Facebook" class="social-icon">
            </a>
            <a href="https://instagram.com" target="_blank" class="mx-5">
                <img src="images/site/svg/instagram.svg" alt="Instagram" class="social-icon">
            </a>
            <a href="https://tiktok.com" target="_blank" class="">
                <img src="images/site/svg/tiktok.svg" alt="TikTok" class="social-icon">
            </a>
        </div>
          <p class="link-footer">@skinly_peru</p>
         
        </div>

        <div class="row footer-section-contact">
            <div class="col-md-4">
                <h5>Navegación</h5>
                <ul class="list-unstyled">
                    <li><a href="/home" class="">Inicio</a></li>
                    <li><a href="/glam" class="">Bodys</a></li>
                    <li><a href="/novias" class="">Jeans Rat</a></li>
                    <li><a href="/nosotros" class="">Nosotros</a></li>
                    <li><a href="/user" class="">Usuario</a></li>
                    <li><a href="/cart" class="">Carrito de Compras</a></li>
                </ul>
            </div>
            <div class="col-md-4 section-middle">
                <img src="/images/site/svg/skinly_logo.svg" alt="logo Perlux">
                <h5>MANTENTE INFORMADA</h5>
                <p>Sé la primera en descubrir nuestras colecciones, ofertas especiales y todas nuestras novedades</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Tu Correo">
                    <button class="btn btn-dark rounded" type="button"><i class="fa-solid fa-angle-right"></i></button>
                </div>
                <small>
                  A enviar tu correo electrónico, aceptas recibir mensajes de marketing recurrentes y automatizados
                  de Perlux. Consulta nuestros <a href="#" >Términos y Condiciones</a> | <a href="#">Política de Privacidad</a>.
                </small>
            </div>
            <div class="col-md-4 section-contact">
                <h5>Contacto</h5>
                <p>Correo: <a href="mailto:contacto@skinlyperu.com" class="">contacto@skinlyperu.com</a></p>
                <p>Teléfono: +51 955 705 137</p>
                <h5 class="ayuda">Ayuda</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="">Libro de reclamaciones</a></li>
                    <li><a href="#" class="">Términos y condiciones</a></li>
                </ul>
            </div>
        </div>

        <!-- Botón flotante de WhatsApp -->
        <a class="whatsapp-float" href="https://wa.me/51920775278" target="_blank">
            <img src="images/site/whatsapp.webp" alt="WhatsApp" class="float-icon">
        </a>

        <!-- Botón flecha hacia arriba -->
        <a class="arrow-top" href="#top">
            <img src="images/site/svg/arrow-top.svg" alt="Ir arriba" class="float-icon">
        </a>
      </footer>

</template>

<script>
export default {
  data() {
    return {
      ruta : window.location.pathname,
      items: [
        { id: 1, image: "/images/site/obs1.jpg", title: "Fuerte", description: "Descripción de la característica" },
        { id: 2, image: "/images/site/obs2.jpg", title: "Elegante", description: "Descripción de la característica" },
        { id: 3, image: "/images/site/obs3.jpg", title: "Sensual", description: "Descripción de la característica" },
        { id: 4, image: "/images/site/obs4.jpg", title: "Segura", description: "Descripción de la característica" },
        { id: 5, image: "/images/site/obs5.jpg", title: "Flexible", description: "Descripción de la característica" },
        { id: 6, image: "/images/site/obs6.jpg", title: "Cómoda", description: "Descripción de la característica" },
      ],
    };
  },

  methods:{
    
    /*mountedHeader() {
      const header = document.getElementById("main-header");
      let lastScrollY = window.scrollY;
      const scrollThreshold = 100;

      // Asegúrate de que al cargar, si ya hay scroll, se aplique
      if (window.scrollY > scrollThreshold) {
        header.classList.add("header-scrolled");
      }

      window.addEventListener("scroll", () => {
        const currentScrollY = window.scrollY;

        // Mostrar/ocultar header basado en dirección de scroll
        if (currentScrollY > scrollThreshold && currentScrollY > lastScrollY) {
          header.classList.add("hidden"); // oculta al bajar
        } else if (currentScrollY <= scrollThreshold || currentScrollY < lastScrollY) {
          header.classList.remove("hidden"); // muestra al subir o arriba
        }

        // Cambiar estilo del header al hacer scroll
        if (currentScrollY > scrollThreshold) {
          header.classList.add("header-scrolled");
        } else {
          header.classList.remove("header-scrolled");
        }

        lastScrollY = currentScrollY;
      });
    }*/

    // En tu método mountedHeader(), también actualiza los estilos del toggler
    mountedHeader() {
      const header = document.getElementById("main-header");
      const toggler = document.querySelector(".navbar-toggler-icon");
      let lastScrollY = window.scrollY;
      const scrollThreshold = 100;

      if (window.scrollY > scrollThreshold) {
        header.classList.add("header-scrolled");
      }

      window.addEventListener("scroll", () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > scrollThreshold && currentScrollY > lastScrollY) {
          header.classList.add("hidden");
        } else if (currentScrollY <= scrollThreshold || currentScrollY < lastScrollY) {
          header.classList.remove("hidden");
        }

        if (currentScrollY > scrollThreshold) {
          header.classList.add("header-scrolled");
        } else {
          header.classList.remove("header-scrolled");
        }

        lastScrollY = currentScrollY;
      });
    }
  },
  mounted() {
    this.mountedHeader();
  },

};
</script>

<style scoped>
/* * {
  border: 1px solid red !important;
} */
#main-header{
  padding-left: 100px;
  padding-right: 100px;
  padding-top: 30px;
  padding-bottom: 30px;
  margin-left:0px;
  margin-right:0px;
  transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

/* Custom styles to complement Bootstrap */
header {
  transition: background-color 0.3s ease, transform 0.3s ease;

}
.nav-link:hover {
  color: #ff6699 !important; /* Texto rosado al hacer hover */
  background-color: transparent; /* Asegura que no haya fondo */
}

.header-scrolled {
  background-color: white !important;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar-brand img{
  height: 40px;
}

.header-scrolled .navbar-brand img,
.header-scrolled .me-3 img {
  filter: invert(0%) brightness(0%); /* Fuerza color negro */
  
}

.header-scrolled .nav-link {
  color: #000 !important;
  transition: color 0.3s ease;
}

.header-scrolled .nav-link:hover {
  color: #ff6699 !important; /* Texto rosado al hacer hover */
  background-color: transparent; /* Asegura que no haya fondo */
}

.header-scrolled .me-3 img:hover,
.header-scrolled .navbar-brand:hover {
  filter: 
    brightness(0) 
    saturate(100%) 
    invert(59%) 
    sepia(39%) 
    saturate(4445%) 
    hue-rotate(299deg) 
    brightness(97%) 
    contrast(101%) !important;
}

/* Evita afectar otros iconos fuera del header */
header.hidden {
  transform: translateY(-100%);
}

.nav-link {
  color: #ffffff;
  font-size:1.3rem;
}

.bg-pink .nav-link {
  color: #343a40;
}

.bg-pink .nav-link:hover {
  color: #ff6699;
}



/* seccion 1 */

.first-section{
  height: 100vh;
}

.first-section .section-new-woman{
  padding-left:100px;
  padding-right:100px;
  top: 80%; left: 22%; transform: translateY(-50%); text-align: left;
}

.btn-lista{
  border-radius:0px;
  font-size:2rem;
  padding-top:0px;
  padding-bottom:0px;
  font-weight: 600;
}

.btn-lista:hover{
  color:#ff6699;
}



img {
  max-width: 100%;
}

.display-4{
  font-size: 5rem;
  font-weight: 900;
  margin-bottom: 0px !important;
  padding-bottom: 0px !important;
}

.lead {
  font-size: 2rem;
  margin-top: 0px;
  padding-top: 0px;
}

/* seccion 2 */
.second-section{
  height: 57rem;
  padding-top:60px;
  padding-bottom:60px;
  padding-left:140px;
  padding-right:140px;
}


.second-section .lead{
  font-size:2.3rem !important;
  text-align: start;
  font-weight: 400;
  color:#000;
  line-height: 1.2
}

.second-section h2{
  font-size:6rem !important;
  text-align: end;
  font-weight: 700;
  color: #000000;
}

.second-section h2 span{
  font-size:6rem !important;
  text-align: end;
  font-weight: 600;
  color: #ff6699;
}

.second-section .lead strong{
  font-weight: 700;
  font-size:2.5rem !important;
  text-transform: uppercase;

}

.second-section .img-fluid{
  width: 100%;
  height: 60vh;
  padding-left: 0px;
  padding-right: 0px;
  margin-left: 0px;
  margin-right: 0px;
  object-fit: cover;    /* Hace el efecto de "zoom" y rellena */
  object-position: center; /* Centra la imagen */
}

.second-section .col-md-2{

  padding-left: 4px;
  padding-right: 4px;
  margin-left: 0px;
  margin-right: 0px;

}

.second-section .text-description{
  font-size:0.8rem;
  color:#000;
  text-align:start;
  margin-top:0px;
}

.second-section .title-item{
  font-size:1.7rem;
  color:#000;
  font-weight: 700;
  text-align:start;
  margin-bottom:0px;
  margin-top:30px;
}

/* seccion 3 */

.third-section .third-section-title{
  /* height: 20vh; */
  padding-top:2rem;
  padding-bottom:2rem;
  background-image: url('/images/site/obs4_new.jpg');
  background-size: cover;
  background-position: center;
}

.third-section .third-section-title .col-title1{
  display:flex;
  justify-content: center;
}

.third-section .third-section-title .col-title2{
  display:flex;
  justify-content: center;
}

.third-section .third-section-title .title1{
  font-size: 2rem;
  color:#ffffff;
  width:70%;
  text-align: end;
}

.third-section .third-section-title .title1 span{
  font-size: 5rem;
  color:#ffffff;
  width:70%;
  text-align: end;
}

.third-section .third-section-title .title2{
  font-size: 2rem;
  color:#ffffff;
  width:70%;
  text-align: start;
}

.third-section .third-section-title .title2 span{
  font-size: 5rem;
  color:#ffffff;
  width:70%;
  text-align: start;
}

/* seccion 4 */
.fourth-section{
  display:flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  /* height: 80vh; */
  padding-top:7rem;
  padding-bottom:7rem;
  background-image: url('/images/site/svg/fondo_medida.svg');
  background-size: cover;
  background-position: center;
}

.fourth-section img{
  width: 15rem;
  height: auto;
  margin-top:0rem;
  margin-bottom:1rem;
  text-transform: uppercase;

}

.fourth-section p{
  font-size:1.3rem;
  font-weight: 400;
  margin-top:0rem;
  margin-bottom:3rem;
  line-height: 1.3;
  text-align: center;
  
}

.fourth-section .table {
    border-collapse: collapse; /* Une bordes */
    font-size:1.7rem;
    background-color: transparent !important;
    background: transparent !important;
}

/* Solo bordes horizontales */
.fourth-section table  th{
    border: none; /* Elimina todos los bordes */
    border-bottom: 2px solid #333; /* Solo borde inferior */
    border-top: none;
    padding: 10px;
}

.fourth-section table  td{
    border: none; /* Elimina todos los bordes */
    background-color: transparent !important;
    padding-top:3px;
    padding-bottom:3px;
    text-align:center;

}

.fourth-section table  th{
    background-color: transparent !important;
    padding-top:3px;
    padding-bottom:3px;
    text-align:center;

}

.fourth-section table  .th1,
.fourth-section table  .td1{
    border-right:2px solid #333;; /* Elimina todos los bordes */
    font-weight: 700;
}

/* seccion 5 */
.footer-section{
    background-color:#000;
    padding-top:5rem;
    padding-bottom:5rem;
}

.footer-section .siguenos{
    color:#ffffff;
    font-size:2.2rem;
    line-height: 1.1;

}

.footer-section span{
    color:#ffffff;
    font-size:2.8rem;
    font-weight: 700;
}

.footer-section .link-footer{
    color:#ffffff;
    font-size:2.7rem;
    font-weight: 400;
}

.social-icon {
    width: 55px;        /* Ajusta el tamaño según necesites */
    height: 55px;
    object-fit: contain;
    margin-top:10px;
    margin-bottom:10px;
    transition: transform 0.1s ease; /* Efecto hover opcional */
}

.social-icon:hover {
    transform: scale(1.1); /* Efecto de aumento al pasar el mouse */
}

.footer-section-contact{
  margin:6rem;
}

.footer-section-contact .section-middle{
  padding-left:0px;
  padding-right:0px;
  display:flex;
  justify-content: center;
  flex-direction:column;
}

.footer-section-contact .section-middle p{
  font-weight: 500;
  margin-top:20px;
}

.footer-section-contact .section-middle .input-group{
  width: 70%;
  display:flex !important;
  justify-content:center !important;
  margin-left: auto;
  margin-right: auto;
}

.footer-section-contact .section-middle .input-group button{
  margin-left: 10px !important;
  border-radius: 12px !important;
  background-color:#000;
  font-size:1.4rem !important;
  padding-top:5px;
  padding-bottom:5px;
  padding-left:15px;
  padding-right:15px;
}

.footer-section-contact .section-middle .input-group button:hover{

  background-color:#ff6699;
  border:1px solid #ff6699;

}

.footer-section-contact .section-middle .input-group button i{
    font-size:1.4rem !important;
}



.footer-section-contact .section-middle .input-group input[type="email"] {
  margin-left: 10px !important;
  border-radius:10px !important;
  border: 1px solid #000;
  font-size:1.3rem !important;
}

.footer-section-contact .section-middle small{
  font-size:0.9rem;
  text-align: center;
  color:#000;
}

.footer-section-contact .section-middle small a{
  text-decoration: none;
  color:#000;
}

.footer-section-contact h5{
  color:#000;
  font-size:1.9rem;
  font-weight: 700;
}

.footer-section-contact ul li a{
  color:#000;
  font-size:1.2rem;
  text-decoration: none;
}

.footer-section-contact ul li a:hover{
  color:#ff6699;
}


.footer-section-contact ul li{
  margin-top: 1rem;
}

.footer-section-contact img{
  height:4rem;
  width:auto;
  filter: brightness(0);
  margin-bottom:2rem;
}

.footer-section-contact p{
  font-size:1.2rem;
  line-height: 1.2;
}

.footer-section-contact .section-contact .ayuda{
  margin-top:2.5rem;
}

.footer-section-contact .section-contact a{
  text-decoration: none;
  color:#000;
}

.footer-section-contact .section-contact li a:hover{
  color:#ff6699;
}

/* Estilos generales para botones flotantes */

.arrow-top {
  position: fixed;
  z-index: 1000;
  border-radius: 50%;
  /* background-color: white; */
  /* padding: 8px; */
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  width: 45px;
  height: auto;
}

.whatsapp-float {
  position: fixed;
  z-index: 1000;
  border-radius: 50%;
  /* background-color: white; */
  /* padding: 8px; */
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  width: 65px;
  height: auto;
}

.whatsapp-float:hover,
.arrow-top:hover {
  transform: translateY(-3px) scale(1.1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.float-icon {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

/* Posicionamiento específico */
.whatsapp-float {
  bottom: 20px;
  right: 20px;
}

.arrow-top {
  bottom: 100px; /* 70px arriba del WhatsApp */
  right: 30px;
}



@media (max-width: 768px) {
  .lead {
    font-size: 1rem;
  }
  .img-fluid {
    max-height: 150px;
  }

  /* primera seccion  */
  .first-section .section-new-woman{
    padding-left:100px;
    padding-right:100px;
    top: 80%; left: 22%; transform: translateY(-50%); text-align: left;
  }

  /* tercera seccion */
  .third-section .third-section-title .title1{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title1 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }


  /* cuarta seccion */
  .fourth-section .table {

    font-size:1.2rem;

  }

  .fourth-section p{
    font-size:1.2rem;
    margin-left:1rem;
    margin-right:1rem;
    text-align: center;
  }

  /* seccion del footer */
  .footer-section-contact .section-middle{
    margin-top:4rem;
    margin-bottom:4rem;
  }

  .footer-section-contact .section-middle .input-group{
    width: 100%;
  }

  .footer-section-contact{
    margin-top:4rem;
    margin-bottom:4rem;
    margin-left:1.5rem;
    margin-right:1.5rem;
  }

  /* seccion ultima */
  .arrow-top {
      width: 45px;
      height: auto;
      bottom: 110px;
  }
    
  .whatsapp-float {
      width: 60px;
      height: auto;
      bottom: 40px;
  }
}





@media (max-width: 576px) {
  /* seccion 1 */
  .display-4 {
    font-size: 2rem;
  }
  .lead {
    font-size: 0.9rem;
  }
  .img-fluid {
    max-height: 100px;
  }

  /* primera seccion */
  .first-section .section-new-woman{
    padding-left:100px;
    padding-right:100px;
    top: 80%; left: 24%; transform: translateY(-50%); text-align: left;
  }

  .section-new-woman{
    top: 80%; left: 30%; text-align: left;
  }

  /* segunda seccion */
  .second-section{
    height: 95vh;
    padding-top:5px;
    padding-bottom:5px;
    padding-left:20px;
    padding-right:20px;
  }

  .second-section .lead{
    font-size:1.2rem !important;
    text-align: start;
    font-weight: 400;
    color:#000;
    line-height: 1.2
  }

  .second-section h2{
    font-size:3rem !important;
    text-align: end;
    font-weight: 700;
    color: #000000;
  }

  .second-section h2 span{
    font-size:3rem !important;
    text-align: end;
    font-weight: 600;
    color: #ff6699;
  }

  .second-section .lead strong{
    font-weight: 700;
    font-size:1.3rem !important;
    text-transform: uppercase;
  }
  
  /* tercera seccion */
  .third-section .third-section-title .title1{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title1 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2{
    font-size: 1.3rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  .third-section .third-section-title .title2 span{
    font-size: 2.2rem;
    color:#ffffff;
    width:70%;
    text-align: center;
  }

  /* cuarta seccion */
  .fourth-section .table {

    font-size:1.2rem;

  }

  .fourth-section p{
    font-size:1.2rem;
    margin-left:1rem;
    margin-right:1rem;
    text-align: center;
  }

  /* seccion del footer */

  .footer-section-contact{
    margin-top:4rem;
    margin-bottom:4rem;
    margin-left:1.5rem;
    margin-right:1.5rem;
  }

  .footer-section-contact .section-middle{
    margin-top:4rem;
    margin-bottom:4rem;
  }

  .footer-section-contact .section-middle .input-group{
    width: 100%;
  }

  /* seccion ultima */
  .arrow-top {
      width: 45px;
      height: auto;
      bottom: 110px;
  }
    
  .whatsapp-float {
      width: 60px;
      height: auto;
      bottom: 40px;
  }


}
</style>





<style scoped>
/* Estilos base del header */


/* Navbar */
.navbar {
  width: 100%;
}

/* Logo */
.navbar-brand {
  margin: 0;
}

/* Iconos de navegación */
.nav-icon {
  width: 30px;
  height: 30px;
  transition: all 0.3s ease;
}

/* Enlaces de navegación */
.nav-link {
  color: #ffffff;
  font-size: 1.3rem;
  transition: color 0.3s ease;
}

.nav-link:hover {
  color: #ff6699 !important;
  background-color: transparent;
}

/* Botón hamburguesa personalizado */
.navbar-toggler {
  border: none;
  padding: 0;
  background: none;
  width: 30px;
  height: 30px;
}

.navbar-toggler:focus {
  box-shadow: none;
}

.navbar-toggler-icon {
  background-image: none;
  width: 25px;
  height: 2px;
  background-color: #ffffff;
  position: relative;
  transition: all 0.3s ease;
}

.navbar-toggler-icon::before,
.navbar-toggler-icon::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 2px;
  background-color: #ffffff;
  transition: all 0.3s ease;
}

.navbar-toggler-icon::before {
  top: -8px;
}

.navbar-toggler-icon::after {
  top: 8px;
}

/* Animación del botón hamburguesa */
.navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
  background-color: transparent;
}

.navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
  transform: rotate(45deg);
  top: 0;
}

.navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
  transform: rotate(-45deg);
  top: 0;
}

/* Estilos cuando se hace scroll */
.header-scrolled {
  background-color: white !important;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header-scrolled .navbar-brand img,
.header-scrolled .nav-icon {
  filter: invert(0%) brightness(0%);
}

.header-scrolled .nav-link {
  color: #000 !important;
}

.header-scrolled .nav-link:hover {
  color: #ff6699 !important;
}

.header-scrolled .navbar-toggler-icon,
.header-scrolled .navbar-toggler-icon::before,
.header-scrolled .navbar-toggler-icon::after {
  background-color: #000000;
}

.header-scrolled .nav-icon:hover,
.header-scrolled .navbar-brand:hover {
  filter: brightness(0) saturate(100%) invert(59%) sepia(39%) saturate(4445%) hue-rotate(299deg) brightness(97%) contrast(101%) !important;
}

/* Header oculto */
.hidden {
  transform: translateY(-100%);
}

/* Responsive Design */
@media (max-width: 991.98px) {
  #main-header {
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 15px;
    padding-bottom: 15px;
  }

  /* Ordenamiento flex para móvil: hamburguesa, logo, iconos */
  .navbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
  }

  /* Logo centrado en móvil */
  .navbar-brand {
 

    position: absolute; /* Cambiado a absolute para mantenerlo fijo */
    left: 50%;
    transform: translateX(-50%);
    top: 15px; /* Ajusta según el padding del header */
    z-index: 1050; /* Asegura que esté por encima del menú */
  }

  /* Menú colapsable ocupa todo el ancho */
  .navbar-collapse {
    flex-basis: 100%;
    margin-top: 2rem;
    /* background-color: rgba(0, 0, 0, 0.95); */
    background-color: #ff6699;
    border-radius: 10px;
    padding: 20px;
    backdrop-filter: blur(10px);
    margin-left: 0px !important;
    margin-right: 0px !important;

  }

  /* Menú vertical en móvil */
  .navbar-nav {
    text-align: center;
  }

  .nav-item {
    margin: 10px 0;
  }

  .nav-link {
    font-size: 1.1rem;
    padding: 10px 20px;
    border-radius: 5px;
  }

  .nav-link:hover {
    background-color: rgba(255, 102, 153, 0.1);
  }

  /* Header scrolled en móvil */
  .header-scrolled .navbar-collapse {
    background-color: rgba(255, 255, 255, 0.98);
    /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); */
  }

  .header-scrolled .nav-link {
    color: #000 !important;
  }

  
}

@media (max-width: 576px) {

  
  #main-header {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 12px;
    padding-bottom: 12px;
  }

  .navbar-brand img {
    height: 30px;
    margin-top:auto;
    margin-bottom:auto;

  }

  .navbar-brand {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    padding-top:0px;
  }

  .nav-icon {
    width: 25px;
    height: 25px;
  }

  .me-3 {
    margin-right: 0.75rem !important;
  }
}

/* Animaciones adicionales */
.navbar-collapse.collapsing,
.navbar-collapse.show {
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 1200px) and (min-width: 993px) {

  /* primera seccion */

  .first-section .section-new-woman{
    position: absolute;
    padding-left: 100px;
    padding-right: 100px;
    top: 70%;
    left: 30%;
    transform: translateY(-50%);
    text-align: left;
  }

  /* segunda seccion */
  .second-section{
    height: 45rem;
    padding-top:60px;
    padding-bottom:60px;
    padding-left:140px;
    padding-right:140px;
  }


  .second-section .lead{
    font-size:1.8rem !important;
    text-align: start;
    font-weight: 400;
    color:#000;
    line-height: 1.2
  }

  .second-section h2{
    font-size:5.5rem !important;
    text-align: end;
    font-weight: 700;
    color: #000000;
  }

  .second-section h2 span{
    font-size:5.5rem !important;
    text-align: end;
    font-weight: 600;
    color: #ff6699;
  }
}
</style>
