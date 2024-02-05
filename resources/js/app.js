require('./bootstrap');

import HighchartsVue from 'highcharts-vue';
import Vue from 'vue';
import Vuetify from 'vuetify';
import functions from './functions';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import ChatGPTIcon from './components/icons/ChatGPTIcon.vue';
import GPTRecreateIcon from './components/icons/GPTRecreateIcon.vue';
import UUID from "vue-uuid";

Vue.use(HighchartsVue);
Vue.use(Vuetify);
Vue.use(UUID);

Vue.component('ClosedReadyDayPlan', require('./components/cards/ClosedReadyDayPlan.vue').default);
Vue.component('History', require('./components/cards/History.vue').default);
Vue.component('Plan', require('./components/cards/Plan/Plan.vue').default);
Vue.component('Stat', require('./components/cards/Stat.vue').default);
Vue.component('Facebook', require('./components/Facebook.vue').default);
Vue.component('ReadyDayPlan', require('./components/ReadyDayPlan.vue').default);
Vue.component('PersonalResults', require('./components/dialogs/PersonalResults.vue').default);

const app =
	new Vue
		(
			{
				el: '#app',
				loader: 'vue-loader',
				vuetify: new Vuetify({
					theme: {},
					icons: {
						values: {
							chatGPTIcon: {
								component: ChatGPTIcon,
							},
							gptRecreateIcon: {
								component: GPTRecreateIcon,
							}
						}
					}
				}),
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
						if (data.dayStatus == 3 || (data.dayOwnMark > 0) || (data.dayStatus == 0) || (data.dayStatus == -1)) /*day is closed || (|| (data[0].day_status === 0) data[0].day_status === 0)*/
						{
							this.currComponent.props = data;
							this.currComponent.name = 'ClosedReadyDayPlan';
						}
						else if (data.dayStatus == 2 || data.dayStatus == 1/*day is opened*/)
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