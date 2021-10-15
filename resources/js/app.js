/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vuetify from 'vuetify';
import Vuelidate from 'vuelidate';
import "vuetify/dist/vuetify.min.css";
import '@mdi/font/css/materialdesignicons.css';
import colors from 'vuetify/lib/util/colors';

import { mdiPlex } from '@mdi/js';
import VTooltip from "v-tooltip";

Vue.use(Vuetify)
Vue.use(Vuelidate)
Vue.use(VTooltip)

const opts = {}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('facebook-component', require('./components/FacebookComponent.vue').default);
Vue.component('plan-component', require('./components/PlanComponent.vue').default);
Vue.component('ready-day-plan-component', require('./components/ReadyDayPlanComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    loader: 'vue-loader',
    components: {app},
    data : {
        currComponent : "plan-component",
        currComponentProps : {}
    },
    computed : {
        component()
        {
            return this.currComponent
        },
        componentProps()
        {
            return this.currComponentProps
        }
    }
});

app.$mount();
