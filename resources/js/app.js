require('./bootstrap');

import HighchartsVue from 'highcharts-vue';
import Vue from 'vue';
import Vuetify from 'vuetify';
import functions from './functions';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';

Vue.use(HighchartsVue);
Vue.use(Vuetify);

Vue.component('ClosedReadyDayPlan', require('./components/cards/ClosedReadyDayPlan.vue').default);
Vue.component('Plan', require('./components/cards/Plan.vue').default);
Vue.component('Stat', require('./components/cards/Stat.vue').default);
Vue.component('Facebook', require('./components/Facebook.vue').default);
Vue.component('ReadyDayPlan', require('./components/ReadyDayPlan.vue').default);

const app =
	new Vue
		(
			{
				el: '#app',
				loader: 'vue-loader',
				vuetify: new Vuetify(),
				components: {app},
				data: {alertDelay: 5e3, currComponent: {name: '', props: {}}},
				computed:
				{
					currComponentName()
					{
						return this.currComponent.name;
					},
					currComponentProps()
					{
						return this.currComponent.props;
					}
				},
				async created()
				{
					if (window.user != '')
					{
						const data = (await axios.post('/ifexists')).data;
						if (data.dayStatus == 3/*day is closed*/)
						{
							this.currComponent.props = data;
							this.currComponent.name = 'ClosedReadyDayPlan';
						}
						else if (data.dayStatus == 2/*day is opened*/)
						{
							this.currComponent.props = data.plan;
							this.currComponent.name = 'ReadyDayPlan';
						}
						else/*no plan*/
						{
							this.currComponent.name = 'Plan';
						}
					}
				}
			}
	);
app.$mount();