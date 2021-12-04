require('./bootstrap')
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
window.Vue = require('vue').default
Vue.use(Vuetify)
Vue.use(Vuelidate)
Vue.component('Facebook',require('./components/Facebook.vue').default)
Vue.component('Plan',require('./components/Plan.vue').default)
Vue.component('ReadyDayPlan',require('./components/ReadyDayPlan.vue').default)
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
						this.currComponent = 'ReadyDayPlan'
					}
					else
					{
						this.currComponent = 'Plan'
					}
				}
			}
	)
app.$mount()