
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('formcalc', require('./components/FormCalcComponent.vue'));
Vue.component('lasttickerlist', require('./components/LastTickerList.vue'));
Vue.component('balance', require('./components/BalanceComponent.vue'));
Vue.component('currencydetail', require('./components/CurrencyDetailComponent.vue'));
Vue.component('instrumentdetail', require('./components/InstrumentDetailComponent.vue'));
Vue.component('realtime', require('./components/RealtimeComponent.vue'));


const app = new Vue({
    el: '#app',
    methods: {

        

        
    }
});
