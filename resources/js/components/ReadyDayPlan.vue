<template>
	<div>
		<template v-if="isShowAddJobTaskDialog">
			<AddJobTask v-on:toggleAddJobTaskDialog="toggleAddJobTaskDialog"/>
		</template>
		<template v-if="isShowCloseDayDialog">
			<CloseDay v-on:toggleCloseDayDialog="toggleCloseDayDialog"/>
		</template>
		<template v-if="isShowEmergencyCallDialog">
			<EmergencyCall v-on:toggleEmergencyCallDialog="toggleEmergencyCallDialog"/>
		</template> 
		<v-data-iterator hide-default-footer v-bind:items="plan">
			<Cards title="Required tasks:" v-if="this.isExistsRequiredTasks(plan)" v-bind:items="this.getRequiredTasks(plan)"/>
			<v-divider></v-divider>
			<Cards title="Non required tasks:" v-if="this.isExistsNonRequiredTasks(plan)" v-bind:items="this.getNonRequiredTasks(plan)"/>
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
	import AddJobTask from './dialogs/AddJobTask.vue'
	import CloseDay from './dialogs/CloseDay.vue'
	import Cards from './cards/Cards.vue'
	import EmergencyCall from './dialogs/EmergencyCall.vue'
	import {mdiCarEmergency,mdiPlusBox,mdiSendClock} from '@mdi/js'
	export default
	{
		components : {AddJobTask,CloseDay,Cards,EmergencyCall},
		props : ['plan'],
		data()
		{
			return {
					icons : {mdiCarEmergency,mdiPlusBox,mdiSendClock},

					isShowAddJobTaskDialog : false,
					isShowCloseDayDialog : false,
					isShowEmergencyCallDialog : false
				}
		},
		methods :
		{
			getRequiredTasks(plan)
			{
				return plan.filter((item) => [4,2].includes(item.type))
			},
			isExistsRequiredTasks(plan)
			{
				return this.getRequiredTasks(plan).length > 0
			},

			getNonRequiredTasks(plan)
			{
				return plan.filter((item) => [3,1].includes(item.type))
			},
			isExistsNonRequiredTasks(plan)
			{
				return this.getNonRequiredTasks(plan).length > 0
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