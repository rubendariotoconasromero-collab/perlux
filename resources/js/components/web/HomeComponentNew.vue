<template>
  <div>
    <SiteHeader 
      :user="user"
      :cart-count="cartCount"
      :favorites-count="favoritesCount"
      @toggle-cart="showCartSidebar = true"
      @toggle-favorites="showFavoritesSidebar = true"
    />

    <CartSidebar 
      :show="showCartSidebar"
      :cart-items="products_carrito"
      :user="user"
      @close="showCartSidebar = false"
      @remove-item="removeFromCart"
    />

    <FavoritesSidebar 
      :show="showFavoritesSidebar"
      :favorites="favorites"
      @close="showFavoritesSidebar = false"
      @remove-favorite="removeFavorite"
    />

    <main class="container-fluid p-0">
      <HeroSlider />

      <div class="text-center second-section">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <p class="lead">Sé tú misma en un mundo <br><strong>que siempre está...</strong></p>
          <h2>OBSERVAND<span>O</span></h2>
        </div>
        <div class="row justify-content-center">
          <div v-for="item in items" :key="item.id" class="col-lg-2 col-md-4 col-sm-12 content-products">
            <img :src="item.image" :alt="item.title" class="img-fluid" loading="lazy"/>
            <h5 class="title-item">{{ item.title }}</h5>
            <p class="text-description">{{ item.description }}</p>
          </div>
        </div>
      </div>

      <div class="third-section text-center">
         <div class="third-section-title">
           <div class="row h-100 mx-0">
             <div class="col-md-5 my-auto col-title1"><h2 class="title1"><span>¿CANSADA</span><br>de las miradas?</h2></div>
             <div class="col-md-2 mx-auto my-auto"><a href="#" class="btn btn-outline-light btn-lista border border-2 border-white">Hazlo tuyo</a></div>
             <div class="col-md-5 my-auto col-title2"><h2 class="title2"><span>¡PIDE YA</span><br>tu segunda piel!</h2></div>
           </div>
         </div>
      </div>

      <div class="fourth-section">
        <img src="/images/site/svg/skinly_medida.svg" alt="Perlux a tu medida" loading="lazy">
        <p>Cada cuerpo es único. Guía de medidas recomendadas:</p>
        <table class="table" style="max-width: 45%">
          <thead><tr><th class="th1">Talla</th><th>Busto</th><th>Cintura</th><th>Caderas</th></tr></thead>
          <tbody>
            <tr><td class="td1">XS</td><td>78-83</td><td>62-67</td><td>82-87</td></tr>
            <tr><td class="td1">S</td><td>83-88</td><td>68-73</td><td>88-93</td></tr>
            <tr><td class="td1">M</td><td>91-96</td><td>76-81</td><td>96-101</td></tr>
            <tr><td class="td1">L</td><td>99-104</td><td>83-88</td><td>104-109</td></tr>
            <tr><td class="td1">XL</td><td>108-112</td><td>92-94</td><td>110-114</td></tr>
          </tbody>
        </table>
      </div>
    </main>

    <SiteFooter />
  </div>
</template>

<script>
import axios from 'axios';
import SiteHeader from '../layout/SiteHeader.vue';
import SiteFooter from '../layout/SiteFooter.vue';
import HeroSlider from '../sections/HeroSlider.vue';
import CartSidebar from '../sections/CartSidebar.vue';
import FavoritesSidebar from '../sections/FavoritesSidebar.vue';

export default {
  components: { SiteHeader, SiteFooter, HeroSlider, CartSidebar, FavoritesSidebar },
  props: {
    user: { type: Object, default: null }
  },
  data() {
    return {
      showCartSidebar: false,
      showFavoritesSidebar: false,
      products_carrito: [],
      favorites: [],
      items: [
         { id: 1, image: "/images/site/obs1.jpg", title: "Fuerte", description: "Moldeamos tu fuerza interior." },
         { id: 2, image: "/images/site/obs2.jpg", title: "Elegante", description: "Curvas sutiles, estilo elevado." },
         // Agrega el resto de items aquí
      ]
    };
  },
  computed: {
    cartCount() { return this.products_carrito.length; },
    favoritesCount() { return this.favorites.length; }
  },
  methods: {
    loadLocalData() {
      this.products_carrito = JSON.parse(localStorage.getItem('products')) || [];
      this.favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    },
    removeFromCart(product) {
      this.products_carrito = this.products_carrito.filter(item => item.ProductID !== product.ProductID);
      localStorage.setItem('products', JSON.stringify(this.products_carrito));
    },
    removeFavorite(product) {
      this.favorites = this.favorites.filter(fav => fav.ProductID !== product.ProductID);
      localStorage.setItem('favorites', JSON.stringify(this.favorites));
    }
  },
  mounted() {
    this.loadLocalData();
  }
};
</script>

<style scoped>
.cart-item {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  padding: 20px;
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e8ecef;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.cart-item:hover {
  border-color: #dee2e6;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transform: translateY(-1px);
}

.cart-item-image {
  flex-shrink: 0;
  width: 80px;
  height: 80px;
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.cart-item:hover .product-image {
  transform: scale(1.05);
}

.cart-item-details {
  flex: 1;
  min-width: 0;
}

.product-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 12px;
  gap: 12px;
}

.product-title {
  font-size: 16px;
  font-weight: 600;
  color: #212529;
  margin: 0;
  line-height: 1.3;
  flex: 1;
}

.cart-items .product-price {
  font-size: 18px;
  font-weight: 700;
  color: #353535;
  white-space: nowrap;
}

.product-variants {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}

.variant-item {
  display: inline-flex;
  align-items: center;
}

.variant-label {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 4px 8px;
  background: #f8f9fa;
  border-radius: 6px;
  border: 1px solid #e9ecef;
}

.color-indicator {
  width: 14px;
  height: 14px;
  border-radius: 50%;
  border: 1px solid rgba(0, 0, 0, 0.1);
  flex-shrink: 0;
}

.variant-icon {
  font-size: 12px;
  color: #6c757d;
}

.variant-text {
  font-size: 13px;
  color: #495057;
  font-weight: 500;
}

.cart-item-actions {
  flex-shrink: 0;
}

.btn-remove {
  width: 32px;
  height: 32px;
  border: none;
  background: #f8f9fa;
  color: #6c757d;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 14px;
}

.btn-remove:hover {
  background: #dc3545;
  color: white;
  transform: scale(1.1);
}

.btn-remove:active {
  transform: scale(0.95);
}

/* Responsive design */
@media (max-width: 576px) {
  .cart-item {
    padding: 16px;
    gap: 12px;
  }
  
  .cart-item-image {
    width: 60px;
    height: 60px;
  }
  
  .product-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .product-title {
    font-size: 14px;
  }
  
  .product-price {
    font-size: 16px;
  }
  
  .product-variants {
    gap: 8px;
  }
  
  .variant-text {
    font-size: 12px;
  }
}
</style>
<style scoped>
.user-avatar {
    width: 33px;
    height: 33px;
   
    background-color: #fff;
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
    cursor: pointer;
    /* box-shadow: 0 2px 4px rgba(0,0,0,0.1); */
}


.header-scrolled .user-avatar {
  background-color: #000;
  color: #fff;
}

/* Para pantallas pequeñas */
@media (max-width: 576px) {
    .user-avatar {
        width: 25px;
        height: 25px;
        font-size: 12px;
    }

    .nav-icon {
        width: 25px;
        height: 25px;
    }
}

/* Aseguramos el tamaño del ícono SVG */
.nav-icon {
    width: 30px;
    height: 30px;
    transition: all 0.3s ease;
}
/* Estilos del sidebar de favoritos */
.favorites-sidebar {
  position: fixed;
  top: 0;
  right: -400px;
  width: 400px;
  height: 100vh;
  background: white;
  z-index: 1060;
  box-shadow: -3px 0 15px rgba(0, 0, 0, 0.1);
  transition: right 0.3s ease;
  display: flex;
  flex-direction: column;
}

.favorites-sidebar.active {
  right: 0;
}

.sidebar-header {
  padding: 20px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: between;
  align-items: center;
  background: #f8f9fa;
}

.sidebar-header h5 {
  color: #333;
  font-weight: 600;
}

.btn-close-sidebar {
  background: none;
  border: none;
  font-size: 1.2rem;
  color: #666;
  cursor: pointer;
  padding: 5px;
  margin-left: auto;
}

.btn-close-sidebar:hover {
  color: #ff6699;
}

.sidebar-content {
  flex: 1;
  overflow-y: auto;
  padding: 0;
}

.empty-favorites {
  text-align: center;
  padding: 60px 20px;
  color: #666;
}

.empty-icon {
  font-size: 3rem;
  color: #ddd;
  margin-bottom: 20px;
}

.favorites-list {
  padding: 0;
}

.favorite-item {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.2s;
}

.favorite-item:hover {
  background-color: #f8f9fa;
}

.favorite-image {
  width: 60px;
  height: 75px;
  margin-right: 15px;
  flex-shrink: 0;
}

.favorite-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 5px;
}

.favorite-info {
  flex: 1;
}

.favorite-info .product-name {
  font-size: 0.9rem;
  font-weight: 600;
  margin: 0 0 5px 0;
  color: #333;
}

.favorite-info .product-price {
  font-size: 0.9rem;
  color: #666;
  margin: 0 0 8px 0;
}

.product-colors {
  display: flex;
  gap: 4px;
}

.color-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 1px solid #ddd;
}

.favorite-actions {
  margin-left: 10px;
}

.btn-remove-favorite {
  background: none;
  border: none;
  color: #ff6699;
  font-size: 1.1rem;
  cursor: pointer;
  padding: 5px;
}

.btn-remove-favorite:hover {
  color: #ff4d8a;
  transform: scale(1.1);
}

.sidebar-footer {
  padding: 20px;
  border-top: 1px solid #eee;
  background: #f8f9fa;
}

.sidebar-footer .btn-primary {
    background-color: #ffffff;
    color: #000000;
    border: 1px solid #000;
    padding: 0.5rem 1.5rem;
    font-size: 1rem;
    border-radius: 0.6rem;
    transition: background-color 0.3s ease;
    width:100%;
    margin-top:1rem;
}

.sidebar-footer .btn-primary:hover {
    background-color: #000000;
    color: #ffffff;

}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1055;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.sidebar-overlay.active {
  opacity: 1;
  visibility: visible;
}

.favorites-badge {
  font-size: 0.7rem;
  padding: 2px 5px;
  min-width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Responsive para el sidebar */
@media (max-width: 768px) {
  .favorites-sidebar {
    width: 100vw;
    right: -100vw;
  }
}
</style>
<style scoped>
/* Estilos base */
#main-header{
  padding-left: 100px;
  padding-right: 100px;
  padding-top: 30px;
  padding-bottom: 30px;
  margin-left:0px;
  margin-right:0px;
  transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

header {
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.nav-link:hover {
  color: #ff6699 !important;
  background-color: transparent;
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
  filter: invert(0%) brightness(0%);
}

.header-scrolled .nav-link {
  color: #000 !important;
  transition: color 0.3s ease;
}

.header-scrolled .nav-link:hover {
  color: #ff6699 !important;
  background-color: transparent;
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

/* Estilos del dropdown */
.dropdown {
  position: relative;
}

.dropdown-toggle::after {
  display: none; /* Ocultar la flecha por defecto de Bootstrap */
}

.collections-dropdown {
  position: absolute;
  top: 90%;
  left: 0;
  right: 0;
  background: rgb(255, 255, 255);
  padding: 0;
  margin-top: 0px;
  width: 120vw;
  margin-left: calc(-50vw + 50%);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 1000;
  box-shadow: none !important;
  border: none !important;
  outline: none !important;
}  
.collections-dropdown.show {
  opacity: 1;
  visibility: visible;
}


.dropdown-content {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  justify-content: center;
  padding-left: 15rem;
  padding-right: auto;
  gap: 10px;
  max-width: 100vw;
  margin: 0 auto;
  width: 100% !important;
  box-sizing: border-box;
}


.dropdown-content-jeans {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  justify-content: center;
  padding-left: 10rem;
  padding-right: auto;
  gap: 10px;
  max-width: 100vw;
  margin: 0 auto;
  width: 100% !important;
  box-sizing: border-box;
}

.collections-section {
  flex: 1;
  min-width: 400px;
  display:flex;
  flex-direction: column;
}

.dropdown-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 25px;
  letter-spacing: 1px;
  padding-left:8rem;
}

.collections-list {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 18px;
  padding-left:8rem;

}

.dropdown-item {
  color: rgb(0, 0, 0);
  text-decoration: none;
  font-size: 1.1rem;
  padding: 0px 0;
  border: none;
  background: none;
  transition: color 0.3s ease;
}

.dropdown-item:hover {
  color: #ff6699;
  background: none;
}

.dropdown-item.active-item {
  color: #ff6699;
  font-weight: 600;
}

.collections-images {
  flex: 4;
  display: flex;
  flex-wrap: wrap;
  /* background-color:red ; */
  gap: 20px;
  width:100%;
}

.collection-item {
  /* flex: 1; */
  /* border:1px solid red; */
  width:10rem !important;
  height: auto !important;
  
}

.collection-img {
  width: 100%;
  height: 15rem;
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 15px;
  /* border:1px solid red; */
}

.collection-img img{
  width: 100%;
  height: auto;
  /* border:1px solid red; */
}



.collection-info h6 {
  font-size: 1rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 8px;
}

.collection-info p {
  font-size: 0.85rem;
  color: #000;
  line-height: 1.4;
  margin: 0;
}

/* Estilos para cuando el header está scrolled */
.header-scrolled .collections-dropdown {
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

/* Primera sección */
.first-section{
  height: 100vh;
  /* nuevo */
  position: relative;
  overflow: hidden;
}

/* nuevo seccion */

/* Estilos del slider */
.slider-container {
  position: relative;
  width: 100%;
  height: 100vh;
}

.slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  opacity: 0;
  transition: opacity 1s ease-in-out;
  display: flex;
  justify-content: start;
}

.slide.active {
  opacity: 1;
}



/* Estilos de los indicadores (dots) */
.slider-dots {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 12px;
  z-index: 10;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.5);
  cursor: pointer;
  transition: all 0.3s ease;
}

.dot.active {
  background-color: #ff6699;
  transform: scale(1.2);
}

.dot:hover {
  background-color: rgba(255, 255, 255, 0.8);
}

/* Estilos de las flechas de navegación */
.slider-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0);
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
}

.slider-arrow:hover {
  background-color: rgba(255, 102, 153, 0.8);
  transform: translateY(-50%) scale(1.1);
}

.slider-arrow.prev {
  left: 30px;
}

.slider-arrow.next {
  right: 30px;
}

/* Pausar animación cuando se hace hover sobre el slider */
.slider-container:hover .slide {
  animation-play-state: paused;
}

/* fin seccion */

.first-section .section-new-woman{
  padding-left:100px;
  padding-right:100px;
  top: 80%; left: 2%; transform: translateY(-50%); text-align: left;
  /* background-color: #000; */
}

.btn-lista{
  border-radius:0px;
  font-size:1.6rem;
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

/* Segunda sección */
.second-section{
  height: auto;
  padding-top:60px;
  padding-bottom:15px;
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

.content-products{
  padding-left:2px;
  padding-right:2px;
  height: auto;
  margin-bottom:45px;
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
  height: 600px !important;
  padding-left: 0px;
  padding-right: 0px;
  margin-left: 0px;
  margin-right: 0px;
  object-fit: cover;
  object-position: center;
}

.second-section .col-md-2{
  padding-left: 4px;
  padding-right: 4px;
  margin-left: 0px;
  margin-right: 0px;
  margin-bottom:2rem;
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

/* Tercera sección */
.third-section .third-section-title{
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
  font-size: 1.8rem;
  color:#ffffff;
  width:70%;
  text-align: end;
}

.third-section .third-section-title .title1 span{
  font-size: 4.4rem;
  color:#ffffff;
  width:70%;
  text-align: end;
  font-weight: 650;
}

.third-section .third-section-title .title2{
  font-size: 2rem;
  color:#ffffff;
  width:70%;
  text-align: start;
}

.third-section .third-section-title .title2 span{
  font-size: 4.4rem;
  color:#ffffff;
  width:70%;
  text-align: start;
  font-weight: 650;
}

/* Cuarta sección */
.fourth-section{
  display:flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
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
    border-collapse: collapse;
    font-size:1.7rem;
    background-color: transparent !important;
    background: transparent !important;
}

.fourth-section table th{
    border: none;
    border-bottom: 2px solid #333;
    border-top: none;
    padding: 10px;
}

.fourth-section table td{
    border: none;
    background-color: transparent !important;
    padding-top:3px;
    padding-bottom:3px;
    text-align:center;
}

.fourth-section table th{
    background-color: transparent !important;
    padding-top:3px;
    padding-bottom:3px;
    text-align:center;
}

.fourth-section table .th1,
.fourth-section table .td1{
    border-right:2px solid #333;
    font-weight: 700;
}

/* Footer */
.footer-section{
    background-color:#000;
    padding-top:5rem;
    padding-bottom:5rem;
}

.footer-section a img:hover{
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
    width: 55px;
    height: 55px;
    object-fit: contain;
    margin-top:10px;
    margin-bottom:10px;
    transition: transform 0.1s ease;
}

.social-icon:hover {
    transform: scale(1.1);
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

/* Botones flotantes */
.arrow-top {
  position: fixed;
  z-index: 1000;
  border-radius: 50%;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  width: 45px;
  height: auto;
}

.whatsapp-float {
  position: fixed;
  z-index: 1000;
  border-radius: 50%;
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

.whatsapp-float {
  bottom: 20px;
  right: 20px;
}

.arrow-top {
  bottom: 100px;
  right: 30px;
}

/* Estilos del navbar responsivo */
.navbar {
  width: 100%;
}

.navbar-nav .dropdown {
  /* position: static !important; */
  position: relative;
}


.navbar-brand {
  margin: 0;
}

.nav-icon {
  width: 30px;
  height: 30px;
  transition: all 0.3s ease;
}

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

.header-scrolled .navbar-toggler-icon,
.header-scrolled .navbar-toggler-icon::before,
.header-scrolled .navbar-toggler-icon::after {
  background-color: #000000;
}



@media (max-width: 991.98px) {
  .slider-arrow {
    width: 40px;
    height: 40px;
  }
  
  .slider-arrow.prev {
    left: 15px;
  }
  
  .slider-arrow.next {
    right: 15px;
  }
  
  .slider-dots {
    bottom: 20px;
  }
  
  .dot {
    width: 10px;
    height: 10px;
  }

  .navbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
  }

  .navbar-brand {
    /* padding-top: 0px !important; */
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    top: 15px;
    z-index: 1050;
  }

 
  .navbar-collapse {
    flex-basis: 100%;
    margin-top: 2rem;
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    backdrop-filter: blur(10px);
    margin-left: calc(-50px) !important;
    margin-right: calc(-50px) !important;
    width: calc(100% + 20px);
    border-radius: 0px;
    color:#000;
  }

  .navbar-collapse  .nav-link {
    color: #000 !important;
  }

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

  .header-scrolled .navbar-collapse {
    background-color: rgba(255, 255, 255, 0.98);
  }

  .header-scrolled .nav-link {
    color: #000 !important;
  }


  .collections-dropdown {
    display: none;
  }

  .collections-images{
    gap:30px;
  }



  .collection-img {
    height: 120px;
  }

  .lead {
    font-size: 1rem;
  }
 

  .first-section{
    height:auto;
  }

  .section-new-woman{
    top: 50%; left: 2%; text-align: left;
  }

  .display-4{
    font-size:3rem;
  }

  .second-section {
    height:auto;
    padding-left:60px;
    padding-right:60px;
  }

  .second-section h2{
    font-size:4rem !important;
  }

  .second-section h2 span{
    font-size:4rem !important;
  }

  .second-section .lead{
    font-size:1.3rem !important;
  }

  .second-section .lead strong{
    font-size:1.5rem !important;
  }

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

  .fourth-section .table {
    font-size:1.2rem;
  }

  .fourth-section p{
    font-size:1.2rem;
    margin-left:1rem;
    margin-right:1rem;
    text-align: center;
  }

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

  #main-header {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 20px;
    padding-bottom: 20px;
  }
}



@media (max-width: 768px) {
  .lead {
    font-size: 1rem;
  }
 
  .first-section{
    height:auto;
  }

  .display-4{
    font-size:3rem;
  }


  .section-new-woman{
    top: 50%; left: 20%; text-align: left;
  }

  

  .second-section {
    height:auto;
    padding-left:60px;
    padding-right:60px;

  }


  .second-section h2{
    font-size:4rem !important;
    
  }

  .second-section h2 span{
    font-size:4rem !important;
  }

  .second-section .lead{
    font-size:1.3rem !important;
  }

  .second-section .lead strong{
    font-size:1.5rem !important;
  }


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

  

  .fourth-section .table {
    font-size:1.2rem;
  }

  .fourth-section p{
    font-size:1.2rem;
    margin-left:1rem;
    margin-right:1rem;
    text-align: center;
  }

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

  #main-header {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 20px;
    padding-bottom: 20px;
  }
}

@media (max-width: 576px) {
  .slider-arrow {
    width: 35px;
    height: 35px;
  }
  
  .slider-arrow.prev {
    left: 10px;
  }
  
  .slider-arrow.next {
    right: 10px;
  }
  
  .slider-dots {
    bottom: 15px;
    gap: 8px;
  }
  
  .dot {
    width: 8px;
    height: 8px;
  }

  .display-4 {
    font-size: 2rem;
  }
  .lead {
    font-size: 0.9rem;
  }


  .first-section{
    height:auto;
  }

  .section-new-woman{
    top: 80%; left: 2%; text-align: left;
  }

  .second-section{
    height: auto;
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

  .fourth-section .table {
    font-size:1.2rem;
  }

  .fourth-section p{
    font-size:1.2rem;
    margin-left:1rem;
    margin-right:1rem;
    text-align: center;
  }

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

@media (max-width: 1400px) and (min-width: 993px) {
  .first-section .section-new-woman{
    position: absolute;
    padding-left: 100px;
    padding-right: 100px;
    top: 70%;
    left: 2%;
    transform: translateY(-50%);
    text-align: left;
  }


  .collections-images{
    gap:30px;
  }

  .dropdown-title {

    padding-left:1rem;
  }

  .collections-list {

    padding-left:1rem;

  }
  .second-section{
    height: auto;
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

  
  .collections-section{
    min-width:300px;
    padding-left:5rem;
    /* width:100px; */
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

</style>