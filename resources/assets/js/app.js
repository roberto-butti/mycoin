
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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('formcalc', require('./components/FormCalcComponent.vue').default);
Vue.component('lasttickerlist', require('./components/LastTickerList.vue').default);
Vue.component('balance', require('./components/BalanceComponent.vue').default);
Vue.component('currencydetail', require('./components/CurrencyDetailComponent.vue').default);
Vue.component('instrumentdetail', require('./components/InstrumentDetailComponent.vue').default);
Vue.component('realtime', require('./components/RealtimeComponent.vue').default);
Vue.component('usertrades', require('./components/UserTradesComponent.vue').default);
Vue.component('viewinstrument', require('./components/ViewInstrumentComponent.vue').default);


const app = new Vue({
    el: '#app',
    data() {
        return {
            showNav: false,
        }
    },
    methods: {




    }
});
