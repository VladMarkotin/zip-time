/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue').default
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'
import "vuetify/dist/vuetify.min.css"
import '@mdi/font/css/materialdesignicons.css'
import colors from 'vuetify/lib/util/colors'

<<<<<<< HEAD
import {  mdiPlex  } from '@mdi/js';
import VTooltip from "v-tooltip";
=======
import { mdiPlex } from '@mdi/js'
import VTooltip from "v-tooltip"
>>>>>>> d599dc937f6076ee3b6828437b46fed2345e9be2

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

Vue.component('example-component',require('./components/ExampleComponent.vue').default)
Vue.component('facebook-component',require('./components/FacebookComponent.vue').default)
Vue.component('plan-component',require('./components/PlanComponent.vue').default)
Vue.component('ready-day-plan-component',require('./components/ReadyDayPlanComponent.vue').default)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Date.prototype.addDays =
    function (days)
    {
        this.setDate(this.getDate() + days)
        return this
    }
Date.prototype.toEnStr =
    function ()
    {
        return this.toISOString().substr(0,10)
    }
const app =
    new Vue
        (
            {
                el : '#app',
                vuetify : new Vuetify(),
                loader : 'vue-loader',
                components : {app},
                data : {currComponent : "",currComponentProps : {}},
                computed :
                {
                    component()
                    {
                        return this.currComponent
                    },
                    componentProps()
                    {
                        return this.currComponentProps
                    }
                },
                async created()
                {
                    const response = await axios.post('/ifexists')
                    if (response.data.length > 0)
                    {
                        this.currComponentProps = response.data
                        this.currComponent = 'ready-day-plan-component'
                    }
                    else
                    {
                        this.currComponent = 'plan-component'
                    }
                }
            }
    )

app.$mount()
