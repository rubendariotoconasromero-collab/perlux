/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//import './bootstrap';
import { createApp } from 'vue';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import HomeComponent from './components/web/HomeComponent.vue';
import NosotrosComponent from './components/web/NosotrosComponent.vue';
import BienvenidaComponent from './components/admin/BienvenidaComponent.vue';
import ColorComponent from './components/admin/ColorComponent.vue';
import SizeComponent from './components/admin/SizeComponent.vue';
import CollectionComponent from './components/admin/CollectionComponent.vue';
import ProductComponent from './components/admin/ProductComponent.vue';
import BodyComponent from './components/web/BodyComponent.vue';
import JeansComponent from './components/web/JeansComponent.vue';
import DetailBodyComponent from './components/web/DetailBodyComponent.vue';
import DetailJeansComponent from './components/web/DetailJeansComponent.vue';
import LoginComponent from './components/web/LoginComponent.vue';
import RegisterComponent from './components/web/RegisterComponent.vue';
import SkinlyLoginComponent from './components/web/SkinlyLoginComponent.vue';
import SkinlyRegisterComponent from './components/web/SkinlyRegisterComponent.vue';
import PersonalDataComponent from './components/web/PersonalDataComponent.vue';
import PasarelaComponent from './components/web/PasarelaComponent.vue';
import UserComponent from './components/admin/UserComponent.vue';
import ClaimsbookComponent from './components/web/ClaimsbookComponent.vue';
import BusinessInfoComponent from './components/web/BusinessInfoComponent.vue';

import CheckoutComponent from './components/web/CheckoutComponent.vue';
import ThankYouComponent from './components/web/ThankYouComponent.vue';
import OrdersComponent from './components/admin/OrdersComponent.vue';


app.component('example-component', ExampleComponent);
app.component('home-component', HomeComponent);
app.component('nosotros-component', NosotrosComponent);
app.component('bienvenida-component', BienvenidaComponent);

app.component('color-component', ColorComponent);
app.component('size-component', SizeComponent);
app.component('collection-component', CollectionComponent);
app.component('product-component', ProductComponent);
app.component('body-component', BodyComponent);
app.component('jeans-component', JeansComponent);
app.component('detailbody-component', DetailBodyComponent);
app.component('detailjeans-component', DetailJeansComponent);
app.component('login-component', LoginComponent);
app.component('register-component', RegisterComponent);
app.component('skinlylogin-component', SkinlyLoginComponent);
app.component('skinlyregister-component', SkinlyRegisterComponent);
app.component('personaldata-component', PersonalDataComponent);
app.component('pasarela-component', PasarelaComponent);
app.component('user-component', UserComponent);
app.component('claimsbook-component', ClaimsbookComponent);
app.component('business-info-component', BusinessInfoComponent);
app.component('checkout-component', CheckoutComponent);
app.component('thank-you-component', ThankYouComponent);
app.component('orders-component', OrdersComponent);





/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
