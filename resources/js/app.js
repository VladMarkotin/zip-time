require('./bootstrap')

import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'

window.Vue = require('vue').default

Vue.use(Vuetify)
Vue.use(Vuelidate)

Vue.component('ClosedReadyDayPlan',require('./components/ClosedReadyDayPlan.vue').default)
Vue.component('Facebook',require('./components/Facebook.vue').default)
Vue.component('Plan',require('./components/Plan.vue').default)
Vue.component('ReadyDayPlan',require('./components/ReadyDayPlan.vue').default)

Date.prototype.addDays =
	function (days)
	{
		this.setDate(this.getDate() + days)
		return this
	}
Date.prototype.subtractDays =
	function (days)
	{
		this.setDate(this.getDate() - days)
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
				loader : 'vue-loader',
				vuetify : new Vuetify(),
				components : {app},
				data : {alertDelay : 5e3,currComponent : {name : '',props : {}}},
				computed :
				{
					currComponentName()
					{
						return this.currComponent.name
					},
					currComponentProps()
					{
						return this.currComponent.props
					}
				},
				async created()
				{
					if (window.user != '')
					{
						const response = await axios.post('/ifexists')
						if (response.data.dayStatus == 3/*day is closed*/)
						{
							this.currComponent.props = response.data
							this.currComponent.name = 'ClosedReadyDayPlan'
						}
						else if (response.data.dayStatus == 2/*day is opened*/)
						{
							this.currComponent.props = response.data.plan
							this.currComponent.name = 'ReadyDayPlan'
						}
						else/*no plan*/
						{
							this.currComponent.name = 'Plan'
						}
					}
				}
			}
	)
app.$mount()