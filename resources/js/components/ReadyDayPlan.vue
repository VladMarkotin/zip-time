<template>
	<div>
		<template v-if="isShowAddJobTaskDialog">
			<AddJobTask v-on:setAlertData="setAlertData" v-on:toggleAddJobTaskDialog="toggleAddJobTaskDialog" v-on:toggleAlertDialog="toggleAlertDialog"/>
		</template>
		<template v-if="isShowCloseDayDialog">
			<CloseDay v-on:toggleCloseDayDialog="toggleCloseDayDialog"/>
		</template>
		<template v-if="isShowEmergencyCallDialog">
			<EmergencyCall v-on:toggleEmergencyCallDialog="toggleEmergencyCallDialog"/>
		</template> 
		<template v-if="isShowAlertDialog">
			<Alert v-bind:type="alert.type" v-bind:text="alert.text" v-on:toggleAlertDialog="toggleAlertDialog"/>
		</template>
		<v-data-iterator hide-default-footer v-bind:items="data">
			<Cards title="Required tasks:" v-if="isExistsRequiredTasks(data)" v-bind:items="getRequiredTasks(data)"/>
			<v-divider></v-divider>
			<Cards title="Non required tasks:" v-if="isExistsNonRequiredTasks(data)" v-bind:items="getNonRequiredTasks(data)"/>
		</v-data-iterator>
		<div class="d-flex justify-space-between mt-3">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="toggleAddJobTaskDialog">
						<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
					</v-btn>
				</template>
				<span>Add job/task</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="toggleCloseDayDialog">
						<v-icon color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
					</v-btn>
				</template>
				<span>Close day</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="toggleEmergencyCallDialog">
						<v-icon color="#D71700" large>{{icons.mdiCarEmergency}}</v-icon>
					</v-btn>
				</template>
				<span>Emergency call</span>
			</v-tooltip>
		</div>
	</div>
</template>
<script>
	import Alert from './dialogs/Alert.vue'
	import AddJobTask from './dialogs/AddJobTask.vue'
	import CloseDay from './dialogs/CloseDay.vue'
	import Cards from './cards/Cards.vue'
	import EmergencyCall from './dialogs/EmergencyCall.vue'
	import {mdiCarEmergency,mdiPlusBox,mdiSendClock} from '@mdi/js'

	export default
	{
		components : {Alert,AddJobTask,CloseDay,Cards,EmergencyCall},
		props : ['data'],
		data()
		{
			return {
					icons : {mdiCarEmergency,mdiPlusBox,mdiSendClock},

					isShowAddJobTaskDialog : false,
					isShowCloseDayDialog : false,
					isShowEmergencyCallDialog : false,
					isShowAlertDialog : false,

					alert : {type : '',text : ''}
				}
		},
		methods :
		{
			getRequiredTasks(data)
			{
				return data.filter((item) => [4,2].includes(item.type))
			},
			isExistsRequiredTasks(data)
			{
				return this.getRequiredTasks(data).length > 0
			},

			getNonRequiredTasks(data)
			{
				return data.filter((item) => [3,1].includes(item.type))
			},
			isExistsNonRequiredTasks(data)
			{
				return this.getNonRequiredTasks(data).length > 0
			},

			toggleAddJobTaskDialog()
			{
				this.isShowAddJobTaskDialog = !this.isShowAddJobTaskDialog
			},
			toggleCloseDayDialog()
			{
				this.isShowCloseDayDialog = !this.isShowCloseDayDialog
			},
			toggleEmergencyCallDialog()
			{
				this.isShowEmergencyCallDialog = !this.isShowEmergencyCallDialog
			},

			setAlertData(type,text)
			{
				this.alert.type = type
				this.alert.text = text
			},
			toggleAlertDialog()
			{
				this.isShowAlertDialog = !this.isShowAlertDialog
			}
		}
	}
</script>
<style>
	.v-card-actions
	{
		margin-top : -20px
	}
	.v-card-title
	{
		background-color : #A10000;
		color : white
	}
</style>