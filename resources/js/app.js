/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/* Vuesax - Biblioteca para interfaz de usuario */
import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
Vue.use(Vuesax, {
    // options here
});

/* SweetAlert2 - Biblioteca para ventanas emergentes */
import Swal from 'sweetalert2';
window.Swal = Swal;

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('view1', require('./components/View1Component.vue').default);
Vue.component('view2', require('./components/View2Component.vue').default);

const app = new Vue({
    el: '#app',
});